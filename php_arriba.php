<?php

$link = mysqli_connect("localhost","root","","bnexcl_moodle");
$var59='';
$var60='';
$var62='';

//obtengo valores del formulario
$Nombre=TIME();
$Categoria=$_POST['categoria'];

//Obtiene la longitud del string ---- valida el ingreso del nombre
$req = (strlen($Nombre));



//Querys


//----------------------------------------------------------------------------------
//query para crear un curso
//----------------------------------------------------------------------------------
$sql= "INSERT INTO mdlhj_course (category,fullname,shortname,summaryformat,format,showgrades,newsitems,startdate,marker,maxbytes,legacyfiles,showreports,visible,
visibleold,groupmode,groupmodeforce,defaultgroupingid, lang, timecreated,timemodified,requested,enablecompletion,completionnotify, cacherev) 
values ('$Categoria','$Nombre','$Nombre','1','topics','1','5',current_timestamp,'0','0','0','0','1','1','0','0','0','es_an',current_timestamp,current_timestamp,'0','1','0', $Nombre);";

$sql10="INSERT INTO mdlhj_grade_categories(courseid, depth, path, fullname, aggregation, keephigh, droplow, aggregateonlygraded, aggregateoutcomes, timecreated, timemodified, hidden)
    VALUES ((select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "'), '1', '0', '?', '13', '0', '0', '1', '0', current_timestamp, current_timestamp, '0');";

$sql13="INSERT INTO mdlhj_grade_categories_history (action, oldid, source, timemodified, courseid, depth, path, fullname, aggregation, aggregateonlygraded)
VALUES ('2',(select id from mdlhj_grade_categories where courseid=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "'))
	,'system',current_timestamp, (select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "'),
	'1', (select path from mdlhj_grade_categories where courseid=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "')), '?', '13', '1');";

$sql11="UPDATE mdlhj_grade_categories set path= concat('/',id,'/') where courseid=(SELECT id FROM mdlhj_course WHERE fullname='" . $Nombre . "' and category=" . $Categoria .");";

$sql1= "INSERT INTO mdlhj_course_format_options(courseid,format,sectionid,name,value) values ((SELECT id FROM mdlhj_course WHERE fullname='" . $Nombre . "' and category=" . $Categoria ."),'topics','0','numsections', '2');";


$sql2="UPDATE mdlhj_course_categories set coursecount=coursecount+1 where id=$Categoria;"; 

//----------------------------------------------------------------------------------
//query para ingresar los temas al curso
//----------------------------------------------------------------------------------

$sql3="INSERT INTO mdlhj_course_sections(course, section, name, summary, summaryformat, visible) VALUES ((SELECT id FROM mdlhj_course 
WHERE fullname='" . $Nombre. "' and category='" . $Categoria. "'), '0',(select categoryname from mdlhj_category_relation where categoryid='" . $Categoria. "'),
'Se deben realizar ambas pruebas que se presentan a continuacion,
para dar por finalizada la actividad de Cambio de Tramo','1','1');";


$sql4="INSERT INTO mdlhj_course_sections(course, section, name, summary, summaryformat, sequence, visible) 
VALUES ((SELECT id FROM mdlhj_course WHERE fullname='" . $Nombre. "' and category='" . $Categoria. "'), 
'1',
'Pruebas',
'',
'1',
(Select id from mdlhj_course_modules where course=(SELECT id FROM mdlhj_course WHERE fullname='" . $Nombre. "' and category='" . $Categoria. "') 
and instance=(Select id from mdlhj_quiz where course= (select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "')
and name='Prueba Tecnica')),
'1');";


$sql5="INSERT INTO mdlhj_course_sections(course, section, name, summaryformat, sequence, visible, availability) VALUES ((SELECT id FROM mdlhj_course 
WHERE fullname='" . $Nombre. "' and category='" . $Categoria. "'), '2', 'Certificado','1','','1',DEFAULT);";

//----------------------------------------------------------------------------------
//query para crear los cuestionarios
//----------------------------------------------------------------------------------


$sql6="INSERT INTO mdlhj_quiz (course,name, introformat, timeopen,timeclose,timelimit,overduehandling,
graceperiod,preferredbehaviour,canredoquestions,attempts,attemptonlast,grademethod,decimalpoints,questiondecimalpoints,
reviewattempt,reviewcorrectness,reviewmarks,reviewspecificfeedback,reviewgeneralfeedback,reviewrightanswer,reviewoverallfeedback,
questionsperpage,navmethod,shuffleanswers,sumgrades,grade, timecreated,timemodified,delay1,
delay2,showuserpicture,showblocks,completionattemptsexhausted,completionpass)
VALUES ((SELECT id FROM mdlhj_course WHERE fullname='" .$Nombre. "' and category= '" .$Categoria. "'),
'Prueba Tecnica', 
'1','0','0','3600',
'autosubmit','0','deferredfeedback','0',
'1','0','1','2','-1','0000','0000','4368',
'16','16','16','16','1','free','1',
'5.00000','10.00000','0','0000','0','0','1',
'0','1','1');";

$sql12="INSERT INTO mdlhj_grade_items (courseid, categoryid, itemname, itemtype, itemmodule, iteminstance, itemnumber, gradepass, sortorder, hidden,
timecreated, timemodified) 
VALUES ((select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "'), 
(select id from mdlhj_grade_categories where courseid=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "')),
 'Prueba Tecnica', 'mod','quiz',(Select id from mdlhj_quiz where course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "')
 and name='Prueba Tecnica'),'0', '8.00000','2', '1', current_timestamp, current_timestamp);";

$sql7="INSERT INTO mdlhj_course_modules(course, module, instance,  section, idnumber, added, score, indent, visible, visibleold, groupmode, groupingid, completion, 
completionview, completionexpected, showdescription)
VALUES (
(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "'), 
'16',
(select id from mdlhj_quiz where course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') and name='Prueba Tecnica'),
(select id from mdlhj_course_sections where 
course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') and section=1),
'',current_timestamp,'0','0','1','1','0','0','2',
'0','0','0');";
	
$sql16="UPDATE mdlhj_course_sections set sequence=(select id from mdlhj_course_modules where 
course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') and 
instance=(select id from mdlhj_quiz where course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') and
name='Prueba Tecnica')) where course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') and name='Pruebas';";	
	
$sql9="INSERT INTO mdlhj_course_modules(course, module, instance,  section, added, score, indent, visible, visibleold, groupmode, groupingid, completion, 
completionview, completionexpected, showdescription)
	VALUES ((select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "'), '16',(select id from mdlhj_quiz where 
	course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') and name='Prueba Seguridad') ,
	(select id from mdlhj_course_sections where course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') and section=2),
	'current_timestamp','0','0','1','1','0','0','2','0','0','0');";

$sql15="INSERT INTO mdlhj_quiz_sections(quizid, firstslot, heading, shufflequestions)
VALUES ((Select id from mdlhj_quiz where course= (select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "')
and name='Prueba Tecnica'), '1','','1');";

$sql8="INSERT INTO mdlhj_quiz (course,name, introformat, timeopen, timeclose, timelimit, overduehandling, 
graceperiod, preferredbehaviour, canredoquestions, attempts, attemptonlast, grademethod,decimalpoints,questiondecimalpoints,
reviewattempt, reviewcorrectness, reviewmarks, reviewspecificfeedback, reviewgeneralfeedback,reviewrightanswer,reviewoverallfeedback,questionsperpage,navmethod,shuffleanswers,sumgrades,grade, timecreated,timemodified,delay1,
delay2,showuserpicture,showblocks,completionattemptsexhausted,completionpass)
VALUES ((SELECT id FROM mdlhj_course WHERE fullname='" .$Nombre. "' and category= '" .$Categoria. "')
,'Prueba Seguridad', '1','0','0','3600',
'autosubmit','0','deferredfeedback','0','1','0','1',
'2','-1','0000','0000','4368','16','16','16','16',
'1','free','1','5.00000','10.00000','0','0000','0','0','1',
'0','1','1');";

$sql18="INSERT INTO mdlhj_grade_items (courseid, categoryid, itemname, itemtype, itemmodule, iteminstance, itemnumber, sortorder, hidden, timecreated, timemodified) 
VALUES ((select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "'), 
(select id from mdlhj_grade_categories where courseid=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "')),
 'Prueba Seguridad', 'mod','quiz',(Select id from mdlhj_quiz where course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "')
 and name='Prueba Seguridad'), '0','3','1', current_timestamp, current_timestamp);";
 
$sql61="INSERT INTO mdlhj_grade_items (courseid, itemtype, iteminstance, gradetype, grademax, grademin, gradepass, sortorder, timecreated, timemodified) 
VALUES ((select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "'), 
'course',(select id from mdlhj_grade_categories where courseid=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "')),
'1','100.00000', '0.00000', '0.00000', '1', current_timestamp, current_timestamp  );";

$sql19="INSERT INTO mdlhj_course_modules(course, module, instance,  section, idnumber, added, score, indent, visible, visibleold, groupmode, groupingid, completion, 
completionview, completionexpected, showdescription)
VALUES (
(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "'), 
'16',
(select id from mdlhj_quiz where course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') and name='Prueba Seguridad') ,
(select id from mdlhj_course_sections where  course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') and section=1),
'',current_timestamp,'0','0','1','1','0','0','2',
'0','0','0');";

$sql20="UPDATE mdlhj_course_sections set sequence=concat(sequence,',',(select id from mdlhj_course_modules where 
course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') and 
instance=(select id from mdlhj_quiz where course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') and
name='Prueba Seguridad'))) where course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') and name='Pruebas';";
	
$sql21="INSERT INTO mdlhj_quiz_sections(quizid, firstslot, heading, shufflequestions)
VALUES ((Select id from mdlhj_quiz where course= (select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "')
and name='Prueba Seguridad'), '1','','1');";

//----------------------------------------------------------------------------------
//-----------------------query para ingresar Certificado----------------------------
//----------------------------------------------------------------------------------

$sql14="INSERT INTO mdlhj_certificate (course, name, intro, introformat, savecert, certificatetype, orientation, bordercolor, printdate, printgrade, 
gradefmt, printsignature, printseal ) VALUES ((select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "'), 
'Certificado Proceso Cambio de Tramos', '', '1', '1', 'letter_non_embedded', 'L', '2', '1','1', '1' ,'Line.png', 'LogoANGLO.jpg');";


//----------------------------------------------------------------------------------
//query para ingresar las preguntas Técnica--- Se debe realizar 5 veces el proceso
//----------------------------------------------------------------------------------

$sql22="INSERT INTO mdlhj_question (category, parent, name, questiontext, questiontextformat, generalfeedback, generalfeedbackformat, defaultmark, penalty,
qtype, length, timecreated, timemodified)
VALUES 
((select idcategoryquestion from mdlhj_question_relation where idcategorycourse='".$Categoria."'),'','Pregunta Tecnica Aleatoria 1','0','0','','0','1.0000000','0.0000000','random','1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP );";

$sql24="INSERT INTO mdlhj_question (category, parent, name, questiontext, questiontextformat, generalfeedback, generalfeedbackformat, defaultmark, penalty,
qtype, length, timecreated, timemodified)
VALUES 
((select idcategoryquestion from mdlhj_question_relation where idcategorycourse='".$Categoria."'),'','Pregunta Tecnica Aleatoria 2','0','0','','0','1.0000000','0.0000000','random','1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP );";

$sql25="INSERT INTO mdlhj_question (category, parent, name, questiontext, questiontextformat, generalfeedback, generalfeedbackformat, defaultmark, penalty,
qtype, length, timecreated, timemodified)
VALUES 
((select idcategoryquestion from mdlhj_question_relation where idcategorycourse='".$Categoria."'),'','Pregunta Tecnica Aleatoria 3','0','0','','0','1.0000000','0.0000000','random','1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP );";

$sql26="INSERT INTO mdlhj_question (category, parent, name, questiontext, questiontextformat, generalfeedback, generalfeedbackformat, defaultmark, penalty,
qtype, length, timecreated, timemodified)
VALUES 
((select idcategoryquestion from mdlhj_question_relation where idcategorycourse='".$Categoria."'),'','Pregunta Tecnica Aleatoria 4','0','0','','0','1.0000000','0.0000000','random','1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP );";

$sql27="INSERT INTO mdlhj_question (category, parent, name, questiontext, questiontextformat, generalfeedback, generalfeedbackformat, defaultmark, penalty,
qtype, length, timecreated, timemodified)
VALUES 
((select idcategoryquestion from mdlhj_question_relation where idcategorycourse='".$Categoria."'),'','Pregunta Tecnica Aleatoria 5','0','0','','0','1.0000000','0.0000000','random','1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP );";
//--------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------
//query para ingresar las preguntas Seguridad--- Se debe realizar 5 veces el proceso
//--------------------------------------------------------------------------------------------------------------------------------
$sql38="INSERT INTO mdlhj_question (category, parent, name, questiontext, questiontextformat, generalfeedback, generalfeedbackformat, defaultmark, penalty,
qtype, length, timecreated, timemodified)
VALUES 
('160','','Pregunta Seguridad Aleatoria 1','0','0','','0','1.0000000','0.0000000','random','1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP );";

$sql39="INSERT INTO mdlhj_question (category, parent, name, questiontext, questiontextformat, generalfeedback, generalfeedbackformat, defaultmark, penalty,
qtype, length, timecreated, timemodified)
VALUES 
('160','','Pregunta Seguridad Aleatoria 2','0','0','','0','1.0000000','0.0000000','random','1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP );";

$sql40="INSERT INTO mdlhj_question (category, parent, name, questiontext, questiontextformat, generalfeedback, generalfeedbackformat, defaultmark, penalty,
qtype, length, timecreated, timemodified)
VALUES 
('160','','Pregunta Seguridad Aleatoria 3','0','0','','0','1.0000000','0.0000000','random','1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP );";

$sql41="INSERT INTO mdlhj_question (category, parent, name, questiontext, questiontextformat, generalfeedback, generalfeedbackformat, defaultmark, penalty,
qtype, length, timecreated, timemodified)
VALUES 
('160','','Pregunta Seguridad Aleatoria 4','0','0','','0','1.0000000','0.0000000','random','1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP );";

$sql42="INSERT INTO mdlhj_question (category, parent, name, questiontext, questiontextformat, generalfeedback, generalfeedbackformat, defaultmark, penalty,
qtype, length, timecreated, timemodified)
VALUES 
('160','','Pregunta Seguridad Aleatoria 5','0','0','','0','1.0000000','0.0000000','random','1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP );";




//ejecución de querys
if(mysqli_query($link,$sql)){ 
        print "<FONT SIZE=6>Pruebas Creadas Exitosamente</FONT>"; 
    }else{ 
        print "<br>No ha sido posible crear el curso. Existe un error en la query name='SQL'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    } 
	$idcurso=mysqli_insert_id($link);

if(mysqli_query($link,$sql10)){ 
        print ""; 
    }else{ 
        print "<br>No ha sido posible ingresar curso a mdlhj_grade_categories. Existe un error en la query name='SQL10'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    } 

if(mysqli_query($link,$sql11)){ 
        print ""; 
    }else{ 
        print "<br>No ha sido posible actualizar la tabla mdlhj_grade_categories. Existe un error en la query name='SQL11'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    } 

if(mysqli_query($link,$sql1)){ 
        print ""; 
    }else{ 
        print "<br>No ha sido posible modificar el número de secciones. Existe un error en la query name='SQL1'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    } 
if(mysqli_query($link,$sql2)){ 
        print ""; 
    }else{ 
        print "<br>No ha sido posible actualizar el número de cursos en la categoria. Existe un error en la query name='SQL2'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    } 
	
if(mysqli_query($link,$sql6)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear el cuestionario técnico. Existe un error en la query name='SQL6'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }     

if(mysqli_query($link,$sql12)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible ingresar cuestionario técnico a la tabla grade_items. Existe un error en la query name='SQL12'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }  

if(mysqli_query($link,$sql4)){ 
       print ""; 
    }else{ 
        print "<brNo ha sido posible actualizar el nombre de los temas. Existe un error en la query name='SQL4'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    } 	
	
if(mysqli_query($link,$sql7)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear el cuestionario tecnico. Existe un error en la query name='SQL7'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }  
	
if(mysqli_query($link,$sql3)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible actualizar el nombre de los temas. Existe un error en la query name='SQL3'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    } 


if(mysqli_query($link,$sql5)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible actualizar el nombre de los temas. Existe un error en la query name='SQL5'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }     



if(mysqli_query($link,$sql13)){ 
       print ""; 
    }else{ 
        print "<br>Existe un error en la query name='SQL13'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }    


if(mysqli_query($link,$sql14)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear el certificado. Existe un error en la query name='SQL14'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }  

  if(mysqli_query($link,$sql15)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible modificar la tabla _quiz_sections. Existe un error en la query name='SQL15'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }  
	
if(mysqli_query($link,$sql16)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible modificar la tabla _course_sections. Existe un error en la query name='SQL16'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    } 

if(mysqli_query($link,$sql8)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear la prueba de seguridad. Existe un error en la query name='SQL8'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }    
			
if(mysqli_query($link,$sql18)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear la prueba de seguridad. Existe un error en la query name='SQL8'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }  

if(mysqli_query($link,$sql61)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear la prueba de seguridad. Existe un error en la query name='SQL61'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }  
		
if(mysqli_query($link,$sql19)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear la prueba de seguridad. Existe un error en la query name='SQL8'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }  
		
if(mysqli_query($link,$sql20)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear la prueba de seguridad. Existe un error en la query name='SQL20'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }  
		
if(mysqli_query($link,$sql21)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear la prueba de seguridad. Existe un error en la query name='SQL21'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }  

//------------------------------------------------------------------------------------------------------------------
//------------------------- ¡¡¡Ejecución querys para crear preguntas a la prueba TECNICA!!!---------------------------------
//----------------------MODIFICACIÓN DE TABLA QUIZ_SLOTS PARA QUE MUESTRE LAS PREGUNTAS-----------------------------
//------------------------------------------------------------------------------------------------------------------

if(mysqli_query($link,$sql22)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear la pregunta. Existe un error en la query name='SQL22'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }	
	
	$id=mysqli_insert_id($link);
	
				//Query para actualizar el campo parent, con el ID recuperado del Insert
				
	$sql23="UPDATE mdlhj_question SET parent=id where id=$id;";
	
	            //Ingreso la query para ingresar la pregunta a la tabla mdlhj_quiz_slots usando ID
				
	$sql32="INSERT INTO mdlhj_quiz_slots (slot,quizid, page, requireprevious, questionid, maxmark) 
	VALUES ('1', (SELECT id from mdlhj_quiz where course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') 
	and name='Prueba Tecnica'), '1','0', " . $id. ",'1.0000000');";
	
if(mysqli_query($link,$sql23)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible actualizar question. Existe un error en la query name='SQL23'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }  
if(mysqli_query($link,$sql32)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear la pregunta. Existe un error en la query name='SQL32'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }	
	
//---------------------------Pregunta 2------
if(mysqli_query($link,$sql24)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear la pregunta. Existe un error en la query name='SQL24'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }		
	$id=mysqli_insert_id($link);
	
				//Query para actualizar el campo parent, con el ID recuperado del Insert

	$sql28="UPDATE mdlhj_question SET parent=id where id=$id;";
	
				//Ingreso la query para ingresar la pregunta a la tabla mdlhj_quiz_slots usando ID
	
	$sql33="INSERT INTO mdlhj_quiz_slots (slot,quizid, page, requireprevious, questionid, maxmark) 
	VALUES ('2', (SELECT id from mdlhj_quiz where course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') 
	and name='Prueba Tecnica'), '1','0', $id,'1.0000000');";

if(mysqli_query($link,$sql28)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible actualizar question. Existe un error en la query name='SQL28'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }  
if(mysqli_query($link,$sql33)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear la pregunta. Existe un error en la query name='SQL33'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }
	
//--------------------------Pregunta 3 --
if(mysqli_query($link,$sql25)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear la pregunta. Existe un error en la query name='SQL22'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }		
	$id=mysqli_insert_id($link);
	
				//Query para actualizar el campo parent, con el ID recuperado del Insert
		
	$sql29="UPDATE mdlhj_question SET parent=id where id=$id;";
	
				//Ingreso la query para ingresar la pregunta a la tabla mdlhj_quiz_slots usando ID	
	
	$sql34="INSERT INTO mdlhj_quiz_slots (slot,quizid, page, requireprevious, questionid, maxmark) 
	VALUES ('3', (SELECT id from mdlhj_quiz where course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') 
	and name='Prueba Tecnica'), '1','0', $id,'1.0000000');";
	
if(mysqli_query($link,$sql29)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible actualizar question. Existe un error en la query name='SQL29'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }
if(mysqli_query($link,$sql34)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear la pregunta. Existe un error en la query name='SQL34'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
	}
//-----------------------------Pregunta 4--
if(mysqli_query($link,$sql26)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear la pregunta. Existe un error en la query name='SQL22'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }		
	$id=mysqli_insert_id($link);
	
				//Query para actualizar el campo parent, con el ID recuperado del Insert
	
	$sql30="UPDATE mdlhj_question SET parent=id where id=$id;";
	
				//Ingreso la query para ingresar la pregunta a la tabla mdlhj_quiz_slots usando ID	
	
	$sql35="INSERT INTO mdlhj_quiz_slots (slot,quizid, page, requireprevious, questionid, maxmark) 
	VALUES ('4', (SELECT id from mdlhj_quiz where course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') 
	and name='Prueba Tecnica'), '1','0', $id,'1.0000000');";
	
if(mysqli_query($link,$sql30)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible actualizar question. Existe un error en la query name='SQL30'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }  
if(mysqli_query($link,$sql35)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear la pregunta. Existe un error en la query name='SQL35'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }		

//-----------------------------Pregunta 5----
if(mysqli_query($link,$sql27)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear la pregunta. Existe un error en la query name='SQL22'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }		
	$id=mysqli_insert_id($link);
	
				//Query para actualizar el campo parent, con el ID recuperado del Insert
	
	$sql31="UPDATE mdlhj_question SET parent=id where id=$id;";
	
				//Ingreso la query para ingresar la pregunta a la tabla mdlhj_quiz_slots usando ID	
				
	$sql36="INSERT INTO mdlhj_quiz_slots (slot,quizid, page, requireprevious, questionid, maxmark) 
	VALUES ('5', (SELECT id from mdlhj_quiz where course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') 
	and name='Prueba Tecnica'), '1','0', $id,'1.0000000');";
	
if(mysqli_query($link,$sql31)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible actualizar question. Existe un error en la query name='SQL31'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }  
if(mysqli_query($link,$sql36)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear la pregunta. Existe un error en la query name='SQL36'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }	
	
//------------------------------------------------------------------------------------------------------------------
//------------------------- ¡¡¡Ejecución querys para crear preguntas a la prueba SEGURIDAD!!!-----------------------
//----------------------MODIFICACIÓN DE TABLA QUIZ_SLOTS PARA QUE MUESTRE LAS PREGUNTAS-----------------------------
//------------------------------------------------------------------------------------------------------------------

if(mysqli_query($link,$sql38)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear la pregunta. Existe un error en la query name='SQL38'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }	
	
	$id=mysqli_insert_id($link);
	
				//Query para actualizar el campo parent, con el ID recuperado del Insert
				
	$sql43="UPDATE mdlhj_question SET parent=id where id=$id;";
	
	            //Ingreso la query para ingresar la pregunta a la tabla mdlhj_quiz_slots usando ID
				
	$sql44="INSERT INTO mdlhj_quiz_slots (slot,quizid, page, requireprevious, questionid, maxmark) 
	VALUES ('1', (SELECT id from mdlhj_quiz where course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') 
	and name='Prueba Seguridad'), '1','0', " . $id. ",'1.0000000');";
	
if(mysqli_query($link,$sql43)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible actualizar question. Existe un error en la query name='SQL43'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }  
if(mysqli_query($link,$sql44)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear la pregunta. Existe un error en la query name='SQL44'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }	
	
//---------------------------Pregunta 2------
if(mysqli_query($link,$sql39)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear la pregunta. Existe un error en la query name='SQL39'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }		
	$id=mysqli_insert_id($link);
	
				//Query para actualizar el campo parent, con el ID recuperado del Insert

	$sql45="UPDATE mdlhj_question SET parent=id where id=$id;";
	
				//Ingreso la query para ingresar la pregunta a la tabla mdlhj_quiz_slots usando ID
	
	$sql46="INSERT INTO mdlhj_quiz_slots (slot,quizid, page, requireprevious, questionid, maxmark) 
	VALUES ('2', (SELECT id from mdlhj_quiz where course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') 
	and name='Prueba Seguridad'), '1','0', $id,'1.0000000');";

if(mysqli_query($link,$sql45)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible actualizar question. Existe un error en la query name='SQL45'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }  
if(mysqli_query($link,$sql46)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear la pregunta. Existe un error en la query name='SQL46'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }
	
//--------------------------Pregunta 3 --
if(mysqli_query($link,$sql40)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear la pregunta. Existe un error en la query name='SQL40'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }		
	$id=mysqli_insert_id($link);
	
				//Query para actualizar el campo parent, con el ID recuperado del Insert
		
	$sql47="UPDATE mdlhj_question SET parent=id where id=$id;";
	
				//Ingreso la query para ingresar la pregunta a la tabla mdlhj_quiz_slots usando ID	
	
	$sql48="INSERT INTO mdlhj_quiz_slots (slot,quizid, page, requireprevious, questionid, maxmark) 
	VALUES ('3', (SELECT id from mdlhj_quiz where course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') 
	and name='Prueba Seguridad'), '1','0', $id,'1.0000000');";
	
if(mysqli_query($link,$sql47)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible actualizar question. Existe un error en la query name='SQL47'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }
if(mysqli_query($link,$sql48)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear la pregunta. Existe un error en la query name='SQL48'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
	}
//-----------------------------Pregunta 4--
if(mysqli_query($link,$sql41)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear la pregunta. Existe un error en la query name='SQL41'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }		
	$id=mysqli_insert_id($link);
	
				//Query para actualizar el campo parent, con el ID recuperado del Insert
	
	$sql49="UPDATE mdlhj_question SET parent=id where id=$id;";
	
				//Ingreso la query para ingresar la pregunta a la tabla mdlhj_quiz_slots usando ID	
	
	$sql50="INSERT INTO mdlhj_quiz_slots (slot,quizid, page, requireprevious, questionid, maxmark) 
	VALUES ('4', (SELECT id from mdlhj_quiz where course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') 
	and name='Prueba Seguridad'), '1','0', $id,'1.0000000');";
	
if(mysqli_query($link,$sql49)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible actualizar question. Existe un error en la query name='SQL49'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }  
if(mysqli_query($link,$sql50)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear la pregunta. Existe un error en la query name='SQL50'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }		

//-----------------------------Pregunta 5----
if(mysqli_query($link,$sql42)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear la pregunta. Existe un error en la query name='SQL42'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }		
	$id=mysqli_insert_id($link);
	
				//Query para actualizar el campo parent, con el ID recuperado del Insert
	
	$sql51="UPDATE mdlhj_question SET parent=id where id=$id;";
	
				//Ingreso la query para ingresar la pregunta a la tabla mdlhj_quiz_slots usando ID	
				
	$sql52="INSERT INTO mdlhj_quiz_slots (slot,quizid, page, requireprevious, questionid, maxmark) 
	VALUES ('5', (SELECT id from mdlhj_quiz where course=(select id from mdlhj_course where fullname='" .$Nombre. "' and category='" .$Categoria. "') 
	and name='Prueba Seguridad'), '1','0', $id,'1.0000000');";
	
if(mysqli_query($link,$sql51)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible actualizar question. Existe un error en la query name='SQL51'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }  
if(mysqli_query($link,$sql52)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible crear la pregunta. Existe un error en la query name='SQL52'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 	
	
	}
	
//-------------------------------------- QUERY PARA actualizar nombre del curso---------------------------------	
$sql53="update mdlhj_course set fullname=concat((select categoryname from mdlhj_category_relation where categoryid='" .$Categoria. "'),'
 /id=',$idcurso) where id=$idcurso ;";

if(mysqli_query($link,$sql53)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible actualizar el nombre del curso. Existe un error en la query name='SQL53'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }		
	
$sql54="update mdlhj_course set shortname=concat((select categoryname from mdlhj_category_relation where categoryid='" .$Categoria. "'),'
 /id=',$idcurso) where id=$idcurso ;";

if(mysqli_query($link,$sql54)){ 
       print ""; 
    }else{ 
        print "<br>No ha sido posible actualizar el nombre del curso. Existe un error en la query name='SQL53'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }	
	
//-------------------------------------- QUERY PARA AGREGAR METODO DE MATRICULACIÓN AL CURSO---------------------------------
//----------------------------------------------------------------------------------------------------------------------------------

$sql37="INSERT INTO mdlhj_enrol (enrol, status, courseid, sortorder, enrolperiod, enrolstartdate, enrolenddate, expirynotify, expirythreshold, notifyall, timecreated, timemodified)
VALUES ('manual', '0', $idcurso, '0', '0','0','0','0','0','0','$Time','$Time');";


if(mysqli_query($link,$sql37)){ 
       print "<br></br>"; 
    }else{ 
        print "<br>No ha sido posible agregar el metodo de matriculación MANUAL. Existe un error en la query name='SQL37'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }	
	

//-----------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------Agregar los 2 campos restantes a la tabla _course_format_options ---------------------------
//-----------------------------------------------------------------------------------------------------------------------------------
$sql55= "INSERT INTO mdlhj_course_format_options(courseid,format,sectionid,name,value) values ($idcurso,'topics','0','hiddensections', '0');";
$sql56= "INSERT INTO mdlhj_course_format_options(courseid,format,sectionid,name,value) values ($idcurso,'topics','0','coursedisplay', '0');";


if(mysqli_query($link,$sql55)){ 
       print ""; 
    }else{ 
        print ""; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }	
	
	
if(mysqli_query($link,$sql56)){ 
       print ""; 
    }else{ 
        print "<br>. Existe un error en la query name='SQL56'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }	

//-----------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------Insertar el certificado en la tabla course_modules para que se vea -------------------------
//-----------------------------------------------------------------------------------------------------------------------------------	
$sql59="select id from mdlhj_course_modules where course=$idcurso and instance=(select id from mdlhj_quiz 
	where course=$idcurso and name='Prueba Tecnica');"; 
	
$sql60="select id from mdlhj_course_modules where course=$idcurso and instance=(select id from mdlhj_quiz 
	where course=$idcurso and name='Prueba Seguridad');";

	
	//querys para asignarle la restricción de acceso al certificado-------------------
	
$execute59 = mysqli_query($link, $sql59);
if($row = mysqli_fetch_array($execute59))
	{
	   $var59 = $row[0];
	}	

$execute60 = mysqli_query($link, $sql60);
if($row = mysqli_fetch_array($execute60))
	{
	   $var60 = $row[0];
	}	
	
$sql58="INSERT INTO mdlhj_course_modules(course, module, instance,  section, idnumber, added, score, indent, visible, visibleold, groupmode, groupingid, completion, 
completionview, completionexpected, showdescription, availability)
VALUES (
($idcurso), 
'27',
(select id from mdlhj_certificate where course=$idcurso and name= 'Certificado Proceso Cambio de Tramos'),
(select id from mdlhj_course_sections where 
course=$idcurso and section=2),
'',current_timestamp,'0','0','1','1','0','0','1',
'0','0','0',
'{\"op\":\"&\",\"c\":[{\"type\":\"completion\",\"cm\":".$var59.",\"e\":1},
{\"type\":\"completion\",\"cm\":".$var60.",\"e\":1}],
\"showc\":[true,true]}'       
);";

if(mysqli_query($link,$sql58)){ 
       print ""; 
    }else{ 
        print "<br>. Existe un error en la query name='SQL58'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }	

	
//-----------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------Actualizar la sección "Certificado" para cargar el certificado -----------------------------
//-----------------------------------------------------------------------------------------------------------------------------------	
$sql57="update mdlhj_course_sections set sequence=(select id from mdlhj_course_modules where course=$idcurso and module='27') where course=$idcurso and name='Certificado';";
if(mysqli_query($link,$sql57)){ 
       print ""; 
    }else{ 
        print "<br>. Existe un error en la query name='SQL57'<br>"; 
        print "<i>Error:</i> ". mysqli_error($link)." <i>Código:</i> ".mysqli_errno($link) ; 
        exit(); 
    }	
	
	
//-----------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------Imprimir el nombre completo de las pruebas creadas-----------------------------
//-----------------------------------------------------------------------------------------------------------------------------------
	
$sql62="select categoryname from mdlhj_category_relation where categoryid='" .$Categoria. "';"
$execute62 = mysqli_query($link, $sql62)
if($row = mysqli_fetch_array($execute62))
	{
	   $var62 = $row[0];
	}	
		
	
print "<FONT SIZE=6><a>Las Pruebas creadas se están en: "$var62.$idcurso" </a></FONT>";
print "<FONT SIZE=6><a target='_blank' href='http://localhost/an/course/view.php?id=" . $idcurso  ."'>Ir a las Pruebas creadas</a></FONT>";

	
//-----------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------Cierro Conexión-----------------------------------------------------------------------------
	

mysqli_close($link); 
