<?php

require("fonctions.inc.php");

// Si la session n'est pas valide on quitte
// ----------------------------------------
if ( ! Session_ok($session) ) exit;

entete("Gestion des Tâches", $session, "", "white");

?>

<!-- ------------------------------------------ JS ------------------------------------->
<SCRIPT LANGUAGE="JavaScript">

function Afficher_Date(nom_champ) {
  
  j = new Date();

  jour  = j.getDate();
  mois  = j.getMonth() + 1;
  an    = j.getFullYear();

  heure = j.getHours();
  min   = j.getMinutes();

  if (mois  < 10) mois  = "0" + mois;
  if (jour  < 10) jour  = "0" + jour;
  if (heure < 10) heure = "0" + heure;
  if (min   < 10) min   = "0" + min;

  if (nom_champ == "Echeance") {
    le_jour =  jour + "/" + mois + "/" + an;
    document.forms["frmSaisie"].ztEcheance.value = le_jour;
    document.forms["frmSaisie"].ztEcheance.focus();
  } else if (nom_champ == "Fin") {
    le_jour =  jour + "/" + mois + "/" + an;
    document.forms["frmSaisie"].ztFin.value = le_jour;
	document.forms["frmSaisie"].ztFin.focus();
  } else {
    le_jour =  jour + "/" + mois + "/" + an + " " + heure + ":" + min;
    document.forms["frmSaisie"].ztDemande.value = le_jour;
	document.forms["frmSaisie"].ztDemande.focus();
  }
}

</SCRIPT>
<!-- ---------------------------------- JS ---------------------------------->

&nbsp;<IMG SRC='images/gauche.gif' ALIGN='absmiddle' BORDER='0'>&nbsp;<A HREF="javascript:history.go(-1)" CLASS="Liens">Annuler</A>&nbsp;
<BR><BR>

<?php

require("conf/config.inc.php");

$nomChamps = array( 
  "Demandeur",
  "Date de la demande",
  "Intervenant",
  "Objet court (30c)",
  "Objet détaillé",
  "Echéance",
  "Priorité",
  "Réalisé",
  "Date de fin",
  "Action"
);

$sql = "SELECT * FROM tache WHERE numero=$code";

mysql_connect($cfgHote, $cfgConsultUsr, $cfgConsultPwd);
$resultat = mysql_db_query($cfgBase, $sql);
$tache = mysql_fetch_array($resultat);

// On regarde les droits de la personne connectée
// ----------------------------------------------

$code_connecte = intSession( $session, $cfgHote, $cfgConsultUsr, $cfgConsultPwd, $cfgBase );
$code_intervenant = $tache[6];
$code_demandeur   = $tache[10];

if ($code_connecte == $code_demandeur) {
  // tous les droits
  $droits1 = "";
  $droits2 = "";
} else if ($code_connecte == $code_intervenant) {
  // droits de clore la tâche seulement
  $droits1 = " DISABLED";
  $droits2 = "";
} else {
  // aucun droit
  $droits1 = " DISABLED";
  $droits2 = " DISABLED";
}

if ($droits1 == "") {
  echo "<FORM METHOD=POST ACTION='valider-suppr.php?session=$session'>\n";
  echo "<INPUT TYPE='hidden' NAME='code' VALUE='$code'>\n";
  echo "<INPUT TYPE='submit' VALUE='Supprimer cette tâche'>\n";
  echo "</FORM>\n";
}

if ($droits1 == " DISABLED" && $droits2 == " DISABLED")
  echo "<FORM>\n";
else
  echo "<FORM METHOD=POST ACTION='valider-saisies.php?session=$session' NAME='frmSaisie'>\n";

if ($droits1 == "")
  echo "<INPUT TYPE='hidden' NAME='type_maj' VALUE='tout'>";
else if ($droits2 == "")
  echo "<INPUT TYPE='hidden' NAME='type_maj' VALUE='partielle'>";

echo "<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=2>\n";
echo "<INPUT TYPE='hidden' NAME='numero' VALUE='$tache[0]'>";

