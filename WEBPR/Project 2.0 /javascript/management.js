/**
 * checks all the fields of the new hotel form
 */
function checkAllHotel() {
    var a = checkMinMax('hotelName', 5, 30, 'uploadHotelFormS', 'uploadHotelFormW', 'Your hotel name is not between 5 and 30 characters.');
    var b = checkMinMax('hotelDescription', 0, 200, 'uploadHotelFormS', 'uploadHotelFormW', 'Your description is longer than 200 characters.');
    var d = checkDatePattern('startDate', 'uploadHotelFormS', 'uploadHotelFormW', 'Your starting date is formatted incorrectly.');
    var e = checkDatePattern('endDate', 'uploadHotelFormS', 'uploadHotelFormW', 'Your end date is formatted incorrectly.');
    var c = checkIdBeforeId('startDate','endDate', 'uploadHotelFormS','uploadHotelFormW','Your starting date is not before your ending date.');
    var g = checkTimePattern('startTime', 'uploadHotelFormS', 'uploadHotelFormW', 'Your start time is not formatted correctly');
    var h = checkTimePattern('endTime', 'uploadHotelFormS', 'uploadHotelFormW', 'Your end time is not formatted correctly');
    var f = checkTimeBeforeTime('startTime', 'endTime', 'uploadHotelFormS', 'uploadHotelFormW', 'Your start time is not before your end time.');
    var i = checkRadioChecked('radioCountry', 'uploadHotelFormS', 'uploadHotelFormW', 'No country is checked');

    if (!(a || b || c || d || e || f || g || h || i)) {
        changeId('uploadHotelFormW', 'uploadHotelFormS');
        document.getElementById('hotelName').setCustomValidity("");
        document.getElementById('hotelDescription').setCustomValidity("");
        document.getElementById('startDate').setCustomValidity("");
        document.getElementById('endDate').setCustomValidity("");
        document.getElementById('startTime').setCustomValidity("");
        document.getElementById('endTime').setCustomValidity("");
        document.getElementsByClassName('radioCountry')[0].setCustomValidity("");
    }
}

/**
 * checks all the fields of the update hotel form
 */
function checkEditHotel() {
    var a = false;
    var b = false;
    var c = false;
    var d = false;
    var e = false;
    var f = false;
    var g = false;
    var h = false;

    if (document.getElementById('hotelName').value != "")
        a = checkMinMax('hotelName', 5, 30, 'uploadHotelFormS', 'uploadHotelFormW', 'Your hotel name is not between 5 and 30 characters.');
    if (document.getElementById('hotelDescription').value != "")
        var b = checkMinMax('hotelDescription', 0, 200, 'uploadHotelFormS', 'uploadHotelFormW', 'Your description is longer than 200 characters.');
    if (document.getElementById('startDate').value != "") 
        var e = checkDatePattern('startDate', 'uploadHotelFormS', 'uploadHotelFormW', 'Your end date is formatted incorrectly.');
    if (document.getElementById('endDate').value != "")
        var d = checkDatePattern('endDate', 'uploadHotelFormS', 'uploadHotelFormW', 'Your starting date is formatted incorrectly.'); 
    if (document.getElementById('startDate').value != "" && document.getElementById('endDate').value != "")
        var c = checkIdBeforeId('startDate','endDate', 'uploadHotelFormS','uploadHotelFormW','Your starting date is not before your ending date.');
    if (document.getElementById('startTime').value != "")
        var g = checkTimePattern('startTime', 'uploadHotelFormS', 'uploadHotelFormW', 'Your start time is not formatted correctly');
    if (document.getElementById('endTime').value != "")
        var h = checkTimePattern('endTime', 'uploadHotelFormS', 'uploadHotelFormW', 'Your end time is not formatted correctly');
    if (document.getElementById('startTime').value != "" && document.getElementById('endTime').value != "") 
        var f = checkTimeBeforeTime('startTime', 'endTime', 'uploadHotelFormS', 'uploadHotelFormW', 'Your start time is not before your end time.');

    if (!(a || b || c || d || e || f || g || h)) {
        changeId('uploadHotelFormW', 'uploadHotelFormS');
        document.getElementById('hotelName').setCustomValidity("");
        document.getElementById('hotelDescription').setCustomValidity("");
        document.getElementById('startDate').setCustomValidity("");
        document.getElementById('endDate').setCustomValidity("");
        document.getElementById('startTime').setCustomValidity("");
        document.getElementById('endTime').setCustomValidity("");
    }
}

