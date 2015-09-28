<?php
function dSwap($d)
{
	return substr($d,4,2).substr($d,2,2).substr($d,0,2);
} 
function thereError($t,$d)
{
	return (strlen(trim($d))==0?"[".$t." required]":"");
}
function urlError($t,$d)
{
	$ret="";
	if (strlen($d)>0)
	{
		if ( (substr($d,0,7)!="http://")&&(substr($d,0,8)!="https://") )	
			$ret ="[".$t." must be a valid Webpage address]";
		elseif (strlen($d)<13)
			$ret="[".$t." must be a valid Webpage address.]";
	}
	return $ret;
}

function dateError($t,$d)
{
	$ret="";
	$d	=onlyDigits($d);
	
	if (strlen($d)>0)
	{
		$dd	= substr($d,0,2);
		$mm	= substr($d,2,2);
		$yy	= substr($d,4,2);
		
		if (($dd==0)|| ($dd>31)||($mm==0)||($mm>12)||($yy<15))
		{
			$ret = "[".$t." not in ddmmyy format - ".$dd."/".$mm."/".$yy."/"."]";
		}
	}
	return $ret;
}
function pgtop($ttl)
{
	session_start();
	checkSession($ttl);
	print '<!DOCTYPE html>
	<html>
	<head>
	<title>Fault System - '.$ttl.'</title>
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<link rel="stylesheet" type="text/css" href="css/main.css" />
	</head>
	<body>
	<div class="top">
		<h1>Fault Report System</h1>
		<h2>'.$ttl.'</h2>
		</div>';
	if ($ttl != "Login")print menu();
	print '<div class="main">';
    return ;
}
function pgFoot()
{
	print '</div>
	</body>
	</html>';
	return;
}
function noQuotes($s)
{
	$ret= str_replace ( "'"," ",$s);
	return str_replace ('"'," ",$ret);
}
function onlyLetters($s)
{
	$ret= "";
	$s	= strtoupper($s);
	
	for ($i=0; $i<strlen($s); $i++)
	{
		$c=substr($s,$i,1);
		if ($c>="A" && $c<="Z") $ret.=$c;
	}
    return $ret;
}
function onlyDigitsLetters($s)
{
	$ret="";
	$s= strtoupper ( $s);
	for ($i=0;$i<strlen($s);$i++)
	{
		$c=substr($s,$i,1);
		if ($c>="A" && $c<="Z") $ret.=$c;
		if ($c>="0" && $c<="9") $ret.=$c;
	}
    return $ret;
}
function onlyDigits($s)
{
	$ret="";
	$s= strtoupper ( $s);
	for ($i=0;$i<strlen($s);$i++)
	{
		$c=substr($s,$i,1);
		if ($c>="0" && $c<="9") $ret.=$c;
	}
    return $ret;
}
function open_db()
{
	$ret= mysql_connect('atlas.elite.net.uk', 'chorlt02_db1_ms', 'mW7ptYRKk');

	if (!$ret) 
	{
   		$ret=-1;
	}
	     else
    {
	   $db_selected = mysql_select_db('chorlt02_db1', $ret);
   	   if (!$db_selected) 
       {
   	      $ret=-1;
       }
	}
	return $ret;
}
function checkSession($pg="?")
{
	if ($pg != "Login")
	{
		$adminUser = $_SESSION["adminUser"];
		switch($adminUser)
		{
			case "N":break;
			case "Y":break;
			default:header("location:index.php?error=Illegal-Access[".$adminUser."]");
			exit;
		}
	}
	return;
}
function menu()
{
	print '<div class="menu">';
	if ($_SESSION["adminUser"]=="Y" )
	{
		print '<a href="projects.php">Projects</a>';
		print '<br/>
		<a href="faults.php">Faults</a>';
	}
	else
	{
		print '<a href="userFaults.php">Faults</a>';
	}
	print '<br/>
			<A href="logout.php">Logout</a>
			</div>';
	return;
}
?>