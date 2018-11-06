
window.onload = function load()
{
	if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
		navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
			try {
				video.srcObject = stream;
			} catch (error) {
				video.src = window.URL.createObjectURL(stream);
			}
			video.play();
		});
	}else
		document.getElementById("Camera").innerHTML = "<p> NO CAMERA </p>";
	document.getElementById("snap").addEventListener("click", click);
	document.querySelector("#delete_snap").addEventListener("click", cancel_click);
	document.querySelector("#delete_snap").style.display = "none";
}

function click()
{
	var img = document.querySelector('#canvas');
	var video = document.querySelector('#video');


	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function ()
	{
		if (this.readyState(4) && this.status == 200)
		{
			document.getElementById("error").innerHTML = this.responseText;
		}
		else if (this.status == 404)
		{
			document.getElementById("error").innerHTML = 'Page not found!';
		}
	}

	img.style.display = "inline";
	img.width = video.offsetWidth;
	img.height = video.offsetHeight;
	context = img.getContext('2d');
	context.drawImage(video, 0, 0, video.offsetWidth, video.offsetHeight);
	document.querySelector("#video").style.display = "none";
    document.querySelector("#snap").style.display = "none";
/*     document.querySelector("#options").style.display = "block";*/
    document.querySelector("#delete_snap").style.display = "inline";
}
   
	
function cancel_click()
{
	document.querySelector("#canvas").style.display = "none";
    /*document.querySelector("#options").style.display = "none";*/
    document.querySelector("#video").style.display = "inline";
    document.querySelector("#snap").style.display = "inline";
    document.querySelector("#delete_snap").style.display = "none";
}


function save_img()
{
	var canvas = document.getElementById("canvas");
	var dataURL = canvas.toDataURL("img/png");
	
	document.getElementById('hidden-data').value = dataURL;
	var fd = new FormData(document.forms["save_img-form"]);

	xhr = new XMLHttpRequest();
	xhr.open('POST', 'includes/save.inc.php');

	xhr.upload.onprogress = function(e) {
		if (e.lengthComputable) {
			var percentComplete = (e.loaded / e.total) * 100;
			console.log(percentComplete + '% uploaded');
			alert('Succesfully uploaded');
		}
	};

	xhr.onload = function()
	{
		console.log("loading...");
	};
	xhr.send(fd);
}