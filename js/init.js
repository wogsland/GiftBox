$(function() {
	$( "#add-dialog" ).dialog({
		open: function(event, ui) { $(".ui-dialog-titlebar-close").hide()},
		dialogClass: 'add-dialog-class',
		autoOpen: false,
		resizable: false,
		width: 620,
		height: 580,
		modal: true,
	});
});

$(function() {
	$( "#send-dialog" ).dialog({
		autoOpen: false,
		resizable: false,
		width: 800,
		height: 300,
		modal: true,
		buttons: {
			Send: function() {
				sendToken();
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
				openURL();
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		},
		open: function() {
			$("#url-dialog").keypress(function(e) {
				if (e.keyCode == $.ui.keyCode.ENTER) {
					openURL();
					return false;
				}
			});
		}
	});
});


$(function() {
	$( "#add-hyperlink-dialog" ).dialog({ 
		autoOpen: false,
		resizable: false,
		height:200,
		width: 600,
		modal: true,
		buttons: {
			Ok: function() {
				addImageHyperlink();
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		},
		open: function() {
			$("#add-hyperlink-dialog").keypress(function(e) {
				if (e.keyCode == $.ui.keyCode.ENTER) {
					addImageHyperlink();
					return false;
				}
			});
		}
	});
});

$(function() {
	$( "#image-dialog" ).dialog({ 
		autoOpen: false,
		resizable: false,
		height:400,
		width: 300
	});
});

$(function() {
	$( "#facebook-album-dialog" ).dialog({
		open: function(){ $("#facebook-albums").trigger("click"); },
		dialogClass: 'facebook-dialog-class',
		autoOpen: false,
		resizable: false,
		width: 620,
		height: 580,
		modal: true,
		buttons: {
			Cancel: function() {
				$( this ).dialog( "close" );
				document.getElementById('facebook-albums').innerHTML = "";
			}
		},
	});
});

$(function() {
	$( "#facebook-photos-dialog" ).dialog({
		dialogClass: 'facebook-dialog-class',
		autoOpen: false,
		resizable: false,
		width: 620,
		height: 580,
		modal: true,
		buttons: {
			Ok: function() {
				addFacebookImage();
			},
			Back: function() {
				$( this ).dialog( "close" );
				$( this ).empty();
				$( this ).html('<div id="facebook-photos" onClick="getFacebookPhotos()"></div>');
				$( "#facebook-album-dialog" ).dialog( "open" );
			}
		},
	});
});

$(function() {
	$( "#facebook-login-fail-dialog" ).dialog({
		dialogClass: 'facebook-fail-dialog-class',
		autoOpen: false,
		resizable: false,
		width: 200,
		height: 200,
		modal: true,
		buttons: {
			Back: function() {
				$( this ).dialog( "close" );
				$("#facebook-album-dialog").dialog("close");
			}
		},
	});
});