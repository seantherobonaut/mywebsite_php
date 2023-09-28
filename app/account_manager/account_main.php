<div class="container-fluid">
    <h1 class="text-center">Profile Interface</h1> 
    <p>Create and manage your profile and account here</p>   
</div>

<div id="profile" class="container p-0">
    <div id="results" class="container lh-1 p-2" ><!-- Bootstrap alerts go here --></div>           

    <form id="login" class="m-1 p-1" method="POST" action="/login">
        Username: <input class="form-control" type="text" name="username" placeholder="Username..." >
        Password: <input class="form-control" type="password" name="password" placeholder="Password...">
        <input type="submit" class="btn btn-primary mt-1" value="Login">
        <button type="button" class="nav_button btn btn-outline-secondary mt-1" data-targetform="forgotPass">Forgot Pass</button>
        <button type="button" class="nav_button btn btn-outline-secondary mt-1" data-targetform="register">Register</button>
    </form>    

    <form id="forgotPass" class="m-1 p-1" method="POST" action="/account/forgot_password" style="display:none">
        Email: <input class="form-control" type="email" name="email" placeholder="Email...">    
        <input type="submit" class="btn btn-primary mt-1" value="Submit">
        <button type="button" class="nav_button btn btn-outline-secondary mt-1" data-targetform="login">Sign In</button>
    </form>                                    

    <form id="register" class="m-1 p-1" method="POST" action="/account/register" style="display:none">
        Email: <input class="form-control" type="email" name="email" placeholder="Email...">
        Username: <input class="form-control" type="text" name="username" placeholder="Username...">
        Password: <input class="form-control" type="password" name="password" placeholder="Password...">
        <input type="submit" class="btn btn-primary mt-1" value="Submit">
        <button type="button" class="nav_button btn btn-outline-secondary mt-1" data-targetform="resend_activation">Resend Activation</button>
        <button type="button" class="nav_button btn btn-outline-secondary mt-1" data-targetform="login">Sign In</button>
    </form>  

    <form id="resend_activation" class="m-1 p-1" method="POST" action="/account/resend_activation" style="display:none">
        Email: <input class="form-control" type="email" name="email" placeholder="Email...">
        <input type="submit" class="btn btn-primary mt-1" value="Submit">
        <button type="button" class="nav_button btn btn-outline-secondary mt-1" data-targetform="login">Sign In</button>
    </form>
</div>
