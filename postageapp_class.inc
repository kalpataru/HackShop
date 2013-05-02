<?php
  // Replace 'postageapp_config.inc' with the name of the PostageApp
  // config file you have created
  require_once('postageapp_config.inc'); 

  class PostageApp
  {
    //Sends a message to Postage App
    function mail($recipient, $subject, $mail_body, $header, $file, $variables=NULL) {
      $content = array(
        'recipients'  => $recipient,
        'headers'     => array_merge($header, array('Subject' => $subject)),
        'variables'   => $variables,
  	'attachments' => $file,
        'uid'         => time()
      );
      if (is_string($mail_body)) {
        $content['template'] = $mail_body;
      } else {
        $content['content'] = $mail_body;
      }

      return PostageApp::post(
              'send_message', 
              json_encode(
                array(
                  'api_key' => POSTAGE_API_KEY, 
                  'arguments' => $content
                )
              )
             );
    }

    // Makes a call to the Postage App API
    function post($api_method, $content) {
      $ch = curl_init(POSTAGE_HOSTNAME.'/v.1.0/'.$api_method.'.json');
      curl_setopt($ch, CURLOPT_POSTFIELDS,  $content);
      curl_setopt($ch, CURLOPT_HEADER, false);
	    curl_setopt($ch, CURLOPT_PROXY, '10.3.100.211:8080');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));   
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      $output = curl_exec($ch);
      curl_close($ch);
      return json_decode($output);
    }
  }
?>
