<?php
echo "test\n";
$data = json_decode('not json', true);
var_dump($data);
var_dump(empty($data));
