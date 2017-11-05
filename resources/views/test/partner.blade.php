<!doctype html>
<html lang="en">

<head>
    <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.4/socket.io.js"></script>
</head>

<body>

    <h1>PARTNER</h1>
    <h1>Connection Status: <span id="connection">Ready</span></h1>
    <h1>Login name: <span id="name"></span></h1>
    <h1>Login email: <span id="email"></span></h1>
    <h1>Partner id: <span id="id"></span></h1>
    <button id="get-status">Get status</button>

    <div class="form">
        <input id="email_login" value="hoanghoi1310@gmail.com" placeholder="Email" />
        <input id="password_login" value="12344321" placeholder="Password" />
        <button id="login">Login</button>
    </div>

    <h3>AVAILABLE DEVICES</h3>
    <ul id="device-list">
        <!-- <li>
            <span class="device-name"></span>
            <span class="device-id"></span>
            <input id="device-state-update" />
            <button id="change-device-state">Change device state</button>
        </li> -->
    </ul>

    <script type="text/javascript">
        $(document).ready(function () {

            function connectSocket(result) {
                if (result.status == 'not_login') {
                    console.log('Not login');
                    return false;
                }
                // console.log(response);

                connectionUpdate('Got token: ' + result.data.auth_token + ', connect to SocketIO');
                //connect tới cổng 3000
                var socket = io.connect('{!! env('APP_URL') !!}:3000');
                socket.on('connect', function () {
                    connectionUpdate('Connected to SocketIO, Authenticating')
                    socket.emit('authenticate', { token: result.data.auth_token });
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
                    $('#email').html(data.email);
                    $('#id').html(data.id);
                });
                //lắng nghe sự kiện từ device và update lên thanh input
                socket.on('device_1_state', function (data) {
                    $("#device-state-update").val(data);
                });
                //lắng nghe sự kiện device_list
                socket.on('device_list', function (data) {
                    console.log("Đây là data");
                    //data trả về là 1 mảng Json, mỗi Json có dạng {device_id: id, store_id: id}
                    //khi bấm nút change device state thì emit sự kiện "change_device_state" để gửi data xuống device
                    // định dạng gửi xuống {device_id, data} trong đó data được qui định như file mềm.
                    console.log(data);
                    data.map(function (device, index) {
                        var device_id = device.device_id;
                        var deviceInfo = `<li class="device_${device_id}">
                            <span class="device-id">${device_id}</span>
                            <input class="device-state-update" />
                            <button class="change-device-state">Change device state</button>

                        </li>`;
                        $("#device-list").append(deviceInfo);
                        socket.on(`device_${device_id}_state`, function (data) {
                            $(`.device_${device_id} .device-state-update`).val(data);
                        });
                    })

                    $(".change-device-state").on("click", function () {
                        var device_id = $(this).siblings('.device-id').text();
                        var data = $(this).siblings('.device-state-update').val();
                        socket.emit("change_device_state", { device_id, data })
                    })

                    $("get-status").on("click", function() {
                        var device_id = $(this).siblings('.device-id').text();
                        socket.emit("get_status", {device_id});
                    });
                })
            }


            $.ajax({
                "async": true,
                "crossDomain": true,
                "url": "{!! env('APP_URL') !!}/partner/session",
                "method": "GET",
                "processData": false,
                "contentType": false,
                "mimeType": "multipart/form-data",
                "dataType": "json",
            }).done(function (response) {
                // console.log(response);
                connectSocket(response);
            }).fail(function (jqXHR, textStatus, errorThrown) {
                connectionUpdate('not login' + textStatus);
            })

            $("#login").on('click', function () {
                connectionUpdate('Requesting JWT Token from Laravel');
                var form = new FormData();
                var email = $("#email_login").val();
                var password = $("#password_login").val();
                form.append("email", email);
                form.append("password", password);

                var settings = {
                    "async": true,
                    "crossDomain": true,
                    //url để đăng nhập cho partner
                    "url": "{!! env('APP_URL') !!}/partner/session/login",
                    "method": "POST",
                    "headers": {
                        "cache-control": "no-cache"
                    },
                    "processData": false,
                    "contentType": false,
                    "mimeType": "multipart/form-data",
                    "dataType": "json",
                    "data": form
                }

                $.ajax(settings).done(function (response) {
                        connectSocket(response);
                    })
                    .fail(function (jqXHR, textStatus, errorThrown) {
                        connectionUpdate('Could not retrieve token: ' + textStatus);
                    })
            });

        });

        function connectionUpdate(str) {
            $('#connection').html(str);
            console.log(str);
        }
    </script>
</body>

</html>
