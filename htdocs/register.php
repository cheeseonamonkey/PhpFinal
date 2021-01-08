<?php
	session_start();
	$pageTitle = "Register";
    
	require('includes/header.php');
	echo '<hr><h2>Register</h2><hr>';
	
	//sanitize inputs
	//also should session check if already logged in
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$validated = true;
		
		if(empty($_POST['username']))
		{
			$validated = false;
			echo "<p>You didn't enter a username!";
			
		}
		if(empty($_POST['password']))
		{
			$validated = false;
			echo "<p>You didn't enter a password!";
		}
		if(empty($_POST['fName']))
		{
			$validated = false;
			echo "<p>You didn't enter a first name!";
		}
		if(empty($_POST['lName']))
		{
			$validated = false;
			echo "<p>You didn't enter a last name!";
		}
		if(empty($_POST['email']))
		{
			$validated = false;
			echo "<p>You didn't enter an email!";
		}
		
		
		
		if($validated)
		{
			require('mysqliConnect.php');
			
			$un = ($_POST['username']);
			$pw = ($_POST['password']);
			$fn = ucfirst($_POST['fName']);
			$ln = ucfirst($_POST['lName']);
			$e = $_POST['email'];
			
			$un = mysqli_real_escape_string($dbc, $un);
			//$pw = mysqli_real_escape_string($dbc, $pw);
			$fn = mysqli_real_escape_string($dbc, $fn);
			$ln = mysqli_real_escape_string($dbc, $ln);
			$e = mysqli_real_escape_string($dbc, $e);
			
			
			
			// sql insert here
			$q = "INSERT INTO accounts (username, password, firstName, lastName, email) VALUES ('$un', SHA1('$pw'), '$fn', '$ln', '$e')";
			echo $q;
			$r = mysqli_query ($dbc, $q);
			
			// if ($mysqli->affected_rows == 1)
			
			
			
			
			$url =  'registered.php';
			header("Location: $url");
			
			exit();
			
		}else
		{
			
		}
		
		
		
		
		
	}
	
	
	
	
	
	
	
?>

<html>
<body>	

<div style="background-color:#b3c3f2; width:33%; padding: 5px;">
	<form action="register.php" method="post">
	<br>
		<p><label><b>First name:</b></label> &nbsp; <input type="text" name="fName" size="15" maxlength="20" /> &nbsp;&nbsp;&nbsp;&nbsp;
		<label><b>Last name:</b></label> &nbsp; <input type="text" name="lName" size="15" maxlength="20" /> </p>
		<p><label><b>Username:</b></label> &nbsp; <input type="text" name="username" size="15" maxlength="30" /> &nbsp;&nbsp;&nbsp;&nbsp;
		<label><b>Password:</b></label> &nbsp; <input type="password" name="password" size="15" maxlength="30" /> </p>
		<p><label><b>Email:</b></label> &nbsp; <input type="text" name="email" size="20" maxlength="40" />
		<div align="center"><input type="submit" name="submit" value="Submit" /></div>
	<br>
	</form>
</div>


</body>
</html>