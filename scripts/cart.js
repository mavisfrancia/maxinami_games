$(document).ready(function() {
	$('.qty-input').change(function() {
		var qty = $(this).val();
		if (validateIntegerQty(qty)) {
			if($(this).val() == 0) {
				$.ajax({
					url: "removefromcart.php",
					type: "post",
					data: encodeURI("id=" + $(this).parent().siblings(".itemid").html()),
					success: function(data) {
						location.reload();
					},
					error: function() {
						alert("error!");
					}
				});
			} else {
				$.ajax({
					url: "updatecart.php",
					type: "post",
					data: encodeURI("id=" + $(this).parent().siblings(".itemid").html() + "&qty=" + qty),
					success: function(data) {
						location.reload();
					},
					error: function() {
						alert("error!");
					}
				});
			}
		} else {
			alert("ERROR: Quantities must be nonnegative integer values.");
			location.reload();
		}
		
	});

	// returns true if qty is a postive integer (or string equivalent)
	function validateIntegerQty(qty) {
		if (Number.isInteger(qty) && qty >= 0)
			return true;

		if(typeof(qty) === 'string') {
			var onlyDigits = qty.match(new RegExp(/^[0-9]+$/, 'g'));
			if (onlyDigits)
				return true;
			else
				return false;
		}

		return false;
	};

	$('.delete-btn').click(function() {
		$.ajax({
			url: "removefromcart.php",
			type: "post",
			data: encodeURI("id=" + $(this).parent().siblings(".itemid").html()),
			success: function(data) {
				location.reload();
			},
			error: function() {
				alert("error!");
			}
		});

	});

	$("#checkout-btn").click(function() {
		location.href = "checkout.php";
	});

	$("#checkout-prompt-btn").click(function() {
		location.href = "signinorguest.php";
	});

});

