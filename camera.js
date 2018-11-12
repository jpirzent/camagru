
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

	document.querySelector("#metal").style.display = "none";
	document.querySelector("#yolo").style.display = "none";
	document.querySelector("#emoji").style.display = "none";
}


function save_img()
{
	var img = document.getElementById("canvas").toDataURL();
	var xhr = new XMLHttpRequest();

	if (document.querySelector("#metal").style.display == "block")
	{
		var metal = 1;
	}
	else
	{
		var metal = 0;
	}
	if (document.querySelector("#yolo").style.display == "block")
	{
		var yolo = 1;
	}
	else
	{
		var yolo = 0;
	}
	if (document.querySelector("#emoji").style.display == "block")
	{
		var emoji = 1;
	}
	else
	{
		var emoji = 0;
	}

	xhr.onreadystatechange = function()
	{
		if (this.readyState == 4 && this.status == 200)
		{
			document.getElementById("response").innerHTML = this.responseText;
		}
	}
	xhr.open("POST", "includes/save.inc.php");
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("img=" + escape(img) + "&metal=" + escape(metal) + "&yolo=" + escape(yolo) + "&emoji=" + escape(emoji));
}

function display_img(num)
{
	if (document.querySelector("#canvas").style.display == "inline")
	{
		if (num == 1)
		{
			document.querySelector("#metal").style.display = "block";
		}
		else if (num == 2)
		{
			document.querySelector("#yolo").style.display = "block";
		}
		else if (num == 3)
		{
			document.querySelector("#emoji").style.display = "block";
		}
		document.querySelector("#save_img").style.display = "inline";
	}
}