$(document).ready(function() {
	$("#add-to-cart-btn").click(function() {
		$.ajax({
			url: "addtocart.php",
			type: "post",
			data: encodeURI("id=" + $(this).siblings(".itemid").html()),
			success: function(data) {
				alert("Added to cart!");
				alert(data);
			},
			error: function() {
				alert("error!");
			}
		});
	});

});