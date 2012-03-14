<?php session_start();  ?>
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
	if (isset($_SESSION['user_id']))
	{
		$completed = false;
		if ($rowadm) {
                    if (isset($_GET['id'])) {$id=$_GET['id'];}
                    if (isset($_POST['id'])) {$id=$_POST['id'];$role=$_POST['roles'];
                    
                        $res = $db->query("UPDATE users SET rid='$role' WHERE id='$id'");
                        if ($res) $completed = true;
                    }
                }
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
                if ($completed) {echo "Completed";}
            ?>
        
            <form action="edit_user.php" method="post" name="editform" enctype="multipart/form-data">
            <input hidden = 'hidden' value=<?php echo $id; ?> type="text" name="id" id="id">              
                    <?php
                    
                        $res = $db->query("SELECT rid, login FROM users WHERE id='$id'");
                        $row = $res->fetch(PDO::FETCH_ASSOC);
                        $rid = $row['rid'];
                        echo "<div>Login: $row[login]</div><div>role: ";
                        echo "<select name='roles'></div>";
                        $res = $db->query("SELECT * FROM roles ORDER BY name");                       
                        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                            if ($row['rid'] == $rid){

                                echo "<option selected = 'selected' value='$row[rid]'>$row[name]</option>";    
                            }
                            else
                            {

                                echo "<option value='$row[rid]'>$row[name]</option>";
                            }
                        }
                    ?>
                </select>                    
                <div><input class="editbutton" type="submit" name="submit" value="Save" /></div>
            </form>
        </div>
        <div id="footer"> 
            <?php include("blocks/footer.php") ?>
        </div>	    
    </div>
</body>
</html>
