<?php
    $app->get("get_content", function($route)
    {
        header('Content-Type: application/json; charset=utf-8');

        // $data = array_shift($route);
        // http_response_code(404);

        //Open DB connection
        $conn = new DBconn;
        $conn->addLogger(new DBLogger($GLOBALS['local'].'logs/database.log'));
        $conn->connect('localhost', 'website', 'root', '');

        //Grab data
        $query = $conn->getQuery("SELECT * FROM `text`;");
        $query->runQuery();
        $result = $query->fetchAll();

        $data = json_encode($result);
        echo $data;
    });

    $app->get("put_content", function($route)
    {
        header('Content-Type: application/json; charset=utf-8');

        //echo true/false
        if(!empty($_GET['comment']))
        {
            $value = $_GET['comment'];

            //Open DB connection
            $conn = new DBconn;
            $conn->addLogger(new DBLogger($GLOBALS['local'].'logs/database.log'));
            $conn->connect('localhost', 'website', 'root', '');

            //Grab data
            $query = $conn->getQuery("INSERT INTO `text` (content) VALUES (?);");
            $query->runQuery(array($value));

            //TODO return a value from sql to indicate success

            echo json_encode(array(true));
        }
        else
            echo json_encode(array(false));
    });

    $app->get("delete_content", function($route)
    {
        header('Content-Type: application/json; charset=utf-8');

        //echo true/false
        if(!empty($_GET['comment_id']))
        {
            $value = $_GET['comment_id'];

            //Open DB connection
            $conn = new DBconn;
            $conn->addLogger(new DBLogger($GLOBALS['local'].'logs/database.log'));
            $conn->connect('localhost', 'website', 'root', '');

            //Grab data
            $query = $conn->getQuery("DELETE FROM `text` WHERE id=?;");
            $query->runQuery(array($value));

            //TODO return a value from sql to indicate success

            echo json_encode(array(true));
        }
        else
            echo json_encode(array(false));
    });

    $app->get("edit_content", function()
    {
        header('Content-Type: application/json; charset=utf-8');

        //echo true/false
        if(!empty($_GET['comment_id']) && !empty($_GET['comment_text']))
        {
            $id = $_GET['comment_id'];
            $text = $_GET['comment_text'];

            //Open DB connection
            $conn = new DBconn;
            $conn->addLogger(new DBLogger($GLOBALS['local'].'logs/database.log'));
            $conn->connect('localhost', 'website', 'root', '');

            //Grab data
            $query = $conn->getQuery("UPDATE `text` SET content=? WHERE id=?;");
            $query->runQuery(array($text, $id));

            //TODO return a value from sql to indicate success

            echo json_encode(array(true));
        }
        else
            echo json_encode(array(false)); 
    });
?>
