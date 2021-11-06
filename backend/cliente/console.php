<?php

include_once ("../conexao.php");

if(isset($_GET["delete"]))
{
    $query = mysqli_query($con, "DELETE FROM console");
    var_dump($query);
    echo "oiioioi";
    die();
}

if(isset($_GET["mostrar"]))
{
    $query = mysqli_query($con, "SELECT * FROM console");
    while($exibe = mysqli_fetch_object($query))
    {
        echo "<textarea rows='1' style='height:1em;' id='text'>$exibe->cod|".base64_decode($exibe->log)."</textarea><br>";
    }
    die();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>textarea {
    border: 0 none white;
    overflow: hidden;
    padding: 0;
    outline: none;
    background-color: #D0D0D0;
}</style>
</head>
<body>
    
    <button id="delete">Excluir tudo</button><input type="checkbox" id="pause">Pause
    <div id="itens">
        espere os itens serem carregados...
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(()=>{

        $("#delete").click(()=>{
            $.ajax({
                url: "console.php",
                data: "delete="
            });
        });
        
        setInterval(() => {
            if(!$("#pause")[0].checked)
            {
                $.ajax({
                    url: "console.php",
                    data: "mostrar",
                    success: (data)=>{
                        $("#itens").html(data);
                        init();
                    }
                });
            }
        }, 300);
    });

    var observe;
if (window.attachEvent) {
    observe = function (element, event, handler) {
        element.attachEvent('on'+event, handler);
    };
}
else {
    observe = function (element, event, handler) {
        element.addEventListener(event, handler, false);
    };
}
function init () {
    $("textarea").each((i, text)=>{

        function resize () {
            text.style.width = `${$(window).width()}px`
            text.style.height = 'auto';
            text.style.height = text.scrollHeight+'px';
        }
        /* 0-timeout to get the already changed text */
        function delayedResize () {
            window.setTimeout(resize, 0);
        }
        observe(text, 'change',  resize);
        observe(text, 'cut',     delayedResize);
        observe(text, 'paste',   delayedResize);
        observe(text, 'drop',    delayedResize);
        observe(text, 'keydown', delayedResize);

        text.focus();
        text.select();
        resize();
    })
}
</script>
</body>
</html>