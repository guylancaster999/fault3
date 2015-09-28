<?php
require"funcz/funcz.php";
pgTop("Login");
?>
<form method="POST" action="doLogin.php"/>
		<table>
			<tr> 
				<td>User</td>
				<td><input type="Text" size="30" id="user" name="user" value="<?php print $_REQUEST["user"];?>"/></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type="password" size="8" required id="psw" name="psw"/></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td style="text-align:center"><input type="submit" value="Go"/></td>
			</tr>
		</table>
	</form>
	<br/>
	<?php 
	print "<div class='error'>".$_REQUEST["error"]."</div>";
 pgFoot();?>
