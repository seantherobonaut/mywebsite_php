<div id="profile" class="container p-0">           
    <h1>Change Password</h1> 
    <div id="results" class="container lh-1 p-0" ><!-- Bootstrap alerts go here --></div>
    
    <form id="pass_reset" class="m-1 p-1" method="POST" action="/account/change_password">
        Password: <input class="form-control" type="password" name="password" placeholder="Password...">
        Confirm: <input class="form-control" type="password" name="confirm_pass" placeholder="Confirm Password...">
        <input type="submit" class="btn btn-primary mt-1" value="Submit">
        <a class="nav_button btn btn-outline-secondary mt-1" href="/account" role="button">Sign In</a>
    </form>  
</div>
