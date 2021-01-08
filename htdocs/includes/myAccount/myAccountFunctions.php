<?php

	function changeBio($dbc, $un)
	{
		$q = "SELECT id FROM accounts WHERE username = '" . $un . "'";
		$rows = mysqli_query($dbc, $q);
		if(mysqli_num_rows($rows) > 0)
		{
			$row = mysqli_fetch_assoc($rows);
			$uId = $row['id'];
		}else
			echo '<p>There was a weird error. Try again.</p>';

		$newBio = $_POST['bio'];
		
		$newBio = mysqli_real_escape_string($dbc, $newBio);
		
		$q = "UPDATE accounts SET bio = '" . $newBio . "' WHERE id = $uId";
				
		$r = mysqli_query($dbc, $q);
		
		if($r)
		{
			$url =  'myAccount.php?action=changedBio';
			header("Location: $url");
		
			exit();
		
		}
		
	}
	
	
	function getProfilePictureDir($dbc, $un)
	{
		$q = "SELECT id FROM accounts WHERE username = '" . $un . "'";
		$rows = mysqli_query($dbc, $q);
		if(mysqli_num_rows($rows) > 0)
		{
			$row = mysqli_fetch_assoc($rows);
			$uId = $row['id'];
		}else
			echo '<p>There was a weird error. Try again.</p>';	


	$q = "select * from profilePictures WHERE userId = '$uId'";
	
	
	$rows = mysqli_query($dbc, $q);
	
	if (mysqli_num_rows($rows) > 0)
	{
		$r = mysqli_fetch_assoc($rows);
		
		return $r['dir'];
	}else
	{
		return 'uploads/profilePictures/default.png';
	}
	
	
	
	}
	
	
	
	function changePassword($dbc, $un)
	{
		
		
		
		
		
		$oldPw = sha1($_POST['oldPassword']);
		$newPw1 = $_POST['newPassword1'];
		$newPw2 = $_POST['newPassword2'];
		
		$oldPw = mysqli_real_escape_string($dbc, $oldPw);
		$newPw1 = mysqli_real_escape_string($dbc, $newPw1);
		$newPw2 = mysqli_real_escape_string($dbc, $newPw2);
		
		$q = "SELECT username, password, id FROM accounts WHERE username = '" . $un . "'";
		
		
		
		$rows = mysqli_query($dbc, $q);
		$row = mysqli_fetch_assoc($rows);
		
		$oldUserPw = $row['password'];
		$userId = $row['id'];
		
		
		
		if($newPw1 == $newPw2)
		{
			if($oldPw == $oldUserPw)
			{
				
				$q = "UPDATE accounts SET password = SHA1('" . $newPw1 . "') WHERE id = $userId";
				
				$r = mysqli_query($dbc, $q);
				
				if($r)
				{
					$url =  'myAccount.php?action=changedPassword';
					header("Location: $url");
				
					exit();
				
				}
				
				
			}else
				echo '<p><i>The old password entered was incorrect.</i></p>';
			
		}else
		{
			echo '<i><p>Your new passwords did not match.</p></i>';
		}
		
		
				
		
	}



	function changeProfilePicture($dbc, $un)
	{
		$q = "SELECT id FROM accounts WHERE username = '" . $un . "'";
		$rows = mysqli_query($dbc, $q);
		if(mysqli_num_rows($rows) == 1)
		{
			$row = mysqli_fetch_assoc($rows);
			$uId = $row['id'];
		}else
			echo '<p>There was a weird error. Try again.</p>';
		
		
		$targetDir = "uploads/profilePictures/";
		$file = $_FILES['profilePicture']['tmp_name'];
		$fileName = $_FILES['profilePicture']['name'];
		
		$fileName = mysqli_real_escape_string($dbc, $fileName);
		
		$fileType = pathinfo($fileName, PATHINFO_EXTENSION);
		$fileSize = $_FILES['profilePicture']['size']; //1000000 = 1MB
		
		$targetFilePath = $targetDir . 'user_' . $uId . '.' . $fileType;
		
		
		
		if($fileSize <= 2000000)  //2 Mb
		{
			if(in_array(strtolower($fileType), ['jpg','jpeg','gif','png','tif']))
			{
				
				//move file
				if(move_uploaded_file($file, $targetFilePath))
				{
					
					$q = "SELECT id, userId FROM profilePictures WHERE userId = '" . $uId . "'";
					
					$rows = mysqli_query($dbc, $q);
					
					$done = false;
					
					if(mysqli_num_rows($rows) == 0)
					{
						$q = "INSERT INTO profilePictures (name, dir, size, userId) VALUES ('$fileName', '$targetFilePath' , '$fileSize', '$uId')";
					
						$r = mysqli_query($dbc, $q);
						$done = true;
						
					}else if(mysqli_num_rows($rows) > 0)
					{
						$q = "UPDATE profilePicture SET name = '$fileName', dir = '$targetFilePath', size = '$fileSize' WHERE id = '$uId'";
					
						$r = mysqli_query($dbc, $q);
						$done = true;
						
					}
					/*
						$q = "select last_insert_id();";
					
						$r = mysqli_query($dbc, $q);
						
						$row = mysqli_fetch_assoc($r);
						echo $row['last_insert_id()'];
						$done = false;
					*/
					
					if($done)
					{
						$url =  'myAccount.php?action=changedProfilePicture';
						header("Location: $url");
				
						exit();
					}else
					{
						echo '<p>There was a weird error. Try again.</p>';
					}
					
					
				}else
					echo '<p>Fail upload failed!</p>';
				
				
			}else
			{
				echo '<p>File must be an image!</p>';
			}
		}else
		{
			echo '<p>File limit 2 MB!</p>';
		}
	}
		
		
		
		
			
			
		
		
	

?>