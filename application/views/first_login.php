
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bookmyt</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>theme/css/toyaja.css" />
</head>

<body style="background:url(<?php echo base_url(); ?>theme/images/toyaja-bg.png) no-repeat center top">
<div class="main-continer" style="text-align:center">
<div class="login">


<form method="post" action="">
	<table>
	<tr>
	<td></td>
	<td colspan="1"><img src="<?php echo base_url(); ?>theme/images/logo.png"></td></tr>
	<tr><td></td><td align="center" colspan='2'> 
		<?php
			if($this->session->flashdata('fail'))
			{
		?>
			<span style="color:red;font-weight:bold;"><?php echo $this->session->flashdata('fail'); ?></span>
		<?php
			}
		?>

		</td>
	</tr>
	<tr>
	<td>Username:</td><td><input type="text" name="uname" id="uname"></td></tr>
		<tr><td>Password:</td><td><input type="password" name="pwd" id="pwd"></td></tr>
		<tr><td></td><td><input type="submit" name="sub" id="sub" value="login" style="float:right;"></td></tr>
		</table>
</form>


</div

</div>
</body>
</html>