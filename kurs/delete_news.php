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
	if (($rowremove) or ($rowadm)) {}
	else {
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
			<form action="delete.php" method="get" name="regForm" enctype="multipart/form-data">
				<?php
					if ($_SESSION['lang']=='en') {
						$querynews="SELECT id,nameen,date FROM news WHERE authorid='$_SESSION[user_id]'";} else {
						$querynews="SELECT id,nameuk,date FROM news WHERE authorid='$_SESSION[user_id]'";
					}
					$res = $db->query($querynews);
					while ($myrow = $res->fetch(PDO::FETCH_ASSOC))
					{
						printf( "<p><label><input type='radio' name='id' value='%s'/>%s</label></p>",$myrow[id],$myrow['name'.$_SESSION['lang']]);
					}			
					$filename = pathinfo(__FILE__,PATHINFO_FILENAME) .'.'.pathinfo(__FILE__,PATHINFO_EXTENSION);
					$resdn = $db->query("SELECT * FROM page_title WHERE file='$filename'");
					$rowdn = $resdn->fetch(PDO::FETCH_ASSOC);
					$arraydn = unserialize($rowdn['array'.$_SESSION['lang']]);
				?>
        		<div class="inputdivnews"><input class="inputnews" type="submit" name="submit" value="<?php echo $arraydn['button'];?>"/> 
                </div>
            </form>
		</div>
		<div id="footer"> 
        	<?php include("blocks/footer.php") ?>
        </div>	    
    </div>
</body>
</html>
