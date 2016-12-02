<?php

function email($komu,$obsah) {

require ('PHPMailer/PHPMailerAutoload.php');

$mail = new PHPMailer;


$mail->isSMTP();                                      
$mail->Host = 'smtp.seznam.cz';  
$mail->SMTPAuth = true;                               
$mail->Username = '';      //doplnit platny mail, ze ktereho to rozesilat          
$mail->Password = '';          // doplnit heslo                 
$mail->SMTPSecure = 'tls';                           
$mail->Port = 25;                                  

$mail->setFrom('kosik@codecamp.cz', 'Eva Cernikova');
$mail->addAddress($komu);    


$mail->isHTML(true);                                  

$mail->Subject = 'Potvrzení objednávky Code Camp';


$mail->Body = $obsah;


$mail->send();
   
}
