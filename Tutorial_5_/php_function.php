<?php 
$str = "hello world";
echo strtolower($str);
echo strtoupper($str);
echo str_word_count($str);
echo strrev($str);
echo strlen($str);

$text= "apple, babana , orange";
$fruits = explode(',', $text); 
print_r($fruits); 
$text = implode(',' , $fruits); 









 ?>