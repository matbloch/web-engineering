var express = require('express');
var app = express();
var http = require('http').Server(app);
var io = require('socket.io')(http);

app.use(express.static('public'));

http.listen(8081, function(){
    console.log('listening on *:8081');
});

var screens = {};	// screen socket to screen name mapping
var connections = {};	// sreen socket to remote socket mapping
var remote_status = {}; // remote socket to selected image mapping

/*
Events:
"refresh screens", value: list of screen sockets with corresponding names, target: all sockets - called when number of screens change
"show image", value: image id, target: specific screen - called when connected remote changes image
"select image", value: image id, target: specific remote - called when remote changes image
"toggle remote binding", value: screen socket id, target: specific remote - called to bind screen to remote
*/

io.sockets.on('connection', function (socket) {

    // new screen connected: add to list
    socket.on('init screen', function (screenName) {
        screens[socket.id] = screenName;

        // publish list to all remotes
        io.sockets.emit('refresh screens', screens);
    });

    // handle socket disconnections
    socket.on('disconnect', function () {

        // disconnect screen
        if (socket.id in screens) {

            // clear screen listing
            delete (screens[socket.id]);

            // break active connection
            if (socket.id in connections) {
                delete (connections(socket.id));
            }

            // TODO: send unbind message to target remote
            //var screenSocketID = Object.keys(connections).filter(function (key) { return connections[key] === socket.id })[0];
            //if (screenSocketID.length > 0) {
            //   io.sockets.socket(connections[socket.id]).emit('toggle remote binding', screenSocketID);
            //}
            io.sockets.socket(connections[socket.id]).emit('toggle remote binding', socket.id);

            // update remotes
            io.sockets.emit('refresh screens', screens);
        } else {
            var screenSocketID = Object.keys(connections).filter(function (key) { return connections[key] === socket.id })[0];

            // its a connected remote
            if (screenSocketID && screenSocketID.length > 0) {
                // clear remote status
                if (socket.id in remote_status) {
                    delete (remote_status[socket.id]);
                }

                // break connection
                delete (connections[screenSocketID]);
                sync_screen_status(screenSocketID);
            }

        }

    });

    // handle remote binding
    socket.on('toggle remote binding', function (screenSocketID) {

        // check if screen is already connected to a remote
        if (screenSocketID in connections && connections[screenSocketID] == socket.id) {
            // disconnect screen
            console.log('disconnect screen');
            delete (connections[screenSocketID]);
        } else {
            // set/update connection
            console.log('connect screen');
            connections[screenSocketID] = socket.id;
        }

        sync_screen_status(screenSocketID);

    });

    // handle remote selection
    socket.on('select image', function (imageID) {

        remote_status[socket.id] = imageID;

        // update screens
        push_remote_status(socket.id);

    });

});

// push selected image to connected screen
function push_remote_status(remoteSocketID){
	
	// update image if screen is connected
	if(remoteSocketID in remote_status){
		// find screen socket id and update
		var screenSocketID = Object.keys(connections).filter(function(key) {return connections[key] === remoteSocketID})[0];
		sync_screen_status(screenSocketID)
	}

}

// update images on screen
function sync_screen_status(screenSocketID){

	// lookup corresponding remote
	if(screenSocketID in connections && connections[screenSocketID] in remote_status){
		// update selected image if a screen is connected and an image is selected on the remote
		var remoteSocketID = connections[screenSocketID];
		io.sockets.socket(screenSocketID).emit('show image', remote_status[remoteSocketID]);
	}else{
		// empty screen
		io.sockets.socket(screenSocketID).emit('show image', '');
	}

}
