<?php


function deleteMessage($dbc, $view)
{
	$q = "DELETE from MESSAGEATTACHMENTS WHERE messageid = $view";
	
	$view = mysqli_real_escape_string($dbc, $view);
	
	$r = mysqli_query($dbc, $q);
	
	
	$q = "DELETE from MESSAGES WHERE id = $view";
	
	
	
	$r = mysqli_query($dbc, $q);
	
	if(($r))
	{
		$url =  'messages.php?action=deletedMessage';
							header("Location: $url");
				
							exit();
		
	}else
		echo '<p>Error deleting.';
}


function printInbox($dbc, $un)
{
	if(isset($_GET['page']))
	{
			$page = ($_GET['page']);
			if($page < 1)
				$page = 1;
	}
		else
			$page = 1;
		
		$page = mysqli_real_escape_string($dbc, $page);
	if(isset($_GET['view']))
	{
		$viewMsg = $_GET['view'];
	}else
		$viewMsg = 0;
	
	$viewMsg = mysqli_real_escape_string($dbc, $viewMsg);
	
	echo '<table width="90%" id="inboxTable">';
	
	//th row
	echo '<tr>';
	echo '<th maxwidth="5%" style="margin: auto; width: 1px; padding: 1px; font-size: 70%;">Read</th>';
	echo '<th width="25%" align="left">Recieved</th>';
	echo '<th  width="10%" align="left">From</th>';
	echo '<th colspan="2" width="55%" align="left">Subject</th>';
	echo '</tr>';
	
	$uId = getUserId($dbc, $un);
	
	$q =
	"
SELECT messages.id as 'messageId', dateTime, fromId, toId, hasAttachment, subject, body, viewed,
accounts.id as 'accountId', username as 'fromUn',
messageAttachments.id as 'attachmentId', messageAttachments.dir as 'attachmentDir',
messageAttachments.name as 'attachmentName'
FROM messages
JOIN accounts ON messages.fromId = accounts.id
LEFT JOIN messageAttachments ON messages.id = messageAttachments.messageId
WHERE toId = $uId
ORDER BY dateTime DESC
LIMIT " . (($page * 8)-8) . ", " . (($page * 8))
	;
	
	//prints each inbox row
	function printInboxRow($msg, $page, $viewMsg)
	{
		$messageId = $msg['messageId'];
		$dateTime = $msg['dateTime'];
		$fromId = $msg['fromId'];
		$toId = $msg['toId'];
		$hasAttachment = $msg['hasAttachment'];
		$subject = $msg['subject'];
		$body = $msg['body'];
		$fromUn = $msg['fromUn'];
		$viewed = $msg['viewed'];
		
		
		
		if($hasAttachment)
		{
			$attachmentId = $msg['attachmentId'];
			$attachmentDir = $msg['attachmentDir'];
			$attachmentName = $msg['attachmentName'];
		}
		
		
		if($viewed == 1 || $viewMsg == $messageId)
		{
			echo '<tr class="newRow">';
			echo '<td align="center">X</td>';
		}
		else if($viewed == 0 )
		{
			echo '<tr class="readRow">';
			echo '<td align="center"></td>';
			
		}
		
			
		
		
		
		
		$date = strtotime($dateTime);
		echo '<td style="font-size: 90%;" align="left">' . date('Md h:mA', $date) . '</td>';
		
		echo '<td align="left">' . $fromUn . '</td>';
		
		echo '<td colspan ="2" maxwidth="69%" width="69%" align="left"><a  href="messages.php?page=' . $page . '&view=' . $messageId . '">' . $subject . '</a></td>';
		
		echo '</tr>';
		
		
	}
	
	//mega array for messages
	$messages = array();
	
	
	$rows = mysqli_query($dbc, $q);
	
	$numMessages = mysqli_num_rows($rows);
	$maxPages = $numMessages / 8;
	
	
	while ($row = mysqli_fetch_array($rows, MYSQLI_ASSOC))
	{
		$messages[] = $row;
	}
	
	
	
	//print each row
	foreach($messages as $msg)
	{
		printInboxRow($msg, $page, $viewMsg);
	}
	
	
	
	//paging		
		echo '<tr>   <td colspan="5" style="padding:3px;"><b style="float:left;">';
		
		if($page == 1)
			echo 'First page';
		else if($page > 1)
			echo '<a href="messages.php?page=' . ($page-1) . '">Back a page</a>';
		
		
		echo '</b>';
		echo '<b style="float: right;">';
		if($numMessages == 8)
			echo '<a href="messages.php?page=' . ($page+1) . '">Next page</a>';
		else if($numMessages < 8)
			echo 'Last page';
		echo '</b>  </td></tr>';
		echo '<tr><td colspan="5" style="padding:1px;">   <i style="float:left;">Page ' . ($page) . ' </i>    <i style="float:right;">Showing ' . $numMessages . ' messages</i>     </td></tr>'; 
			

	echo '</table>';

	
}

