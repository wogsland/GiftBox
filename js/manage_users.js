function resetAlert() {
	$("#dialog-alert").removeClass("alert-success");
	$("#dialog-alert").removeClass("alert-info");
	$("#dialog-alert").removeClass("alert-warning");
	$("#dialog-alert").removeClass("alert-danger");
	$("#dialog-alert").html(null);
}

function dialogAlert(type, text) {
	resetAlert();
	$("#dialog-alert").addClass("alert-"+type);
	$("#dialog-alert").html(text);
}

function openModal() {
	resetAlert();
	$("#user-dialog").modal();
}

function addUser() {
	$("#modal-title").html("Add User");
	$("#action-button").html("Add");
	$("#action").val("ADD");
	$("#user-id").val("");
	$("#first-name").val("");
	$("#last-name").val("");
	$("#email").val("");
	$("#password").val("");
	$("#level").val(1);
	$("#group").val("");
	$("#group-admin").prop("checked", false);
	$("#admin").prop("checked", false);
	openModal();
}

function editUser(id) {
	$("#modal-title").html("Edit User");
	$("#action-button").html("Save");
	$("#action").val("EDIT");
	$("#user-id").val(id);
	$("#first-name").val($("#first-name-"+id).html());
	$("#last-name").val($("#last-name-"+id).html());
	$("#email").val($("#email-"+id).html());
	$("#password").val("");
	var value = $("#level-"+id).html();
	$('#level').val($("#level-"+id).html() == "Basic" ? 1 : 2);
	if ($("#admin-"+id).html() === 'Y') {
		$("#admin").prop("checked", true);
	} else {
		$("#admin").prop("checked", false);
	}
	var groupName = $("#group-"+id).html();
	$("#group > option").each(function() {
		if (this.text == groupName) {
			$("#group").val(this.value);
		}
	});	
	if ($("#group-admin-"+id).html() === 'Y') {
		$("#group-admin").prop("checked", true);
	} else {
		$("#group-admin").prop("checked", false);
	}
	
	openModal();
}

function deleteUser(id) {
	var users = $("#group-users-"+id).html();
	if (users > 0) {
		
	} else {
		$("#modal-title").html("Delete Group");
		$("#action-button").html("Delete");
		$("#action").val("DELETE");
		$("#group-id").val(id);
		$("#group-name").val($("#group-name-"+id).html());
		$("#group-max-users").val($("#group-max-users-"+id).html());
		openModal();
		alertGroup("warning", "Are you sure you want to delete this group?")
		$("#group-name").attr('readonly', true);
		$("#group-max-users").attr('readonly', true);
	}	
}

function saveUser() {
	var id = $("#user-id").val();
	var firstName = $("#first-name").val();
	var lastName = $("#last-name").val();
	var email = $("#email").val();
	var level = $("#level").val();
	var group = $("#group");
	var groupAdmin = $("#group-admin");
	var admin = $("#admin");
	var action = $("#action").val();
	
	if (!firstName) {
		dialogAlert("danger", "Please enter a first name.");
	} else if (!lastName) {
		dialogAlert("danger", "Please enter a last name");
	} else if (!email) {
		dialogAlert("danger", "Please enter a valid email.");
	} else if (group.val().length == 0 && groupAdmin.prop("checked")) {
		dialogAlert("danger", "A group must be selected in order for a user to be a 'Group Aministrator'.");		
	} else {
		dialogAlert("info", "Saving user information...");
		
		$.post("update_user_ajax.php", $("#user-form").serialize(), function(data, textStatus){
			if(data.status === "SUCCESS") {
				dialogAlert("success", "Saved.")
				if (action === "DELETE") {
					$("#row-"+id).remove();
				} else if (action === "ADD") {
					location.reload();
				} else {	
					$("#first-name-"+id).html(firstName);
					$("#last-name-"+id).html(lastName);
					$("#email-"+id).html(email);
					$("#level-"+id).html(level == 1 ? "Basic" : "Standard");
					$("#group-"+id).html($("#group option:selected").text());
					var yesNo = groupAdmin.is(":checked") ? "Y" : "N";
					$("#group-admin-"+id).html(yesNo);
					yesNo = admin.is(":checked") ? "Y" : "N";
					$("#admin-"+id).html(yesNo);
					$("#user-dialog").modal('hide');
				}
			} else if (data.status === "ERROR") {
				dialogAlert("danger", data.message);
			}  else {
				dialogAlert("danger", "Save failed!");
			}
		}).fail(function() {
			dialogAlert("danger", "Save failed!");
		});
	}
}