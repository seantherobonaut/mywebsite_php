<?php
/*
check to see if obflush or error handlers can prevent 
notices and warnings from getting to dom

ensure dom never renders if there are exceptions or trigger errrors

test with full website system if errors/warnings can still be caught
during template rendering creation

note: exceptions, errors halt execution of code

ob_end_clean is redundant after errors or exceptions(this might depend on when)
    //this is critical to make sure output still doesn't show
    //if errors happen during template rendering
    ob_start();

todo check to see if errors still show up even if error reporting is off

what if i want nothing showing up? not even "something is wrong please try again later"?

*/

    /*
        Idea for basic routing
        all first page routes go into an array
        the hard coded ones get put in first, then database ones
        but they all are in an array
    */
    
    $GLOBALS['root'] = __DIR__.'/'; 
    $GLOBALS['local'] = $GLOBALS['root'].'app/'; 
    require 'app/init.php';
?>
