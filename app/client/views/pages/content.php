<style type="text/css">
    #content p
    {
        border:1px dashed gray;
    }

    p.comments:focus
    {
        outline: none;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col text-center mb-4">
            <h1 class="display-4 m-3">Javascript!</h1> 
            <div id="content" style="max-width: 500px; margin: auto; text-align: left"></div>

            <form id="commentform" method="get" action="/put_content" style="max-width: 500px; margin: auto; text-align: left">
                <!-- <input type="hidden" name="paraID" value="1"> -->
                <input id="commentinput" type="text" name="newpost" placeholder="New comment..." autocomplete="off">
                <input type="submit" value="Submit" style="visibility: hidden;">
            </form>


            <!-- Button to Open the Modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                Open modal
            </button>
            <p style="border:1px solid black" contenteditable="true">Hello</p>

<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">

                <form class="form-inline" style="border: 1px solid green" action="/action_page.php">
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Enter email" id="email">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

                <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
            </div>
        </div>
    </div>
</div>



        </div>
    </div>
</div>

<script type="text/javascript">
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
</script>
