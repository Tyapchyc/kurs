<?php session_start();
?>
<?php if (isset($_SESSION['user_id'])) { 
					}
		else {
			Header("Location: index.php"); 
   			 die('Доступ закрыт');
			}
?>
<?php
	include("db.php");
	include("blocks/permission.php");
	if ($rowadm) {}
	else {
	    Header("Location: index.php"); 
	    die('denied');	
	}
?>
<?php
    $id = $_GET[id];
    $res = $db->query("DELETE FROM comments WHERE id = '$id'");
    if ($res) {echo 'ok';} else {echo 'error';};
    header("Location:".$_SERVER['HTTP_REFERER']);
?>