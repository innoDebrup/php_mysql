const firstName = document.querySelector("#firstName");
const lastName = document.querySelector("#lastName");
const fullName = document.querySelector("#fullName");
// Regex to check that the string contains only alphabet characters.
const re = new RegExp("^[A-Za-z]+$"); 

/**
 * This Function Updates the value of the disabled FullName input field.
 * It concatenates firstName with lastName if the strings contain alphabets only.
 * The concatenated string is assigned as the fullName value.
 * If none of the firstName and lastName are in the required format then the fullName gets assigned an empty string.
 */
const update = function () {
  // Checks if the firstName contains alphabets only. If it fails then it enters the IF block.
  if (!re.test(firstName.value)) {
    // If-else structure for lastName. Same check is performed on lastName.
    if (re.test(lastName.value)) {
      fullName.value = `${lastName.value}`;
    } else {
      fullName.value = ``;
    }
  } else {
    // If-else structure for lastName. Same check is performed on lastName.
    if (re.test(lastName.value)) {
      fullName.value = `${firstName.value} ${lastName.value}`;
    } else {
      fullName.value = `${firstName.value}`;
    }
  }
};