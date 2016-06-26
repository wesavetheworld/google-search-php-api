function raccogli() {
	var list=document.getElementsByClassName("sendTo");
	alert("topkek");
	var i;
	for (i=0; i<list.length; i++) {
		document.getElementById("listo").innerHTML += list[i].innerHTML;
	}
}

function activate(str) {
	var eID = str.id.slice(3);
	
	if (str.checked) {
		document.getElementById(eID.toString()).classList.add("sendTo");
	} else {
		document.getElementById(eID.toString()).classList.remove("sendTo");
	}
	
}

