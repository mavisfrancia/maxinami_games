$(document).ready(function() {
	// Toggle content when respective tab is clicked
	$("#order-history-tab").click(function(event) {
		event.preventDefault();
		$("#order-history-tab").addClass("active");
		$("#account-info-tab").removeClass("active");
		$("#modify-items-tab").removeClass("active");

		$("#modify-items-card").addClass("hidden");
		$("#account-info-card").addClass("hidden");
		$("#order-history-card").removeClass("hidden");
	});
	$("#account-info-tab").click(function(event) {
		event.preventDefault();
		$("#account-info-tab").addClass("active");
		$("#order-history-tab").removeClass("active");
		$("#modify-items-tab").removeClass("active");

		$("#modify-items-card").addClass("hidden");
		$("#order-history-card").addClass("hidden");
		$("#account-info-card").removeClass("hidden");
	});
	$("#modify-items-tab").click(function(event) {
		event.preventDefault();
		$("#modify-items-tab").addClass("active");
		$("#order-history-tab").removeClass("active");
		$("#account-info-tab").removeClass("active");

		$("#order-history-card").addClass("hidden");
		$("#account-info-card").addClass("hidden");
		$("#modify-items-card").removeClass("hidden");
	});
});