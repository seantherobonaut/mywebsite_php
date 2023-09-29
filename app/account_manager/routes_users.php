<?php
    /* TODO

        work on the logged in prompts
    */

    $app->get("/account", function($route_data)
    {
        header('Content-Type: text/html; charset=utf-8');
       
        $sub_template = "account_main";
        $page = array_shift($route_data);
        
        if($page == "activation")
            $sub_template = "account_activation";
        
        if($page == "change_password")
            $sub_template = "account_change_pass";
        
        require $GLOBALS['path_app'].'account_manager/account_template.php';
    });

    //Activate account if token from emailed link is valid
    $app->post("/account/activation", function($route_data)
    {
        header('Content-Type: application/json; charset=utf-8');

        //required variables
        if(!empty($_POST['user_id']) && !empty($_POST['token_str']))
        {
            $query = $GLOBALS['db_conn']->getQuery("SELECT * FROM `users` WHERE `user_id`=?;");
            $query->runQuery(array($_POST['user_id']));
            
            //Does the user exist?
            if($query->rowCount() > 0)
            {
                $record = $query->fetch();
                $token_array = json_decode($record['token'],true);

                //Does a token exist?
                if(!empty($token_array))
                {
                    //Is this a register token?
                    if($token_array['type']=='register')
                    {
                        //Does the token provided match the token of the user?
                        if($_POST['token_str'] == $token_array['token'])
                        {
                            $token_time = $token_array['date'];
                            $current_time = time();
        
                            //Did the click the link in less than 15 minutes?
                            if(($current_time-$token_time)<=900)
                            {
                                if($record['active'] == false)
                                {
                                    //update the user's account status
                                    $query = $GLOBALS['db_conn']->getQuery("UPDATE `users` SET `active`=? WHERE `user_id`= ?;");
                                    $query->runQuery(array(true, $record['user_id']));
        
                                    //Send user confirmation email that their account has been activated on purpose
                                    $email_addr = $record['email'];
                                    $username = $record['username'];
                                    $website = $_SERVER['SERVER_NAME'];
                                    $headers = array(
                                        "From" => "Test System <no-reply@email.com>",  
                                        "X-Sender" => "Test System <no-reply@email.com>",
                                        "X-Mailer" => "PHP/".phpversion(),
                                        "Reply-To" => "Test System <no-reply@email.com>",
                                        "Return-Path" => "Test System <no-reply@email.com>", 
                                        "X-Priority" => "1",
                                        "MIME-Version" => "1.0",
                                        "Content-Type" => "text/html; charset=UTF-8"
                                    );
                                    $msg = "
                                    <html>
                                    <head>
                                    <title>Successful Account Activation</title>
                                    </head>
                                    <body>
                                    <p>
                                    Hello $username,<br><br>
                                    Thank you for activating your account for $website!<br><br>
                                    </p>
                                    </body>
                                    </html>
                                    ";
                                    $to = $email_addr;
                                    $subject = "Successful activation for $website";
                
                                    mail($to, $subject, $msg, $headers);
        
                                    echo json_encode(array("alert_type" => "success", "alert_msg" => 'Activation successful!'."\n"));
        
                                    //clear the token
                                    $query = $GLOBALS['db_conn']->getQuery("UPDATE `users` SET `token`=? WHERE `user_id`= ?;");
                                    $query->runQuery(array("{}", $record['user_id']));
                                }
                                else
                                    echo json_encode(array("alert_type" => "info", "alert_msg" => 'Account already active!'."\n"));
                            }
                            else                      
                                echo json_encode(array("alert_type" => "info", "alert_msg" => 'Expired token!'."\n"));
                        }
                        else                
                            echo json_encode(array("alert_type" => "info", "alert_msg" => 'Token mismatch!'."\n"));
                    }  
                    else            
                        echo json_encode(array("alert_type" => "info", "alert_msg" => 'Wrong token type!'."\n"));
                }
                else
                    echo json_encode(array("alert_type" => "info", "alert_msg" => 'Token has already been used or was never created'."\n"));
            }
            else          
                echo json_encode(array("alert_type" => "info", "alert_msg" => 'User not found!'."\n"));
        }
        else
            echo json_encode(array("alert_type" => "warning", "alert_msg" => 'Missing arguments!'."\n"));
    });    

    //Create new user from data 
    $app->post("/account/register", function($route_data)
    {
        header('Content-Type: application/json; charset=utf-8');

        //required variables
        if(!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']))
        {
            //ensure username and email are valid
            if(ctype_alnum($_POST['username']))
            {
                if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
                {
                    //check if username is already taken
                    $query = $GLOBALS['db_conn']->getQuery("SELECT * FROM `users` WHERE `username`=?;");
                    $query->runQuery(array($_POST['username']));
                    if($query->rowCount() == 0)
                    {   
                        //check if email is already taken
                        $query = $GLOBALS['db_conn']->getQuery("SELECT * FROM `users` WHERE `email`=?;");
                        $query->runQuery(array($_POST['email']));
                        if($query->rowCount() == 0)
                        {
                            //token for account activation
                            $token_str = bin2hex(random_bytes(20));
                            $token = json_encode(array("type" => "register", "date" => time(), "token" => $token_str));

                            //create new user record in database
                            $query = $GLOBALS['db_conn']->getQuery("INSERT INTO `users` (`username`, `password`, `email`, `token`) VALUES (?,?,?,?);");
                            $query->runQuery(array($_POST['username'], password_hash($_POST['password'], PASSWORD_DEFAULT), $_POST['email'], $token));

                            //get a copy of the newly created record by email
                            $query = $GLOBALS['db_conn']->getQuery("SELECT * FROM `users` WHERE `email`=?;");
                            $query->runQuery(array($_POST['email']));

                            //Send activation email if account creation is successful
                            if($query->rowCount()>0)
                            {
                                $record = $query->fetch();

                                $headers = array(
                                    "From" => "Test System <no-reply@email.com>",  
                                    "X-Sender" => "Test System <no-reply@email.com>",
                                    "X-Mailer" => "PHP/".phpversion(),
                                    "Reply-To" => "Test System <no-reply@email.com>",
                                    "Return-Path" => "Test System <no-reply@email.com>", 
                                    "X-Priority" => "1",
                                    "MIME-Version" => "1.0",
                                    "Content-Type" => "text/html; charset=UTF-8"
                                );

                                $user_id = $record['user_id'];
                                $email_addr = $record['email'];
                                $username = $record['username'];
                                $website = $_SERVER['SERVER_NAME'];

                                $link = $_SERVER['SERVER_NAME'];
                                if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                                    $link = 'https://'.$link;
                                else
                                    $link = 'http://'.$link;

                                $link .= '/'.'account/activation'.'?user_id='.$user_id.'&token_str='.$token_str;

                                $msg = "
                                <html>
                                <head>
                                <title>Account Activation</title>
                                </head>
                                <body>
                                <p>
                                Hello $username,<br><br>
                                Please click the link below to activate your account. It expires in 15 minutes.<br><br>
                                <a href='$link' target='_blank'>$link</a>
                                </p>
                                </body>
                                </html>
                                ";

                                $to = $email_addr;
                                $subject = "Account activation for $website";

                                mail($to, $subject, $msg, $headers);

                                echo json_encode(array("alert_type" => "success", "alert_msg" => "Account created! Check email for activation link."));
                            }
                            else
                                echo json_encode(array("alert_type" => "danger", "alert_msg" => "Something went wrong serverside, try again later."));
                        }
                        else
                            echo json_encode(array("alert_type" => "info", "alert_msg" => "That email is already being used"));
                    }
                    else
                        echo json_encode(array("alert_type" => "info", "alert_msg" => "That username is already taken"));
                }
                else
                    echo json_encode(array("alert_type" => "warning", "alert_msg" => "Incorrect email format!"));
            }
            else
                echo json_encode(array("alert_type" => "warning", "alert_msg" => "Username must be alphanumeric!"));
        }
        else
            echo json_encode(array("alert_type" => "warning", "alert_msg" => "Missing fields!"));
    });

    //Resend activation email if user exists, and isn't activated
    $app->post("/account/resend_activation", function($route_data)
    {
        header('Content-Type: application/json; charset=utf-8');

        //required variables
        if(!empty($_POST['email']))
        {
            $email = $_POST['email'];

            $query = $GLOBALS['db_conn']->getQuery("SELECT * FROM `users` WHERE `email`=?;");
            $query->runQuery(array($email));

            //Does the user exist?
            if($query->rowCount()>0)
            {
                $result = $query->fetch();
                //Is the user's account active?
                if(!$result['active'])
                {
                    $user_id = $result['user_id'];
                    $email_addr = $result['email'];
                    $username = $result['username'];
                    $website = $_SERVER['SERVER_NAME'];

                    $new_token_str = bin2hex(random_bytes(20));
                    $new_token = json_encode(array("type" => "register", "date" => time(), "token" => $new_token_str));

                    //Update user's token in DB
                    $query = $GLOBALS['db_conn']->getQuery("UPDATE `users` SET `token`=? WHERE `user_id`= ?;");
                    $query->runQuery(array($new_token, $user_id));

                    $headers = array(
                        "From" => "Test System <no-reply@email.com>",  
                        "X-Sender" => "Test System <no-reply@email.com>",
                        "X-Mailer" => "PHP/".phpversion(),
                        "Reply-To" => "Test System <no-reply@email.com>",
                        "Return-Path" => "Test System <no-reply@email.com>", 
                        "X-Priority" => "1",
                        "MIME-Version" => "1.0",
                        "Content-Type" => "text/html; charset=UTF-8"
                    );

                    $link = $_SERVER['SERVER_NAME'];
                    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                        $link = 'https://'.$link;
                    else
                        $link = 'http://'.$link;

                    $link .= '/'.'account/activation'.'?user_id='.$user_id.'&token_str='.$new_token_str;

                    $msg = "
                    <html>
                    <head>
                    <title>Account Activation</title>
                    </head>
                    <body>
                    <p>
                    Hello $username,<br><br>
                    Please click the link below to activate your account. It expires in 15 minutes.<br><br>
                    <a href='$link' target='_blank'>$link</a>
                    </p>
                    </body>
                    </html>
                    ";

                    $to = $email_addr;
                    $subject = "Resend account activation for $website";

                    mail($to, $subject, $msg, $headers);

                    echo json_encode(array("alert_type" => "success", "alert_msg" => "Activation email resent!"));
                }
                else
                    echo json_encode(array("alert_type" => "info", "alert_msg" => "That account is already active..."));
            }
            else
                echo json_encode(array("alert_type" => "info", "alert_msg" => "Email not found."));
        }
        else
            echo json_encode(array("alert_type" => "warning", "alert_msg" => "Missing fields!"));
    });

    $app->post("/account/forgot_password", function($route_data)
    {
        header('Content-Type: application/json; charset=utf-8');

        //required variables
        if(!empty($_POST['email']))
        {
            $query = $GLOBALS['db_conn']->getQuery("SELECT * FROM `users` WHERE `email`=?;");
            $query->runQuery(array($_POST['email']));

            //Does a user with that email exist?
            if($query->rowCount()>0)
            {
                $result = $query->fetch();

                $user_id = $result['user_id'];
                $email_addr = $result['email'];
                $username = $result['username'];
                $website = $_SERVER['SERVER_NAME'];

                $token_str = bin2hex(random_bytes(20));
                $token = json_encode(array("type" => "forgot_password", "date" => time(), "token" => $token_str));

                //Set user's token in DB
                $query = $GLOBALS['db_conn']->getQuery("UPDATE `users` SET `token`=? WHERE `user_id`= ?;");
                $query->runQuery(array($token, $user_id));

                $headers = array(
                    "From" => "Test System <no-reply@email.com>",  
                    "X-Sender" => "Test System <no-reply@email.com>",
                    "X-Mailer" => "PHP/".phpversion(),
                    "Reply-To" => "Test System <no-reply@email.com>",
                    "Return-Path" => "Test System <no-reply@email.com>", 
                    "X-Priority" => "1",
                    "MIME-Version" => "1.0",
                    "Content-Type" => "text/html; charset=UTF-8"
                );

                $link = $_SERVER['SERVER_NAME'];
                if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                    $link = 'https://'.$link;
                else
                    $link = 'http://'.$link;
                $link .= '/'.'account/change_password'.'?user_id='.$user_id.'&token_str='.$token_str;

                $msg = "
                <html>
                <head>
                <title>Password Reset</title>
                </head>
                <body>
                <p>
                Hello $username,<br><br>
                Please click the link below to reset your password. It expires in 15 minutes.<br><br>
                <a href='$link' target='_blank'>$link</a>
                </p>
                </body>
                </html>
                ";

                $to = $email_addr;
                $subject = "Password reset for $website";

                mail($to, $subject, $msg, $headers);

                echo json_encode(array("alert_type" => "success", "alert_msg" => "Password reset email sent!"));
            }
            else
                echo json_encode(array("alert_type" => "info", "alert_msg" => "Email not found."));
        }
        else
            echo json_encode(array("alert_type" => "warning", "alert_msg" => "Missing fields!"));
    });

    $app->post("/account/change_password", function($route_data)
    {
        header('Content-Type: application/json; charset=utf-8');

        //required variables
        if(!empty($_POST['password'] && !empty($_POST['confirm_pass'])))
        {
            if(!empty($_POST['user_id']) && !empty($_POST['token_str']))
            {
                $query = $GLOBALS['db_conn']->getQuery("SELECT * FROM `users` WHERE `user_id`=?;");
                $query->runQuery(array($_POST['user_id']));
    
                //check if the user exists
                if($query->rowCount() > 0)
                {
                    $record = $query->fetch();
                    $token_array = json_decode($record['token'],true);

                    //Does a token exist?
                    if(!empty($token_array))
                    {
                        //Is this a forgot password token?
                        if($token_array['type']=='forgot_password')
                        {
                            //Does the token provided match the token of the user?
                            if($_POST['token_str'] == $token_array['token'])
                            {
                                $token_time = $token_array['date'];
                                $current_time = time();
        
                                //Did the click the link in less than 15 minutes?
                                if(($current_time-$token_time)<=900)
                                {
                                    $password = trim($_POST['password']);
                                    $confirmpass = trim($_POST['confirm_pass']);
                                    
                                    //Do both passwords match? 
                                    if($password == $confirmpass)
                                    {
                                        //Old password can't be new password
                                        if(!password_verify($password, $record['password']))
                                        {
                                            $query = $GLOBALS['db_conn']->getQuery("UPDATE `users` SET `password`=? WHERE `user_id`= ?;");
                                            $query->runQuery(array(password_hash($_POST['password'], PASSWORD_DEFAULT), $_POST['user_id']));
        
                                            echo json_encode(array("alert_type" => "success", "alert_msg" => "Password updated!"));
    
                                            //clear the token
                                            $query = $GLOBALS['db_conn']->getQuery("UPDATE `users` SET `token`=? WHERE `user_id`= ?;");
                                            $query->runQuery(array("{}", $_POST['user_id']));
                                        }
                                        else
                                            echo json_encode(array("alert_type" => "info", "alert_msg" => "New password can't be old password!"));
                                    }
                                    else
                                        echo json_encode(array("alert_type" => "info", "alert_msg" => "Passwords do not match!"));
                                }
                                else
                                    echo json_encode(array("alert_type" => "info", "alert_msg" => "Link expired!"));
                            }
                            else
                                echo json_encode(array("alert_type" => "info", "alert_msg" => "Tokens do not match!"));
                        }
                        else
                            echo json_encode(array("alert_type" => "info", "alert_msg" => "Wrong token type!"));
                    }
                    else
                        echo json_encode(array("alert_type" => "info", "alert_msg" => "Token has already been used or was never created"));
                }
                else
                    echo json_encode(array("alert_type" => "info", "alert_msg" => "User doesn't exist!"));
            }
            else
                echo json_encode(array("alert_type" => "warning", "alert_msg" => "Missing arguments!"));
        }
        else
            echo json_encode(array("alert_type" => "warning", "alert_msg" => "Missing fields!"));
    });

    $app->post("/login", function($route_data)
    {
        header('Content-Type: application/json; charset=utf-8');

        //required variables
        if(!empty($_POST['username'] && !empty($_POST['password'])))
        {
            $query = $GLOBALS['db_conn']->getQuery("SELECT * FROM `users` WHERE `username`=?;");
            $query->runQuery(array($_POST['username']));

            //User exists
            if($query->rowCount() > 0)
            {
                $record = $query->fetch();

                //Check if password matches hash in database
                if(password_verify($_POST['password'], $record['password']))
                {
                    echo json_encode(array("alert_type" => "success", "alert_msg" => "Success!"));
                    if(session_status() !== PHP_SESSION_ACTIVE) session_start();
                    $_SESSION['user_id'] = $record['user_id'];
                    $_SESSION['username'] = $record['username'];
                    $_SESSION['rank'] = $record['rank'];
                }
                else
                    echo json_encode(array("alert_type" => "danger", "alert_msg" => "Password incorrect!"));
            }
            else
                echo json_encode(array("alert_type" => "info", "alert_msg" => "User doesn't exist!"));
        }
        else
            echo json_encode(array("alert_type" => "warning", "alert_msg" => "Missing fields!"));
    });

    $app->get("/logout", function($route_data)
    {
        session_start();
        session_destroy();
        echo '<html><body>You have been logged out. <a href="/">Back to home</a><script type="text/javascript">window.location.href = "/";</script></body></html>';
    });
?>
