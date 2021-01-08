<?php
	session_start();
	$pageTitle = "Login";
    
	require('includes/header.php');
	echo '<hr><h2>Login</h2><hr>';
	
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
		
		if($validated)
		{
			
			require('mysqliConnect.php');
			
			$un = $_POST['username'];
			$pw = $_POST['password'];
			
			$un = mysqli_real_escape_string($dbc, $un);
			$pw = mysqli_real_escape_string($dbc, $pw);
			
			
			
			$q = "SELECT username FROM accounts WHERE username = '$un' AND password = SHA1('$pw')";
			
			$r = mysqli_query($dbc, $q);
			
			if (@mysqli_num_rows($r) == 1) //single match found
			{
				$row = mysqli_fetch_assoc($r);
				
				$un = $row['username'];
				$_SESSION['username'] = $un;
				
				$url =  'loggedIn.php';
				header("Location: $url");
				
				exit();
				
			}else
			{
				echo '<p>The username and password were invalid. Try again or <a href="register.php">register</a> a new account.';
			}
			
		}else
		{
			echo "<p>Check your information and try again.";
		}
		
		
		
	}
	
	
?>



<div style="background-color:#b3c3f2; width:33%; padding: 5px;">
	<form action="login.php" method="post">
	<br>
		<p><label><b>Username:</b></label> &nbsp; <input type="text" name="username" size="25" />
		<p><label><b>Password:</b></label> &nbsp; <input type="password" name="password" size="25" />
		<div align="center"><input type="submit" name="submit" value="Login" /></div>
	<br>
	</form>
	<br>
	<p>Need an account? <a href="register.php">Register here.</a>
</div>



  </body>
</html>