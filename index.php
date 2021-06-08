<?php

require("fonctions.inc.php");

if (isset($session)) {

  // Il s'agit d'une déconnexion, on supprime le sid
  // -----------------------------------------------

  mysql_connect($cfgHote, $cfgMajUsr, $cfgMajPwd);
  $sql = "DELETE FROM sid WHERE sid='".$session."'";
  $resultat = mysql_db_query($cfgBase, $sql);

}

entete("Gestion des Tâches", "", "focusPassword()");

?>

<!-- ---------------------------------------------- JS ------------------------------------------->
<SCRIPT LANGUAGE="JavaScript">

function focusPassword() {
  document.forms[0].ztPassword.focus();
  document.forms[0].choix.value = "Se connecter";
}

function saisieOK() {

  if (document.forms[0].zlInt.selectedIndex == 0) {
    alert("Choisir l'utilisateur !");
    return false;
  } else
    return true;
}

function Connexion(num) {

  if (saisieOK()) {
    if (num == 1)
      document.forms[0].choix.value = "Se connecter";
    else
      document.forms[0].choix.value = "Changer de mot de passe";

    document.forms[0].submit();
  }

}

</SCRIPT>
<!-- -------------------------------------------------- JS ------------------------>

<?php

echo "<TABLE BGCOLOR='#FFFFFF' BORDER='0' CELLSPACING='0' CELLPADDING='1'><TR><TD>\n";
echo "<TABLE BGCOLOR='#9DAEE8' BORDER='0' CELLSPACING='0' CELLPADDING='10'>\n";


echo "<FORM METHOD=POST ACTION='valider-connexion.php' onSubmit='return saisieOK();'>";
echo "<TR><TD VALIGN='center'>";

echo "<BR>&nbsp;&nbsp;&nbsp;Utilisateur&nbsp;<BR>\n";
echo "&nbsp;&nbsp;&nbsp;<SELECT NAME='zlInt' SIZE='1'>\n";

// Affichage de la liste des utilisateurs
// --------------------------------------
$listeLimitee = 1;

// On récupère le cookie : code utilisateur
if (isset($ckUtilisateur)) $zlInt = $ckUtilisateur;

include("liste-intervenants.php");
echo "</SELECT>&nbsp;&nbsp;<BR><BR>\n";

echo "&nbsp;&nbsp;&nbsp;Mot de passe&nbsp;<BR>\n";
echo "&nbsp;&nbsp;&nbsp;<INPUT TYPE='password' NAME='ztPassword' MAXLENGTH='8'>&nbsp;<BR><BR>\n";

echo "</TD></TR></TABLE>\n";
echo "</TD></TR></TABLE>\n";

?>		

<BR><INPUT TYPE="hidden" NAME="choix" VALUE="Se connecter">
&nbsp;&nbsp;<IMG SRC='images/droite.gif' ALIGN='absmiddle' BORDER='0'>&nbsp;<A HREF="javascript:Connexion(1)" CLASS="Liens">Se connecter</A><BR><BR>

<?php

echo "&nbsp;&nbsp;<IMG SRC='images/droite.gif' ALIGN='absmiddle' BORDER='0'>&nbsp;<A HREF='javascript:Connexion(2)' CLASS='Liens'>Changer de mot de passe</A>\n";

?>
