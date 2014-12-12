
function onLoad() {
	var lectures = document.getElementById("lectures").children;
	for (var i = 0; i < lectures.length; i++) {
		lectures[i].children[0].children[2].onclick = presentSlides;
		
		if (lectures[i].children[0].children.length == 4) {
			lectures[i].children[0].children[3].onclick = closeSession;
		}
	}
}

function presentSlides() {
	var lectureId = this.name.replace('present-slide', '');
	
	method = "post";
	path = "presenting.php";
	
	var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", 'lectureId');
	hiddenField.setAttribute("value", lectureId);

	form.appendChild(hiddenField);

    document.body.appendChild(form);
    form.submit();
}


function closeSession() {
	var lectureId = this.id.replace('remove-slide', '');
	var xmlhttp;

    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 ) {
           if(xmlhttp.status == 200){
				if (xmlhttp.responseText == "<SUCCESS>") {
					var button = document.getElementById("remove-slide"+lectureId);
					button.value = "Closed successfully!";
					setTimeout(function() {
						button.parentNode.removeChild(button);
					}, 8000);
				} else {
					alert(xmlhttp.responseText);
					setTimeout(function() {
						setNormal();
					}, 5000);
				}
           }
           else if(xmlhttp.status == 400) {
				alert(xmlhttp.responseText);
				setTimeout(function() {
					setNormal();
				}, 5000);
           }
           else {
				alert(xmlhttp.responseText);
				setError();
				setTimeout(function() {
					setNormal();
				}, 5000);
           }
        }
    }

	xmlhttp.open("GET", "close-session.php?ld="+lectureId, true);
    xmlhttp.send();
}

window.onload = onLoad;