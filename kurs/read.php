<?php session_start(); ?>
<?php
	include("db.php");
	include("blocks/permission.php")
?>
<?php
	if (isset($_GET['id'])) {$id=$_GET['id'];}
	else{
		if (isset($_POST['nid'])) {$id=$_POST['nid']; $rid=$_POST['rid'];
			$res = $db->query("DELETE FROM rating WHERE id = '$rid'");
				 
		}	
	}
	
	if ($_SESSION['lang']=='en') {
		$querynews="SELECT nameen,texten,author,date,authorid FROM news WHERE id=$id";}
	else {
		$querynews="SELECT nameuk,textuk,author,date,authorid FROM news WHERE id=$id";
	}
	$res = $db->query($querynews);
	$myrow = $res->fetch(PDO::FETCH_ASSOC);
	$filename = pathinfo(__FILE__,PATHINFO_FILENAME) .'.'.pathinfo(__FILE__,PATHINFO_EXTENSION);
	$rest = $db->query("SELECT * FROM page_title WHERE file='$filename'");
	$rowread = $rest->fetch(PDO::FETCH_ASSOC);
	$arrayread = unserialize($rowread['array'.$_SESSION['lang']]);
	
	$queryrating="SELECT * FROM rating WHERE nid=$id";
	$resrating = $db->query($queryrating);
	$ratingnow=0;$ratinguser=false;
	while ($myrowrating = $resrating->fetch(PDO::FETCH_ASSOC)) {
		$ratingnow=$ratingnow+$myrowrating['rating'];
		$countrating++;
		if ($myrowrating['uid']==$_SESSION['user_id']) {$ratinguser=$myrowrating['rating'];$ratinguserid=$myrowrating['id'];}
	}
	if ($countrating){
		$ratingnow=round($ratingnow/$countrating,1);
		$strrating="".$arrayread['rating'].":".$ratingnow." ".$arrayread['count_rating'].":".$countrating;
	}
	else {
		$strrating="".$arrayread['norated'];
	}
/*	$res = $db->query("SELECT rid FROM users WHERE id=$_SESSION[user_id]");
	$row = $res->fetch(PDO::FETCH_ASSOC);
	$rid = $row['rid'];
	$permission = 'admin permission';
	$res = $db->query("SELECT * FROM roles_permission WHERE (rid='$rid' AND permission='$permission')");
	$rowadm = $res->fetch(PDO::FETCH_ASSOC);
	
	$permission = 'edit news';
	$res = $db->query("SELECT * FROM roles_permission WHERE (rid='$rid' AND permission='$permission')");
	$rowedit= $res->fetch(PDO::FETCH_ASSOC);
	
	$permission = 'remove news';
	$res = $db->query("SELECT * FROM roles_permission WHERE (rid='$rid' AND permission='$permission')");
	$rowremove= $res->fetch(PDO::FETCH_ASSOC);*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $myrow['name'.$_SESSION['lang']];?></title>
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
				printf( "<div class='news'><p><a href='read.php?id=%s'>%s</a></p><div>%s</div><p>%s</p><p>Author:%s</p><p> Date news:%s </p></div>",$id,$myrow['name'.$_SESSION['lang']],$strrating,$myrow['text'.$_SESSION['lang']],$myrow[author],$myrow[date]);
				if (isset($_SESSION['user_id'])) {
					if (($rowadm) or ($rowrating)){
						if (($ratinguser) ) {
							print <<<HERE
							<form action="read.php" method="post" name="comment" enctype="multipart/form-data">
							<div><input value="$id" class="inputnews" type="hidden" name="nid" id="nid" /><input value="$ratinguserid" class="inputnews" type="hidden" name="rid" id="rid" /></div>
							<div class="labelnews">$arrayread[your_mark] $ratinguser	
								<input class="buttonrating" type="submit" name="submit" value="$arrayread[button_del_rating]" />
							</div>
							</form>
							
HERE;
							
						}else {
							print <<<HERE
							<form action="add_rating.php" method="post" name="comment" enctype="multipart/form-data">
							<div><input value="$id" class="inputnews" type="hidden" name="nid" id="nid" /></div>
							<div class="labelnews">	<label>$arrayread[rating_choice]<select name="rating"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select>
																			</label>
								<input class="buttonrating" type="submit" name="submit" value="$arrayread[button_rating]" />
							</div>
							</form>
							
HERE;
							
						}
					}
					if (($rowadm) or (($rowremove) and ($myrow[authorid]==$_SESSION[user_id]))) {
						echo "<div><a href='delete.php?id=$id'>".$arrayread['remove']."</a>  ";
					}
					if (($rowadm) or (($rowedit) and ($myrow[authorid]==$_SESSION[user_id]))) {
						echo "<a href='update_news.php?id=$id'>".$arrayread['edit']."</a></div>";
					}
				}
      ?>
		<?php
		
		
		if (($rowaddcom) or ($rowadm)) { $datecom = date('Y-m-d H:i:s');
		print <<<HERE
		<form action="add_comment.php" method="post" name="comment" enctype="multipart/form-data">
		<div><input value="$id" class="inputnews" type="hidden" name="nid" id="nid2" /></div>
    <div class="labelnews"><label for="namecomment">$arrayread[title]</label></div>
    <div class="inputdivnews"><input class="inputnews" type="text" name="namecomment" id="namecomment" /></div>
		<div class="labelnews"><label for="text">$arrayread[text]</label></div>
    <div ><textarea class="inputtext" name="text" id="text" rows="20" cols="20" ></textarea></div>
		<div><input value="$datecom" class="inputnews" type="hidden" name="date" id="date" /></div>
		<div class="inputdivnews"><input class="inputnews" type="submit" name="submit" value="$arrayread[button]" /> </div>
		</form>
HERE;
		}
		?>
		<?php
			$querycom="SELECT * FROM comments WHERE nid=$id ORDER BY comments.date DESC";
			$rescom = $db->query($querycom);
			while($myrowcom = $rescom->fetch(PDO::FETCH_ASSOC)) {
				printf("<div class='commentblock'><div><a href='view_profile.php?uid=%s'>%s</a>  %s</div><div>%s</div><div>%s</div>",$myrowcom['uid'],$myrowcom['uname'],$myrowcom['date'],$myrowcom['title'],$myrowcom['text']);
				if ($rowadm) {
					printf("<div><a href='delete_comment.php?id=%s'>%s</a></div>",$myrowcom['id'],$arrayread['remove']);
				}
				echo "</div>";
			}
		?>
    </div>
    <div id="footer"> 
      <?php include("blocks/footer.php") ?>
    </div>	    
  </div>
</body>
</html>