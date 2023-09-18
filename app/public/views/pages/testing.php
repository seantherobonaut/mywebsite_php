<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=0device-width, initial-scale=1">
            
        <meta name="author" content="Sean Leapley">
        <meta name="description" content="Testing page">
        <title>Testing!</title>            

        <!-- Bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <style type="text/css">
            html,body{margin:0px;padding:0px;}

            body{background-color:#777;}

            #profile form input
            {
                margin-bottom:10px;
            }

            #profile form input[type=submit]
            {
                margin-bottom:0px;
            }
        </style>
    </head>
    <body>



        <div id="mybox" class="container my-5 px-5 py-5 bg-dark text-white rounded-circle" style="max-width:700px;">
            <h1>Test Bootstrap Page</h1> 
            <p>This container has a dark background and uses special rounded corners that change shape with its size.</p>    

            <!-- Profile Button -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#profile">
                Profile   
            </button>

        </div>

        <!-- TODO resend activation, have banner at top always showing something -->
  
        <!-- Profile Prompt -->
        <div id="profile" class="modal fade mt-5">
            <div class="modal-dialog">
                <div class="modal-content">
                    
                    <div class="modal-header">
                        <div id="results" class="container lh-1 p-0" ><!-- Bootstrap alerts go here --></div>
                        <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
                    </div>
        
                    <div class="modal-body p-0">
                        <div class="container-fluid p-0">
                            <div class="row m-0">
                                <div class="col-sm-3 p-0 ps-2 py-3">                    
                                    <div id="profilebuttons" class="btn-group-vertical">
                                        <button type="button" class="btn btn-outline-dark active" data-targetform="login">Sign In</button>
                                        <button type="button" class="btn btn-outline-dark" data-targetform="forgotPass">Forgot Pass</button>
                                        <button type="button" class="btn btn-outline-dark" data-targetform="register">Register</button>                            
                                    </div>                                    
                                </div>
                                <div class="col-sm-9 p-1">
                                    <form id="login" class="modal-body m-1 p-1" method="POST" action="/login">
                                        Username: <input class="form-control" type="text" name="username" placeholder="Username..." >
                                        Password: <input class="form-control" type="password" name="password" placeholder="Password...">
                                        <input type="submit" class="btn btn-primary mt-1" value="Login">
                                    </form>    
                    
                                    <form id="forgotPass" class="modal-body m-1 p-1" method="POST" action="/forgotPass" style="display:none">
                                        Email: <input class="form-control" type="email" name="email" placeholder="Email...">
                                        <input type="submit" class="btn btn-primary mt-1" value="Submit">
                                    </form>                                    
                    
                                    <form id="register" class="modal-body m-1 p-1" method="POST" action="/user_register" style="display:none">
                                        Email: <input class="form-control" type="email" name="email" placeholder="Email...">
                                        Username: <input class="form-control" type="text" name="username" placeholder="Username...">
                                        Password: <input class="form-control" type="password" name="password" placeholder="Password...">
                                        <input type="submit" class="btn btn-primary mt-1" value="Submit">
                                        <button id="resend_activation_btn" type="button" class="btn btn-outline-dark mt-1">Resend Activation</button>
                                    </form>  

                                    <form id="resend_activation" class="modal-body m-1 p-1" method="POST" action="/resend_activation" style="display:none">
                                        Email: <input class="form-control" type="email" name="email" placeholder="Email...">
                                        <input type="submit" class="btn btn-primary mt-1" value="Submit">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>        

        
        <script type="text/javascript">

            //Button to show the resend activation form
            document.getElementById("resend_activation_btn").addEventListener("click", function()
            {
                //reset and hide register form
                let register = document.getElementById("register");
                register.reset();
                register.style.display = "none";

                //clear alerts
                document.getElementById("results").innerHTML = "";
                    
                //show resend form
                document.getElementById("resend_activation").style.display = "block";
            });

            //Modal form controls (toggle forms on/off)
            let authButtons = document.querySelectorAll("#profilebuttons button");
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

                    //clear the alerts
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
                    inputs.forEach(function(item)
                    {
                        data += item.name + "=" + item.value + "&";
                    });
                    if(data != "")
                        data = data.substring(0, data.length-1); //remove trailing &

                    //target result box
                    let resultOutput = document.getElementById("results");
                
                    //this runs when we get a response
                    let xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function()
                    {
                        if(this.readyState==4 && this.status==200)
                        {                    
                            let data = JSON.parse(this.responseText);
                            
                            resultOutput.innerHTML = '<div class="alert alert-'+data.alert_type+' m-0 p-3" role="alert">'+data.alert_msg+'</div>';
                        }
                    };
                    
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
