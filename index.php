<?php

header("Content-Type: Text/Html;Charset=UTF-8");
require "./vendor/autoload.php";

$obj = new think\Hashlib();

$encode_str = $obj->encode(1);

var_dump($encode_str);

$decode_str = $obj->decode($encode_str);
var_dump($decode_str);
