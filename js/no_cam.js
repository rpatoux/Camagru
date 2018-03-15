var startbutton2  = document.querySelector('#startbutton2');
var photo2 = document.querySelector('#photo2');
var superpose2 = document.getElementById('superpose2');
var valide2 = document.getElementById('valide2');
var source = 0;
var name2 = null;
var x = 150;
var y = 100;
var size = 100;

function sub_img(objet)
{
	if (confirm("Voulez-vous vraiment supprimer cette photo ??"))
	{
		var parent = objet.parentNode;
		var img = parent.childNodes[1].src;
		img = img.split("/");
		img = '/'+img[3]+'/'+img[4];
		img = '..'+img;
		var xhr = getXMLHttpRequest();
		xhr.onreadystatechange = function()
		{
			if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
			{
				if (xhr.responseText == 'yes')
				{
					parent.parentNode.removeChild(parent);
				}
			}
		}
		xhr.open("POST", "delete_img.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send('img='+img);
	}
}
   function allowDrop2(e)
{
   e.preventDefault();
}

function replace_url()
{
	var good_img = document.getElementById('sup_img').src;
	if (size == '100' && good_img.indexOf("2.png"))
	{
		if (good_img.indexOf("2.png") > 0)
			good_img = good_img.replace("2.png", ".png");
	}
	else if (size == '150' && good_img.indexOf("2.png") == -1)
	{
		if (good_img.indexOf(".png"))
			good_img = good_img.replace(".png", "2.png");
	}
	source = good_img;
	console.log(source);
	document.getElementById('sup_img_2').src = source;
} 

function define_source(here)
{
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
	replace_url();
}
function drop2(e)
{
	if (source)
	{
		delete_wrong2();
		e.preventDefault();
		var dat  = document.getElementById('sup_img_2');
		x = e.clientX; 
		y = e.clientY;

		var scroll_x =document.body.scrollLeft || document.documentElement.scrollLeft;
		var scroll_y =document.body.scrollTop || document.documentElement.scrollTop;

		x += scroll_x;
		y += scroll_y;
		  var x_div = document.getElementById("cheat2").offsetLeft;
		   var y_div = document.getElementById("cheat2").offsetTop;
		   x = x - x_div - (2/4 * size);
		   y = y - y_div - (2/4 * size);
		   dat.style.left = x + 'px';
		   dat.style.top = y + 'px';
	}
}

function get_name()
{
	var src;
	 if (document.getElementById('photo_up').src != '')
	 {
		name2 = document.getElementById('photo_up').src;
		var res = name2.split("/");
		name2 = res[3]+'/'+res[4];
		name2 = '../'+name2;
	 }
}
upload_photo.addEventListener('click', function()
{
	var el = document.getElementById('up_form');
	el.style.visibility = "visible";
	el.style.opacity = '1';
},false);


function get_size(tail)
{
	size = tail;
	document.getElementById('sup_img_2').style.width = tail+"px";
	document.getElementById('sup_img').style.width = tail+"px";
	replace_url();
}

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


function add_wrong_3()
{
	var length = document.getElementById('wrong2').childNodes.length;
	if (length > 0)
	{
		var list = document.getElementById('wrong2');
		var item = list.firstElementChild;
		  list.removeChild(item);
	}
	var z = document.createElement('div');
	var list = document.getElementById('wrong2');
	z.innerHTML = "Téléchargez d'abord une image";
	list.appendChild(z);
	list.insertBefore(z, list.firstChild);

}

function delete_wrong2()
{
	var length = document.getElementById('wrong2').childNodes.length;
	if (length > 0)
	{
		var list = document.getElementById('wrong2');
		var item = list.firstElementChild;
		  list.removeChild(item);
	}
}

valide2.addEventListener('click', function()
{
	if (source && name2 != null)
	{
		var xhr = getXMLHttpRequest();
		xhr.open("POST", "stock_photo_upload.php", true); // true pour asynchrone
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		/* creation url image */
		xhr.send('source='+source+'&value=1&name='+name2);
		var list = document.getElementById('placehere');
		var new_img = document.createElement("img");
		var new_div = document.createElement('div');
		new_div.setAttribute('class', 'button_supimg');
		new_div.innerHTML = '<button type="submit" onclick="sub_img(this)">X</button>';
		new_img.setAttribute("src", name2);
		new_img.setAttribute('draggable', false);
		list.insertBefore(new_div, list.firstChild);
		new_div.appendChild(new_img, new_div.firstChild);
		photo2.setAttribute('src', "");
	}
},false);


function takepicture2()
{
	if (name2)
	{
		var xhr = getXMLHttpRequest();
		xhr.onreadystatechange = function()
		{
			if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
			{
				name2 = xhr.responseText;
				photo2.setAttribute('src', name2);
				photo2.setAttribute('draggable', false);
				startbutton2.disabled = false;
				valide2.disabled = false;
				startbutton2.style.background = 'lightgreen';
				valide2.style.background = 'lightgreen';
			}
			else
			{
				valide2.disabled = true;
				startbutton2.disabled = true;
				startbutton2.style.background = 'red';
				valide2.style.background = 'red';
			}
		} 
		xhr.open("POST", "stock_photo_upload.php", true); // true pour asynchrone
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		var match;
		/* creation url image */
		
		xhr.send('source='+source+'&value=0'+'&name='+name2+'&x='+x+'&y='+y);
	/* fin requete ajax */
	   }
}

startbutton2.addEventListener('click', function(ev)
{	
	get_name();
	if (source && name2 != null)
	{
		var xhr = getXMLHttpRequest();
		xhr.open("POST", "stock_photo.php", true); // true pour asynchrone
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send('source='+source+'&value=3&name='+name2);
		takepicture2();
		ev.preventDefault();
	}
	else if (name2 == null)
	{
		add_wrong_3();
	}
	else
	{
		var length = document.getElementById('wrong2').childNodes.length;
		if (length > 0)
		{
			var list = document.getElementById('wrong2');
			var item = list.firstElementChild;
			  list.removeChild(item);
		}
		var z = document.createElement('div');
		var list = document.getElementById('wrong2');
		z.innerHTML = "Selectionnez d'abord une image";
		list.appendChild(z);
		list.insertBefore(z, list.firstChild);
	}
}, false);
