<html>
<head>
 
</head>
<body background="./bg1.jpg">
<br><br>
Ravelry Project Dashboard 
<br><br>
<form method=POST action=./rav_pg2.php>
Please select the user you would like to see stats on:<select name=n>
<?php

include "./db_connect.inc";
$query = "select * from rav_codes order by rav_name";
//echo $query;
$result = mysql_query($query);


while ($row = mysql_fetch_object($result)) {
	print "<option value=$row->rav_name>$row->rav_name</option>";
} // end while

?>


</select><br><br>
<input type=submit>
</form>

</body>
</html>