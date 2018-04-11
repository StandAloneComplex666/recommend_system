<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'myzhu');
define('DB_NAME', 'library');
$con = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

//mysql_select_db(DB_NAME, $con);

$memberid = $_COOKIE['cname'];
$bookid = $_GET['bookid'];
$copyid = $_GET['copyid'];

//$result = mysql_query("SELECT * FROM purchase WHERE (cname = '$cname' and pname = '$pname' and status='pending') ");
//$test = mysql_fetch_array($result);

//$time = date("Y-m-d H:i:s", time());
//set @dt = now();
//$time2=select date_add(@dt, interval 1 month);
//$time2 = date("Y-m-d H:i:s", time()+24*3600*90);
//if ($test[cname]==null){
$result=mysqli_query($con,"INSERT INTO CheckedOut VALUES ('$copyid', '$memberid', now(), date_add(now(), interval 3 month) , 'Holding')");

$result1=mysqli_query($con,"SELECT * from CheckedOut where mid='$memberid'");

echo "<table border='1'>
<tr>
<th>copyid</th>
<th>mid</th>
<th>checkoutDate</th>
<th>dueDate</th>
<th>status</th>
</tr>";

while($row = mysqli_fetch_assoc($result1))
  {
  echo "<tr>";
  echo "<td>" . $row['copyid'] . "</td>";
  echo "<td>" . $row['mid'] . "</td>";
  echo "<td>" . $row['checkoutDate'] . "</td>";
  echo "<td>" . $row['dueDate'] . "</td>";
  echo "<td>" . $row['status'] . "</td>";
  echo "</tr>";
  }
echo "</table>";

//echo $result;

mysqli_close($con);
?>

<html>
<form action="index.php">
<button>back to main page</button>
</form>


<div>
  <footer class = "center-align">
    <hr>
    <p>Written and coded by <a href="https://www.linkedin.com/in/mengyuan-zhu-b86940137/" target="_blank">Mengyuan Zhu</a></p>
  </footer>
</div>
</html>


