<?php session_start(); ?>
<?php
	include("db.php");
	include("blocks/permission.php");
?>
<?php
	if (!isset($_SESSION['lang'])) {$_SESSION['lang']='en';}
	$filename = pathinfo(__FILE__,PATHINFO_FILENAME) .'.'.pathinfo(__FILE__,PATHINFO_EXTENSION);
	$res = $db->query("SELECT * FROM page_title WHERE file='$filename'");
	$rowtitle = $res->fetch(PDO::FETCH_ASSOC);
	$title = $rowtitle[$_SESSION['lang']];
	$arrayfd = unserialize($rowtitle['array'.$_SESSION['lang']]);
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
				function translitIt($str)
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
				$_SESSION[name_reg] = $_POST[name];
				$_SESSION[yearB_reg] = $_POST[yearB];
				$_SESSION[monthB_reg] = $_POST[monthB];
				$_SESSION[dayB_reg] = $_POST[dayB];
				$texterrror = "";
				if (isset($_POST[login]) and ($_POST[login]!=""))
				{
					$login = $_POST[login];$_SESSION[login_reg] = $login;
					if (preg_match( '/[^0-9a-zA-Z_\.\-]/', $login ))
						$texterrror="<p>$arrayfd[login_error]</p>";//login error
        } 
				else
				{
					$texterrror="<p>$arrayfd[no_login]</p>";//enter login
				}
				if (isset($_POST[email]) and ($_POST[email]!=""))
				{
					$email = $_POST[email];$_SESSION[email_reg] = $email;
				}
				else
				{
					$texterrror="<p>$arrayfd[no_mail]</p>";//enter email
				}
				if (isset($_POST[password])and ($_POST[password]!="")) {$password = $_POST[password];}
				else {$texterrror="<p>$arrayfd[no_pass]</p>". " " .$texterrror;}//enter password
				if ($texterrror!="")
				{
					header( "refresh:2;url=registration.php" );die ( $texterrror); /*echo "<html><head>
                <meta  http-equiv='Refresh' content = '2; URL =registration.php'>
             </head></html>";*/
            //exit ;
				}
				$password2 = $_POST[password2];
				$name = $_POST[name];
				$lastname = $_POST[lastname];
				$yearB = $_POST[yearB];
				$monthB = $_POST[monthB];
				$dayB = $_POST[dayB];//"The entered passwords do not match"
				if ($password!=$password2)
				{
					header( "refresh:2;url=registration.php" );die( $arrayfd[pass_error]);/*echo "<html><head>
                <meta  http-equiv='Refresh' content = '2; URL =registration.php'>
             </head></html>";
             exit ;*/
				}
				if (!preg_match('|([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|is', $email))
				{
					header( "refresh:2;url=registration.php" );/*echo "<html><head>
                <meta  http-equiv='Refresh' content = '2; URL =registration.php'>
             </head></html>";*/
					die( "<p>$arrayfd[mail_error]</p>");/*exit;*/
				}//email error
				$password = crypt($_POST[password]);
				$res = $db->query("SELECT * FROM users WHERE login='$login'");
				$myrow = $res->fetch(PDO::FETCH_ASSOC);
				if ($myrow)
				{
					header( "refresh:2;url=registration.php" );
                /*echo "<html><head>
                <meta  http-equiv='Refresh' content = '2; URL =registration.php'>
             </head></html>";*/
					die( "<p>$myrow[login]-$arrayfd[login_exist]</p>");
				}//login already exist
				else
				{
					$res = $db->query("SELECT * FROM users WHERE email='$email'");
					$myrow = $res->fetch(PDO::FETCH_ASSOC);		
					if ($myrow)
					{
						header( "refresh:2;url=registration.php" );
						//echo "<html><head><meta http-equiv='Refresh' content = '2; URL =registration.php'></head></html>";
					/*echo "*/
						die("<p>$myrow[email]- $arrayfd[mail_exist]</p>");
					}//email already exist
					else
					{
						if ((($_FILES["file"]["type"] == "image/gif")
						|| ($_FILES["file"]["type"] == "image/jpeg")
						|| ($_FILES["file"]["type"] == "image/pjpeg")
						|| ($_FILES["file"]["type"] == "image/png"))
						&& ($_FILES["file"]["size"] < 3000000))
						{
							if ($_FILES["file"]["error"] > 0)
							{
							//echo "ошибка загрузки: " . $_FILES["file"]["error"] . "<br />";
							}
							else
							{
							/*    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
								echo "Type: " . $_FILES["file"]["type"] . "<br />";
								echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
								echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";*/
								$filename = translitIt($_FILES["file"]["name"]);
								$avatar = "upload/" .date('YmdHis'). $filename;
								include('SimpleImage.php');
								$image = new SimpleImage();
								$image->load($_FILES["file"]["tmp_name"]);
								$image->resize(150, 150);
								$image->save($avatar);
							}
						}
						else
						{
//						echo "Invalid file";
//						echo $_FILES["file"]["type"];
//						echo $_FILES["file"]["size"];
						}
						if (isset($avatar))
						{
							$datenow =date('Y-m-d H:i:s');$rid=3;
							$query = $db->prepare("INSERT INTO users (login,password,name,lastname,yearB,monthB,dayB,avatar,email,created,logged,rid) VALUES ('$login','$password','$name','$lastname','$yearB','$monthB','$dayB','$avatar','$email','$datenow','$datenow','$rid')");
							$res = $query->execute();
						}
						else
						{
							$datenow =date('Y-m-d H:i:s'); $rid=3;
							$query = $db->prepare("INSERT INTO users (login,password,name,lastname,yearB,monthB,dayB,email,created,logged,rid) VALUES ('$login','$password','$name','$lastname','$yearB','$monthB','$dayB','$email','$datenow','$datenow','$rid')");
							$res = $query->execute();
						}
						echo "Ok";
						$sql = $db->query("SELECT `id`,`name` FROM `users` WHERE `login`='{$login}' LIMIT 1");
						$row = $sql->fetch(PDO::FETCH_ASSOC);
						if ($row)
						{
							$_SESSION['user_id'] = $row['id'];
							$_SESSION['user_name'] = $row['name'];
							unset($_SESSION[name_reg]);
							unset($_SESSION[yearB_reg]);
							unset($_SESSION[monthB_reg]);
							unset($_SESSION[dayB_reg]);
							unset($_SESSION[login_reg]);
							unset($_SESSION[email_reg]);
							Header("Location: index.php"); 
							exit;
						}
					}
				}
			?>
		</div>
		<div id="footer">
			<?php include("blocks/footer.php") ?>
		</div>	    
  </div>
</body>
</html>
