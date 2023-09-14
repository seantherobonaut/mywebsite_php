<?php
    $app->post("user_register", function($route_data)
    {
        header('Content-Type: application/json; charset=utf-8');

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
                        //TODO button for resend activation email (ONLY if active=false, make a new token each time)
                        
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

                                $link .= '/'.'account_activation'.'/'.$user_id.'/'.$token_str;

                                $msg = "
                                <html>
                                <head>
                                <title>Account Activation</title>
                                </head>
                                <body>
                                <p>
                                Hello $username,<br><br>
                                Please click the link below to activate your account. It expires in 15 minutes.<br><br>
                                <a href='$link'>$link</a>
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
            echo json_encode(array("alert_type" => "info", "alert_msg" => "Missing fields!"));
    });

    $app->get("account_activation", function($route_data)
    {
        header('Content-Type: text/html; charset=utf-8');

        $user = array_shift($route_data);
        $token = array_shift($route_data);

        /*
            look up user by id, pull out token, see if "type of token" matches, see if token matches, compare timestamps of token
        */

        $query = $GLOBALS['db_conn']->getQuery("SELECT * FROM `users` WHERE `user_id`=?;");
        $query->runQuery(array($user));
        
        //Does the user exist?
        if($query->rowCount() > 0)
        {
            $record = $query->fetch();
            $token_array = json_decode($record['token'],true);

            //Is this a register token?
            if($token_array['type']=='register')
            {
                //Does the token provided match the token of the user?
                if($token == $token_array['token'])
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
    
                            echo "Account activation successful!";
                            append_file($GLOBALS['path_app'].'logs/debug.log', date('[Y-n-d G:i:s e]').' - '.'Activation successful!'."\n");
                        }
                        else
                        {
                            echo "Acount is already active...";
                            append_file($GLOBALS['path_app'].'logs/debug.log', date('[Y-n-d G:i:s e]').' - '.'Account is already active'."\n");
                        }
                    }
                    else
                    {
                        echo "Link expired...";
                        append_file($GLOBALS['path_app'].'logs/debug.log', date('[Y-n-d G:i:s e]').' - '.'Token is older than 15 minutes'."\n");
                    }
                }
                else
                {
                    echo "Invalid link!";
                    append_file($GLOBALS['path_app'].'logs/debug.log', date('[Y-n-d G:i:s e]').' - '.'Tokens do not mach!'."\n");
                }
            }  
            else
            {
                echo "Invalid link!";
                append_file($GLOBALS['path_app'].'logs/debug.log', date('[Y-n-d G:i:s e]').' - '.'Incorrect token type!'."\n");
            }
        }
        else
        {
            echo "Invalid link!";
            append_file($GLOBALS['path_app'].'logs/debug.log', date('[Y-n-d G:i:s e]').' - '.'UserID not found!'."\n");
        }

        //error output only "invalid link" or "expired link" store real error in logs
    });
?>
