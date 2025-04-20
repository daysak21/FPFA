<?php
$python_path = '/usr/bin/python3'; 
$script_path = __DIR__ . '/recommendation_minmax.py';

$command = escapeshellcmd("$python_path $script_path");
$output = shell_exec($command);

echo "<pre>$output</pre>";
?>