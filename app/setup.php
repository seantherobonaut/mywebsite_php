<?php
    //Halt program if paths aren't setup
    if(!isset($GLOBALS['path_root']) || !isset($GLOBALS['path_lib']) || !isset($GLOBALS['path_app']) || !isset($GLOBALS['path_public']) || !isset($GLOBALS['path_local']))
        exit('Path setup incorrect.<br>');

    require $GLOBALS['path_lib'].'utils.php';

    //Utility to manage unhandled errors/exceptions
    require $GLOBALS['path_lib'].'DebuggerClass.php';
    $debug = new Debugger(); 
    $debug->addHandler(function($error_data)
    {
        if($error_data['type']=='E_ERROR' || $error_data['type']=='E_USER_ERROR' || $error_data['type']=='EXCEPTION')
            echo 'An internal error has occurred. Please try again later.<br>';
            
        append_file($GLOBALS['path_app'].'logs/debug.log', date('[Y-n-d G:i:s e]').' - '.$error_data['type'].' '.$error_data['msg'].' -> '.$error_data['file'].'@line:'.$error_data['line']."\n");
    });
    $debug->enable(true);

    //Utility to load Class/Abstract/Interface files
    require $GLOBALS['path_lib'].'DependencyManagerClass.php';
    $loader = new DependencyManager($GLOBALS['path_app'].'dependency_list.php');;
    $loader->addSearchPath($GLOBALS['path_app']);
    $loader->addSearchPath($GLOBALS['path_lib']);
    $loader->enable(true);

    //Database connection setup
    require $GLOBALS['path_app'].'db_creds_admin.php';   
    $GLOBALS['db_conn'] = new DBconn;
    $GLOBALS['db_conn']->addHandler(function($error)
    {
        append_file($GLOBALS['path_app'].'logs/database.log', date('[Y-n-d G:i:s e]').' - '.$error."\n");
    });
    $GLOBALS['db_conn']->connect($db_creds['host'], $db_creds['dbname'], $db_creds['username'], $db_creds['password']);
?>
