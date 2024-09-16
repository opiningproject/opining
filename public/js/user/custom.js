// start sign in modal toggle password
const toggleSignInPassword = document.querySelector("#toggleSignInPassword");
const signInpassword = document.querySelector("#signin_id_password");

toggleSignInPassword.addEventListener("click", function (e) {
  // toggle the type attribute
  const type =
    signInpassword.getAttribute("type") === "password" ? "text" : "password";
  signInpassword.setAttribute("type", type);
  // toggle the eye slash icon
  this.classList.toggle("bi-eye");
});
// end sign in modal toggle password

// start sign up modal toggle password
const toggleSignUpPassword = document.querySelector("#toggleSignupPassword");
const signUpPassword = document.querySelector("#signup_id_password");

toggleSignUpPassword.addEventListener("click", function (e) {
  // toggle the type attribute
  const type =
    signUpPassword.getAttribute("type") === "password" ? "text" : "password";
  signUpPassword.setAttribute("type", type);
  // toggle the eye slash icon
  this.classList.toggle("bi-eye");
});
// end sign up modal toggle password

// start sign up modal toggle confirm password
const toggleSignUpConfirmPassword = document.querySelector(
  "#toggleSignupConfirmPassword"
);
const signUpConfirmPassword = document.querySelector(
  "#signup_confirm_id_password"
);

toggleSignUpConfirmPassword.addEventListener("click", function (e) {
  // toggle the type attribute
  const type =
    signUpConfirmPassword.getAttribute("type") === "password"
      ? "text"
      : "password";
  signUpConfirmPassword.setAttribute("type", type);
  // toggle the eye slash icon
  this.classList.toggle("bi-eye");
});
// end sign up modal toggle confirm password

$(document).ready(function () {
  $(".searcheatboxbtn").click(function () {
    $(".searcheatbox").toggleClass("main");
  });
});

//   food quantity

// start counter control
$(document).ready(function () {
  $(".count").prop("disabled", true);
  $(document).on("click", ".plus", function () {
    $(".count").val(parseInt($(".count").val()) + 1);
  });
  $(document).on("click", ".minus", function () {
    $(".count").val(parseInt($(".count").val()) - 1);
    if ($(".count").val() == 0) {
      $(".count").val(1);
    }
  });
});
