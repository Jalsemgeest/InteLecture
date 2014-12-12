
function onLoad() {
	var total = document.getElementById('lectures').children.length;
	for (var i = 0; i < total; i++) {
		var id = document.getElementById('lectures').children[i].id
		document.getElementById('edit-slide'+id).onclick = editSlide;
		document.getElementById('view-slide'+id).onclick = viewSlide;
		if (document.getElementById('answer-slide'+id) != null) {
			document.getElementById('answer-slide'+id).onclick = viewAnswers;
		}
	}
}

function viewSlide() {
	var lectureId = this.id.substr(10);

	method = "post";
	path = "view-slide.php";
	
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

function editSlide() {
	var lectureId = this.id.substr(10);
	
	method = "post";
	path = "edit-slide.php";
	
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

function viewAnswers() {
	var lectureId = this.id.substr(12);

	method = "post";
	path = "lecture-answers.php";

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

window.onload = onLoad;