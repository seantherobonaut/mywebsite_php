<?php
    require 'setup.php';

    $app = new Router();

    require 'path_pages.php';

    $app->get("test", function()
    {
        echo phpversion();
        echo '<br>';
        echo $_SERVER['REMOTE_ADDR'];
    });

    //Overwrite the basic 404 route
    $app->get("404", function($route)
    {
        header('Content-Type: text/html; charset=utf-8');
        http_response_code(404);

        require $GLOBALS['path_app'].'client/views/errors/404.php';
    });

    $app->get("page", function($route)
    {
        header('Content-Type: text/html; charset=utf-8');

        //Grab page name from path
        $page = array_shift($route);

        //Simulate searching a database for objects that match the root path node
        $fakeDB = array('home'=>'home','about'=>'about','test'=>'content');

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
