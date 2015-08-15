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
	openModal();
}

function editGroup(id) {
	$("#modal-title").html("Edit Group");
	$("#action-button").html("Save");
	$("#action").val("EDIT");
	$("#group-id").val(id);
	$("#group-name").val($("#group-name-"+id).html());
	openModal();
}

function deleteGroup(id) {
	$("#modal-title").html("Delete Group");
	$("#action-button").html("Delete");
	$("#action").val("DELETE");
	$("#group-id").val(id);
	$("#group-name").val($("#group-name-"+id).html());
	openModal();
	alertGroup("warning", "Are you sure you want to delete this group?")
	$("#group-name").attr('readonly', true);
	
}

function saveGroup() {
	var id = $("#group-id").val();
	var name = $("#group-name").val();
	if (name.length === 0) {
		alertGroup("danger", "The group name cannot be left blank.");
	} else {
		alertGroup("info", "Saving...")
		$.post("save_group_ajax.php", $("#group-form").serialize(), function(data, textStatus){
			if(data.status === "SUCCESS") {
				$("#group-dialog").modal('hide');
				location.reload();
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