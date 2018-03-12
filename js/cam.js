var streaming = false;
var video = document.querySelector('video');
var canvas = document.querySelector('#canvas');
var startbutton = document.querySelector('#startbutton');
var photo = document.querySelector('#photo');
var superpose = document.getElementById('superpose');
var valide = document.getElementById('valide');
var contain = document.getElementById('container');
var no_cam = document.getElementById('pas_de_cam');
var width = 400;
var height = 300;
var name = 0;
var source = 0;
var data = 0;
var x = 150;
var y = 100;
var size = 100;

function replace_url()
{
	var good_img = document.getElementById('sup_img').src;
	if (size == '100' && (good_img.indexOf("3.png") || good_img.indexOf("2.png")))
	{
		if (good_img.indexOf("2.png") > 0)
			good_img = good_img.replace("2.png", ".png");
		else if (good_img.indexOf("3.png"))
			good_img = good_img.replace("3.png", ".png");
	}
	else if (size == '150' && good_img.indexOf("2.png") == -1)
	{
		if (good_img.indexOf("3.png") > 0)
			good_img = good_img.replace("3.png", "2.png");
		else if (good_img.indexOf(".png"))
			good_img = good_img.replace(".png", "2.png");
	}
	else if (size == '250' && good_img.indexOf("3.png") == -1)
	{
		if (good_img.indexOf("2.png") > 0)
			good_img = good_img.replace("2.png", "3.png");
		else if (good_img.indexOf(".png"))
			good_img = good_img.replace(".png", "3.png");
	}
	source = good_img;
	document.getElementById('sup_img').src = source;
	document.getElementById('sup_img_2').src = source;
} 
function get_size(tail)
{
	size = tail;
	document.getElementById('sup_img_2').style.width = tail+"px";
	document.getElementById('sup_img').style.width = tail+"px";
	replace_url();
}

function define_source(here)
{
	console.log(here);
	source = here;
	document.getElementById('sup_img').src = source;
	document.getElementById('sup_img_2').src = source;
	if (source != '../img/nof.jpeg')
	{
		var el = document.getElementById('radio');
		   el.style.visibility = "visible";
		el.style.opacity = '1';
	}
	if (source == '../img/nof.jpeg')
	{
		var el = document.getElementById('radio');
		   el.style.visibility = "hidden";
		el.style.opacity = '0';
		source = 0;
	}
	delete_wrong2();
	delete_wrong();
	replace_url();
}
function allowDrop(e)
{
   e.preventDefault();
}
function drop(e)
{
	if (source)
	{
		e.preventDefault();
		var dat  = document.getElementById('sup_img');
		x = e.clientX; 
		y = e.clientY;

		var scroll_x =document.body.scrollLeft || document.documentElement.scrollLeft;
		var scroll_y =document.body.scrollTop || document.documentElement.scrollTop;

		x += scroll_x;
		y += scroll_y;
		  var x_div = document.getElementById("cheat").offsetLeft;
		   var y_div = document.getElementById("cheat").offsetTop;
		   x = x - x_div - (2/4 * size);
		   y = y - y_div - (2/4 * size);
		   dat.style.left = x + 'px';
		   dat.style.top = y + 'px';
	   }
}
function delete_wrong()
{
	var length = document.getElementById('wrong').childNodes.length;
	if (length > 1)
	{
		var list = document.getElementById('wrong');
		var item = list.firstElementChild;
		  list.removeChild(item);
	}
}
///////////////////////////////////////////
valide.addEventListener('click', function()
{
	if (data && source && name)
	{
		var xhr = getXMLHttpRequest();
		xhr.open("POST", "stock_photo.php", true); // true pour asynchrone
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send('data='+data+'&name='+name+'&source='+source+'&value=1');
		var list = document.getElementById('placehere');
		var new_img = document.createElement("img");
		new_img.setAttribute("src", name);
		new_img.setAttribute('draggable', false);
		var new_div = document.createElement('div');
		new_div.setAttribute('class', 'button_supimg');
		new_div.innerHTML = '<button type="submit" onclick="sub_img(this)">X</button>';
		list.insertBefore(new_div, list.firstChild);
		new_div.appendChild(new_img, new_div.firstChild);
		photo.setAttribute('src', "");
		data = 0;
	}
},false);

