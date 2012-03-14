<?php session_start();  ?>
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
		
		$name = $_POST[namenews];
            $description = $_POST[description];
            $text = $_POST[text];
	    $nameuk = $_POST[namenewsuk];
            $descriptionuk = $_POST[descriptionuk];
            $textuk = $_POST[textuk];
            $author = $_POST[author];
            $authorid = $_POST[authorid];
            $date = $_POST[date];
			$id = $_POST[id];
			if ($description=='') {
				$string = $text;
				$result = iconv("utf-8", "windows-1251", $string);
				$result = implode(array_slice(explode('<br>',wordwrap($result,150,'<br>',false)),0,1));
				$result = iconv("windows-1251","utf-8", $result);
				if($result!=$string) $result=$result."..." ;
				$description=$result;
			}
			if ($descriptionuk=='') {
				$string = $textuk;
				$result = iconv("utf-8", "windows-1251", $string);
				$result = implode(array_slice(explode('<br>',wordwrap($result,150,'<br>',false)),0,1));
				$result = iconv("windows-1251","utf-8", $result);
				if($result!=$string) $result=$result."..." ;
				$descriptionuk=$result;
			}
		
			$query = $db->prepare("UPDATE news SET nameen=?,descriptionen=?,texten=?,nameuk=?,descriptionuk=?,textuk=?,author=?,authorid=?,date=? WHERE id=?");
			//if ($res) {echo 'Completed';}
			//$query = $db->prepare("INSERT INTO news (name,description,text,author,authorid,date) VALUES (?,?,?,?,?,?)");//);
			$res = $query->execute(array($name,$description,$text,$nameuk,$descriptionuk,$textuk,$author,$authorid,$date,$id));
			if ($res) {header("Location: read.php?id=".$id);} else {echo 'error';};
		?>
            
        </div>
        <div id="footer"> 
        	<?php include("blocks/footer.php") ?>
        </div>	    
    </div>
</body>
</html>
