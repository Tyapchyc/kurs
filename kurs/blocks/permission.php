<?php if (isset($_SESSION['user_id'])){
	$res = $db->query("SELECT rid FROM users WHERE id=$_SESSION[user_id]");
	$row = $res->fetch(PDO::FETCH_ASSOC);
	$rid = $row['rid'];
	/*$permission = 'admin permission';
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
	$rowremove= $res->fetch(PDO::FETCH_ASSOC);
        
        $permission = 'add comment';
	$res = $db->query("SELECT * FROM roles_permission WHERE (rid='$rid' AND permission='$permission')");
	$rowaddcom= $res->fetch(PDO::FETCH_ASSOC);*/
        $res = $db->query("SELECT permission FROM roles_permission WHERE rid='$rid'");
        while ($myrowperm = $res->fetch(PDO::FETCH_ASSOC)) {
            if ($myrowperm['permission']=='admin permission') {$rowadm=true;}
            if ($myrowperm['permission']=='add news') {$rowadd=true;}
            if ($myrowperm['permission']=='edit news') {$rowedit=true;}
            if ($myrowperm['permission']=='remove news') {$rowremove=true;}
            if ($myrowperm['permission']=='add comment') {$rowaddcom=true;}
            if ($myrowperm['permission']=='rating') {$rowrating=true;}
        }
        }
?>