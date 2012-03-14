<?php 
$login = "root";
$passwd ="";
/*try {*/
$db = new PDO('mysql:host=localhost;dbname=kurs', $login, $passwd);
$db->query("set character_set_client='utf8'"); 
$db->query("set character_set_results='utf8'"); 
$db->query("set collation_connection='utf8_general_ci'");

/*} 
catch (PDOException $e) {
echo $e->getMessage();
}*/
?>
