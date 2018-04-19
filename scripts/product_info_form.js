$(document).ready(function() {
	$("#product-image").change(function(event) {
		var fakepath = $("#product-image").val();
		var pieces = fakepath.split(/[\s\/\\]+/);
		$("#product-image-label").html(pieces[pieces.length-1]);
	});

	$("#submit-btn").click(function(event) {
		event.preventDefault();

		var form = $('#product-form')[0];
		var data = new FormData(form);

		var name = $("#product-name").val();
		var type = $("#product-type").val();
		var description = $("#product-description").val();
		var inventory = $("#product-inventory").val();
		var price = $("#product-price").val();

		if(validate(name, type, description, inventory, price)) {
			$.ajax({
	            type: "POST",
	            enctype: 'multipart/form-data',
	            url: "admin_update_itemlist.php",
	            data: data,
	            processData: false,
	            contentType: false,
	            cache: false,
	            timeout: 600000,
	            success: function (data) {
	            	location.href = "account.php";
	            },
	            error: function (e) {
	            	alert("ERROR: " + e);
	            }
	        });
		}

	});

	function validate(name, type, description, inventory, price) {
		if (name === '' || name === null)
			return false;
		if (isNaN(type) || type < 1 || type > 4)
			return false;
		if (isNaN(inventory) || inventory < 0)
			return false;
		if (isNaN(price) || price < 0)
			return false;
		return true;
	}



});