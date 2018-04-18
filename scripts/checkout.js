$("document").ready(function() {
	$("#create-account-check").click(function() {
		if($("#create-account-check").is(':checked'))
		    $("#password-input-group").removeClass("hidden");
		else
		    $("#password-input-group").addClass("hidden");
		
	});
});