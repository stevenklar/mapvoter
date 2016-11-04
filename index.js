var io = require('socket.io').listen('3000');

io.on('connection', function(socket) {
    socket.on('dismissed', function(data) {
        console.log('dismissed', data);
        console.log('dismissed'.concat(data.match));
        io.sockets.emit('dismissed'.concat(data.match), { map: data.map });
    });
});
