<?php session_start();
	
?>
<?php
	include("db.php");
	include("blocks/permission.php");
	if (!isset($_SESSION['lang'])) {$_SESSION['lang']='en';}
	$filename = pathinfo(__FILE__,PATHINFO_FILENAME) .'.'.pathinfo(__FILE__,PATHINFO_EXTENSION);
	$res = $db->query("SELECT * FROM page_title WHERE file='$filename'");
	$rowtitle = $res->fetch(PDO::FETCH_ASSOC);
	$title = $rowtitle[$_SESSION['lang']];
?>
<?php include("head.php")?>
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
			<?php include("blocks/content.php");
			?> 
		</div>
		<div id="footer"> 
			<?php include("blocks/footer.php") ?>
		</div>	    
	</div>
</body>
</html>