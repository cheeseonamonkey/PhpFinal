<div style="background-color:#9cafe6; width:50%; margin: 25px; padding: 5px; float: right;">


<form action="myAccount.php?action=changeBio" method="post">


<label><b>About me:</b></label> &nbsp; <p>
<textarea  style="resize: none;" maxlength="1080" rows = "5" cols = "35" name = "bio"><?php echo $bio; ?></textarea>

<div align="center"><input type="submit" name="changeBio" value="Change" /></div>

</form>
</div>