for ($cpt = 0; $cpt <= 9; $cpt++) {

  if ($cpt < 7) {
    $classe1 = "champ1";
    $classe2 = "champ2";
  } else {
    $classe1 = "champ3";
    $classe2 = "champ4";
  }
  echo "<TR HEIGHT='30'><TD CLASS='$classe1'>&nbsp;$nomChamps[$cpt]&nbsp;</TD>\n";
  echo "<TD CLASS='$classe2'>&nbsp;";
  
  switch ($cpt) {

    case 0:
      $sql = "SELECT nom, prenom FROM intervenant WHERE code=$tache[10]";
      
	  mysql_connect($cfgHote, $cfgConsultUsr, $cfgConsultPwd);
      $resultat = mysql_db_query($cfgBase, $sql);
      $intervenant = mysql_fetch_array($resultat);

	  echo "<INPUT TYPE='hidden' NAME='ztDemandeur' VALUE='$tache[10]'>";
	  echo "&nbsp;$intervenant[1] $intervenant[0]&nbsp;";
	  break;

    case 1:
	  echo "<INPUT TYPE='text' NAME='ztDemande' MAXLENGTH='20' $droits1 VALUE=\"".htmlspecialchars($tache[1])."\">";
	  if ($droits1 == "") {
	    echo "&nbsp;&nbsp;";
  	    echo "<A HREF='javascript:Afficher_Date(\"Demande\")' CLASS='Liens2'>Maintenant</A>";
	  }
	  break;

	case 2:
	  if ($droits1 != "")
	    echo "<INPUT TYPE='hidden' NAME='zlInt_cache' VALUE='$tache[6]'>";
	    
  	  echo "<SELECT NAME='zlInt' $droits1>";
	  $listeLimitee = "vrai";
	  $zlInt = $tache[6];
	  include("liste-intervenants.php");
	  echo "</SELECT>";
	  break;

	case 3:
	  echo "<INPUT TYPE='text' NAME='ztObjCourt' MAXLENGTH='30' SIZE='45' VALUE=\"".htmlspecialchars($tache[9])."\"  $droits1>";
	  break;

	case 4:
	  echo "<TEXTAREA NAME='ztObjLong' ROWS='3' COLS='50' $droits1>" . $tache[2] . "</TEXTAREA>";
	  break;

	case 5:
	  echo "<INPUT TYPE='text' NAME='ztEcheance' MAXLENGTH='20' VALUE=\"".htmlspecialchars($tache[3])."\" $droits1>";
	  if ($droits1 == "") {
	    echo "&nbsp;&nbsp;";
  	    echo "<A HREF='javascript:Afficher_Date(\"Echeance\")' CLASS='Liens2'>Maintenant</A>";
	  }
	  break;

	case 6:
	  echo "<SELECT NAME='zlPriorites' $droits1>";
	  $zlPriorites = $tache[8];
	  include("liste-priorites.php");
	  echo "</SELECT>";
	  break;

	case 7:
	  if ($tache[5] == "O")
	    $coche = " CHECKED";
	  else
	    $coche = "";
	  echo "<INPUT TYPE='checkbox' NAME='ccRealise'".$coche." $droits2>";
	  break;

	case 8:
	  echo "<INPUT TYPE='text' NAME='ztFin' MAXLENGTH='20' VALUE=\"".htmlspecialchars($tache[4])."\" $droits2>";
	  if ($droits2 == "") {
	    echo "&nbsp;&nbsp;";
  	    echo "<A HREF='javascript:Afficher_Date(\"Fin\")' CLASS='Liens2'>Maintenant</A>";
	  }
	  break;

	case 9:
	  echo "<TEXTAREA NAME='ztAction' ROWS='3' COLS='50' $droits2>".$tache[7]."</TEXTAREA>";
	  break;
  }

  echo "&nbsp;</TD></TR>\n";
}

echo "</TABLE><BR>\n";

if ($droits1 != " DISABLED" || $droits2 != " DISABLED")
  echo "<INPUT TYPE='submit' VALUE='Enregistrer'>\n";

echo "</FORM></BODY></HTML>";

?>

