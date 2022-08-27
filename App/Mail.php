<?php

namespace App;

use App\Config;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

/**
 * Mail
 *
 * PHP version 7.0
 */
class Mail
{

    /**
     * Send a message
     *
     * @param string $to Recipient
     * @param string $subject Subject
     * @param string $text Text-only content of the message
     * @param string $html HTML content of the message
     *
     * @return mixed
     */
    public static function send($to, $subject,$html,$username)
    {
      $mail = new PHPMailer();
      $mail->IsSMTP();
      $mail->Mailer = "smtp";

      $mail->SMTPDebug  = 1;  
      $mail->SMTPAuth   = TRUE;
      $mail->SMTPSecure = "tls";
      $mail->Port       = 587;
      $mail->Host       = "smtp.gmail.com";
      $mail->Username   = "hubertkozielsmtp@gmail.com";
      $mail->Password   = "tcwipzijlexwovmw";
      
      $mail->CharSet = "UTF-8";
      $mail->IsHTML(true);
      $mail->AddAddress($to, $username);
      $mail->SetFrom("hubertkozielsmtp@gmail.com", "Twój budżet") ;
      $mail->Subject = $subject;

		  $mail->MsgHTML($html); 

      if(!$mail->Send()) {
        echo "Error while sending Email.";
        var_dump($mail);
      } else {
        echo "Email sent successfully";
}
    }
}
