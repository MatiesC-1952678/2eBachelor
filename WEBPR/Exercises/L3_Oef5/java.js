function checkName() {
  var x= document.getElementById("name").value;
  if (!(/^[A-z ]+$/.test(x)) || (x.length > 30)) {
    incorrect();
  }
}

function checkPass() {
  var form = document.getElementById("form");
  var x= document.getElementById("password").value;
  if (x.length <= 5) {
    incorrect();
  }
}

function checkEquals() {
  var pass1 = document.getElementById("password").value;
  var pass2 = document.getElementById("password2").value;
  if (pass1 != pass2) {
    incorrect();
  }
}

function checkEmail() {
  var email = document.getElementById("email").value;
  if (!(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(myForm.emailAddr.value))){
    incorrect();
  }
}

function incorrect() {
  var form = document.getElementById("form");
  form.id = "formIncorrect";
}
