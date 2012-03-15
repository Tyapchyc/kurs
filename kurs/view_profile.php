<?php session_start(); ?>
<?php
	include("db.php");
	include("blocks/permission.php")
?>
<?php if (isset($_SESSION['user_id'])) { 
					}
		else {
			Header("Location: index.php"); 
   			 die('Доступ закрыт');
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
            <?php
                
            	if (isset($_SESSION['user_id'])) {$id=$_SESSION['user_id'];}
		if (isset($_GET['uid'])) {$id=$_GET['uid'];}
                $res = $db->query("SELECT * FROM users WHERE id=$id");
                $myrow = $res->fetch(PDO::FETCH_ASSOC);
                $avatar="images/noavatar.gif";
                if (isset($myrow['avatar']) && ($myrow['avatar']!='')) 
                {
                    $avatar=$myrow['avatar'];
                }
		$filename = pathinfo(__FILE__,PATHINFO_FILENAME) .'.'.pathinfo(__FILE__,PATHINFO_EXTENSION);
		$resvp = $db->query("SELECT * FROM page_title WHERE file='$filename'");
		$rowbvp = $resvp->fetch(PDO::FETCH_ASSOC);
		$arrayvp = unserialize($rowbvp['array'.$_SESSION['lang']]);
               	printf("<div><p><img src='%s' width = '150px' height='150px' alt='Avatar' /></p><p>%s</p><p>%s %s</p><p>%s:%s</p><p>%s:%s</p></div>",$avatar,$myrow['email'],$myrow['lastname'],$myrow['name'],$arrayvp['created'],$myrow['created'],$arrayvp['logged'],$myrow['logged']);
                if (!isset($_GET['uid'])){
		echo "<div><p><a href='profile.php'>".$arrayvp['edit_profile']."</a></p><p> <a href='delete_profile.php?id=".$id."'>".$arrayvp['remove_profile']."</a></p></div>";
		}            
	    ?>
        </div>
        <div id="footer"> 
            <?php include("blocks/footer.php") ?>
        </div>	    
    </div>
</body>
</html>
