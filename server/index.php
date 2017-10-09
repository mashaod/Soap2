<?php
include('config.php');
include('Cars.php');

ini_set("soap.wsdl_cache_enabled", "0");

$server = new SoapServer("http://192.168.0.15/~user1/SOAP/task2/server/cars3.wsdl");
$server->setClass('Cars');
$server->handle();

//}
////catch (ExceptionFileNotFound $e)
////{
////   echo 'Error message: ' . $e->getMessage();
////}
//
///*
//$car = new Car();
//
//$array[color]='white';
//$array[speed]='30';
//$array[year]='2010';
//
//$data = $car->getCarByType($array);
// */
