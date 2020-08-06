$(document).ready(function(){
razmessage();
});

function razmessage(){
$("#message-warning").hide();
$("#message-warning-custom").hide();
$("#message-error").hide();
$("#message-success").hide();
}

function close_message_warning(){
$("#message-warning").slideUp("slow");
}

function close_message_warning_custom(){
$("#message-warning-custom").slideUp("slow");
}

function close_message_error(){
$("#message-error").slideUp("slow");
}

function close_message_success(){
$("#message-success").slideUp("slow");
}

function processing_show(){
$("#processing").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%;'>&nbsp;&nbsp;Processing...&nbsp;&nbsp;</div></div>");
$("#processing").show();
}

function processing_hide(){
$("#processing").hide();
}

function add(){
processing_show();
document.forms["upload_form"].submit();
}
