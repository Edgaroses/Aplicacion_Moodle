<?php

$link = mysqli_connect("localhost","root","","bnexcl_moodl14");

//obtengo valores del formulario
$Nombre=$_POST['nombre'];
$Categoria=$_POST['categoria'];

//Obtiene la longitud del string ---- valida el ingreso del nombre
$req = (strlen($Nombre));

//Querys
$sql= "INSERT INTO mdlhj_course (category,sortorder,fullname,shortname,summaryformat,format,showgrades,newsitems,startdate,marker,maxbytes,legacyfiles,showreports,visible,visibleold,groupmode,groupmodeforce,defaultgroupingid,timecreated,timemodified,requested,enablecompletion,completionnotify) values ('$Categoria','10003','$Nombre','$Nombre','1','topics','1','1',current_timestamp,'0','0','0','0','1','1','0','0','0',current_timestamp,current_timestamp,'0','0','0');";

$sql1= "INSERT INTO mdlhj_course_format_options(courseid,format,sectionid,name,value) values ((SELECT id FROM mdlhj_course WHERE fullname='" . $Nombre . "' and category=" . $Categoria ."),'topics','0','numsections', '2');";

$sql2="UPDATE mdlhj_course_categories set coursecount=coursecount+1 where id=$Categoria;";

$sql3="INSERT INTO mdlhj_course_sections(course, section, name, summaryformat, visible, availability) VALUES ((SELECT id FROM mdlhj_course WHERE fullname='" . $Nombre. "' and category='" . $Categoria. "'), '0','','1','1','');";

$sql4="INSERT INTO mdlhj_course_sections(course, section, name, summary, summaryformat, visible, availability) VALUES ((SELECT id FROM mdlhj_course WHERE fullname='" . $Nombre. "' and category='" . $Categoria. "'), '1','Pruebas','Se deben realizar ambas pruebas para dar por finalizada la actividad de Cambio de Tramo','1','1',DEFAULT);";

$sql5="INSERT INTO mdlhj_course_sections(course, section, name, summaryformat, visible, availability) VALUES ((SELECT id FROM mdlhj_course WHERE fullname='" . $Nombre. "' and category='" . $Categoria. "'), '2', 'Certificado','1','1',DEFAULT);";

$sql6="INSERT INTO mdlhj_quiz (course,name, introformat, timeopen,timeclose,timelimit,overduehandling,
graceperiod,preferredbehaviour,canredoquestions,attempts,attemptonlast,grademethod,decimalpoints,questiondecimalpoints,
reviewattempt,reviewcorrectness,reviewmarks,reviewspecificfeedback,reviewgeneralfeedback,reviewrightanswer,reviewoverallfeedback,questionsperpage,navmethod,shuffleanswers,sumgrades,grade, timecreated,timemodified,delay1,
delay2,showuserpicture,showblocks,completionattemptsexhausted,completionpass)
VALUES ((SELECT id FROM mdlhj_course WHERE fullname='" .$Nombre. "' and category= '" .$Categoria. "'),'Prueba Técnica', '1','0','0','3600','autosubmit','0','deferredfeedback','0','0','0','1','2','-1','0000','0000','4368','0000','0000','0000','4368','1','free','1','0.00000','10.00000','0','0000','0','0','0','0','0','0');";

$sql7="INSERT INTO mdlhj_course_modules(course, module, instance,  section, added, score, indent, visible, visibleold, groupmode, groupingid, completion, completionview, completionexpected, showdescription)
	VALUES ((select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "'), '16',(select id from mdlhj_quiz where course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') and name='Prueba Tecnica') ,(select id from mdlhj_course_sections where course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') and section=2),'1476211509','0','0','1','1','0','0','0','0','0','0');";





//ejecución de querys
if(mysqli_query($link,$sql)){ 
        print "Curso Creado Con exito"; 
    }else{ 
        print "<br>No ha sido posible crear el curso. Existe un error en la query name='SQL'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    } 

if(mysqli_query($link,$sql1)){ 
        print "<br>Número de secciones modificado con éxito</br>"; 
    }else{ 
        print "<br>No ha sido posible modificar el número de secciones. Existe un error en la query name='SQL1'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    } 
if(mysqli_query($link,$sql2)){ 
        print "La cantidad de cursos de la categoria ingresada ha sido actualizada"; 
    }else{ 
        print "<br>No ha sido posible actualizar el número de cursos en la categoria. Existe un error en la query name='SQL2'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    } 

if(mysqli_query($link,$sql3)){ 
       print "<br>El nombre de los temas ha sido actualizada</br>"; 
    }else{ 
        print "<br>No ha sido posible actualizar el nombre de los temas. Existe un error en la query name='SQL3'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    } 

if(mysqli_query($link,$sql4)){ 
       print "El nombre de los temas ha sido actualizada"; 
    }else{ 
        print "<brNo ha sido posible actualizar el nombre de los temas. Existe un error en la query name='SQL4'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    } 

if(mysqli_query($link,$sql5)){ 
       print "<br>El nombre de los temas ha sido actualizada</br>"; 
    }else{ 
        print "<br>No ha sido posible actualizar el nombre de los temas. Existe un error en la query name='SQL5'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }     

if(mysqli_query($link,$sql6)){ 
       print "<br>El cuestionario ha sido creado</br>"; 
    }else{ 
        print "<br>No ha sido posible crear el cuestionario. Existe un error en la query name='SQL6'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }     

if(mysqli_query($link,$sql7)){ 
       print "<br>El cuestionario ha sido asignado a la sección Pruebas </br>"; 
    }else{ 
        print "<br>No ha sido posible asigane el cuestionario a la sección de Pruebas. Existe un error en la query name='SQL7'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }     
mysqli_close($link); 
