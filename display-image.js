
window.onload = function() {
	document.getElementById("upload-img").style.display = "none";
	document.getElementById("img-upload").style.display = "none";
	document.getElementById("prev").style.display = "none";
}

function displayimg(e)
{
	var reader = new FileReader();
	var canvas = document.getElementById("upload-img");
	var ctx = canvas.getContext('2d');
	reader.onload = function(event)
	{
		var img = new Image();
		img.onload = function()
		{
			canvas.width = img.width;
			canvas.height = img.height;
			ctx.drawImage(img, 0, 0);
		}
		img.src = event.target.result;
	}
	reader.readAsDataURL(e.target.files[0]);

	document.querySelector("#upload").style.display = "none";
	document.querySelector("#img-upload").style.display = "block";
	document.querySelector("#upload-img").style.display = "block";
	document.getElementById("prev").style.display = "block";
}

function display_img(num)
{
	if (document.querySelector("#img-upload").style.display == "block")
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
	}
}


function save_img()
{
	var img = document.getElementById("upload-img").toDataURL();
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