//////////////////////////////////////////////////////////////

navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;	

///////////////////////////////////////////////////////////////////////

function successCallback(stream)
{
	window.stream = stream;
	contain.style.display = 'block';
	no_cam.style.display = "none";
	video.src = window.URL.createObjectURL(stream);
}

///////////////////////////////////////////////////////////

function errorCallback(error)
{
	contain.style.display = "none";
	no_cam.style.display = "block";
}

/////////////////////////////////////////////////////////

video.addEventListener('canplay', function(ev)
{
	if (!streaming)
	{
		  height = video.videoHeight / (video.videoWidth/width);
		  video.setAttribute('width', width);
		  video.setAttribute('height', height);
		  canvas.setAttribute('width', width);
		  canvas.setAttribute('height', height);
		  streaming = true;
	}
  }, false);

/////////////////////////////////////////////

var hconstraints = { video: { mandatory: { minWidth: 300, minHeight: 400 }} };

//////////////////////////////////////////////////////////

function getMedia(Constraints)
{
	if (window.stream)
	{
		  video.src = null;
		  window.stream.getVideoTracks()[0].stop();
	}
	navigator.getUserMedia(Constraints, successCallback, errorCallback);
}

///////////////////////////////////////////////////////////////////////

function getXMLHttpRequest()
{
	var xhr = null;

	if(window.XMLHttpRequest || window.ActiveXObject)
	{
		if(window.ActiveXObject)
		{
			try
			{
				xhr = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch(e)
			{
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
		}
		else
			xhr = new XMLHttpRequest();
	}
	else
	{
		alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
		return null;
	}
	return xhr;
}

//////////////////////////////////////////////////////////////////

function takepicture()
{
	canvas.getContext('2d').drawImage(video, 0, 0, width, height);
	data = canvas.toDataURL('image/png');
	var xhr = getXMLHttpRequest();
	xhr.onreadystatechange = function()
	{
		objet.innerText = xhr.readyState;
		objet.innerText = xhr.status;
		 if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
		 {
			name = xhr.responseText;
			photo.setAttribute('src', name);
			photo.setAttribute('draggable', false);
			startbutton.disabled = false;
			valide.disabled = false;
			startbutton.style.background = 'lightgreen';
			valide.style.background = 'lightgreen';
		 }
		else
		{
			valide.disabled = true;
			startbutton.disabled = true;
			startbutton.style.background = 'red';
			valide.style.background = 'red';
		}
	} 
	xhr.open("POST", "stock_photo.php", true); // true pour asynchrone
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	/* creation url image */
	xhr.send('data='+ data +'&source='+ source +'&value=0&name=1&x='+ x +'&y='+ y);
	echo ("cool");
	data = 1;
	/* fin requete ajax */
}

////////////////////////////////////////////////////////////////////////////

startbutton.addEventListener('click', function(ev)
{	
	console.log(source);
	if (source)
	{
		if (data == 1)
		{
			var xhr = getXMLHttpRequest();
			xhr.open("POST", "stock_photo.php", true); // true pour asynchrone
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send('data='+data+'&source='+source+'&value=3&name='+name);
		}
		takepicture();
		ev.preventDefault();
	}
	else if (!source)
	{
		var length = document.getElementById('wrong').childNodes.length;
		if (length > 1)
		{
			var list = document.getElementById('wrong');
			var item = list.firstElementChild;
			  list.removeChild(item);
		}
		var z = document.createElement('div');
		var list = document.getElementById('wrong');
		z.innerHTML = "Selectionnez d'abord une image";
		list.appendChild(z);
		list.insertBefore(z, list.firstChild);
	}
}, false);
getMedia(hconstraints);
