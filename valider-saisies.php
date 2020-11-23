<?php

require("fonctions.inc.php");

function Rien($chaine) {
  return $chaine;
}

// Si la session n'est pas valide on quitte
// ----------------------------------------
if ( ! Session_ok($session) ) exit;

$ok = 1;

// Vérification des Saisies
// ------------------------
$ztDemande  = trim($ztDemande);
$ztObjCourt = trim($ztObjCourt);
$ztObjLong  = trim($ztObjLong);
$ztEcheance = trim($ztEcheance);
$ztFin      = trim($ztFin);
$ztAction   = trim($ztAction);

if ($ccRealise == "on")
  $ccRealise = "O";
else
  $ccRealise = "N";

if (($ztDemande == "") && ($type_maj == "tout")) {
  $erreur = "Date de la demande invalide";
  $ok = 0;
} else if (($zlInt == 0) && ($type_maj == "tout"))  {
  $erreur = "Intervenant non sélectionné";
  $ok = 0;
} else if (($ztObjCourt == "") && ($type_maj == "tout")) {
  $erreur = "Objet court invalide";
  $ok = 0;
} else if (($ztObjLong == "") && ($type_maj == "tout")) {
  $erreur = "Objet détaillé invalide";
  $ok = 0;
} else if (($ztEcheance == "") && ($type_maj == "tout")) {
  $erreur = "Date d'échéance invalide";
  $ok = 0;
} else if (($zlPriorites == 0) && ($type_maj == "tout")) {
  $erreur = "Priorité non sélectionnée";
  $ok = 0;
} else if ($ccRealise == 'O') {
  if ($ztFin == "") {
    $erreur = "Date de fin invalide";
    $ok = 0;
  } else if ($ztAction == "") {
    $erreur = "Action réalisée invalide";
    $ok = 0;
  }
}

if ($ok == 0) {

  // Saisie invalide
  // ---------------

  entete("TACHES - Validation des Saisies", $session, "");

  echo "<A CLASS='Erreur'>&nbsp;$erreur !&nbsp;</A><BR><BR>\n";
  echo "&nbsp;<IMG SRC='images/gauche.gif' ALIGN='absmiddle' BORDER='0'>&nbsp;<A HREF='javascript:history.go(-1)' CLASS='Liens'>Retour</A>&nbsp;\n";
  echo "</BODY></HTML>";

} else {

  // Saisie ok, on enregistre, et on affiche la liste des taches de l'utilisateur
  // ----------------------------------------------------------------------------

  $site = "phpInfo";

  if ($site == "web2o") {
    $Traitement = "AddSlashes";
  } else {
    $Traitement = "Rien";
  }

  if (isset($numero)) {

    // Mise à jour d'une tâche
	// -----------------------
    
    if ($type_maj == "partielle") {
	  
	  //$ztAction = nl2br( $ztAction );

      $liste_valeurs = "date_fin='".$Traitement($ztFin)."', fini='$ccRealise',action='".$Traitement($ztAction)."'";
	  $zlInt = $zlInt_cache;

	} else {

	  $liste_valeurs = "demandeur='".$Traitement($ztDemandeur)."',date_demande='".$Traitement($ztDemande)."', objet='".$Traitement($ztObjLong)."', echeance='".$Traitement($ztEcheance)."', date_fin='".$Traitement($ztFin)."', fini='$ccRealise', intervenant='$zlInt', action='".$Traitement($ztAction)."', priorite='$zlPriorites', objet_court='".$Traitement($ztObjCourt)."'";
	}

    $sql = "UPDATE tache SET $liste_valeurs WHERE numero=$numero";
  
  } else {

    // Création d'une nouvelle tâche
	// -----------------------------

	$liste_champs = 'demandeur, date_demande, objet, echeance, date_fin, fini, intervenant, action, priorite, objet_court';
    $liste_valeurs = "'$ztDemandeur', '".$Traitement($ztDemande)."', '".$Traitement($ztObjLong)."', '".$Traitement($ztEcheance)."', '".$Traitement($ztFin)."', '$ccRealise', '$zlInt', '".$Traitement($ztAction)."', '$zlPriorites', '".$Traitement($ztObjCourt)."'";
  
	$sql = "INSERT INTO tache ($liste_champs) VALUES ($liste_valeurs)";
  }

  mysql_connect($cfgHote, $cfgMajUsr, $cfgMajPwd);
  $resultat = mysql_db_query($cfgBase, $sql);

  $code_demandeur = intSession($session);
  $code_demandeur = ($code_demandeur == 1) ? 0 : $code_demandeur;

  $lien = $cfgRepTravail. "menu.php?session=" . $session . "&zlInt=" . $code_demandeur;
  rediriger($lien);
  
}

?>