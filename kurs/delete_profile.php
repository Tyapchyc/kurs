<?php session_start(); ?>
<?php
	include("db.php");
	include("blocks/permission.php");
?>
<?php
	if (isset($_SESSION['user_id']))
	{
		$nowuserid=$_SESSION['user_id'];
	}
	else
	{
		Header("Location: index.php");
		die('Denied');
	}
	if (isset($_GET['id'])) {$id = $_GET['id'];}
	if (($id!=$nowuserid) and (!$rowadm))
	{
		Header("Location: index.php");
		die('Denied');
	}
	$res = $db->query("DELETE FROM users WHERE id = '$id'");
	if ($res)
	{
		echo 'ok';
		if(!strpos($_SERVER['HTTP_REFERER'],'users.php')) {unset($_SESSION['user_id']);Header("Location: index.php");}
		Header("Location:".$_SERVER['HTTP_REFERER']);
	}
	else {echo 'error';}
?>