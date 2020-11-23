<?php

require("fonctions.inc.php");

// Si la session n'est pas valide on quitte
// ----------------------------------------
if ( ! Session_ok($session) ) exit;

entete("SIR - Gestion des Tâches", $session, "", "white");

?>

&nbsp;<IMG SRC='images/gauche.gif' ALIGN='absmiddle' BORDER='0'>&nbsp;<A HREF="javascript:history.go(-1)"  CLASS='Liens'>Retour</A>&nbsp;<BR>

<FORM METHOD=POST ACTION="suppr-tache.php3?session=<?php echo $session; ?>&code=<?php echo $code; ?>">
<A CLASS='liens3'>Etes-vous sûr de vouloir supprimer cette tâche ?</A><BR><BR>

<INPUT TYPE="submit" NAME="btnSuppr" VALUE=" Oui ">&nbsp;&nbsp;
<INPUT TYPE="submit" NAME="btnSuppr" VALUE=" Non ">
</FORM>

</BODY>
</HTML>