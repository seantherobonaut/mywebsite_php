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

        require 'public/views/errors/404.php';
    });

    $app->listen();
?>
