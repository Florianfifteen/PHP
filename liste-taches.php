<?php

require("conf/config.inc.php3");

// Plage
// -----

if (isset($coTaches) && $coTaches == "Tout") {
  $tout = 1;
  $critPlage = "tache.fini LIKE \"%\"";
} else {
  $tout = 0;
  $critPlage = "tache.fini = \"N\"";
}

// Intervenant
// -----------

if (!isset($zlInt)) {
  
  if (isset($session)) {
    
	$code_demandeur = intSession($session);
	if ($code_demandeur == 1) // Big Brother (Resp. du Service), on affiche toutes les tâches
      $critInt = "";
	else
      $critInt = " AND (tache.intervenant = $code_demandeur OR tache.demandeur = $code_demandeur)";
	  
  } else {
    $critInt = "";
  }

} elseif ($zlInt == "0") {
  $critInt = "";
} else {
  $critInt = " AND (tache.intervenant = $zlInt OR tache.demandeur = $zlInt)";
}

$tri = " ORDER BY tache.fini, tache.priorite DESC, tache.intervenant";
$sql = "SELECT tache.*, intervenant.prenom FROM tache, intervenant WHERE ".$critPlage.$critInt." AND tache.intervenant = intervenant.code".$tri;

mysql_connect($cfgHote, $cfgConsultUsr, $cfgConsultPwd);
$resultat = mysql_db_query($cfgBase, $sql);
$nb_enr = mysql_num_rows($resultat);

if ($nb_enr == 0)

  echo "<BR><A CLASS='Erreur'>&nbsp;Aucune tâche trouvée pour la sélection demandée.&nbsp;</A><BR>\n";

else {

  echo "<BR>";
  echo "<TABLE WIDTH='100%' CELLSPACING='1' BORDER=0>\n";
  echo "<TR BGCOLOR='#5A6BA5'>";
  if ($tout == 1) echo "<TH>Clos</TH>";
  echo "<TH>Demandeur</TH><TH>Intervenant</TH><TH>Objet</TH><TH>Date demande</TH><TH>Echéance</TH><TH>Priorié</TH></TR>\n";
  
  while ($tache = mysql_fetch_array($resultat)) {

	$lienModif = "modif-tache.php3?code=$tache[0]&session=$session";
	
	if ($tache[5] == "N") {
	  $coche = "&nbsp;";
	  $couleurs = Array(1 => '#9DAEE8', 2=> '#B8C8FE', 3 => '#FFFFFF');
	  echo "<TR BGCOLOR='".$couleurs[$tache[8]]."'>";
    } else {
	  $coche = "<IMG SRC='images/coche.gif' BORDER=0>";
	  echo "<TR BGCOLOR='#FAE492'>";
	}

    if ($tout == 1) {
	  echo "<TD><CENTER>$coche</CENTER></TD>";
	}

    $sql = "SELECT prenom FROM intervenant WHERE code=".$tache[10];
	$resultat2 = mysql_db_query($cfgBase, $sql);
	$demandeur = mysql_fetch_array($resultat2);

    echo "<TD>&nbsp;$demandeur[0]&nbsp;</TD>";											  // Demandeur
    echo "<TD>&nbsp;$tache[11]&nbsp;</TD>";												  // Intervenant
	// Objet
	echo "<TD>&nbsp;<A HREF='$lienModif' CLASS='objet'>".htmlspecialchars($tache[9])."</A>&nbsp;</TD>";
	echo "<TD>&nbsp;".htmlspecialchars($tache[1])."&nbsp;</TD>";						  // Date demande
	echo "<TD>&nbsp;".htmlspecialchars($tache[3])."&nbsp;</TD>";						  // Echéance
	echo "<TD ALIGN='center'>&nbsp;$tache[8]&nbsp;</TD>";								  // Priorité
	echo "</TR>\n";
  }
  echo "</TABLE>\n";
}

?>