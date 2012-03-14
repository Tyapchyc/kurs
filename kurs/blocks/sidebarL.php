<?php
    $filename = pathinfo(__FILE__,PATHINFO_FILENAME) .'.'.pathinfo(__FILE__,PATHINFO_EXTENSION);
    $res = $db->query("SELECT * FROM page_title WHERE file='$filename'");
    $rowbar = $res->fetch(PDO::FETCH_ASSOC);
    $arraybar = unserialize($rowbar['array'.$_SESSION['lang']]);
?>
<p><a href="index.php"><?php echo $arraybar['main'];?></a></p>
<?php if(!isset($_SESSION['user_id']))
printf("<p><a href='registration.php'>%s</a></p>",$arraybar['registration']) ;
?>
