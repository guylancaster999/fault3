<? require "funcz/funcz.php";
pgTop("Faults");?>
<form action ="doFaults.php" method="POST">
		<table>
			<tr>
				<td>ID</td>
				<td><input type='text' id='id' name='id' size='10' value='<?php print $_REQUEST['id'];?>'/>
			</tr>
			<tr>
				<td>System</td>
				<td><select id="sysId" name="sysId">
				<?php
				open_db();
				$qry="select id,systemName from faultsystem ";
				$qry.="where adminUser='N' ";
				$qry.="order by systemName;";
				$result = mysql_query($qry);
				$sysId	=$_REQUEST["sysId"];
			
				while ($row = mysql_fetch_assoc($result)) 
				{
					$fid			=$row["id"];
					$fsystemName	=$row["systemName"];
					print "<option value='".$fid."' ".($sysId==$fid ? " selected " : " ")." >".$fsystemName."</option>";
				}
				?>
				</select>
				</td>
			</tr>
			<tr>
				<td>Web page URL</td>
				<td><input type='text' id='url' name='url' value="<?php print $_REQUEST['url'];?>" size='60'/></td>
			</tr>
			<tr>
				<td>Page</td>
				<td><input type='text' id='page' name='page' value="<?php print $_REQUEST['page'];?>"  size="60" /></td>
			</tr>
			<tr>
				<td>Fault </td>
				<td><input type='text' id='fault' name='fault' size='60' value='<?php print $_REQUEST['fault'];?>'/></td>
				<td>&nbsp;</td>
				<td>Date <input type="text" size="6" id="faultDate" name="faultDate" value="<?php print $_REQUEST["faultDate"];?>"/></td>
			</tr>
			
			<tr>
				<td>Fix </td>
				<td><input type='text' id='fix' name='fix' size='60' value='<?php print $_REQUEST['fix'];?>'/></td>
				<td>&nbsp;</td>
				<td>Date <input type="text" size="6" id="fixDate" name="fixDate" value="<?php print $_REQUEST["fixDate"];?>"/></td>
			</tr>
			
			<tr>
				<td>Confirmed </td>
				<td><input type='checkbox' id='confirmed' name='confirmed' value="Y" <?php print ($_REQUEST['confirmed']=="Y"? " checked ":" ");?> /></td>
				<td>&nbsp;</td>
				<td>Date <input type="text" size="6" id="confirmedDate" name="confirmedDate" value="<?php print $_REQUEST["confirmedDate"];?>"/></td>
			</tr>
			
			<tr>
				<td>Reject Reason</td>
				<td><input type='text' id='rejectReason' name='rejectReason' size='60' value='<?php print $_REQUEST['rejectReason'];?>'/></td>
				<td>&nbsp;</td>
				<td>Date <input type="text" size="6" id="rejectDate" name="rejectDate" value="<?php print $_REQUEST["rejectDate"];?>"/></td>
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