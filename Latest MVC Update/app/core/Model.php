<?php

trait Model {

    use Database;

    protected $limit = 50; 
    protected $offset = 0;
    protected $order = "DESC";
    public $errors = [];

    public function every_row()
    {
        #gets every row from the table
        $query = "SELECT * FROM $this->table ORDER BY $this->order_column $this->order";
        $results = $this->query_db($query);

        return $results;
    }

    public function where_row($data, $data_not = [])
    {

        
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);

        $str = "SELECT * FROM $this->table WHERE ";

        foreach($keys as $key)
            $str .= $key . " = :". $key . " || ";

        foreach($keys_not as $key_not)
            $str .= $key_not . " != :". $key_not . " || ";

        $str = trim($str, " || ");
        
        $query = $str . " LIMIT $this->offset, $this->limit";

        $data = array_merge($data, $data_not);
        $result = $this->query_db($query, $data);
        if($result)
            return $result;

        return false;

    }

    
    public function where_like_row($data, $data_not = [])
    {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);

        $str = "SELECT * FROM $this->table WHERE ";

        foreach($keys as $key){
            $str .= $key . " LIKE :" . $key . " || ";
        }

        foreach($keys_not as $key_not)
            $str .= $key_not . " NOT LIKE :". $key_not . " || ";

        $str = trim($str, " || ");
        
        $query = $str . ";";

        $data = array_merge($data, $data_not);
        $result = $this->like_query_db($query, $data);
        if($result)
            return $result;
        
        return false;
    }


    public function where_first_row($data, $data_not = [])
    {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);

        $str = "SELECT * FROM $this->table WHERE ";

        foreach($keys as $key)
            $str .= $key . " = :". $key . " && ";

        foreach($keys_not as $key_not)
            $str .= $key_not . " != :". $key_not . " && ";

        $str = trim($str, " && ");
        
        $query = $str . " LIMIT $this->offset, $this->limit";

        $data = array_merge($data, $data_not);
        $result = $this->query_db($query, $data);
        if($result)
            return $result[0];
        
        return false;
    }

    public function insert_row($data)
    {
        if(!empty($this->allowedColumns)){
            foreach($data as $key => $val){
                if(!in_array($key, $this->allowedColumns))
                    unset($data[$key]);
            }
        }
        
        $keys = array_keys($data);
        $query = "INSERT INTO $this->table (". implode(", ", $keys).") VALUES (:". implode(", :", $keys).")";
        $this->query_db($query, $data);

        return false;
    }


    public function update_row($id, $data, $id_column = 'id')
    {

        if(!empty($this->allowedColumns)){
            foreach($data as $key => $val){
                if(!in_array($key, $this->allowedColumns))
                    unset($data[$key]);
            }
        }

        $keys = array_keys($data);

        $str = "UPDATE $this->table SET ";

        foreach($keys as $key)
            $str .= $key . " = :". $key . ", ";

        $str = trim($str, ", ");

        $query  = $str . " WHERE $id_column = :$id_column";

        $data[$id_column] = $id;
        
        $this->query_db($query, $data);

        return false;
    }


    public function delete_row($id, $id_column = 'id')
    {
        $data[$id_column] = $id;
        $query = "DELETE FROM $this->table WHERE $id_column = :$id_column";

        $this->query_db($query, $data);

        return false;
    }
}