/**
 * check all the fields of the upload new room form
 */
function checkAllRoom() {
    var a = checkRadioChecked('radioHotel','uploadRoomFormS',"uploadRoomFormW",'You need to have a hotel checked');
    var b = checkMinMax('roomName',5,30,'uploadRoomFormS','uploadRoomFormW','You room name has to be between 5 and 30 characters.');
    var c = checkMinMax('roomDescription', 0, 200, 'uploadRoomFormS','uploadRoomFormW','Your description is longer than 200 characters.');
    var d = checkMinMax('cost',0,9999999999,'uploadRoomFormS','uploadRoomFormW','Your cost must be 0 or above', false);
    var e = checkDatePattern('startdate','uploadRoomFormS','uploadRoomFormW','Your start date is formatted incorrectly');
    var f = checkDatePattern('enddate','uploadRoomFormS','uploadRoomFormW','Your end date is formatted incorrectly');
    var g = checkIdBeforeId('startdate','enddate','uploadRoomFormS','uploadRoomFormW','Your start date is not before your end date.');
    var j = checkMinMax('timeslotmax',0,9999999999,'uploadRoomFormS','uploadRoomFormW','Your timeslot that you gave is less than 1 day.', false);
    
  if (!(a || b || c || d || e || f || g || j)) {
    changeId('uploadRoomFormW', 'uploadRoomFormS');
    document.getElementsByClassName('radioHotel')[0].setCustomValidity("");
    document.getElementById('roomName').setCustomValidity("");
    document.getElementById('roomDescription').setCustomValidity("");
    document.getElementById('startdate').setCustomValidity("");
    document.getElementById('enddate').setCustomValidity("");
    document.getElementById('timeslotmax').setCustomValidity("");
  }
}

/**
 * check all the fields of the edit room form
 */
function checkEditRoom() {
  var b = false;
  var c = false;
  var d = false;

  if (document.getElementById('roomName').value != "")
    b = checkMinMax('roomName',5,30,'uploadRoomFormS','uploadRoomFormW','You room name has to be between 5 and 30 characters.');
  if (document.getElementById('roomDescription').value != "")
    c = checkMinMax('roomDescription', 0, 200, 'uploadRoomFormS','uploadRoomFormW','Your description is longer than 200 characters.');
  if (document.getElementById('cost').value != "")
    d = checkMinMax('cost',0,9999999999,'uploadRoomFormS','uploadRoomFormW','Your cost must be above 0', false);

  if (!(b || c || d)) {
    changeId('uploadRoomFormW', 'uploadRoomFormS');
    document.getElementById('roomName').setCustomValidity("");
    document.getElementById('roomDescription').setCustomValidity("");
  }
}

/**
 * checks all the fields of the edit country form
 */
function checkCountry() {
  var a = checkMinMax('countryName',5,30,'uploadCountryFormS','uploadCountryFormW','The name of the country is not between 5 or 30 characters.');
  var b = checkMinMax('countryDescription',0,200,'uploadCountryFormS','uploadCountryFormW','Your description is too long');
  
  if (!(a || b)) {
    changeId('uploadCountryFormW', 'uploadCountryFormS');
    document.getElementById('countryName').setCustomValidity("");
    document.getElementById('countryDescription').setCustomValidity("");
  }
}

/**
 * gets the value from the html and checks if the given value is between the min and max
 * (or if isLength == false)
 * checks if value is between min and max
 * if condition failed -> changes ids to be able to 
 *
 * @param {*} id of the element you get the data from
 * @param {*} min the min value acceptable
 * @param {*} max the max value acceptable
 * @param {*} islength see if check needs to be taken the length or just the raw value
 * @param {*} before id from before
 * @param {*} after the id that needs to be changed into (before -> after)
 */
function checkMinMax(id, min, max, before, after, error, islength = true) {
    var check = document.getElementById(id).value;
    if (islength) 
        check = check.length
    if (check < min || check > max) {
      changeId(before, after);
      document.getElementById(id).setCustomValidity(error);
      return true;
    } else {
      return false;
    }
  }

  /**
 * checks if the pattern is formatted like a date of an element provided with an id
 * @param {*} id the id from the element
 * @param {*} before the id that was before
 * @param {*} after the id that has to be after when wrong
 * @param {*} error the error custom validity message that will be shown
 */
