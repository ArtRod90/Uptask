<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{
    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarEmail($tipo)
    {
        $mail = new PHPMailer();
      //Server settings
      // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
      $mail->isSMTP();                                            //Send using SMTP
      $mail->Host       = 'smtp.mailtrap.io';                     //Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $mail->Username   = '10e2c4f4c9d862';                     //SMTP username
      $mail->Password   = '59b18d4795efe1';                               //SMTP password
      $mail->SMTPSecure = "tls";                             //Enable implicit TLS encryption               
      $mail->Port= 2525;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
  
      //Recipients
      $mail->setFrom('Cuentas@Uptask.com');
      $mail->addAddress("Cuentas@Uptask.com", "Uptask.com");     //Add a recipient                
      $mail->addReplyTo('Cuentas@Uptask.com');                
      
      //Attachments
      /* $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
      $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
   */
      //Content
      $mail->isHTML(true);    
      $mail->CharSet = "UTF-8";                              //Set email format to HTML
    

      if ($tipo === "crear") {
        $mail->Subject = 'Confirma tu Cuenta';
        $contenido = "<html>";
        $contenido .= "<p><b>" . $this->nombre . "</b> Has Creado tu cuenta en Uptask, porfavor confirmarla
       en el siguiente enlace</p>";
       $contenido .= "<p>Preciona aqui: <a href = 'https://morning-tor-49638.herokuapp.com/confirmar?token=" 
      . $this->token ."'>Confirmar Cuenta</a></p>";

      }elseif ($tipo === "cambiar") {
        $mail->Subject = 'Resstablece tu Password';
        $contenido = "<html>";
        $contenido .= "<p><b>" . $this->nombre . "</b> Has olvidado tu Password sigue las instrucciones
        para cambiar tu password de tu cuenta Uptask, porfavor sigue el siguiente enlace</p>";
        $contenido .= "<p>Preciona aqui: <a href = 'https://morning-tor-49638.herokuapp.com/reestablecer?token=" 
      . $this->token ."'>Reestablecer Cuenta</a></p>";
      }
      
      
      $contenido .= "<p>Si tu no creaste esta cuenta, puedes ignorar este mensaje</p>";
      $contenido .= "</html>";
     
      $mail->Body = $contenido;
      
      $mail->send();
      
    }
}