<?php

require("fonctions.inc.php3");

if ($btnSuppr == " Non ") {

  // Suppression annulée
  // -------------------

  echo "<HTML><HEAD><TITLE>Suppression d'une Tâche</TITLE></HEAD><BODY>\n";
  echo "<SCRIPT LANGUAGE='JavaScript'>\n";
  echo "<!--\n";
  echo "history.go(-2);\n";
  echo "//-->\n";
  echo "</SCRIPT>\n";
  echo "</BODY></HTML>";

} else {

  // On effectue la suppression, et on affiche la liste des taches de l'utilisateur
  // ------------------------------------------------------------------------------

  mysql_connect($cfgHote, $cfgMajUsr, $cfgMajPwd);
  
  $sql = "SELECT demandeur FROM tache WHERE numero=".$code;
  $resultat = mysql_db_query($cfgBase, $sql);
  $tache = mysql_fetch_array($resultat);
  
  $zlInt = ($tache[0] == 1) ? 0 : $tache[0];

  $sql = "DELETE FROM tache WHERE numero=".$code;
  $resultat = mysql_db_query($cfgBase, $sql);

  $lien = $cfgRepTravail . "menu.php3?session=" . $session . "&zlInt=" . $zlInt;
  rediriger( $lien );

}

?>