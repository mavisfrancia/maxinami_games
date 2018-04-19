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

	$('.inventory').change(function() {
		
		var inventory = $(this).val();
		if (validateIntegerInventory(inventory)) {
			$.ajax({
				url: "admin_update_itemlist.php",
				type: "post",
				data: encodeURI("action=update_inventory&id=" + $(this).parent().siblings(".item-id").html() + "&inventory=" + inventory),
				success: function(data) {
					
				},
				error: function() {
					alert("error!");
				}
			});
		} else {
			alert("ERROR: Quantities must be nonnegative integer values.");
			//location.reload();
		}
		
	});

	// returns true if qty is a postive integer (or string equivalent)
	function validateIntegerInventory(inventory) {
		if (Number.isInteger(inventory) && inventory >= 0)
			return true;

		if(typeof(inventory) === 'string') {
			var onlyDigits = inventory.match(new RegExp(/^[0-9]+$/, 'g'));
			if (onlyDigits)
				return true;
			else
				return false;
		}

		return false;
	};

	$('.delete-btn').click(function() {
		
		$.ajax({
			url: "admin_update_itemlist.php",
			type: "post",
			data: encodeURI("action=disable_item" + "&id=" + $(this).parent().siblings(".item-id").html()),
			success: function(data) {
				//alert(data);
				location.reload();
			},
			error: function(data) {
				alert("error! " + data);
			}
		});

	});

	$('.update-btn').click(function() {

		location.href = "product_info_form.php?" + encodeURI("action=update_product" + "&id=" + $(this).parent().siblings(".item-id").html());

	});
});