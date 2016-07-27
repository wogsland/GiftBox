function loginOpen() {
  loginClear();
  $("#login-dialog").modal();
}

function loginClear() {
  $('#login-alert-placeholder').html('<div></div>');
  $('#login_email').val("");
  $('#password').val("");
}

function loginClose() {
  $('#login-dialog').modal('hide');
}

function loginError(message) {
  $('#login-alert-placeholder').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');
}

function loginInfo(message) {
  $('#login-alert-placeholder').html('<div class="alert alert-info"><span>'+message+'</span></div>');
}

function loginSuccess(app_root) {
  $('#login-alert-placeholder').html('<div class="alert alert-success"><span>You have successfully logged into S!zzle.</span></div>');
  setTimeout(function(){
    $('#login-dialog').modal('hide');
    document.location.href = app_root;
  }, 500);
}

function getQueryParameters(str) {
  // Taken from https://github.com/youbastard/jquery.getQueryParameters/blob/master/qp.js
  return (str || document.location.search).replace(/(^\?)/, '').split("&").map(function (n) {
    return n = n.split("="), this[n[0]] = n[1], this;
  }.bind({}))[0];
}

function processLogin(userInfo) {
  loginInfo("Logging into S!zzle.  Please wait...");
  $('.dialog-button-center').addClass("disable-clicks");
  $.post("/ajax/login", userInfo, function(data, textStatus, jqXHR){
    if(data.status === "SUCCESS") {
      var redirect = decodeURIComponent(getQueryParameters()['next']);
      if (redirect == 'undefined') {
        redirect = "profile";
      }
      if (redirect.startsWith('/')) {
        redirect = redirect.slice(1);
      }
      loginSuccess(data.app_root+redirect);
    } else if (data.status === "ERROR") {
      loginError("Login failed. "+data.message);
    }  else {
      loginError("Login failed. Unknown return status: "+data.status);
    }
  }).fail(function() {
    loginError("Login failed.");
  }).always(function() {
    $('.dialog-button-center').removeClass("disable-clicks");
  });
}

function loginEmail() {
  if (!$("#login_email").val()) {
    loginError("An email address is required when logging in with email.");
  } else if (!$("#password").val()) {
    loginError("A password is required when logging in with email.");
  } else {
    processLogin($("#login-form").serialize());
  }
}

/* For handeling pressing enter to Submit... why are the buttons not in the form to begin with? */
$('#login_email').keypress(function(e) {
if (e.which == '13') {
         loginEmail();
   }
});
$('#password').keypress(function(e) {
if (e.which == '13') {
         loginEmail();
   }
});
