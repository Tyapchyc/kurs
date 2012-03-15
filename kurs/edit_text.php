<?php session_start();
	
?>
<?php
	include("db.php");
	include("blocks/permission.php");
	if (isset($_SESSION['user_id']))
	{
		
		if ($rowadm) {}
		else {
			Header("Location: index.php");
		}
	}
	else
	{
		Header("Location: index.php"); 
   		die('denied');
	}
	if (isset($_GET['file'])) {$file = $_GET['file'];}
	if (isset($_POST['file'])) {$file = $_POST['file'];
		foreach ($_POST as $k => $v) {
			if ($k=='en') {$en=$v;}
			elseif ($k=='uk') {$uk=$v;}
			elseif ($k=='file') {}
			elseif ($k=='submit') {}
			elseif (!strpos($k,"ukranian01")) {$arrayadden[$k] = $v;$kuk=$k;}
			else {$arrayadduk[$kuk] = $v;}
		}
		$queryadd = $db->prepare("UPDATE page_title SET en=?,uk=?,arrayen=?,arrayuk=? WHERE file=?");
		$resadd = $queryadd->execute(array($en,$uk,serialize($arrayadden),serialize($arrayadduk),$file));
		if (!$resadd) echo 'error';}
	if (!isset($_SESSION['lang'])) {$_SESSION['lang']='en';}
	$filename = pathinfo(__FILE__,PATHINFO_FILENAME) .'.'.pathinfo(__FILE__,PATHINFO_EXTENSION);
	$res = $db->query("SELECT * FROM page_title WHERE file='$filename'");
	$rowtitle = $res->fetch(PDO::FETCH_ASSOC);
	$title = $rowtitle[$_SESSION['lang']];
	$arrayet = unserialize($rowtitle['array'.$_SESSION['lang']]);
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
		<?php
				
			if (!isset($file)) {
				$respage = $db->query("SELECT file,en,uk FROM page_title");
				while ($myrowpage = $respage->fetch(PDO::FETCH_ASSOC)){
					if ((isset($myrowpage[$_SESSION['lang']]) and ($myrowpage[$_SESSION['lang']]!=''))) {$linkname=$myrowpage[$_SESSION['lang']];}
					else {$linkname=$myrowpage['file'];}
					echo "<p><a href='edit_text.php?file=".$myrowpage['file']."'>".$linkname."</a></p>";}
			} else {
				$respage = $db->query("SELECT * FROM page_title WHERE file='$file'");
				$myrowpage = $respage->fetch(PDO::FETCH_ASSOC);
				//echo $myrowpage['en']."<br/>";
				//echo $myrowpage['uk']."<br/>";
				$arraypageen = unserialize($myrowpage['arrayen']);
				$arraypageuk = unserialize($myrowpage['arrayuk']);
				/*foreach ($arrayadden as $k => $v) {
					echo "\$arraypageen[$k] => $v. $arrayadduk[$k].<br/>";
					
				}*/
				printf ("<form action='edit_text.php' method='post' name='textform' enctype='multipart/form-data'>
					<div><input value='%s' type='hidden' name='file' id='file' /></div>
					<div class='labelnews'><label for='title'>%s</label></div>
					<div class='inputdivnews'><input class='inputnews' type='text' name='en' id='title' value='%s' /></div>
					
					<div class='labelnews'><label for='titleuk'>%s</label></div>
					<div class='inputdivnews'><input class='inputnews' type='text' name='uk' id='titleuk' value='%s' /></div>
					",$file,$arrayet['titleen'],$myrowpage['en'],$arrayet['titleuk'],$myrowpage['uk']);
				foreach ($arraypageen as $k => $v) {
					printf("<div class='labelnews'><label>%s</label></div>
					<div >	<input class='inputnews' type='text' name='%s' id='%s' value='%s' />
									<input class='inputnews' type='text' name='%s' id='%s' value='%s' /></div>
					",$k,$k,$k,$arraypageen[$k],$k.'ukranian01',$k.'ukranian01',$arraypageuk[$k]);}
					echo "<div class='inputdivnews'><input class='inputnews' type='submit' name='submit' value='Ok' /> </div></form>";
			}
			/*$arrayen = array("titleen"=>"Title english","titleuk"=>"Title ukrainian");
			$arrayuk = array("titleen"=>"Назва сторінки англійською" ,"titleuk"=>"Назва сторінки українською");
			$query = $db->prepare("UPDATE page_title SET arrayen=?,arrayuk=? WHERE file=?");
			$res = $query->execute(array(serialize($arrayen),serialize($arrayuk),'edit_text.php'));*/
		?>
		

		</div>
		<div id="footer"> 
			<?php include("blocks/footer.php") ?>
		</div>	    
	</div>
</body>
</html>