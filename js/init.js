$(function() {
	$( "#tabs" ).tabs();
});

$(function() {
	$( "#letter-dialog" ).dialog({
		autoOpen: false,
		resizable: false,
		width: 800,
		height: 600,
		modal: true,
		buttons: {
			OK: function() {
				saveLetter();
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	});
});

$(function() {
	$( "#open-dialog" ).dialog({
		autoOpen: false,
		resizable: false,
		width: 400,
		height: 300,
		modal: true,
		buttons: {
			Open: function() {
				loadSaved();
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	});
});

$(function() {
	$("#unload-count").bind("keydown", function (event) {
		event.preventDefault();
	});			
	$( "#unload-count" ).spinner({min: 0, max: 20});
	$( "#wrapper-dialog" ).dialog({
		autoOpen: false,
		resizable: false,
		width: 500,
		height: 250,
		modal: true,
		buttons: {
			OK: function() {
				save_wrapper();
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	});
});

$(function() {
	$( "#save-dialog" ).dialog({ 
		autoOpen: false,
		resizable: false,
		height:200,
		width: 400,
		modal: true,
		buttons: {
			Save: function() {
				save();
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		},
		open: function() {
			$("#save-dialog").keypress(function(e) {
				if (e.keyCode == $.ui.keyCode.ENTER) {
					save();
					return false;
				}
			});
		}
	});
});

$(function() {
	$( "#url-dialog" ).dialog({ 
		autoOpen: false,
		resizable: false,
		height:200,
		width: 600,
		modal: true,
		buttons: {
			Ok: function() {
				addURL();
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		},
		open: function() {
			$("#url-dialog").keypress(function(e) {
				if (e.keyCode == $.ui.keyCode.ENTER) {
					addURL();
					return false;
				}
			});
		}
	});
});

$(function() {
	$( "#confirm-dialog" ).dialog({
		autoOpen: false,
		resizable: false,
		height:200,
		width: 400,
		modal: true,
		buttons: {
			OK: function() {
				$( this ).dialog( "close" );
			}
		}
	});
});