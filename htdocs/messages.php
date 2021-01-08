<style>

body {
	
}

<style>

<?php
	session_start();
	$pageTitle = "Messages";
	
    require('includes/header.php');
	echo '<hr><h2>Messages</h2><hr>';
	
	if(isset($_SESSION['username']))
	{
		require('mysqliConnect.php');
		$un = $_SESSION['username'];
	
		require('includes/messages/messageFunctions.php');
		
		
		//
		
		if(isset($_GET['page']))
			$page = $_GET['page'];
		else
			$page = "0";
		
		if(isset($_GET['view']))
			$view = $_GET['view'];
		else
			$view = 0;
		
		
		if(isset($_GET['action']))
			$action = $_GET['action'];
		else
			$action = "";
		
		if($action == 'sentMessage')
			echo "<p><i>Your message has been sent!</i></p>";
		else if($action == 'deletedMessage')
			echo "<p><i>Your message has been deleted!</i></p>";
		
		
		
		//
		
		
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			
			if($action == 'sendMessage')
			{
				sendMessage($dbc, $un);
			}else if($action == 'deleteMessage')
			{
				deleteMessage($dbc, $view);
			}
			
		}
		
		
		
		//
		echo '<div style="float: left; display: inline; width:33%; ">';
			echo '<div style="background-color:#b3c3f2; width:95%; inline-block height:400px; margin: 5px; padding: 10px;">';
				include('includes/messages/inboxForm.php');
			echo '</div><br><br">';
			
			
			echo '<div style="background-color:#b3c3f2; width:95%;  margin: 5px; padding: 10px;">';
				include('includes/messages/composeForm.php');
			
			echo '</div>';
		
		echo '</div>';
		
		echo '<div style="display: inline; background-color:#b3c3f2; float:left; width:17%; height:500px; margin: 5px; padding: 10px;">';
		include('includes/messages/viewForm.php');
		
		echo '</div><br>';
		
		
		
		//
		
		
		
		
		
		
		
		
	 
	}
?>

</body>
</html>