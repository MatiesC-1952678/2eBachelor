
function switchElements() {
    if (document.getElementById("DateRadio").checked || document.getElementById("DateRoomRadio").checked) {
        document.getElementById("searchS").id = "searchH";
        document.getElementById("datepickerH").id = "datepickerS";
    } else {
        document.getElementById("searchH").id = "searchS";
        document.getElementById("datepickerS").id = "datepickerH";
    }
}

var search = document.getElementById("searchbar");
search.addEventListener("input", xmlRequest, false);

function xmlRequest() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        showResult(xmlhttp);
    };
    xmlhttp.open("POST", "ajax/ajaxHome.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    var type = document.getElementsByClassName("type");
    var id = "Room";
    for (var i = 0; i < type.length; i++) {
        var current = type[i];
        if (current.checked) {
            id = current.id.substring(0, current.id.length-5);
        }
    } 

    xmlhttp.send("search="+search.value+"&type="+id);

}

function showResult(xmlhttp) {
    if ((xmlhttp) && (xmlhttp.readyState == 4) && (xmlhttp.status == 200)) {
        if (xmlhttp.responseText == "0")
            document.getElementById("List").setCustomValidity("Error accessing db");
        else
            document.getElementById("List").innerHTML = xmlhttp.responseText;
    }
}
