var xmlhttp = new XMLHttpRequest();
var url = "https://www.googleapis.com/customsearch/v1?q=dioculo&cx=001186922872885026417:9ptvru9qau8&key=AIzaSyB8iJub21LJvWSQcMNLLzkyS92XxD9lheQ&start=1";

xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
    var myArr = JSON.parse(xmlhttp.responseText);
    alert(myArr);
    }
};

xmlhttp.open("GET", url, true);
xmlhttp.send();