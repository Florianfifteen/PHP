<?php

require("fonctions.inc.php");

// V�rification du mot de passe
// ----------------------------

mysql_connect($cfgHote, $cfgConsultUsr, $cfgConsultPwd);

$sql = "SELECT password FROM intervenant WHERE code=".$zlInt;
$resultat = mysql_db_query($cfgBase, $sql);
$intervenant = mysql_fetch_array($resultat);

if ($intervenant[0] == "" && $ztPassword == "")
  $ok = 1;
else
  $ok = (md5($ztPassword) == $intervenant[0]) ? 1 : 0;
  
if ( $ok == 0 ) {
  
  // Mot de passe incorrect
  // ----------------------
  
  entete("TACHES - Validation de la Connexion", "", "");

  echo "<A CLASS='Erreur'>&nbsp;&nbsp;Mot de passe incorrect !&nbsp&nbsp;</A><BR><BR>\n";
  echo "<IMG SRC='images/gauche.gif' ALIGN='absmiddle' BORDER='0'>&nbsp;<A HREF='javascript:history.go(-1)' CLASS='Liens'>Retour</A>&nbsp;\n";
  echo "</BODY></HTML>";

} else {
  
  // Mot de passe ok
  // ---------------

  
  // On met le cookie m�morisant le code Utilisateur
  setcookie("ckUtilisateur", $zlInt, time() + (3600 * 100000));

  // On g�n�re un nouveau sid

  srand(time());
  $new_sid = SessionId(8, $zlInt);

  if ($choix == "Se connecter") {

    // Acc�s aux t�ches
	// ----------------
	if ($zlInt == 1) $zlInt = 0;  // Sana, voit toutes les t�ches
  	rediriger("menu.php3?session=$new_sid&zlInt=$zlInt");

  } else {

    // Changement de mot de passe
	// --------------------------
    rediriger("saisie-new-pwd.php?session=$new_sid");

  }
}
?>