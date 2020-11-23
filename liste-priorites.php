<?php

$tabPriorites = array( "1 - Faible", "2 - Normal", "3 - Urgent" );

for ($i = 1; $i <= 3; $i++) {
  $pos = $i - 1;
  if (isset($zlPriorites) && ($zlPriorites == $i))
    echo "<OPTION VALUE='$i' SELECTED>$tabPriorites[$pos]</OPTION>\n";
  else
    echo "<OPTION VALUE='$i'>$tabPriorites[$pos]</OPTION>\n";
}

?>