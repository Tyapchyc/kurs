<?php 
function getMonthName($Month){
	$strTime=mktime(1,1,1,$Month,1,date("Y"));
	return date("F",$strTime);
}

if (isset($_SESSION['user_id'])) {
	include("db.php");
	$query = "SELECT yearB,monthB,dayB
            FROM users
            WHERE id='{$_SESSION[user_id]}'
            LIMIT 1";
	$sql = $db->query($query);
	$row = $sql->fetch(PDO::FETCH_ASSOC);	
	if ($row) {
        $yearB = $row['yearB'];
		$monthB = $row['monthB'];
		$dayB = $row['dayB'];}
	echo "<select name='yearB'>";
	$year= date("Y") - 90;
	while ($year++<date("Y") - 7) {
		if ($year == $yearB) {
			echo "<option selected='selected'>$year</option>";
		}
		else {
			echo "<option >$year</option>";
		}
	}
	echo "</select>";

	echo "<select name='monthB'>";
	$month=0;
	while ($month++<12) {
		$monthName=getMonthName($month);
		if ($month==$monthB) {echo "<option selected='selected' value='$month'>$monthName</option>";}
		else{
			echo "<option value='$month'>$monthName</option>";}
		}
	echo "</select>";

	echo "<select name='dayB'>";
	$x=0;
	while ($x++<31) 
		if ($x==$dayB) {echo "<option selected='selected'>$x</option>";}
		else {
	echo "<option>$x</option>";}
	echo "</select>";
 }
else {
	
echo "<select name='yearB'>";
$year= date("Y") - 90;
while ($year++<date("Y") - 7) {
	if ($year == date("Y") - 18) {
	echo "<option selected='selected'>$year</option>";
	}
	else {
	echo "<option >$year</option>";
	}
}
echo "</select>";

echo "<select name='monthB'>";
$month=0;
while ($month++<12) {
	$monthName=getMonthName($month);
	echo "<option value='$month'>$monthName</option>";
	}
echo "</select>";


echo "<select name='dayB'>";
$x=0;
while ($x++<31) echo "<option>$x</option>";
echo "</select>";
}
?>

