
var slide = 1;
var lectureId;
var totalSlides;

function onLoad() {

	lectureId = document.getElementById("lecture_name").getAttribute('name');
	
	totalSlides = document.getElementById("slides").getAttribute('name');

	document.getElementById("next").onclick = next;
	document.getElementById("previous").onclick = prev;
	
	if (totalSlides == 1) {
		document.getElementById("next").className = "disabled";
		document.getElementById("next").disabled = true;
	}	
}

function next() {
	if (slide == (totalSlides - 1)) {
		this.className = "disabled";
		this.disabled = true;
	}
	if (slide >= 1) {
		document.getElementById("previous").className = "";
		document.getElementById("previous").disabled = false;
	}
	slide++;
	
	getSlide(slide, lectureId);
}

function prev() {
	if (slide <= 2) {
		this.className = "disabled";
		this.disabled = true;
	} else {
		this.className = "";
		this.disabled = false;
	}
	if (slide <= totalSlides) {
		document.getElementById("next").className = "";
		document.getElementById("next").disabled = false;
	}
	slide--;
	
	getSlide(slide, lectureId);
}

function getSlide(slide, lectureId) {

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
				if (xmlhttp.responseText != "<ERROR>") {
					document.getElementById("slide").innerHTML = xmlhttp.responseText;
				} else {
					alert("Error.");
				}
           }
           else if(xmlhttp.status == 400) {
				alert("Error.");
           }
           else {
				alert("Error.");
           }
        }
    }

	xmlhttp.open("POST", "get-lecture.php", true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("ld="+lectureId+"&s="+slide);
}

window.onload = onLoad;