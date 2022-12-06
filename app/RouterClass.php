<?php
    /* IDEAS
        new idea: simpel routing, split url string into array items, each child page has id, only extra tags are passed to next container (ever shirinking $route array)

        try pushing an array to GET that has a path and callback instead of $route so you can loop through and find th first preg match
            another rule is if that function returns nothing, path routing is passed to the next hander

         push each new path to an array so it is executed as first in first out, and specific paths overwrite regex paths
            each path must handle its own 404 or not found errors, if no paths match then there are default 404 errors

        let's say you make a perfect path router, how is data passed to the functions? it depends on the route, just pass $route for now
            especially because a relative path with multiple variables needs specifics and should have its own matching logic
            super globals like post or get can be handled per router

        step1: make everything as a push rather than just set
        setp2: test this with ordering and looping in listen
        step3: implement regex matching 

        everything is either a match, or 404
    */

    //Basic path router
    class Router
    {
        private $routes = array();

        public function __construct()
        {
            //Set default 404 for GET
            $this->routes['GET']['404'] = function()
            {
                http_response_code(404);
                echo "Error 404: File not found";
            };

            //Set default 404 for POST
            $this->routes['POST']['404'] = function()
            {
                http_response_code(404);
                echo "Error 404: File not found";
            };            
        }
        
        //Add paths with a callback to GET
        public function get($route, $callback)
        {
            $this->routes['GET'][$route] = $callback;
        }
        
        //Add paths with a callback to POST
        public function post($route, $callback)
        {
            $this->routes['POST'][$route] = $callback;
        }        

        //Call an anonymous function matching request_uri and request_method from $routes
        public function listen()
        {
            $method = $_SERVER['REQUEST_METHOD'];

            //Strip away the query string
            
            $query = (isset($_SERVER['QUERY_STRING'])) ? '?'.$_SERVER['QUERY_STRING'] : '';
            $uri = $_SERVER['REQUEST_URI'];
                
            $route = strtolower(str_replace($query,'',$uri));
            if(strlen($route)>1)
            {
                //Erase 1st forward slash from path
                if($route[0]=="/")
                    $route = substr($route,1,strlen($route)-1);
                //Convert path to an array
                $route = explode("/", $route);
            }
            else
                $route = array('root');

            //Get the first node off of route
            $node = array_shift($route);

            if(isset($this->routes[$method][$node]))
                $this->routes[$method][$node]($route);
            else 
                $this->routes[$method]['404']($route);
        }
    }
?>
