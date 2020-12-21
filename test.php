<?php
  require 'vendor/autoload.php';
  use \Mailjet\Resources;

function sendMailLol($to,$body){
  $mj = new \Mailjet\Client('56f3b4ff4743b4841d9ef4c8fdf106ea','1ccf194681830fd98831ba69710c3406',true,['version' => 'v3.1']);
  $body = [
    'Messages' => [
      [
        'From' => [
          'Email' => "harsha.jediknight@gmail.com",
          'Name' => "UIS"
        ],
        'To' => [
          [
            'Email' => "$to",
            'Name' => "end user"
          ]
        ],
        'Subject' => "LOW attendance lol.",
        'TextPart' => "My first Mailjet email",
        'HTMLPart' => "$body",
        'CustomID' => "AppGettingStartedTest"
      ]
    ]
  ];
  $response = $mj->post(Resources::$Email, ['body' => $body]);
  if($response->success())
    return true;
  return false;
}

?>
