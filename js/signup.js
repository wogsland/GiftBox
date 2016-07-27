function signupOpen() {
  signupClear();
  $("#signup-dialog").modal();
}

function signupClear() {
  $('#signup-alert-placeholder').html('<div></div>');
  $('#first_name').val("");
  $('#last_name').val("");
  $('#signup_email').val("");
  $('#signup_password').val("");
}

function signupClose() {
  $('#signup-dialog').modal('hide');
}

function signupError(message) {
  $('#signup-alert-placeholder').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');
}

function signupInfo(message) {
  $('#signup-alert-placeholder').html('<div class="alert alert-info"><span>'+message+'</span></div>');
}

function signupSuccess(app_root, signupType, userInfo) {
  var email = $("#signup_email").val();
  $('#signup-alert-placeholder').html('<div class="alert alert-success"><span>You have successfully signed up with S!zzle!</span></div>');
  signupClose();
  window.location = '/thankyou?action=signup&email='+email;
}

function signupEmail() {
  $("#reg_type").val("EMAIL");
  if (!$("#signup_email").val()) {
    signupError("Please enter a valid email.");
  } else if (!$("#signup_password").val()) {
    signupError("Please enter a password.");
  } else {
    processSignup($("#signup-form").serialize(), "EMAIL");
  }
}

function processSignup(userInfo, signupType) {
  signupInfo("Processing your registration.  Please wait...");
  $('.dialog-button-center').addClass("disable-clicks");
  $.post("/ajax/signup", userInfo, function(data, textStatus, jqXHR){
    if(data.status === "SUCCESS") {
      signupSuccess(data.app_root, signupType, userInfo);
    } else if (data.status === "ERROR") {
      signupError(data.message);
    }  else {
      signupError("Unknown return status: "+data.status);
    }
  }).fail(function() {
    signupError("Sign up failed.");
  }).always(function() {
    $('.dialog-button-center').removeClass("disable-clicks");
  });
}

function switchToLogin() {
  signupClose();
  loginOpen();
}
