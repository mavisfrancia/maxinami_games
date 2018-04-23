$(document).ready( function() {
	$("#submit-btn").click( function(event) {
		event.preventDefault();
		var rating = $("#rating").val();
		var description = $("#review-description").val();
		var id = $("#item-id").html();

		var action = "";

		if ($("#submit-btn").html() == "Submit") {
			action = "add_review";
		}
		if ($("#submit-btn").html() == "Update"){
			action = "update_review";
		}

		$.ajax({
			url: "review_item.php",
			type: "post",
			data: encodeURI("action=" + action + "&id=" + id + "&rating=" + rating + "&description=" + description),
			success: function(data) {
				alert("Review submitted");
				location.href = "account.php";
			},
			error: function(data) {
				alert("error! " + data);
			}
		});

	});
});