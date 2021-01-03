
var search = document.getElementById("searchbar");
search.addEventListener("input", xmlRequest, false);

function xmlRequest() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        showResult(xmlhttp);
    };
    xmlhttp.open("POST", "ajax/ajaxChat.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("search="+search.value);

}

function showResult(xmlhttp) {
    if ((xmlhttp) && (xmlhttp.readyState == 4) && (xmlhttp.status == 200)) {
        if (xmlhttp.responseText == "0")
            document.getElementById("List").setCustomValidity("Error accessing db");
        else
            document.getElementById("List").innerHTML = xmlhttp.responseText;
    }
}
