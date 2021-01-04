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
  } else {
    changeId(after, before);
    document.getElementById(id).setCustomValidity("");
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