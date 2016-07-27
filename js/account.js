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

function logout() {
  $('#logout-button').addClass("disable-clicks");
  $.post("/ajax/logout", function(data, textStatus, jqXHR){
    if (data.status === "SUCCESS") {
      document.location.href = data.app_root;
    } else if (data.status === "ERROR") {
      alert(data.message);
    }  else {
      alert("Unknown return status: "+data.status);
    }
  }).fail(function() {
    alert("Logout failed.");
  }).always(function() {
    $('#logout-button').removeClass("disable-clicks");
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
