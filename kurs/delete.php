<?php session_start();  ?>
<?php if (isset($_SESSION['user_id'])) { 
					}
		else {
			Header("Location: ../index.php"); 
   			 die('denied');
			}
?>
<?php
	include("db.php");
	include("blocks/permission.php");
	if (($rowremove) or ($rowadm)) {}
	else {
		Header("Location: index.php"); 
		die('denied');	
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Удаление новости</title>
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
			
			$id = $_GET[id];
			$res = $db->query("SELECT  authorid FROM news WHERE id='$id'");
			$myrow = $res->fetch(PDO::FETCH_ASSOC);
		
			$authorid = $myrow[authorid];
			if ($authorid!=$_SESSION[user_id]){echo 'Isnt your news';}
			else {
				$res = $db->query("DELETE FROM news WHERE id = '$id'");
				if ($res) {echo 'ok';} 
			}
		?>
            
        </div>
        <div id="footer"> 
        	<?php include("blocks/footer.php") ?>
        </div>	    
    </div>
</body>
</html>
