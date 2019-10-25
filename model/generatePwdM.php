<?php

  require ('../base.php');
 /*
 *Laurent
 *verifie que le token passé en paramètre existe bien dans la base de données
 *in : int token
 *out : bool
 */
  function verifToken($s_token) {
      $dbLink = dbConnect();

      // selectionne dans le tuple dans la bd qui a le même token que celui passé en paramètre
      $query  = 'SELECT * from User where token =\'' . $s_token .'\'';
      $result = testError($dbLink,$query);

      $dbRow  = mysqli_fetch_assoc($result);

      if($dbRow == null)
        return false;

       $d_currentDate = new DateTime('now');
       $d_dateToken   = DateTime::createFromFormat('Y-m-d H:i:s.u', $dbRow['dateToken']);
       var_dump($d_dateToken);
      //si la date du token est superieur à 15 min kaput
      if($d_currentDate->diff($d_dateToken)->format('%Y') < 1
        && $d_currentDate->diff($d_dateToken)->format('%m') < 1
        && $d_currentDate->diff($d_dateToken)->format('%d') < 1
        && $d_currentDate->diff($d_dateToken)->format('%i') < 1)// on met à 1 min pour les testes
           return false;
        else
           return true;
  }//verifToken()


  /*
  *Laurent
  *in : int token de l'user
  *in : string nouveau mot de passe
  */
  function changePwd($s_token,$s_newPwd) {
    $dbLink  = dbConnect();

    // met à jour  dans la BD le mot de passe de l'utilisateur qui à le même token passé en paramètre
    $query  = 'UPDATE User
               SET password = \'' . $s_newPwd .'\'
               WHERE token  = \'' . $s_token . '\'';

    $result = testError($dbLink,$query);

  }//changeMail()
