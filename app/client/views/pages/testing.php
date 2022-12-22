<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
            
        <meta name="author" content="Sean Leapley">
        <meta name="description" content="Testing page">
        <title>Testing!</title>            

        <!-- tBootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

        <style type="text/css">
            body{margin:0px;}

            body
            {
                background-color:#777;
            }

            #mybox
            {
                
            }
        </style>
    </head>
    <body>

    
        <div id="mybox" class="container my-5 px-5 py-5 bg-dark text-white rounded-circle" style="max-width:700px;">
            <h1>Serious Attempt Bootstrap Page</h1>
            <p>This container has a dark background and uses special rounded corners that change shape with its size.</p>

            <button id="special" type="button" class="btn btn-primary">I am a button!</button>
            
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                Login
            </button>
            
            <ul id="mylist" class="list-group my-3">
              <li class="list-group-item">First item</li>              
            </ul>
            
        </div>

  

        <!-- The Modal -->
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Login:</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                        
<form action="/action_page.php">
    <div class="mb-3 mt-3">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
    </div>
    <div class="mb-3">
        <label for="pwd">Password:</label>
        <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd">
    </div>
    <div class="form-check mb-3">
        <label class="form-check-label">
        <input class="form-check-input" type="checkbox" name="remember"> Remember me</label>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
                        
<!--                         <form class="form-inline" action="/">
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Enter email" id="email">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form> -->

                        
                    </div>
                
                    
                </div>
            </div>
        </div>        



        
        <script type="text/javascript">

            //url
            //type
            //data
            //datatype

            let mybutton = document.getElementById('special');
            let mylist = document.getElementById('mylist');    

            //it's good practice to create one xhttp object, send the request, and dispose of it, (asychronous stuffs)
            //basically, with only one xhttp object, you are forcing sychronous behavior, the other request can't start until the other one ends
            let counter = 1;
            mybutton.addEventListener("click", function()
            {                
                let xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function()
                {
                    if(this.readyState==4 && this.status==200)
                    {                    
                        // let data = JSON.parse(this.responseText);
                        let data = this.responseText;
                        
                        let newItem = document.createElement('li');
                        newItem.className = 'list-group-item';
                        newItem.innerHTML = data;
                        mylist.appendChild(newItem);
                    }
                    else
                    {
                        if(this.readyState==4 && this.readyState==404)
                            console.log("Well, that didn't work...");
                    }
                        
                };
                xhttp.open("GET", "/ajax_test?comment=click_number_"+counter++, true);
                xhttp.send();
            });

            
            // let mybutton = document.getElementById('special');
            // let mylist = document.getElementById('mylist');    

            // mybutton.addEventListener("click", function()
            // {
            //     let newItem = document.createElement('li');
            //     newItem.className = 'list-group-item';
            //     newItem.innerHTML = "frogs!";
            //     mylist.appendChild(newItem);
            // });


            // //post example ( $_POST['fname'] etc...)
            // xhttp.open("POST", "ajax_test.asp");
            // xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            // xhttp.send("fname=Henry&lname=Ford");


            


// xhttp.open("POST","your_url.php",true);

// xhttp.setRequestHeader("Content-type","application/json; charset=UTF-8") ; //to send json
// xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

// xhttp.send("name="+name + "&" + "email="+email);

        </script>
        
        
    </body>
</html>

<!-- <style type="text/css">
    #content p
    {
        border:1px dashed gray;
    }

    p.comments:focus
    {
        outline: none;
    }
</style> -->

<!-- <div class="container">
    <div class="row">
        <div class="col text-center mb-4">
            <h1 class="display-4 m-3">Javascript!</h1> 
            <div id="content" style="max-width: 500px; margin: auto; text-align: left"></div>

            <form id="commentform" method="get" action="/put_content" style="max-width: 500px; margin: auto; text-align: left"> -->
                <!-- <input type="hidden" name="paraID" value="1"> -->
<!--                 <input id="commentinput" type="text" name="newpost" placeholder="New comment..." autocomplete="off">
                <input type="submit" value="Submit" style="visibility: hidden;">
            </form> -->

            <!-- Button to Open the Modal -->
<!--             <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                Open modal
            </button>
            <p style="border:1px solid black" contenteditable="true">Hello</p> -->

            <!-- The Modal -->
<!--             <div class="modal fade" id="myModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content"> -->
                        <!-- Modal body -->
<!--                         <div class="modal-body">
            
                            <form class="form-inline" style="border: 1px solid green" action="/action_page.php">
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Enter email" id="email">
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form> -->
            
                            <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
<!--                         </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div> -->

<!-- <script type="text/javascript">
    let target = document.getElementById("content");

    function deleteItem(data)
    {
        let id = data.id.split("_")[1];

        data.setAttribute("contenteditable", true);

        // let xhttp = new XMLHttpRequest();
        // xhttp.onreadystatechange = function()
        // {
        //     if(this.readyState==4 && this.status==200)
        //     {
        //         let data = JSON.parse(this.responseText);
        //         if(data[0])
        //             updateContent();
        //     }
        // };

        // xhttp.open("GET", "/delete_content?comment_id="+id, true); //this works if you erase the javascript
        // xhttp.send();        
    }

    function updateContent()
    {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if(this.readyState==4 && this.status==200)
            {
                target.innerHTML = "";
                let data = JSON.parse(this.responseText);
                for(let i=0; i<data.length; i++)
                {
                    let newNode = document.createElement("p");
                    newNode.innerText = data[i].content;
                    newNode.id = "para_"+data[i].id;
                    newNode.className = "comments";
                    newNode.addEventListener("click", function(){deleteItem(this);});
                    target.appendChild(newNode);
                }
            }
        };
        xhttp.open("GET", "/get_content", true);
        xhttp.send();
    }

    updateContent();

    document.getElementById("commentform").addEventListener("submit", function(event)
    {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if(this.readyState==4 && this.status==200)
            {
                let data = JSON.parse(this.responseText);
                if(data[0])
                    updateContent();
            }
        };

        event.preventDefault();
        let myInput = document.getElementById("commentinput");
        let content = "";

        content = myInput.value;
        this.reset(); 

        xhttp.open("GET", "/put_content?comment="+content, true); //this works if you erase the javascript
        xhttp.send();
    });

    /*
        how does php spit back errors on the server? 
        .. maybe something about when error 400, the ajax won't echo anything on the client side? 
        also jQuery success: or failure: might have to do with response code conditions... try more of that

        
            xhttp.open("POST", "/newComment", true); //this works if you erase the javascript
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("comment="+content);
    */
</script> -->
