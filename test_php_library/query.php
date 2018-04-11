<?php

///////////////////////connect to DB
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'myzhu');
define('DB_NAME', 'library');

$con = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

//$db_selected=mysql_select_db('library', $con);
//if (!$db_selected) {
//    die ('Can\'t use library : ' . mysql_error());
//}
/////////////////////////////////////

$keyword = $_POST['keyword'];
$cname = $_POST['cname'];
setcookie('cname',$cname);

$judge = "SELECT mid FROM member where mid='$cname' ";
$result_judge = mysqli_query($con, $judge);
$row_judge = mysqli_fetch_array($result_judge);
$print =  $row_judge['mid'];


if ($print == '') {
  echo 'You are not registered!';
} else {

$query = "SELECT * FROM book natural join bookcopy
WHERE (booktitle like '%$keyword%') or (category like '%$keyword%') and copyid not in 
(
SELECT copyid from checkedout where status = 'Overdue' or status = 'Holding'
)";
$result = mysqli_query($con, $query);

//echo mysql_num_rows($result);

echo "<table border='1'>
<tr>
<th>bookid</th>
<th>booktitle</th>
<th>category</th>
<th>author</th>
<th>publishdate</th>
<th>copyid</th>

<th>operation</th>
</tr>";
if (mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result))
  {
  $temp1 = $row['bookid'];
  $temp2 = $row['copyid'];
  echo "<tr>";
  echo "<td>" . $row['bookid'] . "</td>";
  echo "<td>" . $row['booktitle'] . "</td>";
  echo "<td>" . $row['category'] . "</td>";
  echo "<td>" . $row['author'] . "</td>";
  echo "<td>" . $row['publishdate'] . "</td>";
  echo "<td>" . $row['copyid'] . "</td>";
  //if($row['pstatus']=='available'){
  if(true){
    echo "<td>"."<a href='order.php?bookid=$temp1 & copyid=$temp2'>"."<button type='submit'>"."check"."<value='check'>"."</button>"."</a>"."</td>";
  }
  else{
    echo "<td>"."not available"."</td>";
  }
  
  echo "</tr>";
  }
}
  else{
    echo "no result";
  }
echo "</table>";

}


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
</html>

