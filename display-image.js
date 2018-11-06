
window.onload = function() {
	document.getElementById("myimage").style.display = "none";
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
}