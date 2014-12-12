
var slides;

function onLoad() {
	// Setting up the slides.
	slides = new Array();
	
	document.getElementById("slide1").onkeyup = setHTML;
	document.getElementById("slide1-question").onclick = addQuestions;
	
	document.getElementById("submit-lecture").onclick = submitLecture;
	
	slides[0] = "slide1";
	
	document.getElementById("add-slide").onclick = addSlide;
}

function setHTML() {
	var slide = this.id;
	var slideName = slide + "-html";
	var slideCount = slide + "-count";
	var count = (256 - this.value.replace('\n', '').length);
	if (count >= 0) {
		document.getElementById(''+slideCount).innerHTML = count;
		document.getElementById(''+slideName).innerHTML = this.value.replace('\n', '');
	} else {
		document.getElementById(''+slideCount).innerHTML = 0;
		this.value = this.value.substr(0,256);
	}
}

function addSlide() {
	var number = parseInt(getSlideId(slides[slides.length-1])) + 1;
	slides[slides.length] = "slide" + number;
	var slidesDiv = document.getElementById("slides");
	var div = document.createElement('div');
	div.className = 'slide';
	div.innerHTML = getSlideHTML("slide"+number, "slide"+number+"-count", "slide"+number+"-html");
	slidesDiv.appendChild(div);

	document.getElementById(''+slides[slides.length-1]).onkeyup = setHTML;
	document.getElementById(''+slides[slides.length-1]+'-question').onclick = addQuestions;
}

function getSlideId(id) {
	return id.replace('slide','');
}

function getSlideHTML(slide, counter, slidehtml) {
	return 	"<textarea name=\'" + slide + "\' id=\'" + slide + "\' placeholder=\'Slide" + slide.replace('slide','') + "\' ></textarea>" +
				"<div class=\'counter\' id=\'" + counter + "\'>256</div>" +
				"<div class=\'html-slide\'>" +
					"<p id=\'" + slidehtml + "\'></p>" +
				"</div>" +
				"<div class=\'slide-questions\'>" +
					"<input type=\'button\' class=\'questions-not-active\' value=\'Add Question\' id=\'" + slide + "-question\'/>" +
				"</div>";
}

function addQuestions() {
	var slide = this.id.replace('-question', '');
	
	if (this.className == "questions-not-active") {
		this.className = "questions-active";
		this.value = "Remove Questions";
		var div = document.createElement('div');
		div.className = 'create-questions';
		div.id = slide + '-questions';
		div.innerHTML = getQuestionsHTML(slide);
		this.parentNode.appendChild(div);
	} else {
		this.className = "questions-not-active";
		this.value = "Add Question";
		var questions = document.getElementById(slide+'-questions');
		questions.parentNode.removeChild(questions);
	}
}

function getQuestionsHTML(slide) {
	return 			"<label for=\'answer\'/>Answer:</label>" +
					"<select name=\'"+slide+"-answer\'>" +
						"<option value=\'1\'>1</option>" +
						"<option value=\'2\'>2</option>" + 
						"<option value=\'3\'>3</option>" + 
						"<option value=\'4\'>4</option>" +
					"</select>" +
					"<input type=\'text\' maxlength=\'45\' name=\'question1\' placeholder=\'Question 1\'/>" +
					"<input type=\'text\' maxlength=\'45\' name=\'question2\' placeholder=\'Question 2\'/>" +
					"<input type=\'text\' maxlength=\'45\' name=\'question3\' placeholder=\'Question 3\'/>" +
					"<input type=\'text\' maxlength=\'45\' name=\'question4\' placeholder=\'Question 4\'/>";
}

