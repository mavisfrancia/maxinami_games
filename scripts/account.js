$(document).ready(function() {
	// Toggle content when respective tab is clicked
	$("#order-history-tab").click(function(event) {
		event.preventDefault();
		$("#order-history-tab").addClass("active");
		$("#account-info-tab").removeClass("active");
		$("#account-info-card").addClass("hidden");
		$("#order-history-card").removeClass("hidden");
	});
	$("#account-info-tab").click(function(event) {
		event.preventDefault();
		$("#account-info-tab").addClass("active");
		$("#order-history-tab").removeClass("active");
		$("#order-history-card").addClass("hidden");
		$("#account-info-card").removeClass("hidden");
	});
});