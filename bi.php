<?php
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');


/*************************************************
 * BI endpoint para Power BI (JSON/CSV)
 * Tablas: clientes, horas, planes, planes_registro, registro
 * Extras: uso (minutos/día), help (lista endpoints)
 *************************************************/

// =============== CONFIG ===============
$DB_HOST = 'localhost';
$DB_NAME = 'conectac_sistema';
$DB_USER = 'root';
$DB_PASS = '';

// Cámbialo por uno largo/único antes de publicar
$TOKEN   = 'T0k3n_Super_Largo_y_Unico_9e4d7b0f2a13';

// Opcional: CORS si lo consumes desde otros orígenes
// header('Access-Control-Allow-Origin: https://conectacowork.com');

// =============== RUNTIME SAFETY ===============
ini_set('display_errors', '0');
set_time_limit(60);
date_default_timezone_set('UTC');

// =============== AUTH POR TOKEN ===============
$token = $_GET['token'] ?? '';
if (!hash_equals($TOKEN, $token)) {
  http_response_code(401);
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode(['error' => 'unauthorized']);
  exit;
}

// =============== PARAMS ===============
$endpoint = $_GET['endpoint'] ?? 'help';
$fmt      = strtolower($_GET['fmt'] ?? 'json');          // json | csv
$from     = $_GET['from'] ?? null;                       // YYYY-MM-DD
$to       = $_GET['to']   ?? null;                       // YYYY-MM-DD
$page     = max(1, (int)($_GET['page'] ?? 1));
$perPage  = min(5000, max(1, (int)($_GET['per_page'] ?? 1000)));
$offset   = ($page - 1) * $perPage;

$reDate = '/^\d{4}-\d{2}-\d{2}$/';
if ($from && !preg_match($reDate, $from)) $from = null;
if ($to   && !preg_match($reDate, $to))   $to   = null;

// =============== DB CONN (PDO) ===============
try {
  $dsn = "mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4";
  $pdo = new PDO($dsn, $DB_USER, $DB_PASS, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET time_zone = '+00:00'",
  ]);
} catch (Throwable $e) {
  http_response_code(500);
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode(['error' => 'db_connect_failed']);
  exit;
}

// =============== QUERIES ===============

// 0) HELP
function q_help() {
  return [
    'endpoints' => [
      'clientes'         => 'Dimensión de clientes',
      'horas'            => 'Agenda/slots (h.fecha, h.hora)',
      'planes'           => 'Maestro de planes',
      'planes_registro'  => 'Inscripciones/planes por cliente',
      'registro'         => 'Entradas/salidas (con filtros from/to)',
      'uso'              => 'Minutos por día/cliente/plan (agrupado, from/to)',
    ],
    'params' => [
      'fmt'      => 'json | csv',
      'page'     => '1..n',
      'per_page' => '1..5000 (default 1000)',
      'from'     => 'YYYY-MM-DD (opcional)',
      'to'       => 'YYYY-MM-DD (opcional)',
      'token'    => 'requerido',
    ],
    'examples' => [
      'clientes'        => '?endpoint=clientes&fmt=csv&token=XXXX',
      'horas'           => '?endpoint=horas&fmt=csv&token=XXXX',
      'planes'          => '?endpoint=planes&fmt=csv&token=XXXX',
      'planes_registro' => '?endpoint=planes_registro&fmt=csv&token=XXXX',
      'registro'        => '?endpoint=registro&from=2025-01-01&to=2025-12-31&fmt=csv&token=XXXX',
      'uso'             => '?endpoint=uso&from=2025-01-01&to=2025-12-31&fmt=csv&token=XXXX',
    ],
  ];
}

// 1) CLIENTES
function q_clientes($pdo, $limit, $offset) {
  $sql = "
    SELECT
      documento,
      TRIM(nombre)   AS nombre,
      TRIM(apellido) AS apellido,
      correo,
      telefono,
      suscripcion
    FROM clientes
    ORDER BY apellido, nombre
    LIMIT :lim OFFSET :off
  ";
  $st = $pdo->prepare($sql);
  $st->bindValue(':lim', (int)$limit, PDO::PARAM_INT);
  $st->bindValue(':off', (int)$offset, PDO::PARAM_INT);
  $st->execute();
  return $st->fetchAll(PDO::FETCH_ASSOC);
}

// 2) HORAS
function q_horas($pdo, $from, $to, $limit, $offset) {
  $where = [];
  $params = [];
  if ($from) { $where[] = "h.fecha >= :from"; $params[':from'] = $from; }
  if ($to)   { $where[] = "h.fecha <= :to";   $params[':to']   = $to;   }
  $w = $where ? ('WHERE '.implode(' AND ', $where)) : '';
  $sql = "
    SELECT
      h.secuencial,
      h.secuencial_planes,
      h.documento,
      CONCAT(TRIM(c.nombre),' ',TRIM(c.apellido)) AS cliente,
      h.servicio,
      h.fecha,
      h.hora
    FROM horas h
    LEFT JOIN clientes c ON c.documento = h.documento
    $w
    ORDER BY h.fecha DESC, h.hora DESC
    LIMIT :lim OFFSET :off
  ";
  $st = $pdo->prepare($sql);
  foreach ($params as $k=>$v) $st->bindValue($k, $v);
  $st->bindValue(':lim', (int)$limit, PDO::PARAM_INT);
  $st->bindValue(':off', (int)$offset, PDO::PARAM_INT);
  $st->execute();
  return $st->fetchAll(PDO::FETCH_ASSOC);
}

