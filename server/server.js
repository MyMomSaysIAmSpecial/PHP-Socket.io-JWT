/*
 * Using socket.io just as a cross-browser WebSocket, without server and frameworks
 * http://socket.io/docs/#using-it-just-as-a-cross-browser-websocket
 */
const io = require('socket.io')(3010);

/*
 * socketio-jwt module can be used too
 *
 * Same decoded_token object, but middleware will be:
 * io.use(socketioJwt.authorize({
 *    secret: jwtSecret,
 *    handshake: true
 * }));
 */
const jwt = require('jsonwebtoken');

// Any random string
const jwtSecret = '530120e67dd417b5a8bbc324f25f04d4';

// Middleware for incoming sockets
const authHandler = function authHandler(socket) {
    jwt.verify(socket.handshake.query.token, jwtSecret, function (error, decoded) {
        if (!error) {
            socket.decoded_token = decoded;
            console.log(socket.decoded_token);
            return true;
        }

        socket.disconnect(true);
        return true;
    });
};
io.use(authHandler);

io.on('connection', function (socket) {
    console.log(socket.decoded_token.name, 'connected');
});