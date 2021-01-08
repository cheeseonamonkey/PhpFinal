<?php
	
	session_start();
	
	$pageTitle = "My account";
	
	require('includes/header.php');
	require('mysqliConnect.php');
	require('includes/myAccount/myAccountFunctions.php');
	
	echo '<hr><h2>My account</h2><hr>';
	
	
	if(isset($_SESSION['username']))
	{
		$un = $_SESSION['username'];
		
		
		
		$q = "select * from accounts WHERE username = '$un'";
		
		$rows = mysqli_query($dbc, $q);
		if (mysqli_num_rows($rows) > 0)
		{
			
			$row = mysqli_fetch_assoc($rows);
			
			$fn = $row['firstName'];
			$ln = $row['lastName'];
			$em = $row['email'];
			$bio = $row['bio'];
			
		}
		
		if(isset($_GET['action']))
			$action = $_GET['action'];
		else
			$action = "";
		
		if($action == 'changedPassword')
			echo "<p><i>Your password has been changed!</i></p>";
		else if($action == 'changedProfilePicture')
			echo "<p><i>Your profile picture has been updated!</i></p>";
		else if($action == 'changedBio')
			echo "<p><i>Your bio has been updated!</i></p>";
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			
			if($action == 'changePassword')
			{
				changePassword($dbc, $un);
			}else if($action == 'changeProfilePicture')
			{
				changeProfilePicture($dbc, $un);
			}else if($action == 'changeBio')
			{
				changeBio($dbc, $un);
			}
			
			
			
			
		}
		
		
		
		echo '<div style="background-color:#b3c3f2; width:33%; padding: 10px; overflow: hidden;">'; 
		echo '<div style="float:left; width:33%;">';//name and pic
		echo '<h3><b> ' . $fn . ' ' . $ln . '</b></h3>';
		echo '<p><img src="' . getProfilePictureDir($dbc, $un) . '" height="120" width="120" style="padding:10px;" />';
		echo '</div>';
		include('includes/myAccount/changeBioForm.php');
		echo '<br style="">';
		echo '</div>';
		echo '<br>';
		
		
		include('includes/myAccount/changeProfilePictureForm.php');
		echo '<br>';
		
		include('includes/myAccount/changePasswordForm.php');
		
	}else
	{
		echo '<a href="login.php"><p>Login<p></a>';
	}
	
?>

</body>
</html>