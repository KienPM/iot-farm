<!doctype html>
<html lang="en">

<head>
    <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.4/socket.io.js"></script>
</head>

<body>

    <h1>DEVICE</h1>
    <h1>Connection Status: <span id="connection"></span></h1>
    <h1>Login name: <span id="name"></span></h1>
    <h1>Device id: <span id="id"></span></h1>
    <h1>Store id: <span id="store-id"></span></h1>

    <div class="form">
        <input id="identify" placeholder="Identify" />
        <input id="password" value="12344321" placeholder="Password" />
        <button id="login">Login</button>
    </div>

    <input id="device-state-update" />
    <button id="change-state">Change state</button>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#login").on('click', function () {
                connectionUpdate('Requesting JWT Token from Laravel');
                var form = new FormData();
                var identify = $("#identify").val();
                var password = $("#password").val();
                form.append("identify_code", identify);
                form.append("password", password);

                var settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": "{!! env('APP_URL') !!}/device/session/login",
                    "method": "POST",
                    "headers": {
                        "x-csrf-token": "FThhPWO4wBfcq5PsXFDId1HpDrA6nEmE4zGk4iae",
                        "cache-control": "no-cache",
                        "postman-token": "88c06dac-f068-d45f-337c-4c7d4e820676"
                    },
                    "processData": false,
                    "contentType": false,
                    "mimeType": "multipart/form-data",
                    "dataType": "json",
                    "data": form
                }

                $.ajax(settings).done(function (response) {
                    console.log(response);
                })
                    .fail(function (jqXHR, textStatus, errorThrown) {
                        connectionUpdate('Could not retrieve token: ' + textStatus);
                    })
                    .done(function (result, textStatus, jqXHR) {
                        if (result.status == 'not_login') {
                            console.log('Not login');
                            return false;
                        }

                        connectionUpdate('Got token: ' + result.data.auth_token + ', connect to SocketIO');

                        var device_id;

                        var socket = io.connect('{!! env('APP_URL') !!}:3000');
                        socket.on('connect', function () {
                            connectionUpdate('Connected to SocketIO, Authenticating')
                            socket.emit('authenticate', { token: result.data.auth_token });
                            //console.log("Token nè: "+ result.data.auth_token );
                        });

                        socket.on('authenticated', function () {
                            connectionUpdate('Authenticated');
                        });

                        socket.on('unauthorized', function (data) {
                            connectionUpdate('Unauthorized, error: ' + data.message);
                        });

                        socket.on('disconnect', function () {
                            connectionUpdate('Disconnected');
                        });

                        socket.on('info', function (data) {
                            $('#name').html(data.name);
                            $('#id').html(data.id);
                            $('#store-id').html(data.store_id);
                            device_id = data.id;
                            socket.on('change_device_' + device_id + '_state', function (data) {
                                $("#device-state-update").val(data);
                            });
                        });

                        $("#change-state").on("click", function () {
                            var data = $("#device-state-update").val();
                            socket.emit("device_state", { device_id: device_id, data: data })
                        })
                    });
            });
        });

        function connectionUpdate(str) {
            $('#connection').html(str);
            console.log(str);
        }
    </script>
</body>

</html>
