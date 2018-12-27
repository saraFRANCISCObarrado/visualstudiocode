<?php
$msj=null;
$nombre="admin";
$contraseña="admin";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="./css/estilo.css" rel="stylesheet" type="text/css">

    </head>
    <body>

        <fieldset class="caja_centrada">
            <div class="error"><?php echo $msj?></div>
            <legend style="background:pink ">Subida de ficheros SARA SARA SARA</legend>
            <form action="descarga.php" method="POST" enctype="multipart/form-data">
                <br/>
                Usuario&nbsp&nbsp&nbsp <input type="text" name="name" value="<?php echo $nombre?>"  >
                <br>
                Password/contraseña <input type="text" name="pass" value="<?php echo $contraseña?>"  >
                <br/>
                <br/>
                <!-- MAX_FILE_SIZE debe preceder al campo de entrada del fichero -->
                <input type="hidden" name="MAX_FILE_SIZE" value=100000000 />
                <div style="float:right">
                    <input type="file" name="fichero"><br>
                </div>
                <br>
                <br>
                <input type="submit" value="Subir fichero y entrar" name="enviar">
                <input type="submit" value="Subir fichero" name="enviar">
                <input type="submit" value="Entrar" name="enviar">

            </form>
        </fieldset>
    </body>
</html>
