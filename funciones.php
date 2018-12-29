

//otro cambio
    <?php
//función que pone los acentos donde corresponde en las palabras música e imágenes
//que son los directorios donde se guardaran audios e imágenes 
function acentos($palabra){
switch ($palabra){
	case 'musica':
	$palabra="música";	
	break;
	case 'imagenes':
	$palabra="imágenes";	
	break;
}
return $palabra;}
// publicar es,simplemente pasar los ficheros de la carpeta uploads a download
function publicar($ficheros){
$public=true;
foreach ($ficheros as $fichero){
$rename= rename ("./uploads/$fichero","./download/$fichero");
$public = $rename;} }
//método utilizado para subir los ficheros
function upload_file($fichero){
$subida  = false;
$destino = './uploads/';
$origen=$fichero['tmp_name'];
$tipo = explode ('/', $fichero['type']);
//asi se reconocen los tipos,
if($tipo[0]=='audio'){
			$destino .='musica/';
	}elseif ($tipo[0]=='image'){
//el tipo se identifica en la posicion 0 como image y audio
			$destino .='imagenes/';
		}elseif ($tipo[1]=='pdf'){
// en el caso de pdf se identifica como application/pdf 
//es la posicion 1 la que identifica al archivo como pdf
			$destino .='pdf/';
}else{$destino .='otros/';
}
$destino .=str_replace(" ", "_", $fichero['name']);
$subida =move_uploaded_file($origen, $destino);
escribir_archivolog("SE HA PRODUCIDO UNA SUBIDA DE FICHEROS","info");
return $subida;
}
function muestraficheros($admin){
$html = null;
$html .= show_files_directory_download();
if($admin){
$html .= show_files_directory_upload();
}
return $html;
}
//Método par visualizar las carpetas y los ficheros de download
function show_files_directory_download(){

$html = "<h2>ESPACIO PÚBLICO DE FICHEROS</h2>";
$titulo = ' FICHEROS PREPARADOS PARA DESCARGAR';
$directorio = scandir ("./download");
$html .= "<fieldset class='fieldset1'><legend>$titulo</legend>\n";

foreach($directorio as $dir) {
	if (($dir!='.')&&($dir !=='..')){
	$texto_dir=acentos($dir);
	$html .= "<fieldset class='fieldset2'><legend class=legend2>$texto_dir</legend>\n";
	$ficheros =scandir("./download/$dir");
	$contenido=false;
	unset($ficheros[array_search('.',$ficheros)]);
	unset($ficheros[array_search('..',$ficheros)]);

		foreach ($ficheros as $fichero){
			$contenido=true;
			$html.="<a href = ./download/$dir/$fichero>$fichero</a><br/>\n";
			}	
			if($contenido==false){
			$html.= "<h3>No existen ficheros de   $texto_dir en la actualidad</h3>";
			}
			$html .="</fieldset>\n";		
			}							
			}	
					
			$html .="</fieldset>\n";
			return $html;
			}

function show_files_directory_upload(){

$html = "<h2>ZONA EXCLUSIVA DE -ADMIN- PARA PUBLICAR FICHEROS</h2>";
$titulo = 'FICHEROS PREPARADOS PARA PUBLICAR';

$directorio = scandir ("./uploads");

$html .= "<fieldset class='fieldset1'><legend>$titulo</legend>\n";
$html .= "<form action='descarga.php' method='POST' id=f1>\n";
$html .= "<input type=submit name=enviar value='publicar'
	title='PASAR LOS FICHEROS ELEGIDOS A LA ZONA PÚBLICA'
	:disabled='deshabilitado' />\n";

foreach($directorio as $dir) {
	if (($dir!='.')&&($dir !=='..')){
	$texto_dir=acentos($dir);
	$html .= "<fieldset class='fieldset2'><legend class=legend2>$texto_dir</legend>\n";
	$ficheros =scandir("./uploads/$dir");
	$contenido=false;
	unset($ficheros[array_search('.',$ficheros)]);
	unset($ficheros[array_search('..',$ficheros)]);


foreach ($ficheros as $fichero){
$contenido=true;
$html .= "<input type='checkbox' value='$dir/$fichero' name='ficheros_publicar[]'/>\n";
$html .="<a href = ./uploads/$dir/$fichero>$fichero</a><br/>\n";
}
	if($contenido==false){
		$html.= "<h3>No existen ficheros de   $texto_dir en la actualidad</h3>";
		}
$html.="</fieldset>\n";
} }
$html .="<input type=hidden name=name value='admin' />\n";
$html .="<input type=hidden name=pass value='admin' />\n";
$html .="<input type=submit name=enviar value='publicar' title='PASAR LOS FICHEROS ELEGIDOS A LA ZONA PÚBLICA':disabled='deshabilitado' />\n";
$html .="</form>\n";
$html .="</fieldset>\n";
return $html;
}




?>


