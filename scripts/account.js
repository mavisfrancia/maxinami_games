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

	$(".review-btn").click(function() {
		var item_id = $(this).parent().siblings(".item-id").html();

		// <form method="post" action="review.php">
  //         <input type="hidden" name="item-id" value="<?php echo $row['product_id']; ?>">
  //         <input type="hidden" name="action" value="add_review">
  //       </form>

  		var form = "<form method='post' action='review.php'>";
  		form += "<input type='hidden' name='item-id' value='" + item_id + "'>";
  		form += "<input type='hidden' name='action' value='add_review'>";

  		$(form).appendTo($(document.body)).submit();




	})



});