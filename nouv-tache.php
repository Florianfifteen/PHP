<?php

require("fonctions.inc.php3");

// Si la session n'est pas valide on quitte
// ----------------------------------------
if ( ! Session_ok($session) ) exit;

entete("Gestion des Tâches", $session, "focusDebut()", "white");

?>

<!-- ------------------------------------------------------------------------------------ JS - Début -->
<SCRIPT LANGUAGE="JavaScript">

function focusDebut() { document.forms[0].ztDemande.focus(); }
function FocusObjet() { document.forms[0].ztObjCourt.focus(); }

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
    document.forms[0].ztEcheance.value = le_jour;
    document.forms[0].ztEcheance.focus();
  } else if (nom_champ == "Fin") {
    le_jour =  jour + "/" + mois + "/" + an;
    document.forms[0].ztFin.value = le_jour;
	document.forms[0].ztFin.focus();
  } else {
    le_jour =  jour + "/" + mois + "/" + an + " " + heure + ":" + min;
    document.forms[0].ztDemande.value = le_jour;
	document.forms[0].ztDemande.focus();
  }
}
</SCRIPT>
<!-- -------------------------------------------------------------------------------------- JS - Fin -->

&nbsp;<IMG SRC='images/gauche.gif' ALIGN='absmiddle' BORDER='0'>&nbsp;<A HREF="javascript:history.go(-1)" CLASS='Liens'>Annuler</A>&nbsp;<BR>


<?php

echo "<FORM METHOD=POST ACTION='valider-saisies.php3?session=$session'>\n";
echo "<INPUT TYPE='hidden' NAME='type_maj' VALUE='tout'>";

echo "<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=2>\n";

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
	  $code_demandeur = intSession( $session );

      $sql = "SELECT nom, prenom FROM intervenant WHERE code=$code_demandeur";
      
	  mysql_connect($cfgHote, $cfgConsultUsr, $cfgConsultPwd);
      $resultat = mysql_db_query($cfgBase, $sql);
      $intervenant = mysql_fetch_array($resultat);

	  echo "<INPUT TYPE='hidden' NAME='ztDemandeur' VALUE='$code_demandeur'>";
	  echo "&nbsp;$intervenant[1] $intervenant[0]&nbsp;";
	  break;

    case 1:
	  echo "<INPUT TYPE='text' NAME='ztDemande' MAXLENGTH='20'>";
	  echo "&nbsp;&nbsp;";
	  echo "<A HREF='javascript:Afficher_Date(\"Demande\")' CLASS='Liens2'>Maintenant</A>";
	  break;

	case 2:
	  echo "<SELECT NAME='zlInt' onChange='FocusObjet()'>";
	  $listeLimitee = "vrai";
	  include("liste-intervenants.php3");
	  echo "</SELECT>";
	  break;

	case 3:
	  echo "<INPUT TYPE='text' NAME='ztObjCourt' MAXLENGTH='30' SIZE='35'>";
	  break;

	case 4:
	  echo "<TEXTAREA NAME='ztObjLong' ROWS='3' COLS='50' WRAP=virtual></TEXTAREA>";
	  break;

	case 5:
	  echo "<INPUT TYPE='text' NAME='ztEcheance' MAXLENGTH='20'>";
	  echo "&nbsp;&nbsp;";
	  echo "<A HREF='javascript:Afficher_Date(\"Echeance\")' CLASS='Liens2'>Maintenant</A>";
	  break;

	case 6:
	  echo "<SELECT NAME='zlPriorites'>";
	  include("liste-priorites.php3");
	  echo "</SELECT>";
	  break;

	case 7:
	  echo "<INPUT TYPE='checkbox' NAME='ccRealise'>";
	  break;

	case 8:
	  echo "<INPUT TYPE='text' NAME='ztFin' MAXLENGTH='20'>";
	  echo "&nbsp;&nbsp;";
	  echo "<A HREF='javascript:Afficher_Date(\"Fin\")' CLASS='Liens2'>Maintenant</A>";
	  break;

	case 9:
	  echo "<TEXTAREA NAME='ztAction' ROWS='3' COLS='50'></TEXTAREA>";
	  break;

  }

  echo "&nbsp;</TD></TR>\n";
}
?>

</TABLE>

<BR><INPUT TYPE="submit" VALUE="Enregistrer">
</FORM>

</BODY>
</HTML>