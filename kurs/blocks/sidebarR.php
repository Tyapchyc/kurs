<?php
$filename = pathinfo(__FILE__,PATHINFO_FILENAME) .'.'.pathinfo(__FILE__,PATHINFO_EXTENSION);
	$res = $db->query("SELECT * FROM page_title WHERE file='$filename'");
	$rowbar = $res->fetch(PDO::FETCH_ASSOC);
	$arraybar = unserialize($rowbar['array'.$_SESSION['lang']]);
if (isset($_SESSION['user_id'])){
	
	/*include("db.php");
	$res = $db->query("SELECT rid FROM users WHERE id=$_SESSION[user_id]");
	$row = $res->fetch(PDO::FETCH_ASSOC);
	$rid = $row['rid'];
	$permission = 'admin permission';
	$res = $db->query("SELECT * FROM roles_permission WHERE (rid='$rid' AND permission='$permission')");
	$rowadm = $res->fetch(PDO::FETCH_ASSOC);
	
	$permission = 'add news';
	$res = $db->query("SELECT * FROM roles_permission WHERE (rid='$rid' AND permission='$permission')");
	$rowadd= $res->fetch(PDO::FETCH_ASSOC);
	
	$permission = 'edit news';
	$res = $db->query("SELECT * FROM roles_permission WHERE (rid='$rid' AND permission='$permission')");
	$rowedit= $res->fetch(PDO::FETCH_ASSOC);
	
	$permission = 'remove news';
	$res = $db->query("SELECT * FROM roles_permission WHERE (rid='$rid' AND permission='$permission')");
	$rowremove= $res->fetch(PDO::FETCH_ASSOC);*/
	
	echo "
		<p>".$arraybar['greeting'].",<a href='view_profile.php'>". $_SESSION['user_name']."</a></p>
		<p><a href='view_profile.php'>".$arraybar['profile']."</a>
		</p>";
		if (($rowadm) or ($rowadd)) {
			echo "<p><a href='add_news.php'>".$arraybar['add_news']."</a></p>";
		}
		if (($rowadm) or ($rowedit)) {
			echo "<p><a href='update_news.php'>".$arraybar['edit_news']."</a></p>";
		}
		if (($rowadm) or ($rowremove)) {
			echo "<p><a href='delete_news.php'>".$arraybar['remove_news']."</a></p>";
		}
		
		if ($rowadm)
		{
			echo "<p><a href='users.php'>".$arraybar['user_list']."</a></p>";
			echo "<p><a href='edit_text.php'>".$arraybar['edit_text']."</a></p>";
		}
		echo "<p><a href='logout.php'>".$arraybar['logout']."</a></p>";

	}
		else { 
			echo "<form action='login.php' method='post' name='loginphp' enctype='multipart/form-data'>
					<div><label for='login'>".$arraybar['login'].":</label></div>
					<div><input type='text' name='login' id='login' /></div>
					<div><label for='password'>".$arraybar['password'].":</label></div>
					<div><input type='password' name='password' id='password' /></div>
					<div id='buttonlogin'><input type='submit' name='submit' value='".$arraybar['button']."' /></div>
				</form>
				<form action='registration.php' method='post' name='registrationphp' enctype='multipart/form-data'>
					<div id='buttonreg'><input type='submit' name='submit' value='".$arraybar['registration']."' /></div>
				</form>";
			/*printf ("<form action='login.php' method='post' name='loginphp' enctype='multipart/form-data'>
					<div><label for='login'>%s:</label></div>
					<div><input type='text' name='login' id='login' /></div>
					<div><label for='password'>%s:</label></div>
					<div><input type='password' name='password' id='password' /></div>
					<div id='buttonlogin'><input type='submit' name='submit' value='%s' /></div>
				</form>
				<form action='registration.php' method='post' name='registrationphp' enctype='multipart/form-data'>
					<div id='buttonreg'><input type='submit' name='submit' value='Registration' /></div>
				</form>",$arraybar['login'],$arraybar['password'],$arraybar['button']);	*/			
			}
?>

