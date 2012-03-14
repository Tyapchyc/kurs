<?php 
  include("db.php");
  if (isset($_GET['by'])) {$by=$_GET['by'];}
  if (!isset($by)){
	  $by=0;
	  }
  
  if (isset($_GET['b'])) {$b=$_GET['b'];} else {$b=3;}
  if ($by<0) {$by=0;}
  $handle = $db->query("SELECT count(1) FROM news");
  $tmp  = $handle->fetch(PDO::FETCH_NUM);
//				echo "<br>$tmp[0]"; 
  if ($by>=$tmp[0]) {$by=$by-$b ;}
  if ($_SESSION['lang']=='en') {
    $querynews="SELECT id,nameen,descriptionen,author,date FROM news ORDER BY date DESC LIMIT $by, $b";} else {
    $querynews="SELECT id,nameuk,descriptionuk,author,date FROM news ORDER BY date DESC LIMIT $by, $b";
    }
  $res = $db->query($querynews);
  $filename = pathinfo(__FILE__,PATHINFO_FILENAME) .'.'.pathinfo(__FILE__,PATHINFO_EXTENSION);
    $resе = $db->query("SELECT * FROM page_title WHERE file='$filename'");
    $rowbar = $resе->fetch(PDO::FETCH_ASSOC);
    $arraybar = unserialize($rowbar['array'.$_SESSION['lang']]);
  printf ("<p><span class='left'><a href='index.php?by=%s'>&#8592;</a></span> <span class='right'><a href='index.php?by=%s'>&#8594;</a></span></p>",$by-$b,$by+$b);
  while ($myrow = $res->fetch(PDO::FETCH_ASSOC)){
		  printf( "<div class='news'><p><a href='read.php?id=%s'>%s</a></p>
		   <p>%s</p>
		   <p>%s:%s</p><p>%s:%s </p><p><a href='read.php?id=%s'>%s</a></p></div>",$myrow[id],$myrow['name'.$_SESSION['lang']],$myrow['description'.$_SESSION['lang']],$arraybar['author'],$myrow[author],$arraybar['date_news'],$myrow[date],$myrow[id],$arraybar['read_more']);
		  }	
		  
?>
