function onLoad() {
	document.getElementById('but_register').onclick = submitRegistration;
}

function submitRegistration() {
	var email = document.getElementById('email').value;
	var password = document.getElementById('password').value;
	var password_conf = document.getElementById('password_conf').value;
	
	if (email == "" || password == "" || password_conf == "" || email.indexOf("@") < 0) {
		setError();
		setTimeout(function() {
			setNormal();
		}, 3000);
		return;
	}
	
	setLoading();
	
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
					setComplete();
					setTimeout(function() {
						document.location.href="http://54.68.82.18/0jaca/Inte-Lecture/index.php";
					}, 3000);
				} else {
					setError();
					setTimeout(function() {
						setNormal();
					}, 3000);
				}
           }
           else if(xmlhttp.status == 400) {
				setError();
				setTimeout(function() {
					setNormal();
				}, 3000);
           }
           else {
				setError();
				setTimeout(function() {
					setNormal();
				}, 3000);
           }
        }
    }

    xmlhttp.open("POST", "register_exec.php", true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("email="+email+"&password="+password+"&password_conf="+password_conf);
}

function setComplete() {
	document.getElementById('but_register').value = "Success!";
	document.getElementById('but_register').class = "registration-success";
	
}

function setLoading() {
	document.getElementById('but_register').value = "Loading...";
}

function setNormal() {
	document.getElementById('but_register').value = "Register";
}

function setError() {
	document.getElementById('but_register').value = "Error registering.";
}

window.onload = onLoad;