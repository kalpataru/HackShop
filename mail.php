<?php
 require_once('postageapp_class.inc');

 $to = $_GET['q'];

 // The subject of the message
 $subject = 'Price and Rating Comparision';
 
  $filename='http://localhost/libchart/demo/generated/final.png';
  //$handle = fopen( $filename, 'rb');
  $file_content = file_get_contents($filename);
  //fclose($handle);
  
  $attachment =array(
      'demo1.png' => array(
        'content_type' => "application/octet-stream",
        'content' => chunk_split(base64_encode($file_content), 60, "\n")
      )
    );
 // Setup some headers
 $header = array(
    'From'      => 'amitcet.05@gmail.com',
    'Reply-to'  =>  $to
 );

 // The body of the message
 $mail_body = array(
    'text/plain' => 'Price and Rating Comparision Chart',
    //'text/html' => '<h1>Testing</h1><p>in <b>HTML</b></p>'
 );

 // Send it all
 $ret = PostageApp::mail($to, $subject, $mail_body, $header, $attachment);

 // Checkout the response
 if ($ret->response->status == 'ok') {
    //echo '<br/><b>SUCCESS:</b>, An email was sent and the following response was received:';
 } else {
    //echo '<br/><b>Error sending your email:</b> '.$ret->response->message;
 }

 //echo '<pre style="text-align:left;">';
 //print_r ($ret);
 //echo '</pre>';
 //echo "mail sent";
?>