// 3) PLANES  ✅ sin 'estado'
function q_planes($pdo, $limit, $offset) {
  $sql = "
    SELECT
      codigo,
      TRIM(nombre) AS nombre,
      cowork,
      sala_reuniones,
      impresiones,
      evento,
      precio
    FROM planes
    ORDER BY codigo
    LIMIT :lim OFFSET :off
  ";
  $st = $pdo->prepare($sql);
  $st->bindValue(':lim', (int)$limit, PDO::PARAM_INT);
  $st->bindValue(':off', (int)$offset, PDO::PARAM_INT);
  $st->execute();
  return $st->fetchAll(PDO::FETCH_ASSOC);
}


// 4) PLANES_REGISTRO
function q_planes_registro($pdo, $limit, $offset) {
  $sql = "
    SELECT
      secuencial_planes, documento, codigo, fecha_i, fecha_f, estado
    FROM planes_registro
    ORDER BY secuencial_planes DESC
    LIMIT :lim OFFSET :off
  ";
  $st = $pdo->prepare($sql);
  $st->bindValue(':lim', (int)$limit, PDO::PARAM_INT);
  $st->bindValue(':off', (int)$offset, PDO::PARAM_INT);
  $st->execute();
  return $st->fetchAll(PDO::FETCH_ASSOC);
}

// 5) REGISTRO (crudo, con filtros)
function q_registro($pdo, $from, $to, $limit, $offset) {
  $where = [];
  $params = [];
  if ($from) { $where[] = "DATE(r.entrada) >= :from"; $params[':from'] = $from; }
  if ($to)   { $where[] = "DATE(r.entrada) <= :to";   $params[':to']   = $to;   }
  $w = $where ? ('WHERE '.implode(' AND ', $where)) : '';
  $sql = "
    SELECT
      secuencial_R, secuencial_planes, documento, servicio, entrada, salida, concluido, estado
    FROM registro r
    $w
    ORDER BY r.entrada DESC
    LIMIT :lim OFFSET :off
  ";
  $st = $pdo->prepare($sql);
  foreach ($params as $k=>$v) $st->bindValue($k, $v);
  $st->bindValue(':lim', (int)$limit, PDO::PARAM_INT);
  $st->bindValue(':off', (int)$offset, PDO::PARAM_INT);
  $st->execute();
  return $st->fetchAll(PDO::FETCH_ASSOC);
}

// 6) USO (agrupado por día/cliente/plan)
function q_uso($pdo, $from, $to, $limit, $offset) {
  $where = [];
  $params = [];
  if ($from) { $where[] = "DATE(r.entrada) >= :from"; $params[':from'] = $from; }
  if ($to)   { $where[] = "DATE(r.entrada) <= :to";   $params[':to']   = $to;   }
  $w = $where ? ('WHERE '.implode(' AND ', $where)) : '';

  $sql = "
    SELECT
      c.documento,
      CONCAT(TRIM(c.nombre),' ',TRIM(c.apellido)) AS cliente,
      pr.codigo       AS plan,
      DATE(r.entrada) AS fecha,
      SUM(TIMESTAMPDIFF(MINUTE, r.entrada, r.salida)) AS minutos_totales,
      COUNT(*) AS sesiones
    FROM registro r
    JOIN planes_registro pr ON pr.secuencial_planes = r.secuencial_planes
    JOIN clientes c         ON c.documento = r.documento
    $w
    GROUP BY c.documento, pr.codigo, DATE(r.entrada)
    ORDER BY fecha DESC, cliente
    LIMIT :lim OFFSET :off
  ";
  $st = $pdo->prepare($sql);
  foreach ($params as $k=>$v) $st->bindValue($k, $v);
  $st->bindValue(':lim', (int)$limit, PDO::PARAM_INT);
  $st->bindValue(':off', (int)$offset, PDO::PARAM_INT);
  $st->execute();
  return $st->fetchAll(PDO::FETCH_ASSOC);
}

// =============== ROUTER ===============
switch ($endpoint) {
  case 'help':            $rows = q_help(); break;
  case 'clientes':        $rows = q_clientes($pdo, $perPage, $offset); break;
  case 'horas':           $rows = q_horas($pdo, $from, $to, $perPage, $offset); break;
  case 'planes':          $rows = q_planes($pdo, $perPage, $offset); break;
  case 'planes_registro': $rows = q_planes_registro($pdo, $perPage, $offset); break;
  case 'registro':        $rows = q_registro($pdo, $from, $to, $perPage, $offset); break;
  case 'uso':             $rows = q_uso($pdo, $from, $to, $perPage, $offset); break;
  default:
    http_response_code(400);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['error'=>'unknown_endpoint']);
    exit;
}


// =============== OUTPUT ===============
if ($fmt === 'csv') {
  header('Content-Type: text/csv; charset=utf-8');
  header('Content-Disposition: attachment; filename="'.$endpoint.'-'.$page.'.csv"');
  $out = fopen('php://output', 'w');
  if (is_array($rows) && !empty($rows)) {
    fputcsv($out, array_keys($rows[0]));
    foreach ($rows as $r) fputcsv($out, $r);
  } elseif (isset($rows['endpoints'])) {
    // CSV básico para help
    fputcsv($out, ['endpoint', 'descripcion']);
    foreach ($rows['endpoints'] as $k=>$v) fputcsv($out, [$k, $v]);
  }
  fclose($out);
  exit;
}

// JSON por defecto
header('Content-Type: application/json; charset=utf-8');
echo json_encode([
  'endpoint' => $endpoint,
  'page'     => $page,
  'per_page' => $perPage,
  'from'     => $from,
  'to'       => $to,
  'rows'     => $rows,
], JSON_UNESCAPED_UNICODE);
