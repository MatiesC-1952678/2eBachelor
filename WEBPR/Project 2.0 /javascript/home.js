if (document.getElementById("datepickerS") !== null)
    document.getElementById("datepickerS").id = "datepickerH";

if (document.getElementById('mapH'))   
    checkMap();

function switchElements() {
    if (document.getElementById("DateRadio").checked || document.getElementById("DateRoomRadio").checked) {
        if (document.getElementById("searchS") !== null)
            document.getElementById("searchS").id = "searchH";
        if (document.getElementById("datepickerH") !== null)
            document.getElementById("datepickerH").id = "datepickerS";
    } else {
        if (document.getElementById("searchH") !== null)
            document.getElementById("searchH").id = "searchS";
        if (document.getElementById("datepickerS") !== null)
            document.getElementById("datepickerS").id = "datepickerH";
    }
}

function checkMap() {
    var checkbox = document.getElementById("MapBox");
    if (checkbox !== null && !checkbox.checked) 
        document.getElementById("map").id = "mapH";
    else 
        document.getElementById("mapH").id = "map";
}

var search = document.getElementById("searchbar");
if (search !== null)
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
            document.getElementsByClassName("List")[0].setCustomValidity("Error accessing db");
        else
            document.getElementsByClassName("List")[0].innerHTML = xmlhttp.responseText;
    }
}
