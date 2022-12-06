<?php
    //Return: content type, output, http status code

    function basic_page($route)
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
            require 'public/views/errors/404.php';
        }
        else
        {
            $type = $fakeDB[$page];
            $subtemplate = 'public/views/pages/'.$type.'.php';        
            require 'public/views/root_template.php';
        }
    }

    $app->get("root", function($route){basic_page(array('home'));});
    $app->get("page", function($route){basic_page($route);});
?>
