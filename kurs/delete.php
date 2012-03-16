<?php session_start();  ?>
<?php
	if (isset($_SESSION['user_id']))
	{
		
	}
	else
	{
		Header("Location: index.php");
		die('denied');
	}
?>
<?php
	include("db.php");
	include("blocks/permission.php");
	if (($rowremove) or ($rowadm)) {}
	else
	{
		Header("Location: index.php");
		die('denied');
	}
?>
<?php $title = "Delete news";include("head.php")?>
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
				$id = $_GET[id];
				$res = $db->query("SELECT  authorid FROM news WHERE id='$id'");
				$myrow = $res->fetch(PDO::FETCH_ASSOC);
				$authorid = $myrow[authorid];
				if ($authorid!=$_SESSION[user_id]){echo 'Isnt your news';}
				else
				{
					$res = $db->query("DELETE FROM news WHERE id = '$id'");
					if ($res) {echo 'ok'; header("Location: delete_news.php");}
				}
			?>
		</div>
		<div id="footer">
			<?php include("blocks/footer.php") ?>
		</div>
	</div>
</body>
</html>
