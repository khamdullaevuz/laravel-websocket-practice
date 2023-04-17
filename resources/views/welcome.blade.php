<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body class="bg-ligt">
<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <div class="form-group mb-2">
                <label for="message">Message</label>
                <div class="input-group">
                    <input type="text" id="message" class="form-control">
                    <button type="button" class="btn btn-primary" id="send">Send</button>
                </div>
            </div>
            <h5>Messages:</h5>
            <div id="messages"></div>
            <button type="button" class="btn btn-danger" id="clear">Clear</button>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    const socket = new WebSocket('{{ config('services.websocket.host') }}');
    socket.onopen = function() {
        console.log("Соединение установлено.");
    };

    socket.onclose = function(event) {
        if (event.wasClean) {
            console.log('Соединение закрыто чисто');
        } else {
            console.log('Обрыв соединения'); // например, "убит" процесс сервера
        }
        console.log('Код: ' + event.code + ' причина: ' + event.reason);
    };

    socket.onmessage = function(event) {
        const data = JSON.parse(event.data);
        console.log("Получены данные " + data.message);
        $("#messages").append("<p><b>("+ data.resource_id +")</b> " + data.message + "</p>");
    };

    socket.onerror = function(error) {
        console.log("Ошибка " + error.message);
    };
    $("#send").click(function () {
        const message = $("#message").val();
        socket.send(message);
        $("#messages").append("<p><b>(me)</b> " + message + "</p>");
    });
    $("#clear").click(function () {
        $("#messages").html("");
    });
</script>
</body>
</html>
