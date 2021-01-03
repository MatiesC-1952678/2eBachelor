
function showElements() {
  if (document.getElementById("customer").checked) {
    document.getElementById("userH").id = "userS";
    document.getElementById("enterpriseS").id = "enterpriseH";

  }
  if (document.getElementById("enterprise").checked) {
    document.getElementById("enterpriseH").id = "enterpriseS";
    document.getElementById("userS").id = "userH";
  }
}

function checkUser() {
  var username = document.getElementById("username").value;
  var email = document.getElementById("email").value;
  var password = document.getElementById("password").value;
  if (username.length < 5 ||
     username.length > 30 ||
     !(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(email)) ||
     email.length > 50 ||
     email.length < 1 ||
     password.length > 50 ||
     password.length < 5
     //you can add more conditions here for the login!
   ) {
    document.getElementById("userS").id = "userW";
  } else {
    var userObj = document.getElementById("userW");
    if (userObj.id == "userW") {
      userObj.id = "userS";
    }
  }
}

function checkName() {
  var name = document.getElementById("enterpriseName").value;
  if (name.length < 5 || name.length > 30) {
    changeenterpriseState("enterpriseS", "enterpriseW");
  } else {
    changeenterpriseState("enterpriseW", "enterpriseS");
  }
}

function checkEmail() {
  var email = document.getElementById("enterpriseEmail").value;
  if (!(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(email)) ||
      email.length > 50) {
    changeenterpriseState("enterpriseS", "enterpriseW");
  } else {
    changeenterpriseState("enterpriseW", "enterpriseS");
  }
}

function checkPhone() {
  var phone = document.getElementById("enterprisePhone").value;
  if (!(/^[0-9]/.test(phone)) ||
      phone.length > 50) {
    changeenterpriseState("enterpriseS", "enterpriseW");
  } else {
    changeenterpriseState("enterpriseW", "enterpriseS");
  }
}

function checkDescription() {
  var desc = document.getElementById("enterpriseDescription").value;
  if (desc.length > 200) {
    changeenterpriseState("enterpriseS", "enterpriseW");
  } else {
    changeenterpriseState("enterpriseW", "enterpriseS");
  }
}

function checkPassword() {
  var password = document.getElementById("enterprisePassword").value;
  if (password.length > 50 || password.length < 5) {
    changeenterpriseState("enterpriseS", "enterpriseW");
  } else {
    changeenterpriseState("enterpriseW", "enterpriseS");
  }
}

function changeenterpriseState(before, after) {
  document.getElementById(before).id = after;
  if (before == "enterpriseW") {
    document.getElementById(before).disabled = true;
  } else {
    document.getElementById(before).disabled = false;
  }
}
