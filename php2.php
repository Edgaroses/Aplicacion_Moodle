<?php

//Conexión con la Base de datos y el servidor
//$link = mysql_connect("localhost","root","") or die ("<h2> No se encuentra el servidor</h2>");
$link = mysqli_connect("localhost","root","","bnexcl_moodl14");
//$db = mysql_select_db("bnexcl_moodl14", $link) or die ("<h2>Error de Conexión</h2>");

//obtengo valores del formulario
$Nombre=$_POST['nombre'];
$Categoria=$_POST['categoria'];



//Obtiene la longitud del string ---- valida el ingreso del nombre
$req = (strlen($Nombre));

//Ingresar valores a la BD
$sql= "INSERT INTO mdlhj_course (category,sortorder,fullname,shortname,summaryformat,format,showgrades,newsitems,startdate,marker,maxbytes,legacyfiles,showreports,visible,visibleold,groupmode,groupmodeforce,defaultgroupingid,timecreated,timemodified,requested,enablecompletion,completionnotify) values ('$Categoria','10003','$Nombre','$Nombre','1','topics','1','1',current_timestamp,'0','0','0','0','1','1','0','0','0',current_timestamp,current_timestamp,'0','0','0');";


$sql.= "INSERT INTO mdlhj_course_format_options(courseid,format,sectionid,name,value) values ((SELECT id FROM mdlhj_course WHERE fullname='" . $Nombre . "' and category=" . $Categoria ."),'topics','0','numsections', '2');";


$sql.="UPDATE mdlhj_course_categories set coursecount=coursecount+1 where id=$Categoria;";




if(mysqli_multi_query($link,$sql)){ 
        print "Datos insertados con éxito"; 
    }else{ 
        print "<br>No ha podido realizarse la consulta. Ha habido un error<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    } 
mysqli_close($link); 



/*
if (!$link->multi_query($sql)) {
    echo "Falló la multiconsulta: (" . $link->errno . ") " . $link->error;
}

do {
    if ($resultado = $link->store_result()) {
        var_dump($resultado->fetch_all(MYSQLI_ASSOC));
        $resultado->free();
    }
} while ($link->more_results() && $link->next_result());

echo "Creación completada";

*/

?>

