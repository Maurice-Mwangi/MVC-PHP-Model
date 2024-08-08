<?php

check_extensions();

function check_extensions(){
    $required_extensions = [
        'curl', 'fileinfo', 'gettext', 'mbstring', 'exif',
        'mysqli', 'pdo_mysql', 'pdo_sqlite'
    ];

    $not_loaded_ext = [];

    foreach ($required_extensions as $ext){
        if(!extension_loaded($ext)){
            $not_loaded_ext[] = $ext;
        }
    }

    if(!empty($not_loaded_ext)){
        show("please load the following extensions in your php.ini file: <br>" . implode(", - ", $not_loaded_ext));
        die;
    }
}

function redirect($path){
    header("location: " . ROOT . $path);
    die;
}


function show($param){
    echo "<pre>";
    print_r($param);
    echo "<pre>";
}


function get_image(mixed $file = '', string $type = 'post'): string
{
    $file = $file ?? '';
    if(file_exists($file))
        return ROOT.$file;

    if($type == 'user')     #get if session was set...
        return ROOT;
    else
        return ROOT;
}




function get_pagination_vars():array
{
    $vars = [];
    $vars['page']       = $_GET['page'] ?? 1;
    $vars['page']       = (int)$vars['page'];
    $vars['prev_page']  = $vars['page'] <= 1 ? 1 : $vars['page'] - 1;
    $vars['next_page']  = $vars['page'] + 1;

    return $vars;

}



// function message(string $msg = null, bool $clear = false)
// {
//     $ses = new Core\Session();

//     if(!empty($msg)){
//         $ses ->set('message', $msg);
//     }else
//     if(!empty($ses->get('message'))){
//         $msg = $ses->get('message');
//         if($clear){
//             $ses->pop('message');
//         }
//         return $msg;
//     }
//     return false;
// }



function old_text(string $key, mixed $default = "", string $mode = 'post'):mixed
{
    $POST = ($mode == 'post') ? $_POST : $_GET;
    if(isset($POST[$key]))
        return $POST[$key];

    return $default;
}


function old_select(string $key, mixed $value, mixed $default = "", string $mode = 'post'):mixed
{
    $POST = ($mode == 'post') ? $_POST : $_GET;
    if(isset($POST[$key]))
    {
        if($POST[$key] == $value){
            return " selected ";
        }
    }else if($default == $value){
        return ' selected ';
    }

    return null;
}


function old_check_multiple(string $key, mixed $value, mixed $default = ""):mixed
{
    if(isset($POST[$key]))
    {
        if(in_array($value, $POST[$key]))
            return ' checked';

        show($POST[$key]);
    }
}


function old_check(string $key, string $value, string $default = ""):mixed
{

    if(isset($_POST[$key]))
    {
        if($_POST[$key] == $value){
            return ' checked ';
        }
    }else{
        if($_SERVER['REQUEST_METHOD'] == 'GET' && $default == $value){
            return ' checked ';
        }
    }

    return null;
}


function get_user_read_date($date)
{
    return date("jS M, Y", strtotime($date));
}


function URL($key): mixed
{
    $URL = $_GET['url'] ?? 'home';
    $URL = explode("/", trim($URL, "/"));
    
    switch($key){
        case 'page':
        case 0:
            return $URL[0] ?? null;
            break;

        case 'section':
        case 'slug':
        case 1:
            return $URL[1] ?? null;
            break;

        case 'action':
        case 2:
            return $URL[2] ?? null;
            break;

        case 'id':
        case 3:
            return $URL[3] ?? null;
            break;
        
        default:
            return null;
            break;
    }
}