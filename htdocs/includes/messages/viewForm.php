



<?php


echo '<form action="messages.php?action=deleteMessage&view=' . $view . '" method="post" enctype="multipart/form-data">';


if(isset($_GET['view']))
{
	$view = $_GET['view'];

$q = 
"SELECT messages.id as 'messageId', dateTime, fromId, toId, hasAttachment, subject, body, viewed,
accounts.id as 'accountId', username as 'fromUn',
messageAttachments.id as 'attachmentId', messageAttachments.dir as 'attachmentDir',
messageAttachments.name as 'attachmentName'
FROM messages
JOIN accounts ON messages.fromId = accounts.id
LEFT JOIN messageAttachments ON messages.id = messageAttachments.messageId
WHERE messages.id = $view
";

$r = mysqli_query($dbc, $q);

$msg = mysqli_fetch_assoc($r);



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


if(! $viewed)
{
	
	$q = "UPDATE messages SET viewed = 1 WHERE id = $messageId";
	
	$r = @ mysqli_query($dbc, $q);
	
	if($r)
	{}
}


// echo '<div style="float: left;"><input type="submit" name="reply" value="Reply" /> &nbsp; </div>';
echo '<div style="float: right;"><input type="submit" name="delete" value="Delete" /></div>';

echo '<br style="clear:both;">';


echo '<h3 style="background-color:#CFD8F3;">' . $subject . '</h3>';

$date = strtotime($dateTime);

echo '<h4 width="90%" style="background-color:#CFD8F3;">From: ' . $fromUn . ' on ' . date('M d h:ma', $date) . '</h4>';

if($hasAttachment)
{
	echo '<img src=' . $attachmentDir .'  width="90%" height="width">';
	
	
}

echo '<h4 style="background-color:#CFD8F3;">Message:<br></h4>';
echo '<p width="90%">' . $body . '</p>';

}
?>


<div align="center">

</div>





<br></form>