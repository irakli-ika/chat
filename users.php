<?php
    $user_id = $_GET['user'];
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>

    <div>
        <button data-id="8" onclick="startConversation(this.dataset.id)">irakli 8</button>
        <button data-id="7" onclick="startConversation(this.dataset.id)">join 7</button>
        <button data-id="9" onclick="startConversation(this.dataset.id)">mariami 9</button>
    </div>

    <script type="text/javascript">
        const user_id = <?=$user_id?>;
        const startConversation = (receiver_id) => {
                const data = new FormData();
                data.append('user_id', user_id);
                data.append('receiver_id', receiver_id);
                
                const request = new XMLHttpRequest();
                request.open('POST', 'api/start_conversation.php');
                
                request.onload = function(){
                    let result = JSON.parse(request.responseText);
                    if (result.status == 'created') {
                        // window.history.replaceState(null, null, "http://localhost/real_chat/?user=8");
                        window.location.href = `http://localhost/real_chat/?user=8&conversation=${result.receiver}`;
                    }
                }
                
                request.send(data);
        }
    </script>

    </body>
</html>