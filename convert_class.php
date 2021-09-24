<?php

// Путь для локальной работы с проектом
require_once __DIR__ . '/../vendor/autoload.php';
use NcJoes\OfficeConverter\OfficeConverter;


function getActionUpload($file) {
	
	//оперделяем тип фаила
	$file_name_parts = explode('.', $file['name']);
	$ext = $file_name_parts[count($file_name_parts) - 1];
	$ext = mb_strtolower($ext);
	
		
		if ($ext == 'ppt' || $ext == 'pptx'){
			   //если это PowerPoint , то надо законверить в pdf
			   
			   $path = __DIR__."/test.ppt";
			   
			   move_uploaded_file($_FILES['templateDoc']["tmp_name"], $path);
			
			   $converter = new OfficeConverter('test.ppt');
			   $converter->convertTo('test.pdf'); //generates pdf file in same directory as test-file.docx
			   
			 return 'test.pdf';  
			   
			} elseif ($ext == 'pdf') {
			
			
			$path = __DIR__."/test.pdf";
			move_uploaded_file($_FILES['templateDoc']["tmp_name"], $path);
			
			return 'test.pdf';
			} else {
				
				return 'Нельзя загружать файлы такого типа!';
			}
			
	   }	
	   
	   
function getActionConvert($file) {
	
	$file_path = getActionUpload($file);
	
	$pdfAbsolutePath = __DIR__."/".$file_path;
	
	$im = new imagick($pdfAbsolutePath);

	  $noOfPagesInPDF = $im->getNumberImages(); 

	  if ($noOfPagesInPDF) { 

		  for ($i = 0; $i < $noOfPagesInPDF; $i++) { 

			  $url = $pdfAbsolutePath.'['.$i.']'; 

			  $image = new Imagick($url);

			  $image->setImageFormat("jpg"); 
			  
			  $rand = rand(5, 15);

			  $image->writeImage(__DIR__."/".($i+1).'-'.$rand.'.jpg'); 
		      
			  $out[$i]  = ''.($i+1).'-'.$rand.'.jpg';
		      
			
		    }
	        return $out;
		}
	
	}
	
	


	
?>