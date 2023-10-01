<div class="container-fluid mt-3">
    <h3 class="text-center">Change Password</h3>   
</div>
<div id="profile" class="container p-0">           
    <div id="results" class="container lh-1 px-2" ><!-- Bootstrap alerts go here --></div>
    
    <form id="pass_reset" class="m-1 p-1" method="POST" action="/account/password/change">
        Password: <input class="form-control" type="password" name="password" placeholder="Password...">
        Confirm: <input class="form-control" type="password" name="confirm_pass" placeholder="Confirm Password...">
        <input type="submit" class="btn btn-primary mt-1" value="Submit">
        <button class="btn btn-secondary mt-1" type="button" onclick="window.close()">Close Tab</button>
    </form>
</div>
