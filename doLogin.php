<?php
require "funcz/funcz.php";
$psw = onlyDigitsLetters($_POST["psw"]);
$user= onlyLetters($_POST["user"]);
open_db();
$qry	="select id,adminUser, password,systemName ";
$qry	.=" from faultsystem";
$qry	.=" where userName='".$user."';";
$result = mysql_query($qry);
if (!$result) 
{
    die('Invalid query: ' . mysql_error());
}
$ctr = mysql_affected_rows() ;
if ($ctr==0)
{
	header("location:index.php?error=User%20".$user."%20Not%20found");
	exit;
}
$row 		= mysql_fetch_assoc($result);
$admin		=$row["adminUser"];
$pswStored	=$row["password"];
$systemName =$row["systemName"];
$sysId 		=$row["id"];

if (sha1($psw)!=$pswStored)
{
		header("location:index.php?error=Bad%20Password&user=".$user);
		exit;
}
session_start();
$_SESSION["adminUser"] 	=$admin;

if ($admin=="N")
{
	$_SESSION["sysId"]		=$sysId;
	$_SESSION["systemName"]	=$systemName;
	header("location:userFaults.php");
}
else
{
	header("location:faults.php");
}
?>