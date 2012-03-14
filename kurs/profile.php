<?php session_start(); ?>
<?php
	include("db.php");
	include("blocks/permission.php");
?>
<?php if (isset($_SESSION['user_id'])) {
	        $id=$_SESSION['user_id'];
                $res = $db->query("SELECT * FROM users WHERE id=$id");
                $myrow = $res->fetch(PDO::FETCH_ASSOC);

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
	$array = unserialize($rowtitle['array'.$_SESSION['lang']]);
	
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
        	<form action="update_profile.php" method="post" name="regForm" enctype="multipart/form-data">
            	<p><input value="<?php echo $_SESSION['user_id']?>" class="input" type="hidden" name="id" id="login" /></p>
            	<div class="label"><label for="password"><?php echo $array['password']?>:</label></div>
                	<div class="inputdiv"><input class="input" type="password" name="password" id="password" /></div>
                
            	<div class="label"><label for="password2"><?php echo $array['password2']?>:</label></div>
                	<div class="inputdiv"><input class="input" type="password" name="password2" id="password2" /></div>
                
		
			<div class="label"><label for="email"><?php echo $array['email']?>:</label></div>
			<div class="inputdiv"><input value="<?php echo $myrow['email']?>" class="input" type="text" name="email" id="email" /></div>			
		
            	<div class="label"><label for="name"><?php echo $array['name']?>:</label></div>
                	<div class="inputdiv"><input value="<?php echo $_SESSION['user_name']?>" class="input" type="text" name="name" id="name" /></div>
                
            	<div class="label"><label for="lastname"><?php echo $array['last_name']?>:</label></div>
                	<div class="inputdiv"><input value="<?php echo $myrow['lastname']?>" class="input" type="text" name="lastname" id="lastname" /></div>
                 	
                <div class="label"><label for="file"><?php echo $array['avatar']?>:</label></div>
                	<div class="inputdiv"><input type="file"  title="jpeg,gif" name="file" id="file" /></div>
                
            	<div class="label"><label><?php echo $array['birthday']?>:</label></div>
<!--                    <select name="dayB">
-->                        <div class="inputdiv"><?php include("blocks/birthday.php") ?></div>
<!--                    </select>
-->              
				<div class="inputdiv"><input class="input" type="submit" name="submit" value="<?php echo $array['button']?>" /> </div>
            </form>
        </div>
        <div id="footer"> 
        	<?php include("blocks/footer.php") ?>
        </div>	    
    </div>
</body>
</html>
