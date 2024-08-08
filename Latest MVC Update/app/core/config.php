<?php

if($_SERVER['SERVER_NAME'] == "localhost"){
    define("ROOT", "http://localhost/MVC/public/");
    define("DB_NAME", "brown_m_db");
    define("DB_HOST", "127.0.0.1:3308");
    define("DB_USER", "root");
    define("DB_PASS", "");
    define("DEBUG", true);

}else{
    define("ROOT", "");
    define("DB_NAME", "");
    define("DB_HOST", "");
    define("DB_USER", "");
    define("DB_PASS", "");
    define("DEBUG", false);
    
}

define('APP_NAME', 'BROWN M.');
define('APP_DESC', "Brown M. Properties Website");
