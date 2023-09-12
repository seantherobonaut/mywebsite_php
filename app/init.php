<?php
    require 'setup.php';

    $app = new Router();

    $app->get("test", function()
    {
        header('Content-Type: text/html; charset=utf-8');

        echo 'testing!';      
    });

    $app->get("testing", function($route_data)
    {
        header('Content-Type: text/html; charset=utf-8');

        require $GLOBALS['path_public'].'views/pages/testing.php';
    });

    //Overwrite the basic 404 route
    $app->get("404", function($route_data)
    {
        header('Content-Type: text/html; charset=utf-8');
        http_response_code(404);

        require $GLOBALS['path_public'].'views/errors/404.php';
    });

    //Add all routes below
    require $GLOBALS['path_app'].'account_manager/routes_users.php';
    require $GLOBALS['path_app'].'public/routes_pages.php';

    $app->listen();
?>