function checkDatePattern(id, before, after, error) {
    var check = document.getElementById(id).value;
    if (!/^\d{4}\-\d{2}\-\d{2}$/.test(check)) {
      changeId(before, after);
      document.getElementById(id).setCustomValidity(error);
      return true;
    } else {
      return false;
    }
  }


  /**
 * checks if the pattern is formatted like a time of an element provided with an id
 * @param {*} id the id from the element
 * @param {*} before the id that was before
 * @param {*} after the id that has to be after when wrong
 * @param {*} error the error custom validity message that will be shown
 */
function checkTimePattern(id, before, after, error) {
    var check = document.getElementById(id).value;
    if (!/^(2[0-3]|[01]?[0-9]):([0-5]?[0-9])$/.test(check)) {
      changeId(before, after);
      document.getElementById(id).setCustomValidity(error);
      return true;
    } else {
      return false;
    }
  }

  /**
 * checks if the first date is before the second date with entering ids
 * @param {*} firstDateId 
 * @param {*} secondDateId 
 * @param {*} before 
 * @param {*} after 
 * @param {*} error 
 */
function checkIdBeforeId(firstDateId, secondDateId, before, after, error) {
    var firstDate = document.getElementById(firstDateId).value;
    var secondDate = document.getElementById(secondDateId).value;
    if (new Date(firstDate) > new Date(secondDate)) {
      changeId(before, after);
      document.getElementById(firstDateId).setCustomValidity(error+" | First date: "+firstDate+" Second date: "+secondDate);
      return true;
    } else {
      return false;
    }
}

/**
 * checks if the first date is before the second date with entering the first date and giving the id for the sec
 * @param {*} firstDate 
 * @param {*} secondDateId 
 * @param {*} before 
 * @param {*} after 
 * @param {*} error 
 */
function checkDateBeforeId(firstDate, secondDateId, before, after, error) {
  var secondDate = document.getElementById(secondDateId).value;
  if (new Date(firstDate) > new Date(secondDate)) {
    changeId(before, after);
    document.getElementById(secondDateId).setCustomValidity(error+"| Your date: "+secondDate+" Available date: "+firstDate);
    return true;
  } else {
    return false;
  }
}

/**
 * checks if the first date is before the second date with entering the first id and giving the second date
 * @param {*} firstDate 
 * @param {*} secondDateId 
 * @param {*} before 
 * @param {*} after 
 * @param {*} error 
 */
function checkIdBeforeDate(firstDateId, secondDate, before, after, error) {
  var firstDate = document.getElementById(firstDateId).value;
  if (new Date(firstDate) > new Date(secondDate)) {
    changeId(before, after);
    document.getElementById(firstDateId).setCustomValidity(error+"| Your date: "+firstDate+" Available date: "+secondDate);
    return true;
  } else {
    return false;
  }
}

/**
 * checks if a the begin time is before the end time with entered ids
 * @param {*} beginTimeId 
 * @param {*} endTimeId 
 * @param {*} before 
 * @param {*} after 
 * @param {*} error 
 */
function checkTimeBeforeTime(beginTimeId, endTimeId, before, after, error) {
    var firstTime = document.getElementById(beginTimeId).value;
    var secondTime = document.getElementById(endTimeId).value;
    if (firstTime > secondTime) {
      changeId(before, after);
      document.getElementById(beginTimeId).setCustomValidity(error+" | Begin time: "+firstTime+" End time: "+secondTime);
      return true;
    } else {
      return false;
    }
}

function checkRadioChecked(className, before, after, error) {
    var radios = document.getElementsByClassName(className);
    for (var i = 0; i < radios.length; i++) {
        if (radios[i].checked)
        return false;
    }
    changeId(before, after);
    document.getElementsByClassName(className)[0].setCustomValidity(error);
    return true;
}

/**
 * gets the element by id from the html and changes it to this new id
 * @param {*} before 
 * @param {*} after 
 */
function changeId(before, after) {
    var element = document.getElementById(before);
    if (element != null)
      element.id = after;
  }