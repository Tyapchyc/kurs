<?php session_start();  ?>
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
	if (($rowadd) or ($rowadm)) {}
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
        	<form action="add.php" method="post" name="regForm" enctype="multipart/form-data">
            	<div class="labelnews"><label for="namenews"><?php echo $array['titleen'];?></label></div>
                <div class="inputdivnews"><input class="inputnews" type="text" name="namenews" id="namenews" /></div>
                
               <div class="labelnews"><label for="description"><?php echo $array['descriptionen'];?></label></div>
                <div ><textarea class="inputnewsarea" name="description" id="description" rows="20" cols="20" ></textarea></div>
                
                <div class="labelnews"><label for="text"><?php echo $array['texten'];?></label></div>
                <div ><textarea class="inputtext" name="text" id="text" rows="20" cols="20" ></textarea></div>
                
		<div class="labelnews"><label for="namenewsuk"><?php echo $array['titleuk'];?></label></div>
                <div class="inputdivnews"><input class="inputnews" type="text" name="namenewsuk" id="namenewsuk" /></div>
                 
                <div class="labelnews"><label for="descriptionuk"><?php echo $array['descriptionuk'];?></label></div>
                <div ><textarea class="inputnewsarea" name="descriptionuk" id="descriptionuk" rows="20" cols="20" ></textarea></div>
                
                <div class="labelnews"><label for="textuk"><?php echo $array['textuk'];?></label></div>
                <div ><textarea class="inputtext" name="textuk" id="textuk" rows="20" cols="20"></textarea></div>
                
            	<div class="labelnews"><label for="author"><?php echo $array['author'];?></label></div>
                <div class="inputdivnews"><input value="<?php echo $_SESSION['user_name'];?>" readonly="readonly" class="inputnews" type="text" name="author" id="author" /></div>
		<div><input value="<?php echo $_SESSION['user_id'];?>"  class="inputnews" type="hidden" name="authorid" id="authorid" /></div>
                 
            	<div class="labelnews"><label for="date"><?php echo $array['date_news'];?> </label></div>
                <div class="inputdivnews"><input value="<?php echo date('Y-m-d');?>" class="inputnews" type="text" name="date" id="date" /></div>
                 
		<div class="inputdivnews"><input class="inputnews" type="submit" name="submit" value="<?php echo $array['button'];?>" /> </div>
            </form>
        </div>
        <div id="footer"> 
        	<?php include("blocks/footer.php") ?>
        </div>	    
    </div>
</body>
</html>
