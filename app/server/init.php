<?php
    require 'setup.php';

    $app = new Router();

    $app->get("testing", function($route_data)
    {
        header('Content-Type: text/html; charset=utf-8');

        require $GLOBALS['path_app'].'client/views/pages/testing.php';
    });

    $app->get("ajax_test", function($route_data)
    {
        // header('Content-Type: application/json; charset=utf-8');
        if(isset($_GET["comment"]))
            echo $_GET["comment"]."!";
        else            
            http_response_code(404);
    });







    //Overwrite the basic 404 route
    $app->get("404", function($route_data)
    {
        header('Content-Type: text/html; charset=utf-8');
        http_response_code(404);

        require $GLOBALS['path_app'].'client/views/errors/404.php';
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
            require $GLOBALS['path_app'].'client/views/errors/404.php';
        }
        else
        {
            $type = $fakeDB[$page];
            $subtemplate = $GLOBALS['path_app'].'client/views/pages/'.$type.'.php';        
            require $GLOBALS['path_app'].'client/views/root_template.php';
        }
    });

    $app->listen();
?>
