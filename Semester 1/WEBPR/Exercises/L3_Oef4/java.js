
function startScroll() {
  var el = document.getElementById("right");
  for (i = 0; i < 100; i++) {
    el.id = "left";
    setTimeout(function () {
      el.id = "right";
    }, 1000);
  }
}
