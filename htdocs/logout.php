<?php
	session_start();
	$_SESSION['username'] = '';
	session_unset();
	session_destroy();

	$pageTitle = "Logged out";
    
	require('includes/header.php');
	echo '<hr><h2>You are now logged out.</h2><hr>';
	echo '<h4><a href="index.php">Go back home</a></h4>';
?>

  </body>
  
</html>