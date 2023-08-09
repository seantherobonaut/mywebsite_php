<?php
    require 'setup.php';

    $app = new Router();


    $app->get("testing", function($route_data)
    {
        header('Content-Type: text/html; charset=utf-8');

        require $GLOBALS['path_public'].'views/pages/testing.php';
    });

    $app->post("login", function($route_data)
    {
        if(!empty($_POST['username']))
        {
            //this is where the logic for the login system is created
            
            if($_POST['username'] == 'sean')
            {
                echo json_encode(array("alert_type" => "success", "alert_msg" => "Login successful"));
            }
            else
            {
                echo json_encode(array("alert_type" => "warning", "alert_msg" => "User not found."));
            }
        }
        else
        {
            echo json_encode(array("alert_type" => "info", "alert_msg" => "Missing fields."));
        }
    });

    $app->post("newUser", function($route_data)
    {
        echo "not enabled yet";
    });






    //Overwrite the basic 404 route
    $app->get("404", function($route_data)
    {
        header('Content-Type: text/html; charset=utf-8');
        http_response_code(404);

        require $GLOBALS['path_public'].'views/errors/404.php';
    });

    $app->get("page", function($route_data)
    {
        header('Content-Type: text/html; charset=utf-8');

        //Grab page name from path
        $page = array_shift($route_data);

        //Simulate searching a database for objects that match the root path node
        $fakeDB = array('home'=>'home','about'=>'about');

        //If the path cannot be found, return 404
        if(empty($fakeDB[$page]))
        {
            http_response_code(404);
            require $GLOBALS['path_public'].'views/errors/404.php';
        }
        else
        {
            $type = $fakeDB[$page];
            $subtemplate = $GLOBALS['path_public'].'views/pages/'.$type.'.php';        
            require $GLOBALS['path_public'].'views/root_template.php';
        }
    });

    $app->listen();
?>
