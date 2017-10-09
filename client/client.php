<?php
ini_set("soap.wsdl_cache_enable", "0");

try{
    $client = new SoapClient('http://192.168.0.15/~user1/SOAP/task2/server/cars3.wsdl');

    if($_POST['id_car'])
    {
        $id_car = $_POST['id_car'];
        echo $client->getCarById($id_car);
    }
    elseif($_POST['brand'] || $_POST['year'] || $_POST['engine'] || $_POST['color'] || $_POST['speed'] || $_POST['price'] )
    {
        $params = $_POST;
        foreach($params as $key => $val)
        {
            if(empty($val) || ($key!='brand' && $key!='year' && $key!='engine' && $key!='color' && $key!='speed' && $key!='price'))
                unset($params[$key]);
        }
        $dataJSON = json_encode($params);
        echo $client->getCarsByParams($dataJSON);
    }
    else
    {
        echo $client->getAllCars();
    }

    if($_POST['fName'] && $_POST['lName'] && $_POST['email'] && $_POST['id_car'] && $_POST['payment'])
    {
        $dataJSON = json_encode($_POST);
        echo $client->getOrderCar($dataJSON); 
    }
}
catch(SoapFault $e)
{
    echo json_encode($e->getMessage());
}
