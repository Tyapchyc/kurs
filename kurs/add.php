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
	if (($rowadd) or ($rowadm)) {}
	else {
		Header("Location: index.php"); 
		die('denied');	
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add news</title>
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
		$name = $_POST[namenews];//$db->quote();
            $description = $_POST[description];
            $text = $_POST[text];//$db->quote();
	    $nameuk = $_POST[namenewsuk];//$db->quote();
            $descriptionuk = $_POST[descriptionuk];
            $textuk = $_POST[textuk];//$db->quote();
            $author = $_POST[author];
            $authorid = $_POST[authorid];
            $date = $_POST[date];
			
		
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
			/*$query = $db->quote("INSERT INTO news (name,description,text,author,authorid,date) VALUES ('$name','$description','$text','$author','$authorid','$date')");//);
			$res = $db->query($query);*/
			$query = $db->prepare("INSERT INTO news (nameen,descriptionen,texten,nameuk,descriptionuk,textuk,author,authorid,date) VALUES (?,?,?,?,?,?,?,?,?)");//);
			$res = $query->execute(array($name,$description,$text,$nameuk,$descriptionuk,$textuk,$author,$authorid,$date));
			if ($res) {echo 'ok';} else {echo 'error';};
		?>
            
        </div>
        <div id="footer"> 
        	<?php include("blocks/footer.php") ?>
        </div>	    
    </div>
</body>
</html>
