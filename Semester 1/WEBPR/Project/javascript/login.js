
function showElements() {
  if (document.getElementById("customer").checked) {
    document.getElementById("usernameH").id = "usernameS";
  }
  if (document.getElementById("hotel").checked) {
    document.getElementById("usernameS").id = "usernameH";
  }
}

function checkInput() {
  var username = document.getElementById("usernameField").value;
  var email = document.getElementById("emailField").value;
  if (username.length < 5 || !(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(email)) ) {
    document.getElementById("usernameS").id = "usernameW";
  } else {
    var userObj = document.getElementById("usernameW");
    if (userObj.id == "usernameW") {
      userObj.id = "usernameS";
    }
  }
}
