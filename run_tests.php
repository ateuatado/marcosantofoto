<?php
$output = [];
$return_var = 0;
exec('vendor\bin\phpunit 2>&1', $output, $return_var);
file_put_contents('test_report.txt', implode("\n", $output));
echo "Done";
