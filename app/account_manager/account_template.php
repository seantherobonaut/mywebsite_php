<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
            
        <meta name="author" content="Sean Leapley">
        <meta name="description" content="Profile Interface">
        <title>Profile Interface</title>            

        <!-- Bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <style type="text/css">
            html,body{margin:0px;padding:0px;}

            body{background-color:#777;}

            #profile form input{margin-bottom:10px;}

            #profile form input[type=submit]{margin-bottom:0px;}

            #profile form 
            {
                border-bottom:1px solid white;
                padding-bottom:15px;
            }

            #main
            {
                color: white;
                max-width:600px;
            }

            #main > div
            {
                max-width:350px;
                margin:0px auto 110px auto;
            }

            button.nav_button{color:white;}
        </style>
    </head>
    <body>
        <div id="main" class="container mt-4 pt-4 pb-4 bg-dark rounded-circle">
            <div>
                <!-- Sub Template -->
                <?php require "$sub_template.php";?>
            </div>
        </div>
        
        <script type="text/javascript">
            //Modal form controls (toggle forms on/off)
            let authButtons = document.querySelectorAll("#profile button.nav_button");
            let authForms = document.querySelectorAll("#profile form");
            authButtons.forEach(function(element)
            {
                element.addEventListener("click", function()
                {
                    let button = this;
                    let targetID = this.dataset.targetform;
                    
                    //ensure all buttons inactive
                    authButtons.forEach(function(element)
                    {
                        element.classList.remove("active");
                    });
                    //make this button active
                    button.classList.add("active");

                    //ensure hiding and resetting all forms
                    authForms.forEach(function(element)
                    {
                        element.reset();
                        element.style.display = "none";
                    });

                    //clear bootstrap alerts
                    document.getElementById("results").innerHTML = "";
                    
                    //show target form
                    document.getElementById(targetID).style.display = "block";
                });
            });

            //On Submit, block default html submit, collect data, clear form, submit through ajax, return success/error messages
            document.querySelectorAll("#profile form").forEach(function(element)
            {
                element.addEventListener("submit", function(event)
                {
                    event.preventDefault();

                    //Grab method and action
                    let method = element.method;
                    let action = element.action;
                    
                    //Stringify all values into string labeled "data"
                    let inputs = this.querySelectorAll('input:not([type="submit"])');
                    let data = "";
                    
                    //Add query parameters if they are there!
                    let queryString = window.location.search.replace('?', '');
                    if(queryString!="")
                        data += queryString+"&";

                    inputs.forEach(function(item)
                    {
                        data += item.name + "=" + item.value + "&";
                    });
                    if(data != "")
                        data = data.substring(0, data.length-1); //remove trailing &

                    //target result box
                    let resultOutput = document.getElementById("results");
                    //have a little spinner for request delays
                    resultOutput.innerHTML = '<div class="alert alert-secondary m-0 p-3" role="alert">Processing... <img width=15 heigh=15 src="<?php echo $GLOBALS['path_local'];?>images/spinner.gif" /></div>';
                
                    //this runs when we get a response
                    let xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function()
                    {
                        if(this.readyState==4 && this.status==200)
                        {                    
                            let data = JSON.parse(this.responseText);
                            
                            //output a bootstrap alert
                            resultOutput.innerHTML = '<div class="alert alert-'+data.alert_type+' m-0 p-3" role="alert">'+data.alert_msg+'</div>';

                            //if login is successful, redirect to home page
                            if(element.id == "login" && data.alert_type == "success")
                            {
                                setTimeout(function()
                                {
                                    location.reload();
                                }, 1000);
                            }

                            //update username on page if changed
                            if(element.id == "update-username" && data.alert_type == "success")
                                document.getElementById("usrnm").innerText = data.new_username;
                        }
                    };
                    
                    //reset the form instantly
                    this.reset();

                    if(method="get")
                    {
                        xhttp.open(method, action+"?"+data, true);
                        xhttp.send();
                    }
                    if(method="post")
                    {
                        xhttp.open(method, action, true);
                        xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                        xhttp.send(data);
                    }    
                });
            });
        </script>
    </body>
</html>