function submitLecture() {

	if (document.getElementById("lecture-name").value == "") {
		setInvalidLectureName();
		return;
	}

	var slides = document.getElementById("slides");
	var slide_num = slides.children.length;
	
	var lectureName = document.getElementById("lecture-name").value;
	
	var slide = '{ "lecture_name":"'+lectureName+'", "slide_num":"'+slide_num+'", "slides" : [';
	var questions = '{ "questions" : [';
	var finale = false;
	
	for (var i = 0; i < slide_num; i++) {
		slides.children[i].children[2].children[0].innerHTML = "";
	}
	
	for (var i = 0; i < slide_num; i++) {
		var slidesChild = slides.children[i].children;
		if ((i + 1) == slide_num) {
			finale = true;
		}
		for (var num = 0; num < slidesChild.length; num++) {
			// Final case.
			if (finale && num == 0) {
				slide += '{ "slide":"' + slidesChild[num].name + '" , "content":"'+slidesChild[num].value.replace('\n','') + '" } ]}'; 
			}
			else if (slidesChild[num].type == "textarea") {
				// If the child is the text area we are adding the text area to the list.
				slide += '{ "slide":"' + slidesChild[num].name + '" , "content":"'+slidesChild[num].value + '" },'; 
			}
			// If there we are looking at the slide-questions and there are 2 children, ie. it has been clicked then go in here.
			if (slidesChild[num].className == "slide-questions" && slidesChild[num].children.length == 2) {
				// Getting the slide-questions
				var qChildren = slidesChild[num].children;
				// Getting the create-questions.
				for (var z = 0; z < qChildren.length; z++) {
					if (qChildren[z].className == "create-questions") {
						qChildren = qChildren[z].children;
						break;
					}
				}
				// Iterating through the create-questions div.
				for (var qNum = 0; qNum < qChildren.length; qNum++) {
					// Get the select statement.
					if (questions == '{ "questions" : [' && qNum == 1) {
						var selectedAnswer = qChildren[qNum].options[qChildren[qNum].selectedIndex].value;
						questions += '{ "question":"' + slides.children[i].children[0].id + '" , "answer":"' + selectedAnswer + '",';
					}
					else if (qNum == 1) {
						var selectedAnswer = qChildren[qNum].options[qChildren[qNum].selectedIndex].value;
						questions += ',{ "question":"' + slides.children[i].children[0].id + '" , "answer":"' + selectedAnswer + '",';
					}
					// Last case.
					else if (qNum == 5) {
						if (finale) {
							questions += '"'+qChildren[qNum].name+'":"' + qChildren[qNum].value + '" }';
						} else {
							questions += '"'+qChildren[qNum].name+'":"' + qChildren[qNum].value + '" } ';
						}
					}
					else if (qNum > 0) {
						questions += '"'+qChildren[qNum].name+'":"' + qChildren[qNum].value + '" ,';
					}
				}
			}
		}
	}
	// Add the end to the questions string.
		if (questions.indexOf("} ]}") == -1) {
			questions += " ]}";
		}
	if (questions == '{ "questions" : [') {
		questions = '{ "questions" : [] }';
	}
	
	for (var i = 0; i < slide_num; i++) {
		slides.children[i].children[2].children[0].innerHTML = slides.children[i].children[0].value;
	}
	
	// Making it so we can send them both over one file.
	var jsonObj = slide + 'DIVIDER' + questions;
	//slides.innerHTML = "JSON: " + jsonObj;
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
					document.getElementById("submit-lecture").value = "Complete!";
					setTimeout(function() {
						document.location.href="http://54.68.82.18/0jaca/Inte-Lecture/index.php";
					}, 8000);
				} else {
					//slides.innerHTML = "Response: " + xmlhttp.responseText;
					setError();
					setTimeout(function() {
						setNormal();
					}, 5000);
				}
           }
           else if(xmlhttp.status == 400) {
				//slides.innerHTML = "Response2: " + xmlhttp.responseText;
				setError();
				setTimeout(function() {
					setNormal();
				}, 5000);
           }
           else {
				setError();
				setTimeout(function() {
					setNormal();
				}, 5000);
           }
        }
    }

	xmlhttp.open("POST", "create_exec.php", true);
	xmlhttp.setRequestHeader("Content-type","application/json;charset=UTF-8");
    xmlhttp.send(JSON.stringify(jsonObj));
	
}

function setNormal() {
	document.getElementById("submit-lecture").value = "Submit";
}

function setError() {
	document.getElementById("submit-lecture").value = "Error.";
}

function setInvalidLectureName() {
	document.getElementById("submit-lecture").value = "Invalid Lecture Name.";
}

window.onload = onLoad;