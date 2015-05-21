var currentImage = 0; // the currently selected image
var imageCount = 7; // the maximum number of images available
var socket = null;
var myScreens = {};

function showImage (index){
    // Update selection on remote
    currentImage = index;
    var images = document.querySelectorAll("img");
    document.querySelector("img.selected").classList.toggle("selected");
    images[index].classList.toggle("selected");

    // Send the command to the screen
	socket.emit('select image',currentImage);

}

function initialiseGallery(){
    var container = document.querySelector('#gallery');
    var i, img;
    for (i = 0; i < imageCount; i++) {
        img = document.createElement("img");
        img.src = "images/" +i +".jpg";
        document.body.appendChild(img);
        var handler = (function(index) {
            return function() {
                showImage(index);
            }
        })(i);
        img.addEventListener("click",handler);
    }

    document.querySelector("img").classList.toggle('selected');
}

document.addEventListener("DOMContentLoaded", function (event) {
    initialiseGallery();

    document.querySelector('#toggleMenu').addEventListener("click", function (event) {
        var style = document.querySelector('#menu').style;
        style.display = style.display == "none" || style.display == "" ? "block" : "none";
    });
    connectToServer();
    showImage(0);
});

function connectToServer(){
    socket = io();
    
	// get current screens
    socket.on('refresh screens', function (screens) {

        // TODO: list screen (include screen socket.id to data-attribute)

        console.log(screens);



        var list = $('ul.mylist');
        list.html("");
        for (var screen in screens) {
            if (!(screen in myScreens)) {
                myScreens[screen] == "disconnected"
            }
            var li = $('<li/>')
				.addClass('ui-menu-item')
				.attr('role', 'menuitem')
                .attr('data-socketID', screen)
				.appendTo(list);
            var aaa = $('<a/>')
				.text(screens[screen])
				.appendTo(li);
            var aaa = $('<button/>')
                .addClass('pure-button')
                .addClass('toggleScreen')
			    .text(myScreens[screen] == "connected" ? "Disconnect" : "Connect")
                .attr('data-socketid', screen)
			    .appendTo(li);

        }
        for (var scrn in myScreens) {
            if (!(scrn in screens)) {
                delete (myScreens[scrn]);
            } 
        }

        $('#menu').html(list);

    });
}

/*
 TODO:
 enable screen toggling: bind click event to "toggle remote binding event". Send target screen id received from the data attribute of the corresponding list element
 */
$(document).on("click", ".toggleScreen", function () {
    var ScreenSocketID = $(this).data('socketid');
    console.log(ScreenSocketID);
    socket.emit('toggle remote binding', ScreenSocketID);
    if ($(this).text() == 'Connect') {
        myScreens[ScreenSocketID] = "connected";
        $(this).text("Disconnect")
    }else{
        myScreens[ScreenSocketID] = "disconnected";
        $( this ).text('Connect'); 
    }
});

 
 