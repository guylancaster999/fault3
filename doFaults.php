<?php
require "funcz/funcz.php";
function backLink($id,$sysId,$url,$page,$fault,$faultDate,$fix,$fixDate,$confirmed,$confirmedDate,$rejectReason,$rejectDate,$error="",$status="")
{	
	$ret="faults.php";
	$ret.="?id=".$id;
	$ret.="&sysId=".$sysId;
	$ret.="&url=".$url;
	$ret.="&page=".$page;
	$ret.="&fault=".$fault;
	$ret.="&faultDate=".($faultDate);
	$ret.="&fix=".$fix;
	$ret.="&fixDate=".($fixDate);
	$ret.="&confirmed=".$confirmed;
	$ret.="&confirmedDate=".$confirmedDate;
	$ret.="&rejectReason=".$rejectReason;
	$ret.="&rejectDate=".$rejectDate;
	$ret.="&error=".$error;
	$ret.="&status=".$status;
	return $ret;
}
function goback($id,$sysId,$url,$page,$fault,$faultDate,$fix,$fixDate,$confirmed,$confirmedDate,$rejectReason,$rejectDate,$error="",$status="")
{
	header("Location:".backLink($id,$sysId,$url,$page,$fault,$faultDate,$fix,$fixDate,$confirmed,$confirmedDate,$rejectReason,$rejectDate,$error,$status));
	exit;
}
session_start();
checkSession();
$submit			=$_POST["submit"];
$id				=onlyDigits($_POST['id']);
$sysId 			=onlyDigits($_POST['sysId']);
$url			=noQuotes($_POST['url']);
$page			=noQuotes($_POST['page']);
$fault			=noQuotes($_POST['fault']);
$faultDate 		=onlyDigits($_POST['faultDate']);
$fix			=noQuotes($_POST['fix']);
$fixDate		=onlyDigits($_POST['fixDate']);
$confirmed 		=($_POST['confirmed']=="Y"? "Y":"N");
$confirmedDate	=onlyDigits($_POST["confirmedDate"]);
$rejectReason 	=noQuotes($_POST['rejectReason']);
$rejectDate		=onlyDigits($_POST['rejectDate']);
$error			=$status	="";
open_db();
	
