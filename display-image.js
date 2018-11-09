
window.onload = function() {
	document.getElementById("myimage").style.display = "none";
	document.getElementById("img-upload").style.display = "none";
}

function displayimg(event)
{
	var img = event.target.files[0];
	var reader = new FileReader();
	
	var imgtag = document.getElementById("myimage");
	imgtag.style.display = "block";
	imgtag.title = img.name;

	reader.onload = function(event)
	{
		imgtag.src = event.target.result;
	}
	reader.readAsDataURL(img)
	document.querySelector("#upload").style.display = "none";
	document.querySelector("#img-upload").style.display = "block";
}

function display_img(num)
{
	if (document.querySelector("#img-upload").style.display == "block")
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
	}
}