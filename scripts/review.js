$(document).ready( function() {
	$("#submit-btn").click( function(event) {
		event.preventDefault();
		var rating = $("#rating").val();
		var description = $("#review-description").val();
		var id = $("#item-id").html();

		$.ajax({
			url: "review_item.php",
			type: "post",
			data: encodeURI("action=add_review" + "&id=" + id + "&rating=" + rating + "&description=" + description),
			success: function(data) {
				alert(data);
				//location.href = "account.php";
			},
			error: function(data) {
				alert("error! " + data);
			}
		});

	});
});