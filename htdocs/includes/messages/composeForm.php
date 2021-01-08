<h3>Compose new message:</h3>
<form action="messages.php?action=sendMessage" method="post" enctype="multipart/form-data">

<label style=""><b>To:</b></label> &nbsp; <input type="text" name="to" size="15" maxlength="30" /> </p>

<input type="file" name="attach" style="float:right; background-color: #ECF6FE; ">
<label style="float: right;"><b>Attach: &nbsp;&nbsp;&nbsp;</b></label>

<label style="clear: both;"><b>Subject:</b></label> &nbsp; <input type="text" name="subject" size="15" maxlength="30" /> </p>

<label style="margin-left: 25px;"><b>Message:</b></label><br>

<div align="center">
<textarea  style="resize: none;" maxlength="1080" rows = "5" cols = "75" name = "body"></textarea>
</div>
<div align="center"><input type="submit" name="compose" value="Send" /></div>


<br></form>