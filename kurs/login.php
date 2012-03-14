<?php session_start(); ?>
<?php
	include("db.php");
	if (!isset($_SESSION['lang'])) {$_SESSION['lang']='en';}
	$filename = pathinfo(__FILE__,PATHINFO_FILENAME) .'.'.pathinfo(__FILE__,PATHINFO_EXTENSION);
	$res = $db->query("SELECT * FROM page_title WHERE file='$filename'");
	$rowtitle = $res->fetch(PDO::FETCH_ASSOC);
	$title = $rowtitle[$_SESSION['lang']];
	$arraylog = unserialize($rowtitle['array'.$_SESSION['lang']]);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title;?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.5.min.js" type="text/javascript"> </script>
<script src="js/equalHeight.js" type="text/javascript"> </script>
</head>
<body>
	<div id="wrapper"> 
		<div id="header"> 
        	<?php include("blocks/header.php") ?>
        </div>
		<div id="sidebarL">
        	<?php include("blocks/sidebarL.php") ?>
        </div>
        <div id="sidebarR"> 
        	<?php include("blocks/sidebarR.php") ?>
        </div>
        <div id="content">
			<?php 
            
            if (isset($_POST['login']) && isset($_POST['password']))
            {
                $login =($_POST['login']);
                /*$password = md5($_POST['password']);
                $query = "SELECT `id`,`name`,rid FROM `users` WHERE (`login`='{$login}' OR `email`='{$login}') AND `password`='{$password}'
                        LIMIT 1";
                        $sql = $db->query($query);*/
		$user_input = $_POST['password'];
		$sql = $db->query("SELECT id,name,rid,password FROM `users` WHERE (login='$login' OR email='$login') LIMIT 1");
		    
            $row = $sql->fetch(PDO::FETCH_ASSOC);
	    if ($row) { 
		$password = $row['password'];
		if (crypt($user_input, $password)==$password) {
			if ($row['rid']=='5') {echo $arraylog['banned']; exit;} //5 роль забаненых юзеров
			else {
				$_SESSION['user_id'] = $row['id'];
				$_SESSION['user_name'] = $row['name'];
				echo 'Logining';
				$datenow =date('Y-m-d H:i:s');
				$res = $db->query("UPDATE users SET logged='$datenow' WHERE id='$row[id]'");
				Header("Location: index.php"); 
				exit;
			}
		}
                else {
                    if (isset($_SESSION['user_id'])) {unset($_SESSION['user_id']);} 
                    echo $_SESSION['user_id'];
		    echo $arraylog['incorrect'];//('Your email, login or password is incorrect, please try again.');
                }
            } else { echo $arraylog['not_found'];}}//'This login or email not found';
            ?>
		</div>
        <div id="footer"> 
        	<?php include("blocks/footer.php") ?>
        </div>	    
    </div>
</body>
</html>