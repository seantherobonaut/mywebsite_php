<style type="text/css">
    #compatToggle
    {
        display: none;
        background-color:white;
        position:fixed;
        top:0px;
        right:0px;
        bottom:0px;
        left:0px;
        text-align: center;
        z-index: 99999;
    }
    
    .compatBox
    {
        padding-top:50px;
        position: absolute;
        top:0px;
        right:0px;
        bottom:0px;
        left:0px;
        background-color: white;
    }

    .compatBox > span
    {
        border:1px solid lightgray;
        border-radius: 15px;
        display: inline-block;
        padding:15px;
        font-size:14px;
        font-family:verdana;
    }
</style>

<!--[if lte IE 9]>
    <style type="text/css">
        #compatToggle{display: block;}
        #compatJS{display: none;}
    </style>
<![endif]-->
<noscript>
    <style type="text/css">
        #compatToggle{display: block;}
        #compatBrowser{display: none;}
    </style>
</noscript>

<div id="compatToggle">
    <div class="compatBox">
        <span>
            <u>Your browser is both outdated and has javascript disabled.</u><br>
            *Please enable javascript and try again.<br>
            *Please either update Internet Explorer beyond version 9, or use another browser and try again.
        </span>
    </div>
    <div id="compatBrowser" class="compatBox">
        <span>
            *Please either update Internet Explorer beyond version 9, or use another browser and try again.
        </span>
    </div>
    <div id="compatJS" class="compatBox">
        <span>
            *Please enable javascript and try again.
        </span>
    </div>
</div>