function sendMessage($dbc, $un)
{
	$uId = getUserId($dbc, $un);
	$toUn = $_POST['to'];
	$toUId = getUserId($dbc, $toUn);
	
	$toUn = mysqli_real_escape_string($dbc, $toUn);
	
	if($toUId >= 0)
	{
		if(isset($_POST['subject']))
			$subject = $_POST['subject'];
		else
			$subject = "(no subject)";
		
		if(isset($_POST['body']))
			$body = $_POST['body'];
		else
			$body = '(no body)';
		
		$subject = mysqli_real_escape_string($dbc, $subject);
		$body = mysqli_real_escape_string($dbc, $body);
		
		if(file_exists($_FILES['attach']['tmp_name']))
		{
			$hasAttach = true;
		}
		else
			$hasAttach = false;
		
		
		
		
		//sql post message
		if($hasAttach)
			$q = "INSERT INTO messages (fromId, toId, subject, body, hasAttachment) VALUES ($uId, $toUId, '$subject', '$body', true)";
		else
			$q = "INSERT INTO messages (fromId, toId, subject, body, hasAttachment) VALUES ($uId, $toUId, '$subject', '$body', false)";
		
		
		$r = mysqli_query ($dbc, $q);
		
					/*	gets last inserted id */
					$q = "select last_insert_id();";
				
					$r = mysqli_query($dbc, $q);
					
					$row = mysqli_fetch_assoc($r);
					$thisMessageId = $row['last_insert_id()'];
					/*						 */
					
					
		
						
						
						
						
		if($r)
		{
		
		
		//then do attachment sql
		if($hasAttach)
		{
			$targetDir = "uploads/messageAttachments/";
			$file = $_FILES['attach']['tmp_name'];
			$fileName = $_FILES['attach']['name'];
			
			$fileName = mysqli_real_escape_string($dbc, $fileName);
			
			$fileType = pathinfo($fileName, PATHINFO_EXTENSION);
			$fileSize = $_FILES['attach']['size']; //1000000 = 1MB
			
			$targetFilePath = $targetDir . 'message_' . $thisMessageId . '.' . $fileType;
			
			
			
			if($fileSize <= 2000000)  //2 Mb
			{
				if(in_array(strtolower($fileType), ['jpg','jpeg','gif','png','tif', 'doc', 'txt', 'zip', 'docx', 'mov', 'mp4']))
				{
					
					//move file
					if(move_uploaded_file($file, $targetFilePath))
					{
						
						$q = "INSERT INTO messageAttachments (messageId, dir, name, size) VALUES ($thisMessageId, '$targetFilePath', '$fileName', $fileSize)";
					
						$r = mysqli_query($dbc, $q);
						
						if($r)
						{
							//success!
							$url =  'messages.php?action=sentMessage';
							header("Location: $url");
				
							exit();
							
							
						}else
							echo '<p><i>Error sending attachment.</i></p>';
						
						
						
						
					}
				}else
				{
					echo '<p><i>File must be of type jpg, jpeg, gif, png, tif, doc, docx, txt, zip, mpg, or mov.';
				}
			}else
			{
				echo '<p><i>File limit 2 MB!</i></p>';
			}
		
		}
		
		}else
		{
			echo '<p><i>Error sending message.</i></p>';
			//error 
		}
	}else
	{
		//to user not found
	}
	
	
}

function getUserId($dbc, $un)
{
	$q = "SELECT id FROM accounts WHERE username LIKE '" . $un . "'";
		$rows = mysqli_query($dbc, $q);
		if(mysqli_num_rows($rows) > 0)
		{
			$row = mysqli_fetch_assoc($rows);
			$uId = $row['id'];
			return $uId;
			
			
		}else
		{
			echo '<p>There was an error. Try again.</p>';
			return -1;
		}
	
}






?>