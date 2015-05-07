var express = require('express');
var app = express();
var http = require('http').Server(app);
var io = require('socket.io')(http);

app.use(express.static('public'));

http.listen(8080, function(){
    console.log('listening on *:8080');
});

var screens = {};	// only object can be passed over .emit, not arrays!

io.sockets.on('connection', function (socket) {

	// new screen connected: add to list
	socket.on('new screen', function(screenname){
		screens[socket.id] = screenname;
		console.log("--- connected screens: "+screens.length);
		
		// publish list to all remotes
		console.log(screens);
		io.sockets.emit('refresh screens', screens);
	});
	
	// remove disconnected screens
   socket.on('disconnect', function() {
		//console.log(screens);
		// if it's a screen: remove from list and push list
		if (socket.id in screens) {
			delete(screens[socket.id]);
			console.log("--- connected screens: "+screens.length);
			
			// publish screen list to all remotes
			io.sockets.emit('refresh screens', screens);
		}
		
   });
});

	


