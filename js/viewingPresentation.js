
var lectureId, sessionId, slideNum;

function onLoad() {
	lectureId = document.getElementById("lecture_name").getAttribute("name");
	sessionId = document.getElementById("session").getAttribute("name");
	slideNum = document.getElementById("slide").getAttribute("name");
	setInterval(getSlideFromServer, 10000);
}

function getSlideFromServer() {

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
					if (xmlhttp.responseText == "<CLOSED>") {
						document.getElementById("slide").parentNode.innerHTML = "<h1><u>LECTURE CLOSED</u></h1>";
						setTimeout(function() {
							document.location.href="http://54.68.82.18/0jaca/Inte-Lecture/index.php";
						}, 8000);
					}
					else {
						// If it is new information, then print change it.
						if (xmlhttp.responseText != "<SAME_SLIDE>") {
							document.getElementById("slide").parentNode.innerHTML = xmlhttp.responseText;
							// Have to set the slideNum variable again.
							slideNum = document.getElementById("slide").getAttribute("name");

							// Set the onClicks of the buttons.
							if (document.getElementById("answer_1") != null) {
								document.getElementById("answer_1").onclick = answerQuestion;
								document.getElementById("answer_2").onclick = answerQuestion;
								document.getElementById("answer_3").onclick = answerQuestion;
								document.getElementById("answer_4").onclick = answerQuestion;
							}
						}
					}
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

	xmlhttp.open("POST", "get-slide.php", true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("ld="+lectureId+"&s="+sessionId+"&in="+slideNum);
}

function answerQuestion() {
	if (confirm("Are you sure you want to choose: '" + this.value + "'?")) {
		// Disable buttons
		disableButtons();
		var button = this;
		// Send answer to the server.  If the client answers the question they could just refresh the page.
		// This means that we MUST deal with answers on server side.  Ie.  Once they answer a question once, it sets it in the answers table.
		// If it's in the answers table they may not answer it again. maybe do answer checking from server
		
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
					if (xmlhttp.responseText != "<FAILURE>") {
						if (xmlhttp.responseText == "<ANSWERED>") {
							// The user has already answered this question.  So change the colour of the button to green.
							button.className = "questions-active answered-button";
						}
						// If it is new information, then print change it.
						else if (xmlhttp.responseText == "<SUCCESS>"){
							button.className = "questions-active answered-button";
						}
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

		xmlhttp.open("POST", "answer-question.php", true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("ld="+lectureId+"&in="+slideNum+"&idq="+this.getAttribute("name"));
		
	}
}

function disableButtons() {
	document.getElementById("answer_1").disabled = true;
	document.getElementById("answer_1").className = "questions-active view-slide"
	document.getElementById("answer_2").disabled = true;
	document.getElementById("answer_2").className = "questions-active view-slide"
	document.getElementById("answer_3").disabled = true;
	document.getElementById("answer_3").className = "questions-active view-slide"
	document.getElementById("answer_4").disabled = true;
	document.getElementById("answer_4").className = "questions-active view-slide"
}

window.onload = onLoad;