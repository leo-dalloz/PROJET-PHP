<?php
    require ('../model/newPwdM.php');
    $step = $_GET['step'];
    if ($step == null)
        $msg = 'verification mail';
    else if($step == 'ok')
        $msg = 'un mail à été envoyé' ;
    else if ($step == 'error')
        $msg = 'adresse mail inexistante dans notre base de données ';
    /*
    * Laurent
    * Envoie un mail avec le token généré à l'utilisateur souhaitant changer son mot de passe
    * in : string mail de user
    */
    function sendMail($s_mail) {
      $s_token  = md5(uniqid(mt_rand(100000,999999)));
      $boundary = uniqid(mt_rand(1,1000));
      $mail1    = '../public/email1.html';
      $mail2    = '../public/email2.html';
      $handle1  = fopen($mail1,'r');
      $handle2  = fopen($mail2,'r');
      $headers  = "MIME-Version: 1.0\r\n";
      $s_obj   .= "mot de passe oublié";
      $headers .= "Content-Type: multipart/alternative;boundary=" . $boundary . "\r\n";
      // mail au format texte
      $message .= "\r\n\r\n--" . $boundary . "\r\n";
      $message .= "Content-type: text/plain;charset=utf-8\r\n\r\n";
      $message .= "mot de passe oublié ? cliquez sur ce lien : \n";
      $message .= 'http://projet-iut-info.alwaysdata.net/PROJET-PHP/controller/generatePwdC.php?token=' . $s_token . '&step=hello';
      //    mail au format html
      $message .= "\r\n\r\n--" . $boundary . "\r\n";
      $message .= "Content-type: text/html;charset=utf-8\r\n\r\n";
      $message .= fread($handle1,filesize($mail1));
      $message .= 'http://projet-iut-info.alwaysdata.net/PROJET-PHP/controller/generatePwdC.php?token=' . $s_token . '&step=hello <br><br>';
      $message .= fread($handle2,filesize($mail2));
      $message .= "\r\n\r\n--" . $boundary . "--";
      addToken($s_token,$s_mail);
      mail($s_mail,$s_obj,$message, $headers);
      fclose($handle1);
      fclose($handle2);
    } // sendMail()
    if (isset($_POST['mail'])) {
      $s_mail = $_POST['mail'];
      // si le mail existe dans la bd on averti l'utilisateur de l'envoie du mail sinon en le previent de la non existance du mail
      if(getMail($s_mail))
      {
        sendMail($s_mail);
        header('Location: newPwdC.php?step=ok');
      }
      else {
        header('Location: newPwdC.php?step=error');
      }
    }
    require ('../view/newPwdV.php');
