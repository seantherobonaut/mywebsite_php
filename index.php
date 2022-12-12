<?php
    /*
        TODO throw gitstart.sh into project code, organize project code (new branch, orgnize)

        Idea for basic routing
        all first page routes go into an array
        the hard coded ones get put in first, then database ones
        but they all are in an array

        timestamp class
        fileSearch
        
        TODO touch up readme
        
        admin:
        make a sql query dialog box
        use echo shell_exec('ls -a | xargs'.' 2>&1'); ...to run commands, return output
        TODO TRY proc_open, put commands in sh file, run sh file and see what happens? grab output?
                
        can main merge with a feature branch without a comit just to update it?
    */

    $GLOBALS['path_root'] = __DIR__.'/'; 
    $GLOBALS['path_app'] = $GLOBALS['path_root'].'app/'; 
    $GLOBALS['path_lib'] = $GLOBALS['path_root'].'lib/';

    require $GLOBALS['path_app'].'server/init.php';    
?>
