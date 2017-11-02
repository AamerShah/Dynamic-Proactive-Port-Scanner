<?php
$domain = $_POST['domain'];
$port = $_POST['port'];

		$port = $port;
		$name = getservbyport($port, "tcp");
        if($pf = @fsockopen($domain, $port, $err, $err_string, 1)) 
		{
            echo "<span style=\"color:green\">[+] OPEN</span>: Port $port ($name)<br />";
            fclose($pf);
        } 
		else 
		{
            echo "<span style=\"color:red\">[-] CLOSED</span>: Port $port ($name)<br />";
        }
?>
