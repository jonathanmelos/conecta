<?php 
include 'conexion.php';
include 'header.php';

   // Consulta para prostecto
$sql = "SELECT COUNT(*) as total FROM plantilla WHERE nombre = 'prospectos'";
$result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $count = $row['total'];
if($count == 1){

    $prospecto = "<li class='list-group-item list-group-item-success'>El nombre <strong>prospectos</strong> reservado para prospectos del embudo de venta &#9745;</li>";
}else{
    $prospecto = "<li class='list-group-item list-group-item-success'>El nombre <strong>prospectos</strong> reservado para prospectos del embudo de venta</li>";
}
   
  // Consulta para clientes
  $sql2 = "SELECT COUNT(*) as total FROM plantilla WHERE nombre = 'clientes'";
  $result2 = $conn->query($sql2);
      $row2 = $result2->fetch_assoc();
      $count2 = $row2['total'];
  if($count2 == 1){
  
      $clientes = "<li class='list-group-item list-group-item-secondary'>El nombre <strong>clientes</strong> reservado para clientes del embudo de venta &#9745;</li>";
  }else{
      $clientes = "<li class='list-group-item list-group-item-secondary'>El nombre <strong>clientes</strong> reservado para clientes del embudo de venta</li>";
  }
  // Consulta para contactos
  $sql3 = "SELECT COUNT(*) as total FROM plantilla WHERE nombre = 'contactos'";
  $result3 = $conn->query($sql3);
      $row3 = $result3->fetch_assoc();
      $count3 = $row3['total'];
  if($count3 == 1){
  
      $contactos = "<li class='list-group-item list-group-item-danger'>El nombre <strong>contactos</strong> reservado para contactos del embudo de venta &#9745;</li>";
  }else{
      $contactos = "<li class='list-group-item list-group-item-danger'>El nombre <strong>contactos</strong> reservado para contactos del embudo de venta</li>";
  }
   // Consulta para general
   $sql4 = "SELECT COUNT(*) as total FROM plantilla WHERE nombre = 'general'";
   $result4 = $conn->query($sql4);
       $row4 = $result4->fetch_assoc();
       $count4 = $row4['total'];
   if($count4 == 1){
   
       $general = "<li class='list-group-item list-group-item-warning'>El nombre <strong>general</strong> reservado para todos los leads del embudo de venta &#9745;</li>";
   }else{
       $general = "<li class='list-group-item list-group-item-warning'>El nombre <strong>general</strong> reservado para todos los leads del embudo de venta</li>";
   }
       ?>   
<body>
	
	<div class="container">
    
	<div class="abs-center">
		<h4 class="mb-3">Plantillas de Whatsapp</h4>
        <ul class="list-group">
        

<?php echo $contactos.$prospecto.$clientes.$general?>
<li class='list-group-item list-group-item-primary'>Redacte un mensaje en la aplicación de Whatsapp de hasta 150 caracteres copie y pegue</li>

 <br>
</ul> 

		<form action="i_plantilla.php" method="post">
	<input type="hidden" class="form-control" id="accion" name="accion" value="ll">
  <div class="form-group row">
    <label for="staticEmail" class="col-sm-4 col-form-label"> Nombre </label>
    <div class="form-group col-md-8">	
    <input type="text" class="form-control" id="nombre" name="nombre">
	<small id="emailHelp" class="form-text text-muted">como se llama su plantilla </small>
    </div>
</div>
 <div class="form-group row">
    <label for="staticEmail" class="col-sm-4 col-form-label">Mensaje</label>
    <div class="form-group col-md-8">	
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="info" oninput="validateText(this)"></textarea>
    <div id="character-count">150 caracteres restantes</div>
    <small id="emailHelp" class="form-text text-muted">Escriba hasta 150 caracteres en texto plano, puede incluir 👋 mojis de whatsapp </small> 
	
</div>
  </div>
<div class="form-group row">
    <div class="form-group col-md-12">
		<br>
      <button type="submit" class="btn btn-primary btn-lg btn-block ">Crear nueva Plantilla</button>		
	</div>
 </div>	

	
	
			
		</form>		
		</div>
		
	</div>	
    <script>
      function validateText(textarea) {
  const input = textarea.value;

  // Verificar la longitud máxima de 150 caracteres
  if (input.length > 150) {
    textarea.value = input.substring(0, 150); // Limitar el texto a 150 caracteres
  }

  // Verificar si el texto contiene solo caracteres de texto plano y emojis
  const regex = /^[a-zA-Z0-9\s\.,\?!@#$%^&*()\-_+=|\\\/:;"'<>\{\}\[\]`~\p{Emoji}]+$/u;
  if (!regex.test(input)) {
    textarea.value = removeInvalidCharacters(input); // Eliminar caracteres no válidos
  }

  // Actualizar el contador de caracteres restantes
  const count = 150 - textarea.value.length;
  document.getElementById('character-count').textContent = count + ' caracteres restantes';
}

function removeInvalidCharacters(input) {
  // Eliminar caracteres no válidos utilizando expresiones regulares
  const regex = /[^a-zA-Z0-9\s\.,\?!@#$%^&*()\-_+=|\\\/:;"'<>\{\}\[\]`~\p{Emoji}]/gu;
  return input.replace(regex, '');
}
    </script>  
</body>
</html>