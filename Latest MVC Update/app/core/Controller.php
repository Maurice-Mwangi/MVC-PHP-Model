<?php

trait Controller {

    public function view($f_name, $data = [])
    {

        if(!empty($data))
            extract($data);

        
        $fileName = "../app/views/". ucfirst($f_name). ".view.php";
    
        if(file_exists($fileName)){
            require $fileName;
        }else{
            require "../app/views/No_page.view.php";
        }

    }
}