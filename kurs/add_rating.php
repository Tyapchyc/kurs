<?php session_start();  ?>
<?php if (isset($_SESSION['user_id'])) { 
					}
		else {
			Header("Location: index.php"); 
   			 die('denied');
			}
?>
<?php
	include("db.php");
	include("blocks/permission.php");
	if (($rowrating) or ($rowadm)) {}
	else {
		Header("Location: index.php"); 
		die('denied');	
	}
?>
<?php
	if (!isset($_SESSION['lang'])) {$_SESSION['lang']='en';}
	$filename = pathinfo(__FILE__,PATHINFO_FILENAME) .'.'.pathinfo(__FILE__,PATHINFO_EXTENSION);
	$resar = $db->query("SELECT * FROM page_title WHERE file='$filename'");
	$rowtitlear = $resar->fetch(PDO::FETCH_ASSOC);
	$title = $rowtitlear[$_SESSION['lang']];
	$arrayar = unserialize($rowtitlear['array'.$_SESSION['lang']]);
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
		$nid = $_POST[nid];//$db->quote();
		$rating = $_POST[rating];
            
		$query = $db->prepare("INSERT INTO rating (nid,uid,rating) VALUES (?,?,?)");
		$res = $query->execute(array($nid,$_SESSION[user_id],$rating));
			if ($res) {echo "<a href='read.php?id=".$nid."'>".$arrayar['thank']."</a>";} else {echo 'error';};
		?>
            
        </div>
        <div id="footer"> 
        	<?php include("blocks/footer.php") ?>
        </div>	    
    </div>
</body>
</html>
