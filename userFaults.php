<? 
require "funcz/funcz.php";
session_start();
pgTop("Faults -".$_SESSION["systemName"]);
?>
<form action ="doUserFaults.php" method="POST">
		<table>
			<tr>
				<td>ID</td>
				<td><input type='text' id='id' name='id' size='10' value='<?php print $_REQUEST['id'];?>'/>
			</tr>
			<tr>
				<td>System</td>
				<td><?php 
				print $_SESSION["systemName"];
				print '<Input type="hidden" id="sysId" name="sysId" value="'.$_SESSION["sysId"].'">
				<Input type="hidden" id="systemName" name="systemName" value="'.$_SESSION["systemName"].'">';
				?>
				</td>
			</tr>
			<tr>
				<td>Web page URL</td>
				<td><input type='text' id='url' name='url' value="<?php print $_REQUEST['url'];?>" size='60'/></td>
			</tr>
			<tr>
				<td>Page</td>
				<td><input type='text' id='page' name='page'  size="60" value="<?php print $_REQUEST['page'];?>" /></td>
			</tr>
			<tr>
				<td valign='top'>Fault </td>
				<td valign='top'><textarea rows="4" cols="60" id='fault' name='fault' ><?php print $_REQUEST['fault'];?></textarea></td>
				<td valign='top'>&nbsp;</td>
				<td valign='top'>Date <input type="text" size="6" id="faultDate" name="faultDate" value="<?php print $_REQUEST["faultDate"];?>"/></td>
			</tr>			
			<tr>
				<td valign='top'>Fix</td>
				<td valign='top'><input type='hidden' id='fix' name='fix' value='<?php print $_REQUEST['fix'];?>'/>
				<textarea rows="4" cols="60" id='fix' name='fix' readonly ><?php print $_REQUEST['fix'];?></textarea></td>
				<td>&nbsp;</td>
				<td valign='top'>Date <input type="text"  size="6"  readonly  id="fixDate" name="fixDate" value="<?php print $_REQUEST["fixDate"];?>"></td>
			</tr>
			<tr>
				<td valign='top'>Reject Reason</td>
				<td valign='top'><textarea rows="4" cols="60" id='rejectReason' name='rejectReason' ><?php print $_REQUEST['rejectReason'];?></textarea></td>
				<td>&nbsp;</td>
				<td valign="top">Date <input type="text" size="6" id="rejectDate" name="rejectDate" value="<?php print $_REQUEST["rejectDate"];?>"/></td>
			</tr>
			<tr>
				<td>Fix Confirmed </td>
				<td><input type='checkbox' id='confirmed' name='confirmed' value="Y" <?php print ($_REQUEST['confirmed']=="Y"? " checked ":" ");?> /></td>
				<td>&nbsp;</td>
				<td>Date <input type="text" size="6" id="confirmedDate" name="confirmedDate" value="<?php print $_REQUEST["confirmedDate"];?>"/></td>
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
		<br/>
		<br/>
		* Dates must be in ddmmyy format - e.g. 311215
	</form>
	<?php print "<br/><div class='error'>".$_REQUEST["error"]."</div>"; ?><?php print "<div class='status'>".$_REQUEST["status"]."</div>"; ?> 
<? pgFoot();?>