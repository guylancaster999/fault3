<?php
require "funcz/funcz.php";
function backLink($userName,$admin,$id,$systemName,$error="",$status="")
{	$ret="projects.php";
	$ret.="?userName=".$userName;
	$ret.="&admin=".$admin;
	$ret.="&id=".$id;
	$ret.="&systemName=".$systemName;
	$ret.="&error=".$error;
	$ret.="&status=".$status;
	return $ret;
}

function goback($userName,$admin,$id="",$systemName,$error="",$status="")
{
	header("Location:".backLink($userName,$admin,$id,$systemName,$error,$status));
	exit;
}
session_start();
checkSession();
$submit		=$_POST["submit"];
$id			=onlyDigits($_POST['id']);
$userName	=onlyLetters($_POST['userName']);
$password	=onlyDigitsLetters($_POST['password']);
$systemName	=onlyDigitsLetters($_POST['systemName']);
$admin		=$_POST["admin"];
if ($admin !="Y") $admin="N";
$error		=$status	="";
open_db();
	
switch($submit)
{
	case "Add":		
		$error=thereError("Username",$userName);		
		$error=thereError("Password",$password);
		$error=thereError("System Name",$systemName);
		if (strlen($error>0))
			goback($userName,$admin,"",$systemName,$error,$status);
 		$qry	="insert into faultsystem ";
		$qry	.="(password,userName,systemName,adminUser) ";
		$qry	.=" values ('".sha1($password)."','".$userName."','".$systemName."','".$admin."');";
		$result = mysql_query($qry);
		if (!$result) 
		{
			die('Invalid query: '.$qry.mysql_error());
		}
		$id = mysql_insert_id();		
		$status="[Added Project ".$id."]";
		goback($userName,$admin,$id,$systemName,$error,$status);
	break;
	
	case "Change":
		if (strlen($id)==0)$error.="[ID required for change]";
    	if (strlen($userName)<3)$error.="[Username required`]";
		if (strlen($systemName)<3)$error.="[System name required`]";
		if (strlen($error>0))		goback($username,$admin,$id,$systemName,$error,$status);
		$qry	="select count(*) as ctr from faultsystem where id=".$id;
		$result = mysql_query($qry);
		$row	=mysql_fetch_assoc($result);
		$ctr	=$row["ctr"];
		if ($ctr==0)goback($username,$admin,$id,$systemName,"[ID ".$id."not found]",$status);
		$qry	="Update faultsystem ";
		$qry	.=" set userName='".$userName."', systemName='".$systemName."', adminUser='".$admin."'";
		$qry	.=" where id=".$id;
		if (strlen($password)>0) $qry.=", password='".$password."'";
		$result = mysql_query($qry);

		if (!$result) 
		{
			die('Invalid query: '.$qry.mysql_error());
		}
		goback($userName,$admin,$id,$systemName,$error,"[Changed Project".$id."]");
	break;
	
	case "Delete":
		if (strlen($id)==0)goback($userName,$admin,$id,$systemName,"[ID required for change]");
	 	$qry	="select count(*) as ctr from faultsystem where id=".$id;
		$result = mysql_query($qry);
		$row	= mysql_fetch_assoc($result);
		$ctr	= $row["ctr"];
		if ($ctr==0)goback($userName,$admin,$id,$systemName,"[Delete failed:ID ".$id."not found]");
 		$qry="delete from faultsystem where id=".$id;
		$result = mysql_query($qry);
		if (!$result) 
		{
			die('Invalid query: '.$qry.mysql_error());
		}
		goback("","","","","","[Deleted ID ".$id."]");	

	case "Enquire":
		if (strlen($id)==0)goback($userName,$admin,$id,$systemName,"[ID required for Enquire]",$status);	
		$qry	= "select userName,systemName,adminUser from faultsystem where id=".$id;
		$result = mysql_query($qry);
		if (mysql_num_rows($result) == 0)goback($userName,$admin,$id,$systemName,"[No Project found for ID ".$id."]",$status);	
		$row = mysql_fetch_assoc($result);
		$userName	= $row["userName"];
		$admin		= $row["adminUser"];
		$systemName	= $row["systemName"];
		goback($userName,$admin,$id,$systemName,$error,"[Enquiry on ID ".$id."]");	

	case "Clear":
		goback("","","","","[Cleared]");

	case "List":
		$qry	= "select id, userName, systemName, adminUser from faultsystem order by id;";
		$result = mysql_query($qry);
		if (!$result)  goback($userName,$admin,$id,$systemName,"[Query ".$qry." Failed]");	
		if (mysql_num_rows($result) == 0) goback($userName,$admin,$id,$systemName,"[No Rows found]");	
		pgTop("Projects");
		print "<table>
		<tr>
		<td><b>ID&nbsp;</b></td>
		<td><b>User</b></td>
		<td><b>Admin&nbsp;</b></td>
		<td><b>System</b></td>
		</tr>";
		while ($row = mysql_fetch_assoc($result)) 
		{
			$id			= $row["id"];
			$userName	= $row["userName"];
			$admin		= $row["adminUser"];
			$systemName	= $row["systemName"];
			$link		= backLink($userName,$admin,$id,$systemName,$error,$status);
			print "<tr>
			<td><a href='".$link."'>".$id."</a></td>
			<td>".$userName."</td>
			<td>".($admin=="Y"?"yes":"no")."</td>
			<td>".$systemName."</td>
			</tr>";
		}
		print "</table>";
		print "<blockquote><form action='projects.php'><input type='submit' value='Exit'/></form></blockquote>";
		pgFoot();
	break;
 }
?>