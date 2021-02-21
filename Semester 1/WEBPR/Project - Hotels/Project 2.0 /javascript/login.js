
function showElements() {
  if (document.getElementById("customer").checked) {
    if (document.getElementById("userH") !== null)
      document.getElementById("userH").id = "userS";
    if (document.getElementById("enterpriseS") !== null)
      document.getElementById("enterpriseS").id = "enterpriseH";
  }
  if (document.getElementById("enterprise").checked) {
    if (document.getElementById("enterpriseH") !== null)
      document.getElementById("enterpriseH").id = "enterpriseS";
    if (document.getElementById("userS") !== null)
      document.getElementById("userS").id = "userH";
  }
}

initElements();
function initElements() {
  document.getElementById("radioH").id = "radioS";
  document.getElementById("userS").id = "userH";
  document.getElementById("enterpriseS").id = "enterpriseH";
}

function checkAllUser() {
  var a = checkName('username', 'userS', 'userW');
  var b = checkEmail('email','userS','userW');
  var c = checkPassword('password','userS','userW');

  if (!(a || b || c)) {
    changeenterpriseState('userW', 'userS');
    document.getElementById('username').setCustomValidity("");
    document.getElementById('email').setCustomValidity("");
    document.getElementById('password').setCustomValidity("");
  }
}

function checkEditUser() {
  var a = false;
  var b = false;
  var c = false;
  if (document.getElementById('username').value !== "" )
    a = checkName('username', 'userS', 'userW');
  if (document.getElementById('email').value !== "")
    b = checkEmail('email','userS','userW');
  if (document.getElementById('password').value !== "")
    c = checkPassword('password','userS','userW');

  if (!(a || b || c)) {
    changeenterpriseState('userW', 'userS');
    document.getElementById('username').setCustomValidity("");
    document.getElementById('email').setCustomValidity("");
    document.getElementById('password').setCustomValidity("");
  }
}

function checkAllEnterprise() {
  var a = checkName('enterpriseName','enterpriseS','enterpriseW');
  var b = checkDescription();
  var c = checkEmail('enterpriseEmail','enterpriseS','enterpriseW');
  var d = checkPhone();
  var e = checkPassword('enterprisePassword','enterpriseS','enterpriseW');

  if (!(a || b || c || d || e)) {
    changeenterpriseState('enterpriseW', 'enterpriseS');
    document.getElementById('enterpriseName').setCustomValidity("");
    document.getElementById('enterpriseDescription').setCustomValidity("");
    document.getElementById('enterpriseEmail').setCustomValidity("");
    document.getElementById('enterprisePhone').setCustomValidity("");
    document.getElementById('enterprisePassword').setCustomValidity("");
  }
}

function checkEditEnterprise() {
  var a = false;
  var b = false;
  var c = false;
  var d = false;
  var e = false;
  if (document.getElementById('enterpriseName').value !== "")
    a = checkName('enterpriseName','enterpriseS','enterpriseW');
  if (document.getElementById('enterpriseDescription').value !== "")
    b = checkDescription();
  if (document.getElementById('enterpriseEmail').value !== "")
    c = checkEmail('enterpriseEmail','enterpriseS','enterpriseW');
  if (document.getElementById('enterprisePhone').value !== "")
    d = checkPhone();
  if (document.getElementById('enterprisePassword').value !== "")
    e = checkPassword('enterprisePassword','enterpriseS','enterpriseW');
  if (!(a || b || c || d || e)) {
    changeenterpriseState('enterpriseW', 'enterpriseS');
    document.getElementById('enterpriseName').setCustomValidity("");
    document.getElementById('enterpriseDescription').setCustomValidity("");
    document.getElementById('enterpriseEmail').setCustomValidity("");
    document.getElementById('enterprisePhone').setCustomValidity("");
    document.getElementById('enterprisePassword').setCustomValidity("");
  }
}

function checkName(id, before, after) {
  var name = document.getElementById(id).value;
  if (name.length < 5 || name.length > 30) {
    changeenterpriseState(before, after);
    document.getElementById(id).setCustomValidity("Your name is not between 5 and 30 characters.");
    return true;
  } else {
    return false;
  }
}

function checkEmail(id, before, after) {
  var email = document.getElementById(id).value;
  if (!(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(email)) ||
      email.length > 50 || email.length < 1) {
    changeenterpriseState(before, after);
    document.getElementById(id).setCustomValidity("Your email is not between 1 and 50 characters or is formatted incorrectly.");
    return true;
  } else {
    return false;
  }
}

function checkPhone() {
  var phone = document.getElementById("enterprisePhone").value;
  if (!(/^(\s*|\d+)$/.test(phone)) ||
      phone.length > 50) {
    changeenterpriseState("enterpriseS", "enterpriseW");
    document.getElementById("enterprisePhone").setCustomValidity("Your phone number is either formatted incorrectly or is longer than 50 characters.");
    return true;
  } else {
    return false;
  }
}

function checkDescription() {
  var desc = document.getElementById("enterpriseDescription").value;
  if (desc.length > 200) {
    changeenterpriseState("enterpriseS", "enterpriseW");
    document.getElementById("enterpriseDescription").setCustomValidity("Your description is longer than 200 characters.");
    return true;
  } else {
    return false;
  }
}

function checkPassword(id, before, after) {
  var password = document.getElementById(id).value;
  if (password.length > 50 || password.length < 5) {
    changeenterpriseState(before, after);
    document.getElementById(id).setCustomValidity("Your password is not between 5 and 50 characters.");
    return true;
  } else {
    return false;
  }
}

function changeenterpriseState(before, after) {
  var element = document.getElementById(before);
  if (element !== null)
    element.id = after;
}
