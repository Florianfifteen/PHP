<?php

try {
	$dbh = new PDO('mysql:host=localhost;dbname=todolist;charset=utf8', 'florian', 'glpi');
    foreach($dbh->query('SELECT * from todolist') as $row) {
        print_r($row);
    }
    $dbh = null;
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}

// et maintenant, fermez-la !
$sth = null;
$dbh = null;
?>
