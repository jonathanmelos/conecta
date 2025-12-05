<?php 
include 'conexion.php';
include 'header.php';
$id = $_GET['id'];
$sql = "SELECT * FROM plantilla WHERE id_plantilla = $id ";
       $result = mysqli_query($conn,$sql);  
       $row = mysqli_fetch_assoc($result);
       $nombre =$row['nombre']; 
       $info =$row['info']; 
       ?>   
<body>
	
	<div class="container">
    
	<div class="abs-center">
		<h4 class="mb-3">Plantillas de Whatsapp</h4>
        <ul class="list-group">


 <br>
</ul> 

		<form action="m_plantilla_wp_bd.php" method="post">
	<input type="hidden" class="form-control" id="accion" name="accion" value="ll">
  <div class="form-group row">
    <label for="staticEmail" class="col-sm-4 col-form-label"> Nombre </label>
	  <input type="hidden" name="id" value="<?php echo $id ?>">
    <div class="form-group col-md-8">	
	<fieldset disabled="">	
	
    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>"> </fieldset>
	<small id="emailHelp" class="form-text text-muted">vas a modificar la plantilla</small>
    </div>
</div>
 <div class="form-group row">
    <label for="staticEmail" class="col-sm-4 col-form-label">Mensaje</label>
    <div class="form-group col-md-8">	
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="info" oninput="validateText(this)"><?php echo $info; ?> </textarea>
    <div id="character-count">150 caracteres restantes</div>
    <small id="emailHelp" class="form-text text-muted">Escriba hasta 150 caracteres en texto plano, puede incluir 👋 mojis de whatsapp </small> 
	
</div>
  </div>
<div class="form-group row">
    <div class="form-group col-md-12">
		<br>
      <button type="submit" class="btn btn-primary btn-lg btn-block ">Modificar Plantilla</button>		
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