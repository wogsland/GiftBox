function getSession() {
  var session = null;
  $.ajax({
    url: "/ajax/get_session",
    async: false
  }).done(function(data, textStatus, jqXHR){
    session = data;
  });
  return session;
}

function changePassword() {
  var newPassword = $("#new-password").val();
  var confirmPassword = $("#confirm-password").val();
  if (!newPassword) {
    $("#change-password-message").text("Please enter a new password.");
  } else if (!confirmPassword) {
    $("#change-password-message").text("Please confirm the new password");
  } else if (newPassword !== confirmPassword) {
    $("#change-password-message").text("Passwords do not match.");
  } else {
    var eventTarget = event.target;
    $(eventTarget).addClass("disable-clicks");
    $.post("/ajax/change_password", {new_password: newPassword, user_id: 125}, function(data, textStatus, jqXHR){
      $.magnificPopup.close();
      $("#my-account-message").text("Your password has been changed.");
    }).fail(function(){
      alert("Change password failed.");
    }).always(function() {
      $(eventTarget).removeClass("disable-clicks");
    });
  }
}

function logout() {
  var eventTarget = event.target;
  $(eventTarget).addClass("disable-clicks");
  $.post("/ajax/logout", function(data, textStatus, jqXHR){
    if (data.status === "SUCCESS") {
      if (data.login_type === "FACEBOOK") {
        FB.getLoginStatus(function(response) {
          // are they currently logged into Facebook?
          if (response.status === 'connected') {
            //they were authed so do the logout
            FB.logout(function(response) {
            });
          }
        });
      }
      document.location.href = data.app_root;
    } else if (data.status === "ERROR") {
      alert(data.message);
    }  else {
      alert("Unknown return status: "+data.status);
    }
  }).fail(function() {
    alert("Logout failed.");
  }).always(function() {
    $(eventTarget).removeClass("disable-clicks");
  });
}

function showStatus(id, text) {
  $(id).removeClass("red-text");
  $(id).text(text);
}

function showError(id, text) {
  $(id).addClass("red-text");
  $(id).text(text);
}

function saveMyAccount() {
  if (!$("#first-name").val()) {
    showError("#my-account-message", "Please enter a first name.");
  } else if (!$("#last-name").val()) {
    showError("#my-account-message", "Please enter a last name");
  } else if (!$("#email").val()) {
    showError("#my-account-message", "Please enter a valid email.");
  } else {
    showStatus("#my-account-message", "Saving account information...");
    var eventTarget = event.target;
    $(eventTarget).addClass("disable-clicks");
    var posting = $.post("/ajax/user/update", $("#account-form").serialize());

    posting.done(function(data) {
      showStatus("#my-account-message", "Your account changes have been saved.");
    });

    posting.fail(function(data, textStatus) {
      showError("#my-account-message", textStatus);
    });

    posting.always(function() {
      $(eventTarget).removeClass("disable-clicks");
    });
  }
}
