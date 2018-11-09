
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
	document.querySelector("#save_img").style.display = "none";
}

function click()
{
	var img = document.querySelector('#canvas');
	var video = document.querySelector('#video');

	img.style.display = "inline";
	img.width = video.offsetWidth;
	img.height = video.offsetHeight;
	context = img.getContext('2d');
	context.drawImage(video, 0, 0, video.offsetWidth, video.offsetHeight);
	document.querySelector("#video").style.display = "none";
    document.querySelector("#snap").style.display = "none";
	document.querySelector("#delete_snap").style.display = "inline";
/* 	document.querySelector("#save_img").style.display = "inline"; */
}
   
	
function cancel_click()
{
	document.querySelector("#canvas").style.display = "none";
    document.querySelector("#video").style.display = "inline";
    document.querySelector("#snap").style.display = "inline";
	document.querySelector("#delete_snap").style.display = "none";
	document.querySelector("#save_img").style.display = "none";

	document.querySelector("#cig").style.display = "none";
	document.querySelector("#hat").style.display = "none";
	document.querySelector("#glasses").style.display = "none";
}


function save_img()
{
	var img = document.getElementById("canvas").toDataURL();
	var xhr = new XMLHttpRequest();

	xhr.open("POST", "includes/save.inc.php");
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("img=" + escape(img));
}

function display_img(num)
{
	if (document.querySelector("#canvas").style.display == "inline")
	{
		if (num == 1)
		{
			document.querySelector("#cig").style.display = "block";
		}
		else if (num == 2)
		{
			document.querySelector("#hat").style.display = "block";
		}
		else if (num == 3)
		{
			document.querySelector("#glasses").style.display = "block";
		}
		document.querySelector("#save_img").style.display = "inline";
	}
}