
function showElements() {
  if (document.getElementById("customer").checked) {
    document.getElementById("userH").id = "userS";
    document.getElementById("hotelS").id = "hotelH";

  }
  if (document.getElementById("hotel").checked) {
    document.getElementById("hotelH").id = "hotelS";
    document.getElementById("userS").id = "userH";
  }
}

function checkUser() {
  var username = document.getElementById("username").value;
  var email = document.getElementById("userEmail").value;
  if (username.length < 5 ||
     username.length > 30 ||
     !(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(email)) ||
     email.length > 50
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
  var name = document.getElementById("hotelName").value;
  if (name.length > 30) {
    changeHotelState("hotelS", "hotelW");
  } else {
    changeHotelState("hotelW", "hotelS");
  }
}

function checkEmail() {
  var email = document.getElementById("hotelEmail").value;
  if (!(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(email)) ||
      email.length > 50) {
    changeHotelState("hotelS", "hotelW");
  } else {
    changeHotelState("hotelW", "hotelS");
  }
}

function checkPhone() {
  var phone = document.getElementById("hotelPhone").value;
  if (!(/^[0-9]/.test(phone)) ||
      phone.length > 50) {
    changeHotelState("hotelS", "hotelW");
  } else {
    changeHotelState("hotelW", "hotelS");
  }
}

function checkDescription() {
  var desc = document.getElementById("hotelDescription").value;
  if (desc.length > 200) {
    changeHotelState("hotelS", "hotelW");
  } else {
    changeHotelState("hotelW", "hotelS");
  }
}

function changeHotelState(before, after) {
  document.getElementById(before).id = after;
}
