<?php session_start();
if (isset($_GET[id])) {$id = $_GET[id];}  ?>
<?php
	include("db.php");
	include("blocks/permission.php");
	if (($rowedit) or ($rowadm)) {}
	else {
		Header("Location: index.php"); 
		die('denied');	
	}
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
        <div id="content"> <?php 
		
		if (!isset($id)) {
			if ($_SESSION['lang']=='en') {
				$querynews="SELECT  id,nameen,author,date FROM news WHERE authorid='$_SESSION[user_id]'";} else {
				$querynews="SELECT  id,nameuk,author,date FROM news WHERE authorid='$_SESSION[user_id]'";
			}
		$res = $db->query($querynews);
		
		while ($myrow = $res->fetch(PDO::FETCH_ASSOC)){
					printf( "<p><a href='update_news.php?id=%s'>%s</a></p>",$myrow[id],$myrow['name'.$_SESSION['lang']]);
						}	}		
		
		
		else{
		$res = $db->query("SELECT  nameen,nameuk,descriptionen,descriptionuk,texten,textuk,author,date,authorid FROM news WHERE id='$id'");
		$myrow = $res->fetch(PDO::FETCH_ASSOC);
		
		$authorid = $myrow[authorid];
		$date=$myrow[date];
		$name=$myrow[nameen];
		$description=$myrow[descriptionen];
		$text=$myrow[texten];
		$nameuk=$myrow[nameuk];
		$descriptionuk=$myrow[descriptionuk];
		$textuk=$myrow[textuk];
		$author=$myrow[author];
		$filename = pathinfo(__FILE__,PATHINFO_FILENAME) .'.'.pathinfo(__FILE__,PATHINFO_EXTENSION);
		$resun = $db->query("SELECT * FROM page_title WHERE file='$filename'");
		$rowun = $resun->fetch(PDO::FETCH_ASSOC);
		$arrayun = unserialize($rowun['array'.$_SESSION['lang']]);
		if (($authorid==$_SESSION[user_id]) or ($rowadm)){
		print <<<HERE
        	<form action="update.php" method="post" name="regForm" enctype="multipart/form-data">
		<div><input value="$id" type="hidden" name="id" id="id" /></div>
            	<div class="labelnews"><label for="namenews">$arrayun[titleen]</label></div>
                	<div class="inputdivnews"><input value="$name" class="inputnews" type="text" name="namenews" id="namenews" /></div>
		
                <div class="labelnews"><label for="description">$arrayun[descriptionen]</label></div>
                	<div ><textarea class="inputnewsarea" name="description" id="description" rows="20" cols="20">$description</textarea></div>
                
                <div class="labelnews"><label for="text">$arrayun[texten]</label></div>
                	<div ><textarea class="inputtext" name="text" id="text" rows="20" cols="20">$text</textarea></div>
                
		<div class="labelnews"><label for="namenewsuk">$arrayun[titleuk]</label></div>
                	<div class="inputdivnews"><input value="$nameuk" class="inputnews" type="text" name="namenewsuk" id="namenewsuk" /></div>
		
                <div class="labelnews"><label for="descriptionuk">$arrayun[descriptionuk]</label></div>
                	<div ><textarea class="inputnewsarea" name="descriptionuk" id="descriptionuk" rows="20" cols="20">$descriptionuk</textarea></div>
                
                <div class="labelnews"><label for="textuk">$arrayun[textuk]</label></div>
                	<div ><textarea class="inputtext" name="textuk" id="textuk" rows="20" cols="20">$textuk</textarea></div>
                
            	<div class="labelnews"><label for="author">$arrayun[author]</label></div>
                	<div class="inputdivnews"><input value="$author" readonly="readonly" class="inputnews" type="text" name="author" id="author" /></div>
		<div><input value="$_SESSION[user_id]"  class="inputnews" type="hidden" name="authorid" id="authorid" /></div>
                
            	<div class="labelnews"><label for="date">$arrayun[date_news]</label></div>
                	<div class="inputdivnews"><input value="$date" class="inputnews" type="text" name="date" id="date" /></div>
                 
				<div class="inputdivnews"><input class="inputnews" type="submit" name="submit" value="$arrayun[button]" /> </div>
            </form>
HERE;
		}
		else echo 'Isnt your news';}?></div>
        <div id="footer"> 
        	<?php include("blocks/footer.php") ?>
        </div>	    
    </div>
</body>
</html>
