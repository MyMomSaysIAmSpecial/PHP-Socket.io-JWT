<?php
    session_start();
    require 'vendor/autoload.php';

    $key = '530120e67dd417b5a8bbc324f25f04d4';

    /*
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE0Nzk4OTkzMjMsImV4cCI6MTQ3OTg5OTYyM30.n97XhPDtRU6R17MqxzQK8QD01jLTnKXt6gX9hEHurDY';

        try {
            $decode = \Firebase\JWT\JWT::decode($token, $key, ['HS256']);
            var_dump($decode);
        } catch(\Exception $e) {
            var_dump($e->getMessage());
        }
    */

//    session_unset();
    if (empty($_SESSION['token'])) {
        $data = [
            'iat' => time(),
            'name' => 'Roman',
            'project' => 'autoplius'
        ];

        $_SESSION['token'] = \Firebase\JWT\JWT::encode($data, $key);
    }

    echo $_SESSION['token'];
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