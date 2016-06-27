function raccogli() {
	var list=document.getElementsByClassName("sendTo");
	var i;
	for (i=0; i<=list.length; i++) {
		console.log(list[i].innerHTML);
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


$(document).ready(function(){
    $('#sendTestBtn').click(function () {
    var i;
    var strEmails ="";
    var list=document.getElementsByClassName("sendTo");
    for (i=0; i<list.length; i++) {
		 strEmails += list[i].id;
		 strEmails += "%20";
	}
	document.getElementById('emails').value = strEmails;
    });
});


$('#testEmailBTN').click(function(){
    $.ajax
    ({ 
        url: 'emails.php',
        data: {"test": "true",
    			"emails": $('#testEmailTXT').val()
    			},
        type: 'post',
        success: function(result)
        {
            $('#testResult').text(result);
           
        }
    });
});

