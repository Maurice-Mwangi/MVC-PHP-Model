<?php 

class App
{

    private $contoller = "home";
    private $method = 'index';

    private function split_url(){
        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        return $URL;
    }

    public function load_controller(){
    
        $URL = $this->split_url();
    
        $fileName = "../app/controllers/". ucfirst($URL[0]). ".php";
    
        if(file_exists($fileName)){
            require $fileName;
            $this->contoller = ucfirst($URL[0]);
            unset($URL[0]);

        }else{
            require "../app/controllers/No_page.php";
            $this->contoller = "No_page";
        }

        $contoller = new $this->contoller;

        if(!empty($URL[1])){
            if(method_exists($contoller, $URL[1]))
                $this->method = $URL[1];
                unset($URL[1]);
        }
        
        call_user_func_array([$contoller, $this->method], $URL);    
    }
}
