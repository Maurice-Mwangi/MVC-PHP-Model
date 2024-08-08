<?php

trait Database {
    private function connect_database()
    {
        $string_connector = "mysql:host=". DB_HOST . ";dbname=" .DB_NAME;

        $connect_db = new PDO($string_connector, DB_USER, DB_PASS);

        return $connect_db;
    }

    public function query_db($query, $col_data = []){

        $connect = $this->connect_database();
        $stmt = $connect->prepare($query);
        $check = $stmt->execute($col_data);
        
        if($check){
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            if(is_array($result) && count($result))
                return $result;

            return false;
        }
    }

    public function like_query_db($query, $col_data){

        $connect = $this->connect_database();
        $stmt = $connect->prepare($query);

        foreach($col_data as $key => $val){
            $col_data[$key] = "%".$val."%";
        }
        
        $check = $stmt->execute($col_data);

        if($check){
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            if(is_array($result) && count($result))
                return $result;

            return false;
        }
    }
}

