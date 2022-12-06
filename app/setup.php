<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    // error_reporting(0);
    // ini_set('display_errors', 0);
    // ini_set('display_startup_errors', 0);

    //Utility to load Class/Abstract/Interface files
    require 'lib/DependencyManager/DependencyManagerClass.php';
    $autoLoader = new DependencyManager($GLOBALS['local'].'dependencies.php');
    $autoLoader->setSearchPaths(array($GLOBALS['root'].'lib',$GLOBALS['root'].'public',$GLOBALS['local']));
    $autoLoader->enableLoader(true);

    //Utility to manage unhandled errors/exceptions
    $debug = new Debugger();

    //show all errors to web
    $debug->addHandler(new HandlerWeb(array(E_USER_WARNING)));

    //show all errors except these ones
    //$debug->addHandler(new HandlerWeb(array(E_USER_ERROR,E_WARNING, E_USER_WARNING, E_NOTICE, E_USER_NOTICE, 'exception')));
    
    $debug->addHandler(new HandlerLog($GLOBALS['local'].'logs/debug.log'));
    $debug->handleErrors(true);
    $debug->handleExceptions(true);    
?>
