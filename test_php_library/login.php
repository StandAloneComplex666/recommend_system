<html>
<head>
</head>
<body>
	<?php
	print "<h2>Library checkout system by Yancheng Chen - N17579714</h2>";
	print "Hello!<br>";
	print "Please enter your memberID and keywords you want to search for.";
	?>
	<?php
	$username = $keywords = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
  	$username = test_input($_POST["username"]);
  	$keywords = test_input($_POST["keywords"]);
    }

    #setcookie('username_cookie', $username)
    #setcookie('keywords_cookie', $keywords)
	function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }
    ?>

    
    <form action="list_available.php" method="POST">
	memberID：<input type="text" name="username"><br>
	keywords：<input type="text" name="keywords"><br>
	<input type = 'submit' name = 'submit' value = 'search'>
	</form>
</body>
</html>