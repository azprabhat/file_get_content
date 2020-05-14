<?php
function editProfileImage($input_param,$profile_image)
{

$filename = $profile_image['tmp_name'];
$type = $profile_image['type'];
$base_url = $BASE_URL."";
$param = 'data=' . $input_param;

define('MULTIPART_BOUNDARY', '--------------------------'.microtime(true));

$header = 'Content-Type: multipart/form-data; boundary='.MULTIPART_BOUNDARY;

define('FORM_FIELD', 'profile_image');

$file_contents = file_get_contents($filename);

$content = "--".MULTIPART_BOUNDARY."\r\n".
"Content-Disposition: form-data; name=\"profile_image\"; filename=\"".$profile_image['name']."\"\r\n".
"Content-Type: ".$type."\r\n\r\n".
$file_contents."\r\n";

$content .= "--".MULTIPART_BOUNDARY."--\r\n";

$context = stream_context_create(array(
'http' => array(
'method' => 'POST',
'header' => $header,
'content' => $content,
)
));

$output = file_get_contents($base_url . "?" . enc($param), false, $context );

if ($output !== false) {
return dec($output);
} else {
return "Fail";
}
}	
?>