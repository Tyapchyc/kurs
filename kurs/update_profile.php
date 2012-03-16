<?php session_start(); ?>
<?php
	include("db.php");
	include("blocks/permission.php")
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
	$arrayup = unserialize($rowtitle['array'.$_SESSION['lang']]);
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
			  <?php function translitIt($str) 
              {
                  $tr = array(
                      "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G",
                      "Д"=>"D","Е"=>"E","Ж"=>"J","З"=>"Z","И"=>"I",
                      "Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
                      "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
                      "У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH",
                      "Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"",
                      "Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b",
                      "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
                      "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
                      "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
                      "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
                      "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
                      "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya"
                  );
                  return strtr($str,$tr);
              }
              ?>
			<?php 
			
            $texterrror = "";
            if (isset($_POST[id]) and ($_POST[id]!="")) {
                $id = $_POST[id];
                } 
                else { 
                        $texterrror='<p>no id</p>';
                    }
		if (isset($_POST[email]) and ($_POST[email]!="")) {
                $email = $_POST[email];
                } 
                else { 
                        $texterrror="<p>".$arrayup[no_mail]."</p>";//enter email
                    }
            if (isset($_POST[password])and ($_POST[password]!="")) {$password = $_POST[password];} 
            //else {$texterrror='<p>Please fill out both password fields.</p>'. ' ' .$texterrror;}
            
            if ($texterrror!="") {/*echo $texterrror;echo "<html><head>
                <meta  http-equiv='Refresh' content = '5; URL =profile.php'>
             </head></html>";
            exit ();*/
						header( "refresh:3;url=profile.php" ); die ($texterrror);
                }
            $password2 = $_POST[password2];
            $name = $_POST[name];
						$lastname = $_POST[lastname];
            $yearB = $_POST[yearB];//|([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|is
            $monthB = $_POST[monthB];
            $dayB = $_POST[dayB];
	    if (!preg_match('|([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|', $email)) {/*echo "<html><head>
                <meta  http-equiv='Refresh' content = '1; URL =profile.php'>
             </head></html>";
            echo "<p>".$arrayup[mail_error]."</p>";exit;*/
						header( "refresh:3;url=profile.php" );
						die($arrayup[mail_error]);
						}//email error"The entered passwords do not match"
            if ($password!=$password2) {/*echo $arrayup[pass_error];echo "<html><head>
                <meta  http-equiv='Refresh' content = '2; URL =profile.php'>
             </head></html>";
             exit ;*/
						 header( "refresh:3;url=profile.php" );
						 die ($arrayup[pass_error]);
            }
	    
		$res = $db->query("SELECT * FROM users WHERE email='$email' AND id!='$id'");
		$myrow = $res->fetch(PDO::FETCH_ASSOC);		
		if ($myrow) {
			/*echo "<html><head><meta http-equiv='Refresh' content = '5; URL =profile.php'></head></html>";
			echo "<p>$myrow[email]- $arrayup[mail_exist]</p>";exit ();*/
			header( "refresh:3;url=profile.php" );
			die("<p>$myrow[email]- $arrayup[mail_exist]</p>");
			}//email already exist $myrow[id]
		else {
			if ((($_FILES["file"]["type"] == "image/gif")
				  || ($_FILES["file"]["type"] == "image/jpeg")
				  || ($_FILES["file"]["type"] == "image/pjpeg")
					|| ($_FILES["file"]["type"] == "image/png"))
				  && ($_FILES["file"]["size"] < 3000000))
				{																
					if ($_FILES["file"]["error"] > 0)
					  {
					  echo "error upload: " . $_FILES["file"]["error"] . "<br />";
					  }
					else
					  {
				  /*    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
					  echo "Type: " . $_FILES["file"]["type"] . "<br />";
					  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
					  echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
				  */ $filename = translitIt($_FILES["file"]["name"]);
				 
					 /* if (file_exists("upload/" . $filename))
						{
						move_uploaded_file($_FILES["file"]["tmp_name"],
						"upload/" . $filename);
						$avatar = "upload/" . $filename;
						}
					  else
						{*/
						/*move_uploaded_file($_FILES["file"]["tmp_name"],
						"upload/" . $filename);*/
						$avatar = "upload/" .date('YmdHis'). $filename;
						//echo $_FILES["file"]["size"];
						/*
						$im=imagecreatefromgif($_FILES["file"]["tmp_name"]);
						$im1=imagecreatetruecolor(150,150);
						imagecopyresampled($im1,$im,0,0,0,0,150,150,imagesx($im),imagesy($im));
						imagejpeg($im1,$avatar,100);
						imagedestroy($im);
						imagedestroy($im1);*/
						include('SimpleImage.php');
						$image = new SimpleImage();
						$image->load($_FILES["file"]["tmp_name"]);
						$image->resize(150, 150);
						$image->save($avatar);
						
						//}
					  }
					}
				   
				  else
					{
//					echo "Invalid file";
//					echo $_FILES["file"]["type"];
//					echo $_FILES["file"]["size"];
					}
			if (isset($avatar)){
				if ($password) {$password = crypt($_POST[password]);
					$query = $db->prepare("UPDATE users SET password='$password',name='$name',lastname='$lastname',yearB='$yearB',monthB='$monthB',dayB='$dayB',avatar='$avatar',email='$email' WHERE id='$id'");
					$res = $query->execute();}
				else {$query = $db->prepare("UPDATE users SET name='$name',lastname='$lastname',yearB='$yearB',monthB='$monthB',dayB='$dayB',avatar='$avatar',email='$email' WHERE id='$id'");
					$res = $query->execute();}
			}
			else {
				if ($password) {$password = crypt($_POST[password]);
					$query = $db->prepare("UPDATE users SET password='$password',name='$name',lastname='$lastname',yearB='$yearB',monthB='$monthB',dayB='$dayB',email='$email' WHERE id='$id'");
					$res = $query->execute();}
				else {$query = $db->prepare("UPDATE users SET name='$name',lastname='$lastname',yearB='$yearB',monthB='$monthB',dayB='$dayB',email='$email' WHERE id='$id'");
					$res = $query->execute();}
				}
				if ($res) {
					$_SESSION['user_name'] = $name;
            /*echo "<p>$arrayup[complete]</p>";echo "<html><head>
                <meta  http-equiv='Refresh' content = '2; URL =view_profile.php'>
             </head></html>";*/
						 header( "refresh:2;url=view_profile.php" );
						 die($arrayup[complete]);
						 }}
            ?>
		</div>
        <div id="footer"> 
        	<?php include("blocks/footer.php") ?>
        </div>	    
    </div>
</body>
</html>
