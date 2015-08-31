function resetAlert() {
	$("#group-alert").removeClass("alert-success");
	$("#group-alert").removeClass("alert-info");
	$("#group-alert").removeClass("alert-warning");
	$("#group-alert").removeClass("alert-danger");
	$("#group-alert").html(null);
}

function dialogAlert(type, text) {
	resetAlert();
	$("#user-alert").addClass("alert-"+type);
	$("#user-alert").html(text);
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
	var firstName = $("#first-name");
	var lastName = $("#last-name");
	var emailAddress = $("#email");
	var admin = $("#admin");
	var group = $("#group");
	var groupValue = group.val();
	var groupAdmin = $("#group-admin");
	var groupAdminChecked = groupAdmin.checked;
	var level = $("#level");
	
	if (!firstName.val()) {
		dialogAlert("danger", "Please enter a first name.");
	} else if (!lastName.val()) {
		dialogAlert("danger", "Please enter a last name");
	} else if (!emailAddress.val()) {
		dialogAlert("danger", "Please enter a valid email.");
	} else if (group.val().length == 0 && groupAdmin.attr("checked")) {
		dialogAlert("danger", "A group must be selected in order for a user to be a 'Group Aministrator'.");		
	} else {
		dialogAlert("info", "Saving user information...");
		
		$.post("update_user_ajax.php", $("#user-form").serialize(), function(data, textStatus){
			if(data.status === "SUCCESS") {
				if (action === "DELETE") {
					$("#row-"+id).remove();
				} else if (action === "ADD") {
					location.reload();
				} else {	
					$("#group-name-"+id).html(name);
					$("#group-max-users-"+id).html(maxUsers);
					$("#group-dialog").modal('hide');
				}
			} else if (data.status === "ERROR") {
				dialogAlert("danger", textStatus);
			}  else {
				dialogAlert("danger", "Save failed!");
			}
		}).fail(function() {
			dialogAlert("danger", "Save failed!");
		});
	}
}