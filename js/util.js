var confirmOnPageExit = function(e)
{
    // If we haven't been passed the event get the window.event
    e = e || window.event;

    var message = 'Any unsaved changes will be lost!';

    // For IE6-8 and Firefox prior to version 4
    if (e)
    {
        e.returnValue = message;
    }

    // For Chrome, Safari, IE8+ and Opera 12+
    return message;
};

function saved () {
	window.onbeforeunload = null;
}

function unsaved() {
	window.onbeforeunload = confirmOnPageExit;
}

$(function() {
	$( "#status-dialog" ).dialog({
		autoOpen: false,
		modal: true,
		dialogClass: "no-close"
	});
});

$(function() {
	$( "#message-dialog" ).dialog({
		autoOpen: false,
		modal: true,
		buttons: {
			OK: function() {
				$(this).dialog("close");
			}
		}
	});
});

function get_browser_info(){
    var ua=navigator.userAgent,tem,M=ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
    if(/trident/i.test(M[1])){
        tem=/\brv[ :]+(\d+)/g.exec(ua) || [];
        return {name:'IE ',version:(tem[1]||'')};
        }
    if(M[1]==='Chrome'){
        tem=ua.match(/\bOPR\/(\d+)/);
        if(tem!==null)   {
          return {name:'Opera', version:tem[1]};
        }
    }
    M=M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
    if((tem=ua.match(/version\/(\d+)/i))!==null) {M.splice(1,1,tem[1]);}
    return {
      name: M[0],
      version: M[1]
    };
 }

function openStatus(title, text) {
	$("#status-dialog").dialog( "option", "title", title);
	$("#status-text").text(text);
	$("#status-dialog").dialog("open");
}

function closeStatus() {
	$("#status-dialog" ).dialog("close");
}

function setStatus(text) {
	$("#status-text").text(text);
}

function openMessage(title, text) {
	$("#message-dialog").dialog( "option", "title", title);
	$("#message-text").text(text);
	$("#message-dialog").dialog("open");
}

document.write('\
<style>\
	#message-text {\
		font-size: 16px;\
	}\
\
	#status-text {\
		font-size: 16px;\
	}\
</style>\
\
\
	<div id="status-dialog" title="No title specified">\
		<p id="status-text" style="text-align: center"></p>\
	</div>\
\
	<div id="message-dialog" title="No title specified">\
		<p id="message-text" style="text-align: center"></p>\
	</div>\
');
