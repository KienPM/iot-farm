var express = require('express');
var app = express();
var server = require('http').createServer(app);
var io = require('socket.io')(server);
var socketioJwt = require('socketio-jwt');
require('dotenv').config({path: '.env'});
// Let express show auth.html to client
app.use(express.static(__dirname + '/static'));
app.get('/', function (req, res, next) {
    res.sendFile(__dirname + '/static/auth.html');
});
// Accept connection and authorize token
io.on('connection', socketioJwt.authorize({
    secret: process.env.JWT_SECRET,
    timeout: 15000
}));
// When authenticated, send back name + email over socket
io.on('authenticated', function (socket) {
    console.log(socket.decoded_token);
    socket.emit('name', socket.decoded_token.name);
    socket.emit('email', socket.decoded_token.email);
});
// Start Node server at port 3000
server.listen(3000);
