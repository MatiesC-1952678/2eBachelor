function checkBooking(timeslot,start,end) {
    var a = checkDatePattern('startDate','formS','formW','Your starting date is formatted incorrectly');
    var b = checkDatePattern('endDate','formS','formW','Your ending date is formatted incorrectly');
    var c = checkIdBeforeId('startDate','endDate','formS','formW','Your start date is not before your end date');
    var d = checkDateBeforeId(start, 'startDate', 'formS', 'formW', 'Your start date is before the first day that your room is available')
    var e = checkIdBeforeDate('endDate', end, 'formS', 'formW', 'Your end date is after the last day that your room is available' )
    var f = checkTimeslot(timeslot,'startDate','endDate','formS','formW');

    if (!(a || b || c || d || e || f)) {
        changeId('formW', 'formS');
        document.getElementById('startDate').setCustomValidity("");
        document.getElementById('endDate').setCustomValidity("");
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
 * 
 * @param {*} timeslot 
 * @param {*} startDateId 
 * @param {*} endDateId 
 */
function checkTimeslot(timeslot, startDateId, endDateId, before, after) {
  var startDate = new Date(document.getElementById(startDateId).value);
  var endDate = new Date(document.getElementById(endDateId).value);
  var dayDiff = (endDate.getTime() - startDate.getTime()) / (1000 * 3600 * 24); 
  if (timeslot != null && dayDiff > timeslot) {
      changeId(before, after);
      document.getElementById(endDateId).setCustomValidity("The amount of days that you stay exceeds the maximum allowed of days (check timeslot). | Amount of days: "+dayDiff+" Max timeslot: "+timeslot);
      return true;
  } else {
      return false;
  }
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