switch($submit)
{
	case "Add":
		$error.=thereError("System Name",	$sysId);
		$error.=thereError("Page or URL",	$page.$url);
		$error.=urlError("URL",	$url);
		$error.=thereError("Fault",			$fault);
		$error.=dateError("Fault Date",		$faultDate);
		$error.=dateError("Fix Date",		$fixDate);
		$error.=dateError("Confirmed Date",	$confirmedDate);
		$error.=dateError("Reject Date",	$rejectDate);
		if (strlen($error)>0)
			goback($id,$sysId,$url,$page,$fault,$faultDate,$fix,$fixDate,$confirmed,$confirmedDate,$rejectReason,$rejectDate,$error);
		$qry	="INSERT INTO `chorlt02_db1`.`faultItem` ";
		$qry	.="(`sysId`,`url`,`page`,`faultDescr`,`fixDescr`,`faultDate`,`fixDate`, `confirmedDate`, `confirmed`, `rejectReason`, `rejectDate`) ";
		$qry	.=" VALUES ";
		$qry	.=" (".$sysId.",'".$url."','".$page."','".$fault."','".$fix."','".dswap($faultDate)."','".dswap($fixDate)."','".dswap($confirmedDate)."','".$confirmed."','".$rejectReason."','".dswap($rejectDate)."');";
		$result = mysql_query($qry);
		if (!$result) 
			die('Invalid query: '.$qry.mysql_error());
		$id = mysql_insert_id();
		goback($id,$sysId,$url,$page,$fault,$faultDate,$fix,$fixDate,$confirmed,$confirmedDate,$rejectReason,$rejectDate,$error,"[Added Fault ".$id."]");
		break;
	
	case "Change":
		$error.=thereError("ID",$id);
		$error.=thereError("System Name",$sysId);
		$error.=thereError("Page or URL",$page.$url);
		$error.=urlError("URL",	$url);
		$error.=thereError("Fault",$fault);
		$error.=dateError("Fault Date",$faultDate);
		$error.=dateError("Fix Date",$fixDate);
		$error.=dateError("Confirmed Date",$confirmedDate);
		$error.=dateError("Reject Date",$rejectDate);
		if (strlen($error)>0)
			goback($id,$sysId,$url,$page,$fault,$faultDate,$fix,$fixDate,$confirmed,$confirmedDate,$rejectReason, $rejectDate,$error);
		$qry	="select count(*) as ctr from faultItem where id=".$id.";";
		$result = mysql_query($qry);
		$row	= mysql_fetch_assoc($result);
		$ctr	= $row["ctr"];
		if ($ctr==0)
			goback($id,$sysId,$url,$page,$fault,$faultDate,$fix,$fixDate,$confirmed,$confirmedDate,$rejectReason,$rejectDate,"[Fault ".$id." not found]".$qry,$status);
		$qry	="Update faultItem ";
		$qry	.=" set sysId=".$sysId.",";
		$qry	.=" url='".$url."',";
		$qry	.=" page='".$page."',";
		$qry	.=" faultDescr='".$fault."',";
		$qry	.=" faultDate='".dswap($faultDate)."',";
		$qry	.=" fixDescr='".$fix."',";
		$qry	.=" fixDate='".dswap($fixDate)."',";
		$qry	.=" confirmed='".$confirmed."',";
		$qry	.=" confirmedDate='".dswap($confirmedDate)."',";
		$qry	.=" rejectReason='".$rejectReason."',";
		$qry	.=" rejectDate='".dswap($rejectDate)."'";
		$qry	.=" where id=".$id;
		$result = mysql_query($qry);
		if (!$result) 
		{
			die('Invalid query: '.$qry.mysql_error());
		}
		goback($id,$sysId,$url,$page,$fault,$faultDate,$fix,$fixDate,$confirmed,$confirmedDate,$rejectReason,$rejectDate,$error,"[Changed Fault ".$id."]");
	break;
	
	case "Delete":
		if (strlen($id)==0)goback($id,$sysId,$url,$page,$fault,$faultDate,$fix,$fixDate,$confirmed,$confirmedDate,$rejectReason,$rejectDate,"[Id required]");
	 	$qry	="select count(*) as ctr from faultItem where id=".$id.";";
		$result = mysql_query($qry);
		$row	= mysql_fetch_assoc($result);
		$ctr	= $row["ctr"];
		if ($ctr==0)
			goback($id,$sysId,$url,$page,$fault,$faultDate,$fix,$fixDate,$confirmed,$confirmedDate,$rejectReason,$rejectDate,"[Delete failed:Fault ".$id." not found]");
 		$qry="delete from faultItem where id=".$id.";";
		$result = mysql_query($qry);
		if (!$result) 
			die('Invalid query: '.$qry.mysql_error());
		goback("","","","","","","","","","","","","","[Deleted Fault ".$id."]");	

	case "Enquire":
		if (strlen($id)==0)
			goback($id,$sysId,$url,$page,$fault,$faultDate,$fix,$fixDate,$confirmed,$confirmedDate,$rejectReason,$rejectDate,"[ID required for Enquire]");	
		$qry="select count(*) as ctr from faultItem where id=".$id;
		$result = mysql_query($qry);
		$row 	= mysql_fetch_assoc($result);
		$ctr	= $row["ctr"];
		if ($ctr == 0)
			goback($id,$sysId,$url,$page,$fault,$faultDate,$fix,$fixDate,$confirmed,$confirmedDate,$rejectReason,$rejectDate,"[ID not found]");	
		$qry			= "select id, sysId, url, page, faultDescr, faultDate, fixDescr, fixDate, confirmed, confirmedDate, rejectReason, rejectDate";
		$qry			.= " from faultItem ";
		$qry			.= " where id=".$id;
		$result 		= mysql_query($qry);
		$row 			= mysql_fetch_assoc($result);
		$sysId			= $row["sysId"];
		$url			= $row["url"];
		$page			= $row["page"];
		$fault			= $row["faultDescr"];
		$faultDate		= dswap($row["faultDate"]);
		$fix			= $row["fixDescr"];
		$fixDate		= dswap($row["fixDate"]);
		$confirmed		= $row["confirmed"];
		$confirmedDate	= dswap($row["confirmedDate"]);
		$rejectReason	= $row["rejectReason"];
		$rejectDate		= dswap($row["rejectDate"]);
		goback($id,$sysId,$url,$page,$fault,$faultDate,$fix,$fixDate,$confirmed,$confirmedDate,$rejectReason,$rejectDate,"","Enquiry on ID ".$id);

	case "Clear":
		goback("","","","","","","","","","","",""," " ,"[Cleared]");

	case "List":
		$qry= "select a.id, a.sysId, a.url, a.page, a.faultDescr, a.faultDate, a.fixDescr, a.fixDate, a.confirmed, a.confirmedDate, a.rejectReason, a.rejectDate, b.systemName, b.userName ";
		$qry.= " from  faultItem as a, faultsystem as b ";
		$qry.=" where a.sysId = b.id ";
		$qry.=" order by   a.id;";
		$result = mysql_query($qry);
		if (!$result)
			goback($id,$sysId,$url,$page,$fault,$faultDate,$fix,$fixDate,$confirmed,$confirmedDate,$rejectReason,$rejectDate,"[Query ".$qry." Failed]");	
		if (mysql_num_rows($result) == 0) 
			goback($id,$sysId,$url,$page,$fault,$faultDate,$fix,$fixDate,$confirmed,$confirmedDate,$rejectReason,$rejectDate,"[No Rows found]");	
		pgTop("Faults");
		print "<table>
		<tr>
		<td><b>Fault ID&nbsp;</b></td>
		<td><b>User</b></td>
		<td><b>System</b></td>
		<td><b>Fault</b></td>
		</tr>";
		
		while ($row = mysql_fetch_assoc($result)) 
		{
			$id			= $row["id"];
			$sysId		= $row["sysId"];
			$page		= $row["page"];
			$url		= $row["url"];
			$userName	= $row["userName"];
			$fault		= $row["faultDescr"];
			$faultDate	= dswap($row["faultDate"]);
			$fixDate	= dswap($row["fixDate"]);
			$fix		= $row["fixDescr"];
			$confirmedDate	= dswap($row["confirmedDate"]);
			$confirmed	= $row["confirmed"];
			$rejectReason= $row["rejectReason"];
			$rejectDate	= dswap($row["rejectDate"]);
			$systemName	= $row["systemName"];
    		$link		= backLink($id,$sysId,$url,$page,$fault,$faultDate,$fix,$fixDate,$confirmed,$confirmedDate,$rejectReason,$rejectDate);
			print "<tr>
			<td><a href='".$link."'>".$id."</a></td>
			<td>".$userName."</td>
			<td>".$systemName	."</td>
			<td>".$fault."</td>
			</tr>";
		}
		print "</table>";
		print "<blockquote><form action='faults.php'><input type='submit' value='Exit'/></form></blockquote>";
		pgFoot();
	break;
 }
?>