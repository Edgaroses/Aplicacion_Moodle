<?php

$link = mysqli_connect("localhost","root","","bnexcl_moodl14");

//obtengo valores del formulario
$Nombre=$_POST['nombre'];
$Categoria=$_POST['categoria'];

//Obtiene la longitud del string ---- valida el ingreso del nombre
$req = (strlen($Nombre));



//Querys
$sql= "INSERT INTO mdlhj_course (category,fullname,shortname,summaryformat,format,showgrades,newsitems,startdate,marker,maxbytes,legacyfiles,showreports,visible,visibleold,groupmode,groupmodeforce,defaultgroupingid,timecreated,timemodified,requested,enablecompletion,completionnotify) values ('$Categoria','$Nombre','$Nombre','1','topics','1','5',current_timestamp,'0','0','0','0','1','1','0','0','0',current_timestamp,current_timestamp,'0','0','0');";



$sql10="INSERT INTO mdlhj_grade_categories(courseid, depth, path, fullname, aggregation, keephigh, droplow, aggregateonlygraded, aggregateoutcomes, timecreated, timemodified, hidden)
    VALUES ((select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "'), '1', '0', '?', '13', '0', '0', '1', '0', current_timestamp, current_timestamp, '0');";



$sql13="INSERT INTO mdlhj_grade_categories_history (action, oldid, source, timemodified, courseid, depth, path, fullname, aggregation, aggregateonlygraded)
VALUES ('2',(select id from mdlhj_grade_categories where courseid=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "'))
	,'system',current_timestamp, (select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "'),
	'1', (select path from mdlhj_grade_categories where courseid=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "')), '?', '13', '1');";



$sql11="UPDATE mdlhj_grade_categories set path= concat('/',id,'/') where courseid=(SELECT id FROM mdlhj_course WHERE fullname='" . $Nombre . "' and category=" . $Categoria .");";



$sql1= "INSERT INTO mdlhj_course_format_options(courseid,format,sectionid,name,value) values ((SELECT id FROM mdlhj_course WHERE fullname='" . $Nombre . "' and category=" . $Categoria ."),'topics','0','numsections', '2');";



$sql2="UPDATE mdlhj_course_categories set coursecount=coursecount+1 where id=$Categoria;";



$sql3="INSERT INTO mdlhj_course_sections(course, section, name, summaryformat, visible, availability) VALUES ((SELECT id FROM mdlhj_course 
WHERE fullname='" . $Nombre. "' and category='" . $Categoria. "'), '0','','1','1','');";



$sql4="INSERT INTO mdlhj_course_sections(course, section, name, summary, summaryformat, sequence, visible) 
VALUES ((SELECT id FROM mdlhj_course WHERE fullname='" . $Nombre. "' and category='" . $Categoria. "'), '1',
'Pruebas','Se deben realizar ambas pruebas para dar por finalizada la actividad de Cambio de Tramo','1',
(Select id from mdlhj_course_modules where course=(SELECT id FROM mdlhj_course WHERE fullname='" . $Nombre. "' and category='" . $Categoria. "') 
and instance=(Select id from mdlhj_quiz where course= (select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "')
and name='Prueba Tecnica')),'1');";



$sql5="INSERT INTO mdlhj_course_sections(course, section, name, summaryformat, visible, availability) VALUES ((SELECT id FROM mdlhj_course 
WHERE fullname='" . $Nombre. "' and category='" . $Categoria. "'), '2', 'Certificado','1','1',DEFAULT);";



$sql6="INSERT INTO mdlhj_quiz (course,name, introformat, timeopen,timeclose,timelimit,overduehandling,
graceperiod,preferredbehaviour,canredoquestions,attempts,attemptonlast,grademethod,decimalpoints,questiondecimalpoints,
reviewattempt,reviewcorrectness,reviewmarks,reviewspecificfeedback,reviewgeneralfeedback,reviewrightanswer,reviewoverallfeedback,
questionsperpage,navmethod,shuffleanswers,sumgrades,grade, timecreated,timemodified,delay1,
delay2,showuserpicture,showblocks,completionattemptsexhausted,completionpass)
VALUES ((SELECT id FROM mdlhj_course WHERE fullname='" .$Nombre. "' and category= '" .$Categoria. "'),'Prueba Tecnica', '1','0','0','3600',
'autosubmit','0','deferredfeedback','0','0','0','1','2','-1','0000','0000','4368','0000','0000','0000','4368','1','free','1','0.00000','10.00000',
'0','0000','0','0','0','0','0','0');";



$sql12="INSERT INTO mdlhj_grade_items (courseid, categoryid, itemname, itemtype, itemmodule, iteminstance) 
VALUES ((select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "'), 
(select id from mdlhj_grade_categories where courseid=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "')),
 'Prueba Tecnica', 'mod','quiz',(Select id from mdlhj_quiz where course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "')
 and name='Prueba Tecnica'));";




$sql7="INSERT INTO mdlhj_course_modules(course, module, instance,  section, idnumber, added, score, indent, visible, visibleold, groupmode, groupingid, completion, 
completionview, completionexpected, showdescription)
VALUES (
(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "'), 
'16',
(select id from mdlhj_quiz where course=(select id 
from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') and name='Prueba Tecnica') ,
(select id from mdlhj_course_sections where 
course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') and section=1),
'',current_timestamp,'0','0','1','1','0','0','1',
'0','0','0');";

	
$sql16="UPDATE mdlhj_course_sections set sequence=(select id from mdlhj_course_modules where 
course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') and 
instance=(select id from mdlhj_quiz where course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') and
name='Prueba Tecnica')) where course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') and name='Pruebas';";	
	
	
	



$sql8="INSERT INTO mdlhj_quiz (course,name, introformat, timeopen, timeclose, timelimit, overduehandling, 
graceperiod, preferredbehaviour, canredoquestions, attempts, attemptonlast, grademethod,decimalpoints,questiondecimalpoints,
reviewattempt, reviewcorrectness, reviewmarks, reviewspecificfeedback, reviewgeneralfeedback,reviewrightanswer,reviewoverallfeedback,questionsperpage,navmethod,shuffleanswers,sumgrades,grade, timecreated,timemodified,delay1,
delay2,showuserpicture,showblocks,completionattemptsexhausted,completionpass)
VALUES ((SELECT id FROM mdlhj_course WHERE fullname='" .$Nombre. "' and category= '" .$Categoria. "'),'Prueba Seguridad', '1','0','0','3600','autosubmit','0','deferredfeedback','0','0','0','1','2','-1','0000','0000','4368','0000','0000','0000','4368','1','free','1','0.00000','10.00000','0','0000','0','0','0','0','0','0');";



$sql9="INSERT INTO mdlhj_course_modules(course, module, instance,  section, added, score, indent, visible, visibleold, groupmode, groupingid, completion, completionview, completionexpected, showdescription)
	VALUES ((select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "'), '16',(select id from mdlhj_quiz where course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') and name='Prueba Seguridad') ,(select id from mdlhj_course_sections where course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') and section=2),'1476211509','0','0','1','1','0','0','0','0','0','0');";


$sql14="INSERT INTO mdlhj_certificate (course, name, introformat, savecert, certificatetype, orientation, bordercolor, printdate, printgrade, gradefmt, printsignature, printseal ) VALUES ((select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "'), 'Certificado Aprobación Proceso Cambio de Tramos', '1', '1', 'letter_non_embedded', 'L', '2', '1','1', '1' ,'Line.png', 'LogoANGLO.jpg');";


$sql15="INSERT INTO mdlhj_quiz_sections(quizid, firstslot, heading, shufflequestions)
VALUES ((Select id from mdlhj_quiz where course= (select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "')
and name='Prueba Tecnica'), '1','','1');";




//ejecución de querys
if(mysqli_query($link,$sql)){ 
        print "Curso Creado Con exito"; 
    }else{ 
        print "<br>No ha sido posible crear el curso. Existe un error en la query name='SQL'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    } 

if(mysqli_query($link,$sql10)){ 
        print "Curso ingresado a tabla mdlhj_grade_categories con exito."; 
    }else{ 
        print "<br>No ha sido posible ingresar curso a mdlhj_grade_categories. Existe un error en la query name='SQL10'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    } 

if(mysqli_query($link,$sql11)){ 
        print "<br>Tabla mdlhj_grade_categories actualizada correctamente</br>"; 
    }else{ 
        print "<br>No ha sido posible actualizar la tabla mdlhj_grade_categories. Existe un error en la query name='SQL11'<br>"; 
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
	
if(mysqli_query($link,$sql6)){ 
       print "<br>El cuestionario técnico ha sido creado</br>"; 
    }else{ 
        print "<br>No ha sido posible crear el cuestionario técnico. Existe un error en la query name='SQL6'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }     

if(mysqli_query($link,$sql12)){ 
       print "<br>El cuestionario técnico ha sido ingresado a la tabla grade_items</br>"; 
    }else{ 
        print "<br>No ha sido posible ingresar cuestionario técnico a la tabla grade_items. Existe un error en la query name='SQL12'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }  

if(mysqli_query($link,$sql4)){ 
       print "El nombre de los temas (sección 1) ha sido actualizada"; 
    }else{ 
        print "<brNo ha sido posible actualizar el nombre de los temas. Existe un error en la query name='SQL4'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    } 	
	
if(mysqli_query($link,$sql7)){ 
       print "<br>El cuestionario de Técnico ha sido creado </br>"; 
    }else{ 
        print "<br>No ha sido posible crear el cuestionario tecnico. Existe un error en la query name='SQL7'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }  
	
if(mysqli_query($link,$sql3)){ 
       print "<br>El nombre de los temas (sección 0) ha sido actualizada</br>"; 
    }else{ 
        print "<br>No ha sido posible actualizar el nombre de los temas. Existe un error en la query name='SQL3'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    } 


if(mysqli_query($link,$sql5)){ 
       print "<br>El nombre de los temas (sección 2) ha sido actualizada</br>"; 
    }else{ 
        print "<br>No ha sido posible actualizar el nombre de los temas. Existe un error en la query name='SQL5'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }     



if(mysqli_query($link,$sql13)){ 
       print "<br>La tabla mdlhj_grade_categories_history ha sido actualizada</br>"; 
    }else{ 
        print "<br>Existe un error en la query name='SQL13'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }    


if(mysqli_query($link,$sql14)){ 
       print "<br>El certificado ha sido creado </br>"; 
    }else{ 
        print "<br>No ha sido posible crear el certificado. Existe un error en la query name='SQL14'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }  

  if(mysqli_query($link,$sql15)){ 
       print "<br>Se ha modificado la tbla _quiz_sections correctamente </br>"; 
    }else{ 
        print "<br>No ha sido posible modificar la tabla _quiz_sections. Existe un error en la query name='SQL15'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }  
	
if(mysqli_query($link,$sql16)){ 
       print "<br>Se ha actualizado correctamente la tabla mdlhj_course_sections </br>"; 
    }else{ 
        print "<br>No ha sido posible modificar la tabla _course_sections. Existe un error en la query name='SQL16'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    } 
/*
if(mysqli_query($link,$sql8)){ 
       print "<br>El cuestionario ha sido asignado a la sección Pruebas </br>"; 
    }else{ 
        print "<br>No ha sido posible asigane el cuestionario a la sección de Pruebas. Existe un error en la query name='SQL8'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }     */
mysqli_close($link); 
