<?php
    session_start();
    require 'vendor/autoload.php';

    $key = '530120e67dd417b5a8bbc324f25f04d4';


    if (empty($_SESSION['token'])) {
        $data = [
            'iat' => time(),
            'name' => 'Roman'
        ];

        $_SESSION['token'] = \Firebase\JWT\JWT::encode($data, $key);
    }
?>

<script src="//cdn.socket.io/socket.io-1.4.5.js"></script>
<script>
    const requestUri = 'http://192.168.33.33:3010/';
    const requestToken = '<?=$_SESSION['token'];?>';

    (function () {
        const connectionHandler = function connectionHandler(token) {
            const socket = io.connect(
                    requestUri,
                    {
                        reconnection: false,
                        query: 'token=' + token
                    }
            );

            setInterval(function () {
                socket.emit('message', {});
            }, 1000);
        };

        connectionHandler(requestToken);
    })();
</script>