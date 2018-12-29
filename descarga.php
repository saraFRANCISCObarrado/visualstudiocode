//MODIFICACIONES DESDE GITHUB
<?php

function escribir_archivolog($cadena,$tipo)
{
	$arch = fopen ("log.txt", "a"); 

	fwrite($arch, "[".date("Y-m-d H:i:s.u")."] ".$cadena."\n");
	fclose($arch);
}
//llamamo a funciones.php
require_once "funciones.php";
//Usuario y contraseña
$admin=false;

if (isset ( $_POST['name'] )){
$name=$_POST['name'];}

if (isset ( $_POST['pass'] )){
$pass=$_POST['pass'];}

//Comprueba si son correctas usario y contraseña
if(empty($name)){
header ("Location:index.php?msj='Debe registrarse y especificar un nombre'");
exit();}

if(empty($pass)){
header ("Location:index.php?msj='Debe registrarse y especificar la contraseña'");
exit();}

if (($name === 'admin') and ( $pass === 'admin')) {
    $admin = true;
}


//Verificamos que botón pulso el usuario de la web.

switch ($_POST['enviar']){
	case 'Subir fichero y entrar':
		$file =$_FILES['fichero'];
		upload_file($file);
		$ficheros = muestraficheros($admin);
	escribir_archivolog("SE HA PRODUCIDO LA SUBIDA DE UN FICHERO Y SE A ACCEDIDO COMO USUARIO: "."$name","info");//esto es lo q se registra en el archivo log
		break;
	case 'Subir fichero':
		$file =$_FILES['fichero'];
		$msj="El fichero".$file['name']."<br/>";
		if(upload_file($file))			
			$msj.="SE HA SUBIDO CORRECTAMENTE";
		else
			$msj.="NO SE HA PODIDO SUBIR .<br/Error:".$file['error'];
		header ("Location:index.php?msj=$msj");
	        escribir_archivolog("INTENTO DE SUBIR UN FICHERO COMO USUARIO: "."$name","info");
		break;
	case 'Entrar':
		$ficheros= muestraficheros($admin);
	escribir_archivolog("SE A ACCEDIDO COMO USUARIO: "."$name","info");
		break;
	case 'publicar':
		$ficheros_subir=$_POST['ficheros_publicar'];
		publicar($ficheros_subir);
		$ficheros = muestraficheros($admin);
	escribir_archivolog("SE HAN PUBLICADO FICHEROS COMO USUARIO: "."$name","info");
		break;
	default:
		header ("Location:index.php?msj='DEBE REGISTRARSE PARA SUBIR FICHEROS.'");
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/estilo.css" type="text/css">
    <script src='https://unpkg.com/vue'></script>
    <script src='https://github.com/vuejs/vue-devtools'></script>
    <title>Descarga de ficheros</title>

</head>
<body>
<h1>WEB DE DESCARGAS DE FICHEROS</h1>
<div id="app">
    <form action="index.php" method="POST">
        <input style="float:right; margin-right:30%" type="submit" value="Volver" name="enviar">
        <input type="hidden" value="<?php echo $name ?>" name="name">
        <input type="hidden" value="<?php echo $pass ?>" name="pass">

    </form>
   <?php echo $ficheros?>
<input type=hidden name=name value='admin' />
<input type=hidden name=pass value='admin' />
</form>

</div>
</body>

</html>

