<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=0device-width, initial-scale=1">
            
        <meta name="author" content="Sean Leapley">
        <meta name="description" content="Testing page">
        <title>Password Reset</title>            

        <!-- Bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <style type="text/css">
            html,body{margin:0px;padding:0px;}

            body{background-color:#777;}

            form input
            {
                margin-bottom:10px;
            }

            form input[type=submit]
            {
                margin-bottom:0px;
            }
        </style>
    </head>
    <body>

        <div id="mybox" class="container my-5 px-5 py-5 bg-dark text-white rounded-circle" style="max-width:700px;">
            <h1>Password Reset:</h1> 
            <div id="results" class="container lh-1 p-0" ><!-- Bootstrap alerts go here --></div>
            
            <form id="pass_reset" class="m-1 p-1" method="POST" action="/change_password">
                Password: <input class="form-control" type="password" name="password" placeholder="Password...">
                Confirm: <input class="form-control" type="password" name="confirm_pass" placeholder="Confirm Password...">
                <input type="hidden" name="user_id" value="<?php echo $user;?>">
                <input type="hidden" name="token_str" value="<?php echo $token;?>">
                <input type="submit" class="btn btn-primary mt-1" value="Submit">
            </form>  
        </div>

        <script type="text/javascript">

            //On Submit, block default html submit, collect data, clear form, submit through ajax, return success/error messages
            document.getElementById("pass_reset").addEventListener("submit", function(event)
            {
                event.preventDefault();

                //Grab method and action
                let element = this;
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

                xhttp.open(method, action, true);
                xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xhttp.send(data);
            });
        </script>
    </body>
</html>
