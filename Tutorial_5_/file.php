<?php 

$filename = "example.txt";

if (file_exists($filename) && is_readable($filename)) {
	// $file =fopen($filename, "r");
	// $content = fread($file , filesize($filename));
	// fclose($file);
	// echo $content;  
$content = file_get_contents($filename);
echo nl2br($content); 

}

else { 
	echo "file doesnt exists or is not readable";
}
 
if (file_exists ($filename) && is_writable($filename) )  {
	// $file = fopen($filename, "w");
	// fwrite( $file , $content);
	// fclose($file);
file_put_contents($filename ,"<br>". $data)
	// code...
}

else {
	echo "file doesnt exist or is not writieable"; 
} 
 
?> 
