<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
            
        <meta name="author" content="Sean Leapley">
        <meta name="description" content="My personal website">
        <title><?php echo ucfirst($page);?></title>            
        <link rel="shortcut icon" href="<?php echo $GLOBALS['path_local'];?>images/awesome_face.ico">

        <!-- Bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Font for icons -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- Style for layout -->
        <link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['path_local'];?>css/layout.css"> 
    </head>
    <body class="d-flex flex-column align-items-stretch">
        <?php require $GLOBALS['path_public'].'views/frontEndCompat.php';?>
            
        <!-- Header -->
        <div id="header" class="jumbotron text-center border p-4 flex-shrink-0">
            <div id="bannerBG" style="background-image:url(<?php echo $GLOBALS['path_local'];?>images/bridge3.jpg)"></div>
            <img src="<?php echo $GLOBALS['path_local'];?>images/me2.jpg" class="rounded-circle img-thumbnail img-fluid" width="250" height="250" alt="Sean Leapley">
            <h3>
                <small class="fst-italic fw-normal">"Imagination is more important than knowledge."</small>
                <p class="blockquote-footer small fw-normal" style="font-size:70%;margin-top:10px">Albert Einstein</p>
            </h3>
        </div>
        
        <!-- Navbar -->
        <nav class="navbar navbar-expand-sm navbar-dark flex-shrink-0" style="background-color:#263238">            
            <div class="container-fluid p-0 justify-content-end" style="max-width: 1140px">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-center" id="collapsibleNavbar">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link <?php if($page=='home')echo 'active';?>" href="/">Home</a></li>
                        <li class="nav-item"><a class="nav-link <?php if($page=='about')echo 'active';?>" href="/page/about">About Me</a></li>   
                        <li class="nav-item"><a class="nav-link" href="<?php echo $GLOBALS['path_local'];?>Resume.pdf">Resume</a></li>   
                    </ul>
                </div>  
            </div>
        </nav> 

        <!-- Content -->
        <div class="flex-grow-1">
            <?php require $subtemplate;?>                                     
        </div>

        <!-- Footer -->        
        <footer class="page-footer pt-4 text-center flex-shrink-0" style="background-color:#263238">            
            <div class="container-fluid d-flex justify-content-around p-0" style="max-width: 350px">                
                <a class="btn-floating rounded-circle shadow fa fa-github" href="https://github.com/seantherobonaut/" alt="Github" title="Github"></a>
                <a class="btn-floating rounded-circle shadow fa fa-facebook" href="https://www.facebook.com/sean.leapley" alt="Facebook" title="Facebook"></a>
                <a class="btn-floating rounded-circle shadow fa fa-instagram" href="https://www.instagram.com/seantherobonaut/" alt="Instagram" title="Instagram"></a>
            </div>
            <a href="mailto:seantherobonaut@gmail.com" class="nav-link text-center text-light my-2">seantherobonaut@gmail.com</a>
            <div class="text-center py-3 text-secondary" style="background-color:#1E282D">
                <small class="text-nowrap">© 2011-<?php echo date('Y');?> seanleapley.com.</small>
                <small class="text-nowrap"> All Rights Reserved.</small>
            </div>
        </footer>
    </body>
</html>
