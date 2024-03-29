<?php
    $app->get("/", function()
    {
        header('Content-Type: text/html; charset=utf-8');

        $page = 'home';
        $type = 'home';
        $subtemplate = $GLOBALS['path_public'].'views/pages/'.$type.'.php';        
        require $GLOBALS['path_public'].'views/root_template.php';
    });
    
    $app->get("/page", function($route_data)
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
?>
