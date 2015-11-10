function resetAlert() {
	$("#group-alert").removeClass("alert-success");
	$("#group-alert").removeClass("alert-info");
	$("#group-alert").removeClass("alert-warning");
	$("#group-alert").removeClass("alert-danger");
	$("#group-alert").html(null);
}

function openModal() {
	resetAlert();
	$("#group-name").attr('readonly', false);
	$("#group-max-users").attr('readonly', false);
	$("#group-dialog").modal();

}
function alertGroup(type, text) {
	resetAlert();
	$("#group-alert").addClass("alert-"+type);
	$("#group-alert").html(text);
}

function addGroup() {
	$("#modal-title").html("Add Group");
	$("#action-button").html("Add");
	$("#action").val("ADD");
	$("#group-id").val("");
	$("#group-name").val("");
	$("#group-max-users").val(0);
	openModal();
}

function editGroup(id) {
	$("#modal-title").html("Edit Group");
	$("#action-button").html("Save");
	$("#action").val("EDIT");
	$("#group-id").val(id);
	$("#group-name").val($("#group-name-"+id).html());
	$("#group-max-users").val($("#group-max-users-"+id).html());
	openModal();
}

function deleteGroup(id) {
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

function saveGroup() {
	var id = $("#group-id").val();
	var name = $("#group-name").val();
	var maxUsersText = $("#group-max-users").val();
	var maxUsers = parseInt($("#group-max-users").val());
	var users = parseInt($("#group-max-users-"+id).html());
	var action = $("#action").val();
	if (name.length === 0) {
		alertGroup("danger", "The group name cannot be left blank.");
	} else if (maxUsersText.length === 0) {
		alertGroup("danger", "The maximum number of users cannot be left blank.");
	} else if (maxUsers < users) {
		alertGroup("danger", "The maximum number of users cannot be less than the current number of users.");
	} else {
		alertGroup("info", "Saving...")
		$.post("/ajax/user_group/save", $("#group-form").serialize(), function(data, textStatus){
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
				alertGroup("danger", textStatus)
			}  else {
				alertGroup("danger", "Save failed!")
			}
		}).fail(function() {
			alertGroup("danger", "Save failed!")
		});
	}
}
