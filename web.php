<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">
<title>Port Scanner</title>
<script src="js/jquery-2.0.2.min.js" type="text/javascript"></script>
<script src="js/loadFields.js" type="text/javascript" ></script>
<script>function pS() { var tim; window.scrollBy(0, 1); tim = setTimeout('pS()', 10);}</script><body onload=pS()>
<style>#nav{position: fixed; top: 50; left: 30%;} #result{position: relative; top: 45;}</style>
</head>
<body bgcolor=efefef link=red vlink=red><center><div id="nav"><h3><span style="color:gray">Web based, DYNAMIC <span style="color:#9c353a">PORT SCANNER</span></span></h3>
<form method="post">
    <input autocomplete="off" required placeholder="Domain / IP..." type="text" name="domain" autofocus />&nbsp;
	<input autocomplete="off" required placeholder="Starting Port" type="text" name="startport" />&nbsp;
	<input autocomplete="off" required placeholder="Ending Port..." type="text" name="endport" />&nbsp;
    <input type="submit" value="Scan" />
</form>
<hr /></div>
</center>

<div class="results" id="result">
<?php
error_reporting(0);
$ip = getIP();
function GetIP() 
{ 
	if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) 
		$ip = getenv("HTTP_CLIENT_IP"); 
	else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) 
		$ip = getenv("HTTP_X_FORWARDED_FOR"); 
	else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) 
		$ip = getenv("REMOTE_ADDR"); 
	else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) 
		$ip = $_SERVER['REMOTE_ADDR']; 
	else 
		$ip = "unknown"; 
	return($ip); 
}
$today = date("D M j Y g:i:s a T");
	$domain = htmlspecialchars($_POST['domain']);
	$startport = htmlspecialchars($_POST['startport']);
	$endport = htmlspecialchars($_POST['endport']);

if (strlen($domain) < 4) {echo "";exit;}
if(!is_numeric($startport)){echo "<b>Ports are always numbers</b>"; exit;}
if(!is_numeric($endport)){echo "<b>Ports are always numbers</b>"; exit;}
if (($startport < 1) || ($startport > 65535)){echo '<b>Range is incorrect. Give between 1 - 65535</b>';exit;};
if (($endport < 1) || ($endport > 65535)){echo '<b>Range is incorrect. Give between 1 - 65535</b>';exit;};
if (strlen($domain) > 88) {echo "<b>That definitely ain't a hostname</b>";exit;}
elseif(strpos( $domain, ' ' ) !== false) {echo 'No spaces please, I just hate it';exit;}
elseif(strpos( $domain, '"' ) !== false) {echo 'Hostname does not have double-quotes!';exit;}
elseif(strpos( $domain, '!' ) !== false) {echo 'Hostname does not have !, or so I think';exit;}
elseif(strpos( $domain, '`' ) !== false) {echo 'Since when did hostnames have back-ticks! To get a shell, open your command window';exit;}
elseif(strpos( $domain, '<' ) !== false) {echo 'What was that ... XSS!';exit;}
elseif(strpos( $domain, '>' ) !== false) {echo 'Hostname does not have > No XSS!';exit;}
elseif(strpos( $domain, '^' ) !== false) {echo 'Hostname does not have ^';exit;}
elseif(strpos( $domain, '?' ) !== false) {echo 'Hostname bro not queries!';exit;}
elseif(strpos( $domain, '/' ) !== false) {echo 'Hostname does not have slashes!';exit;}
elseif(strpos( $domain, "(" ) !== false) {echo 'Hostname does not have braces!';exit;}
elseif(strpos( $domain, ")" ) !== false) {echo 'Hostname does not have braces!';exit;}
elseif(strpos( $domain, "{" ) !== false) {echo 'Hostname does not have braces!';exit;}
elseif(strpos( $domain, "]" ) !== false) {echo 'Hostname does not have braces!';exit;}
elseif(strpos( $domain, "[" ) !== false) {echo 'Hostname does not have braces!';exit;}
elseif(strpos( $domain, "{" ) !== false) {echo 'Hostname does not have braces!';exit;}
elseif(strpos( $domain, "~" ) !== false) {echo 'Hostname does not have ~ ..';exit;}
elseif(strpos( $domain, "," ) !== false) {echo 'Looks like you mistyped....';exit;}
elseif(strpos( $domain, ":" ) !== false) {echo 'We are already port scanning';exit;}
elseif(strpos( $domain, "'" ) !== false) {echo "Next times babes... sql thug says: no injections please";exit;}
elseif(strpos( $domain, "127.0.0.1" ) !== false) {echo "I don't port scan myself";exit;}
elseif(strpos( $domain, "|" ) !== false) {echo 'Hostname does not have | aka OR operators!';exit;}
elseif(stripos( $domain, 'aamer.xyz' ) !== false) {echo "This site cannot be port-scanned";exit;}
elseif(strpos( $domain, '.' ) != true){echo"where is the dot";exit;}
elseif(strpos( $domain, ';' ) !== false) {echo "<b>Bad Input! Try again</b>";exit;}
    $logfile = fopen('history.txt', 'a+');
    fwrite($logfile, $domain . ", Requester:" . $ip . ", Time:" . $today . ", Range:" . $startport . " to " . $endport . "\n\n");
    fclose($logfile);

if($startport > $endport)
	{
		$temp = $startport;
		$startport = $endport;
		$endport = $temp;
	}
	else
	{
		$startport = $startport;
		$endport = $endport;
	}
	$limit = $startport - $endport;
	$control = abs($limit);
	$control = $control + 1;
	if($control > 101) {echo "<b>Bulk port scanning barred due to bandwidth issues. Max range can be 101</b>";exit;}
	echo 'Scan started for: <b>' . $control . '</b> port(s) of:<b> ' . $domain . '</b> from Port: <b>' . $startport . '</b> to Port: <b>' . $endport . '</b><br /><br />';
	echo '<script type="text/javascript">sendRequest("' . $domain . '", ' . $startport . ', ' . $endport . ');</script>';
	
?>
</div>
</body>
</html>
