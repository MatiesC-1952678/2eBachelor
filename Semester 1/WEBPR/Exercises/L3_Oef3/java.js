
function raiseMeUp(num) {
  var element = document.getElementById("Geike"+num);
  element.id = "Geike"+num+"t";
}

function backToNormal(num) {
  var element = document.getElementById("Geike"+num+"t");
  element.id = "Geike"+num;
}
