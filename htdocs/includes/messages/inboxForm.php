<h3>Inbox</h3>

<style>
th, td {
	padding: 5px;
	background-color:#ECF6FE;
}

#inboxTable .readRow td {
	background-color: #CFD8F3;
	
}

#inboxTable .newRow td {
	
	background-color:#9cafe6;
}

#inboxTable tr:hover td {
	background-color:#b3c3f2;
}


</style>



	
	
	
	
	
	
	<?php
		printInbox($dbc, $un);
	?>
	
	
	
	
	
