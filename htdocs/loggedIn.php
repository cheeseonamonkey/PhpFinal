<?php
	session_start();

	$pageTitle = "Login succesful";
    
	require('includes/header.php');
	echo '<hr><h2>Login successful!</h2><hr>';
	echo 'Welcome back, ' . $_SESSION['username'] . '!';
	echo '<h4><a href="index.php">Go back home</a></h4>'
?>

  </body>
  
</html>