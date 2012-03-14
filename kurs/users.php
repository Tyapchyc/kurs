<?php session_start(); ?>
<?php
	include("db.php");
	include("blocks/permission.php")
?>
<?php
	if (isset($_SESSION['user_id']))
	{
		
		if ($rowadm) {}
		else {
			Header("Location: index.php");
		}
	}
	else
	{
		Header("Location: index.php"); 
   		die('denied');
	}
?>
<?php
	if (!isset($_SESSION['lang'])) {$_SESSION['lang']='en';}
	$filename = pathinfo(__FILE__,PATHINFO_FILENAME) .'.'.pathinfo(__FILE__,PATHINFO_EXTENSION);
	$res = $db->query("SELECT * FROM page_title WHERE file='$filename'");
	$rowtitle = $res->fetch(PDO::FETCH_ASSOC);
	$title = $rowtitle[$_SESSION['lang']];
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
				$filename = pathinfo(__FILE__,PATHINFO_FILENAME) .'.'.pathinfo(__FILE__,PATHINFO_EXTENSION);
				$resus = $db->query("SELECT * FROM page_title WHERE file='$filename'");
				$rowus = $resus->fetch(PDO::FETCH_ASSOC);
				$arrayus = unserialize($rowus['array'.$_SESSION['lang']]);
				if (isset($_GET['by'])) {$by=$_GET['by'];}
//				echo "$by";
				if (!isset($by)){
				$by=0;
				}
				if (isset($_GET['b'])) {$b=$_GET['b'];} else {$b=12;}
				if ($by<0) {$by=0;}
				$handle = $db->query("SELECT count(1) FROM users");
				$tmp  = $handle->fetch(PDO::FETCH_NUM);
//				echo "<br>$tmp[0]"; 
				if ($by>=$tmp[0]) {$by=$by-$b ;}
				$res = $db->query("SELECT login, id FROM users ORDER BY login LIMIT $by, $b");
				printf ("<p><span class='left'><a href='users.php?by=%s'>&#8592;</a></span> <span class='right'><a href='users.php?by=%s'>&#8594;</a></span></p>",$by-$b,$by+$b);
				while ($myrow = $res->fetch(PDO::FETCH_ASSOC)){
					echo "<div class='userlist'><div><span>$myrow[login]</span></div>";
					echo "<p><a href='edit_user.php?id=$myrow[id]'>".$arrayus['edit']."</a>    <a href='delete_profile.php?id=$myrow[id]'>".$arrayus['remove']."</a></p></div>";
				}	
			?>
		</div>
		<div id="footer"> 
			<?php include("blocks/footer.php") ?>
		</div>
	</div>

</body>
</html>
