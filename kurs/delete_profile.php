<?php session_start(); ?>
<?php
	include("db.php");
	include("blocks/permission.php");
?>
<?php
	if (isset($_SESSION['user_id']))
	{
		$nowuserid=$_SESSION['user_id'];
	}
	else
	{
		Header("Location: index.php");
		die('Denied');
	}
	if (isset($_GET['id'])) {$id = $_GET['id'];}
	if (isset($_POST['id'])) {$id = $_POST['id'];}
	if (($id!=$nowuserid) and (!$rowadm))
	{
		Header("Location: index.php");
		die('Denied');
	}
?>
<?php
	if (!isset($_SESSION['lang'])) {$_SESSION['lang']='en';}
	$filename = pathinfo(__FILE__,PATHINFO_FILENAME) .'.'.pathinfo(__FILE__,PATHINFO_EXTENSION);
	$res = $db->query("SELECT * FROM page_title WHERE file='$filename'");
	$rowtitle = $res->fetch(PDO::FETCH_ASSOC);
	$title = $rowtitle[$_SESSION['lang']];
	$arraydp = unserialize($rowtitle['array'.$_SESSION['lang']]);
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
		<?php if (!isset($_POST['id'])) {
			print <<<HERE
			<div>
				<form action="delete_profile.php" method="post" name="delForm" enctype="multipart/form-data"><div>$arraydp[msg]</div>
					<div><input value='$id' type='hidden' name='id' />
					<input value='$_SERVER[HTTP_REFERER]' type='hidden' name='ref' />
					<input class="input" type="submit" name="submit" value="$arraydp[button]" />
					<a href='$_SERVER[HTTP_REFERER]'>$arraydp[cancel]</a></div>
				</form>
			</div>
HERE;
		}
		?>
			<?php	if (isset($_POST['id'])) {
				$res = $db->query("DELETE FROM users WHERE id = '$id'");
				if ($res)
				{
					echo 'ok';
					if(!strpos($_POST['ref'],'users.php')) {unset($_SESSION['user_id']);Header("Location: index.php");}
					Header("Location:".$_POST['ref']);
				}
				else {echo 'error';}
			}
			?>
		</div>
		<div id="footer"> 
			<?php include("blocks/footer.php") ?>
		</div>	    
	</div>
</body>
</html>
