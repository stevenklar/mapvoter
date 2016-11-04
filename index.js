var io = require('socket.io').listen('3000');

io.on('connection', function(socket) {
    socket.on('create', function (room) {
        socket.join(room);
        console.log('Join room ' + room);

        socket.in(room).on('dismissed', function() {
            console.log('Dismissed...');
            console.log(this);

            io.to(room).emit('dismissed', data);
        });
    });
});
