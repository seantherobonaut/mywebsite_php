<div class="container-fluid">
    <div class="text-center">
        <a class="btn btn-primary mb-3" href="/" role="button">Home</a>
        <a class="btn btn-primary mb-3" href="/logout" role="button">Logout</a>
    </div>
    <h3 class="text-center">
    <?php
        if(!empty($_SESSION['user_data']))
            echo 'Welcome back <span id="usrnm">'.ucfirst($_SESSION['user_data']['username']).'</span>!';
        else
            echo "Login issue, try again...";
    ?>
    </h3>  
    <p class="text-center">What would you like to do today?</p> 
</div>

<div id="profile" class="container p-0">
    <div id="results" class="container lh-1 px-2" ><!-- Bootstrap alerts go here --></div>           

    <form id="update-username" class="m-1 px-1" method="POST" action="/account/update/username" style="display:none">
        Username: <input class="form-control" type="text" name="new_username" placeholder="Username...">
        <input type="submit" class="btn btn-primary mt-1" value="Submit">
    </form>
    
    <form id="update-password" class="m-1 px-1" method="POST" action="/account/update/password" style="display:none">
        New Password: <input class="form-control" type="password" name="password" placeholder="Password...">
        Confirm Pass: <input class="form-control" type="password" name="confirm_pass" placeholder="Confirm Password...">
        <input type="submit" class="btn btn-primary mt-1" value="Submit">
     </form>
     
    <form id="update-email" class="m-1 px-1" method="POST" action="/account/update/email" style="display:none">
        New Email: <input class="form-control" type="email" name="new_email" placeholder="New Email...">
        <input type="submit" class="btn btn-primary mt-1" value="Submit">
    </form>

    <form id="delete-account" class="m-1 px-1 text-center" method="POST" action="/account/delete/request" style="display:none">
        <h5><b><i>Are you sure?</i></b></h5>
        <input type="submit" class="btn btn-danger mt-1" value="Start Deletion">
    </form>

    <div class="text-center">
        <button type="button" class="btn-sm nav_button btn btn-outline-info mt-1" data-targetform="update-username">Edit Username</button>
        <button type="button" class="btn-sm nav_button btn btn-outline-info mt-1" data-targetform="update-password">Edit Password</button>
        <button type="button" class="btn-sm nav_button btn btn-outline-info mt-1" data-targetform="update-email">Edit Email</button>
        <br>
        <button type="button" style="border-width:3px" class="nav_button btn btn-outline-danger mt-1 fw-bold" data-targetform="delete-account">Delete Account</button>
    </div>

</div>
