<? require "funcz/funcz.php";
pgTop("Projects");?>

	<form action ="doProjects.php" method="POST">
		<table>
			<tr>
				<td>ID</td>
				<td><input type='text' id='id' name='id' size='10' value='<?php print $_REQUEST['id'];?>'/>
			</tr>
			<tr>
				<td>User</td>
				<td><input type='text' id='userName' name='userName' size='40' value='<?php print $_REQUEST['userName'];?>'/></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type='password' id='password' name='password' size='8'/></td>
			</tr>
			<tr>
				<td>Admin</td>
				<td><input type='checkbox' id='admin' name='admin'  value="Y" <?php print ($_REQUEST['admin']=="Y"?" checked ":" ");?>' /></td>
			</tr>
			<tr>
				<td>System</td>
				<td><input type='text' id='systemName' name='systemName' size='40' value='<?php print $_REQUEST['systemName'];?>'/></td>
			</tr>
			<tr>
				<td></td>
				<td><input type='submit' id='submit' name="submit" value='Add'> 
				<input type='submit' id='submit'  name="submit"value='Change'>
				<input type='submit' id='submit' name="submit" value='Delete'>
				<input type='submit' id='submit' name="submit" value='Enquire'>
				<input type='submit' id='submit' name="submit" value='Clear'>
				<input type='submit' id='submit' name="submit" value='List'></td>
			</tr>			
		</table>
	</form>
	<?php print "<br/><div class='error'>".$_REQUEST["error"]."</div>"; ?><?php print "<div class='status'>".$_REQUEST["status"]."</div>"; ?> 
<? pgFoot();?>