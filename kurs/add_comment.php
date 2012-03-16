<?php session_start();  ?>
<?php
    include("db.php");
    $nid=$_POST['nid'];
    $uid=$_SESSION['user_id'];
    $uname=$_SESSION['user_name'];
    $titlecom=preg_replace("(<[^<]+?>)"," ",$_POST['namecomment']);
    $textcom=preg_replace("(<[^<]+?>)"," ",$_POST['text']);
    $datecom=$_POST['date'];
    if ((empty($titlecom) && (empty($textcom)))) {header("Location:".$_SERVER['HTTP_REFERER']); exit;}
    if ($titlecom=='')
		{
			$string = $textcom;
			$result = iconv("utf-8", "windows-1251", $string);
			$result = implode(array_slice(explode('<br>',wordwrap($result,15,'<br>',false)),0,1));
			$result = iconv("windows-1251","utf-8", $result);
			if($result!=$string) $result=$result."..." ;
			$titlecom=$result;
		}
		$query = $db->prepare("INSERT INTO comments (nid,uid,uname,title,text,date) VALUES (?,?,?,?,?,?)");
		$res = $query->execute(array($nid,$uid,$uname,$titlecom,$textcom,$datecom));
    //echo $nid,$uid,$uname,$titlecom,$textcom,$datecom;
		if ($res) {echo 'ok';} else {echo 'error';};
		header("Location:".$_SERVER['HTTP_REFERER']);
?>