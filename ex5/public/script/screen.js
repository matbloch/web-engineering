var devicename; // the name of this screen and specified in the URL
var imageCount = 7; // the maximum number of images available

document.addEventListener("DOMContentLoaded", function(event) {
    devicename = getQueryParams().name;
    if (devicename) {
        var text = document.querySelector('#name');
        text.textContent = devicename;
    }

    connectToServer();
});

function showImage (index){
    var img = document.querySelector('#image');
    var msg = document.querySelector('#msg');
    if (index >= 0 && index <= imageCount){
        img.setAttribute("src", "images/" +index +".jpg");
        msg.style.display = 'none';
        img.style.display = 'block';
    }
}

function clearImage(){
    var img = document.querySelector('#image');
    var msg = document.querySelector('#msg');
    img.style.display = 'none';
    msg.style.display = 'block';
}

function getQueryParams() {
    var qs =  window.location.search.split("+").join(" ");

    var params = {}, tokens,
        re = /[?&]?([^=]+)=([^&]*)/g;

    while (tokens = re.exec(qs)) {
        params[decodeURIComponent(tokens[1])]
            = decodeURIComponent(tokens[2]);
    }

    return params;
}


function connectToServer(){
    var socket = io();
	// send device name to server
    socket.emit('init screen',devicename);

	// TODO: image change: emtyp imageID means don't show any image
	socket.on('show image', function(imageID){
		if (imageID == ''){
            clearImage();
		}else{
		    showImage(imageID);
		}	
		
	});
}