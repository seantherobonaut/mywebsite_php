<?php
    require 'setup.php';
    $app = new Router;

    //Return: content type, output, http status code

    //TODO start branching instead of always committing to master
    //TODO allow each route to PARTIALLY decide how it handles bugs

    /*
        AJAX front end: edit/delete has a popup, with a dialog box that at the end has an X or Check mark

        a few different tables with various columns
    
        query calls a join of the data map, and type of data
        the columns of that data type are concatinated into 1 cell
        result set is a union of common columns (id, type, data{a,b,c,...}(string))
    */

    require 'path_ajax.php';
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
