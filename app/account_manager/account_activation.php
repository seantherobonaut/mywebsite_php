<div id="profile" class="container p-0">             
    <h1>Account Activation</h1> 
    <div id="results" class="container lh-1 p-0" ><!-- Bootstrap alerts go here --></div>
    <a class="nav_button btn btn-outline-secondary mt-2" href="/" role="button">Home</a>
    <a class="nav_button btn btn-primary mt-2" href="/account" role="button">Sign In</a>
</div>
<script type="text/javascript">
    //automatically send post request once the page loads

    //query parameters
    let data = window.location.search.replace('?', '');

    //target result box
    let resultOutput = document.getElementById("results");

    //have a little spinner for request delays
    resultOutput.innerHTML = '<div class="alert alert-secondary m-0 p-3" role="alert">Processing... <img width=15 heigh=15 src="https://i.gifer.com/ZZ5H.gif" /></div>';

    //this runs when we get a response
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if(this.readyState==4 && this.status==200)
        {                    
            let data = JSON.parse(this.responseText);
            
            //output a bootstrap alert
            resultOutput.innerHTML = '<div class="alert alert-'+data.alert_type+' m-0 p-3" role="alert">'+data.alert_msg+'</div>';
        }
    };

    xhttp.open("post", "/account/activation", true);
    xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhttp.send(data);
</script>
