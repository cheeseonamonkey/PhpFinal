<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  
  <?php
  echo "<title> $pageTitle </title>"; 
  
  $_GET   = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


  ?>

  
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    
    <style>

.link-button {
    background: none;
    border: none;
    color: blue;
    text-decoration: underline;
    cursor: pointer;
    font-size: 100%;
}


      	

body {
      	background-color: #ECF6FE;
		
      }
	  
	  
     
     
	  
	  ul {
      
	  list-style-type: none;
 	 margin: 0;
 	 padding: 0;
	}

    li a {
      display: block;
	  text-decoration: none;
	  font-size: 130%;
	  font-weight: bold;
	  margin-left: 5px;
    }
	
	.nav li:hover
	{
		background-color:#b3c3f2;
	}
	
	.nav {
    	  background-color: #CFD8F3;
   	     width: 50%;
		 clear: both;
      }
      
	.login {
		float: right;
		height: 5%;
		width: 33%;
		text-align: right;
		background-color: #CFD8F3;
		
	}
	
	h1 {
		margin-left: 0px;
		margin-right: 0px;
		margin-bottom: 10px;
		margin-top: 5px;
	}
	
	.login:hover {
		background-color:#b3c3f2;
	}
	
	.login a {
		text-decoration: none;
		display:inline-block;
		width: 100%;
		
	}
	
	.title {
		background-color: #9cafe6;
		height: 5%;
		float: left;
      	width: 50%;
		
	}
	
	.titleWrapper {
		width: 50%;
	}
	
	h2 {
		margin-top: 3px;
		margin-bottom: 3px;
	}
      
    </style>
    
  </head>
  
  
      <div class="titleWrapper">
      
      <h1 class="title"><b>Some Title</b></h1>
    	
	<h1 class="login">
		<?php if(isset($_SESSION['username'])) {echo '<a href="logout.php">Logout</a>';} else {echo '<a href="login.php">Login</a>';} ?>
	</h1>
	</div>
    
    
    <div class="nav">
		<hr>
      <ul>
		<li><a href="index.php">Home</li>
        <li><a href="myAccount.php">My account</li>
		<li><a href="messages.php">Messages</a></li>
		<li><a href="">Link 4</a></li>
      </ul>
	  <hr>
    </div>
    
    

  <body>