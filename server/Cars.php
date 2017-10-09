<?php
Class Cars
{
    protected $dbMy;

    public function __construct()
    {
        $this->dbMy = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
        if(!$this->dbMy)
           new SoapFault ("ERROR CONNECT", ERROR_CONNECT);

        $connect = mysql_select_db('user1', $this->dbMy);
        if(!$connect)
           new SoapFault("ERROR DB", ERROR_DB);

    }

    public function getAllCars()
    {
        $query = "SELECT id_car, brand, model, price FROM `soap_cars`";
        $result = mysql_query($query, $this->dbMy);
        $data = array();

        while($row = mysql_fetch_assoc($result))
        {
            $data[] = $row;
        }

        if(!empty($data))
            return json_encode($data);
    }

    public function getCarById($id)
    {
        if($id)
        {
            $query = "SELECT id_car, brand, model, year, engine, color, speed, price FROM `soap_cars` where id_car = $id";
            $data = mysql_query($query, $this->dbMy);
            $result = mysql_fetch_assoc($data);
            return json_encode($result);
        }
        else
        {
            new SoapFault("getCarById", ERROR_ID); 
        }
    }

    public function getCarsByParams($JSONstring)
    {
        $params = json_decode($JSONstring, true);

        if(is_array($params)){

            foreach ($params as $key=>$val)
            {
                if($key == 'speed' or $key == 'price' or $key == 'engine' or $key == 'year')
                    $operand = '>=';
                else
                    $operand = '=';

                $where[] = $key . $operand . '\'' . $val . '\' ';
            }

            $where = join('AND ', $where);

            $query = "SELECT id_car, brand, model, year, engine, color, speed, price FROM `soap_cars` where $where";
            $data = mysql_query($query, $this->dbMy);

            while($row = mysql_fetch_assoc($data))
            {
                $result[] = $row;
            }
            
            return json_encode($result);
        }
        else
        {
            new SoapFault("getCarsByParams", ERROR_ARRAY); 
        }
    }

    public function getOrderCar($JSONstring){

        $data = json_decode($JSONstring, true);

        if(is_array($data))
        {
            if (!empty($data['id_car']) && !empty($data['fName']) && !empty($data['lName']) && !empty($data['payment']) && !empty($data['email']))    
            {     
                $fName = $data['fName'];
                $lName = $data['lName'];
                $payment = $data['payment'];
                $email = $data['email'];
                $id_car = $data['id_car'];

                $query = "INSERT INTO soap_orders (`f-name`, `l-name`, `email`, `payment`, `id_car`) VALUES ('$fName', '$lName', '$email', '$payment', '$id_car')";
                $result = mysql_query($query, $this->dbMy);

                if ($result === false)
                    throw new SoapFault('getOrderCar', ERROR_INSERT);
            }
           
            return json_encode($result);
        }
        else
        {
           new SoapFault("getOrderCar", ERROR_ARRAY);
        }
    }
}
