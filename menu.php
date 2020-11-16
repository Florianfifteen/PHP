<?php

require("fonctions.inc.php3");

// Si la session n'est pas valide on quitte
// ----------------------------------------
if ( ! Session_ok($session) ) exit;

entete("Gestion des Tâches", $session, "");

?>

<!-- ------------------------------------------------------------------------------------ JS - Début -->
<SCRIPT LANGUAGE="JavaScript">
<!--
function Cocher(valeur) { document.forms[0].coTaches[valeur].checked = true; }
//-->
</SCRIPT>
<!-- -------------------------------------------------------------------------------------- JS - Fin -->

<?php

echo "<TABLE BORDER='0' CELLSPACING='0' CELLPADDING='0'><TR><TD>\n";

  echo "<TABLE BGCOLOR='#FFFFFF' BORDER='0' CELLSPACING='0' CELLPADDING='1'><TR><TD>\n";
  echo "<TABLE BGCOLOR='#5A6BA5' BORDER='0' CELLSPACING='0' CELLPADDING='10'><TR><TD>\n";

  echo "<FORM METHOD=POST ACTION='menu.php3?session=$session'>";

  // On met les cases à cocher à la valeur précédente
  // ------------------------------------------------

  if (!isset($coTaches) || $coTaches == "EnCours") {
    $chk1 = " CHECKED";
    $chk2 = "";
  } else {
    $chk1 = "";
    $chk2 = " CHECKED";
  }

  echo "&nbsp;<INPUT TYPE='radio' NAME='coTaches' VALUE='EnCours'$chk1>\n";
  echo "&nbsp;<A HREF='javascript:Cocher(0)'>Tâches en cours</A><BR>\n";
  echo "&nbsp;<INPUT TYPE='radio' NAME='coTaches' VALUE='Tout'$chk2>\n";
  echo "&nbsp;<A HREF='javascript:Cocher(1)'>Toutes les tâches</A>&nbsp;\n";

  echo "</TD></TR>\n";
  echo "<TR><TD HEIGHT='40' VALIGN='center'>\n";

  echo "&nbsp;<SELECT NAME='zlInt' SIZE='1'>\n";
  include("liste-intervenants.php3");
  echo "</SELECT>&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE='submit' VALUE=' Ok '>&nbsp;\n";


  echo "</TD></TR></TABLE>\n";
  echo "</TD></TR></TABLE>\n";

echo "</TD><TD VALIGN='middle'>\n";

  echo "&nbsp;&nbsp;&nbsp;<IMG SRC='images/droite.gif' ALIGN='absmiddle' BORDER='0'>&nbsp;<A HREF='nouv-tache.php3?session=$session' CLASS='Liens'>Nouvelle Tâche</A>&nbsp;<BR><BR>\n";
  echo "&nbsp;&nbsp;&nbsp;<IMG SRC='images/droite.gif' ALIGN='absmiddle' BORDER='0'>&nbsp;<A HREF='index.php3?session=$session' CLASS='Liens'>Se déconnecter</A>&nbsp;<BR><BR>\n";
  
echo "</TD></TR></TABLE>\n";

include("liste-taches.php3");

echo "</BODY></HTML>";

?>