<html>
<body>
	<?php
		$servername = "localhost";
		$db_username = "root";
		$password = "";
		$dbname = "db_hw3";

		// Create connection
		$conn = new mysqli($servername, $db_username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 

		$username = $_COOKIE['cname'];
		$bookcopyID = $_GET['copyid'];
		$bookid = $_GET['bookid'];
		echo 'Hello! ',$username,'<br>';
		echo 'You are borrowing book: '. $bookcopyID.' --- ' .$bookid."<br>";

		$t =time();
		$checkout_time =date("Y-m-d h:m:s",$t);
		echo "It is ".$checkout_time." now. You should return it in 3 months."."<br>";
		//$return_date =date("Y-m-d h:m:s", '+2 month');
		//$sql = $conn->prepare("INSERT INTO `checkedout` (`copyid`, `mid`, `checkoutDate`, `dueDate`, `check_status`) VALUES (?,?,?,?,?)");
		//$sql->bind_param("sssss",$bcID,$mid,$checkout_time,$return_date,$status);
		$sql = "INSERT INTO `checkedout`  VALUES ('$bookcopyID', '$username', now(), date_add(now(), interval 3 month) , 'Holding')";
		/*$bcID = $bookcopyID;(`copyid`, `mid`, `checkoutDate`, `dueDate`, `check_status`)
		$mid = $username;
		$checkout_time ="2018-4-7 19:00:00";
		$return_date ="2018-12-31 23:00:00";
		$status = 'Holding';
		$sql->execute();*/
		
		if ($conn->query($sql) === TRUE) {
		    //echo "New record created successfully";
		    echo "Your book rental record has been submmited!";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
		$result1=mysqli_query($conn,"SELECT * from CheckedOut where mid='$username'");
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
		//$sql->close();
		$conn->close();
	?>
<form action="login.php">
<button>Back to login page.</button>
</form>
</body>
</html>