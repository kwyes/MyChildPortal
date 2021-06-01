<?php
  $format = $_POST['format'];
  $folder = $_POST['folder'];
  $limit = $_POST['limit'];
  // $token = file_get_contents('https://api-m.bodwell.edu/canto/cantoAppToken.php?type=web');
  $url = "https://bodwell.canto.com/api/v1/tree/{$folder}?sortBy=name&sortDirection=ascending";
  $token = '';

  // create curl resource
  $options = array('http' => array(
      'method'  => "GET",
      'header' => array("Authorization: Bearer ".$token, "Cache-Control: no-cache, must-revalidate")
  ));
  $context  = stream_context_create($options);
  $response = file_get_contents($url, false, $context);
  echo $response;


 ?>
