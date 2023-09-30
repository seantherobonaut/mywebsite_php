<div class="container-fluid mt-3">
    <h3 class="text-center">Confirm New Email</h3>   
</div>
<div id="profile" class="container p-0">             
    <div id="results" class="container lh-1 px-2" ><!-- Bootstrap alerts go here --></div>
    
    <!-- try opening with # or something with target=_blank.. follow guidelines and find a way -->
    <div class="m-1 p-1">
        <button class="btn btn-secondary" type="button" onclick="window.close()">Close Tab</button>
    </div>
</div>

<script type="text/javascript">    
    //Automatically send post request once the page loads

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

    xhttp.open("post", "/account/change_email", true);
    xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhttp.send(data);
</script>
