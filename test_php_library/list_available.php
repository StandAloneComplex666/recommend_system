<html>
<body>
	<?php
	//echo 'it is list_available.php';
	//echo "<br>"	;
	$username = $_POST['username'];
	$keywords = $_POST['keywords'];

	setcookie('cname',$username);
	echo "<br>";
	echo $username;
	echo "<br>";
	echo "the keyword you are searching : " , $keywords;
	echo "<br>";
	

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

	$sql_memberid = "SELECT mid FROM member";
	$result_memberid = $conn->query($sql_memberid);
	
	if ($result_memberid->num_rows > 0){
		$flag_valid_user = 0;
		while ($row = $result_memberid->fetch_assoc())
		{
			if ($row['mid'] != $username) { 
				//echo $row['mid'], "<br>"; 
				continue;}
				else{$flag_valid_user = 1;}
			#echo $row['mid'],"<br>";
		}
		#echo $flag_valid_user;
		if ($flag_valid_user == 1){
			//$sql_temp = 'SELECT bookid, copyid, mid, max(dueDate), check_status as latest  FROM bookcopy natural join checkedout group by copyid having(latest != 'Returned');'
			//$sql = "SELECT * FROM book natural join bookcopy left join (SELECT copyid from checkedout where status = 'Overdue' or status = 'Holding')WHERE (booktitle like '%$keywords%') or (category like '%$keywords%')";
			//$sql = "SELECT copyid ,status from checkedout where status = 'Overdue' or status = 'Holding';";
			$sql = "SELECT * FROM book natural join bookcopy WHERE copyid not in (SELECT copyid from checkedout where status = 'Overdue' or status = 'Holding')";
			/*$result = $conn->query($sql);
			while ($row = $result->fetch_assoc())
			{
				echo $row['copyid'],"<br>";
			}*/
			/*
			$sql1 = "CREATE VIEW temp1 AS SELECT bookid, copyid, mid, max(dueDate), check_status as latest  FROM bookcopy natural join checkedout group by copyid having(latest != 'Returned')";

            $sql2 = "SELECT * from bookcopy natural join book where copyid not in (select copyid from 'temp1' );";

            $sql3 = "DROP VIEW temp1;";
			$conn->query($sql1);
			$result =$conn->query($sql2);
			$conn->query($sql3);
			*/
			$result = $conn->query($sql);
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
			if ($result->num_rows > 0) {
				//echo strpos($row['booktitle'], $keywords);
			    // output data of each row
			    $start = 0;
			    while($row = $result->fetch_assoc()) 
			    {	
			    	if (strlen($keywords) == 0)
			    		{
			    		//echo $start;
			    		$start += 1;

			    		//echo " - bookid: " . $row["bookid"]. " -BookcopyID: " .$row['copyid']." - Booktitle: " .$row["booktitle"]. " - Category: " . $row["category"]. " - Author: " . $row["author"]. " - Publishdate: " .$row["publishdate"]. "<br>";
			    		  $temp1 = $row['bookid'];
						  $temp2 = $row['copyid'];
						  echo "<tr>";
						  echo "<td>" . $row['bookid'] . "</td>";
						  echo "<td>" . $row['booktitle'] . "</td>";
						  echo "<td>" . $row['category'] . "</td>";
						  echo "<td>" . $row['author'] . "</td>";
						  echo "<td>" . $row['publishdate'] . "</td>";
						  echo "<td>" . $row['copyid'] . "</td>";
						  echo "<td>"."<a href='user_records.php?bookid=$temp1 & copyid=$temp2'>"."<button type='submit'>"."check this book now!"."<value='check this book'>"."</button>"."</a>"."</td>";
			    		continue;
			    		}
			    	elseif ((strpos(strtolower($row['category']), strtolower($keywords)) === False) && (strpos(strtolower($row['booktitle']), strtolower($keywords)) === False))
			    		{
			    		continue;
			    		}
			    	else{
			    		//echo $start;
			    		$start += 1;
			    		//echo " - bookid: " . $row["bookid"].  " -Bookcopyid: " .$row['copyid']." - Booktitle: " .$row["booktitle"]. " - Category: " . $row["category"]. " - Author: " . $row["author"]. " - Publishdate: " .$row["publishdate"]. "<br>";
			    		  $temp1 = $row['bookid'];
						  $temp2 = $row['copyid'];
						  echo "<tr>";
						  echo "<td>" . $row['bookid'] . "</td>";
						  echo "<td>" . $row['booktitle'] . "</td>";
						  echo "<td>" . $row['category'] . "</td>";
						  echo "<td>" . $row['author'] . "</td>";
						  echo "<td>" . $row['publishdate'] . "</td>";
						  echo "<td>" . $row['copyid'] . "</td>";
						  echo "<td>"."<a href='user_records.php?bookid=$temp1 & copyid=$temp2'>"."<button type='submit'>"."check this book now!"."<value='check'>"."</button>"."</a>"."</td>";
			    		}
			    }
			    echo "<tr>";
			    //echo "Type the BookcopyID of book you want to borrow!";
			    //echo "<a href = 'user_records.php'>"."<method = 'POST'>"."<input type ='text', name = 'bookcopyID'>"."</input>"."<input type = 'submit' name ='submit'>"."Borrow"."<value = 'borrow'>"."</input>"."<a>";
			    //echo "<a href = 'login.php'>"."<button type ='submit'>"."Back to main page"."<value = 'back to main page'>"."</button>"."<a>";
				} 
				else 
				{
			    echo "0 results";
				}
			if ($start == 0)
				{ 
					echo "Sorry no available books now!";
				}
		}
		else
		{
			echo "<br>";
			echo "Invalid memberID!"."<br>";
			echo "<a href = 'login.php'>"."<button type =submit>"."Back to main page"."<value = 'back to main page'>"."</button>"."<a>";
			echo "<br>";
		}
	}
	$conn->close();
	?>
	
	  	 	
</body>
</html>