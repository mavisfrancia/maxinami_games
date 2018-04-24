$("document").ready(function() {
	if(validateFields()) {
		if ($("#create-account-check").is(':checked')) {
			checkIfUsernameAvailable($(this).val());
		} else {
			$("#checkout-btn").prop("disabled", false);
		}
	} else {
		$("#checkout-btn").prop("disabled", true);
	}


	$("#create-account-check").click(function() {
		if($("#create-account-check").is(':checked')) {
		    $("#password-input-group").removeClass("hidden");
		    checkIfUsernameAvailable($("#email").val());
		}
		else {
		    $("#password-input-group").addClass("hidden");
		    if ($("#email").next().is(".error-msg")) {
		    	if ($("#email").next().html() === "Email address already exists in system") {
		    		$("#email").next().remove();
		    	}
		    }
		}
	});

	$("#checkout-form input").blur(function() {
		if(validateFields()) {
			if ($("#create-account-check").is(':checked')) {
				checkIfUsernameAvailable($(this).val());
			} else {
				$("#checkout-btn").prop("disabled", false);
			}
		} else {
			$("#checkout-btn").prop("disabled", true);
		}
	});

	$("#checkout-form input").click(function() {
		$(this).siblings(".error-msg").remove();
	})

	$("#name").blur(function() {
		if (!$(this).val())
			$("<p>Name is required</p>").addClass("error-msg").insertAfter(this);
	});

	$("#address").blur(function() {
		if (!$(this).val())
			$("<p>Address is required</p>").addClass("error-msg").insertAfter(this);
	});

	$("#email").blur(function() {
		if (!$(this).val())
			$("<p>Email is required</p>").addClass("error-msg").insertAfter(this);
		else if (!isValidEmail($(this).val()))
			$("<p>Invalid email address</p>").addClass("error-msg").insertAfter(this);
		else {
			if ($("#create-account-check").is(':checked')) {
				checkIfUsernameAvailable($(this).val());
			}
		}
	});

	$("#phone").blur(function() {
		if ($(this).val()) {
			if (!isValidPhoneNumber($(this).val()))
				$("<p>Invalid phone number</p>").addClass("error-msg").insertAfter(this);
		}
	});

	$("#credit-card").blur(function() {
		if (!$(this).val())
			$("<p>Credit card is required</p>").addClass("error-msg").insertAfter(this);
		else if (!isValidCreditCard($(this).val()))
			$("<p>Invalid credit card number</p>").addClass("error-msg").insertAfter(this);
	});

	$("#password").blur(function() {
		if (!$(this).val())
			$("<p>Password is required</p>").addClass("error-msg").insertAfter(this);
	});

	$("#password-verify").blur(function() {
		if (!$(this).val())
			$("<p>Verify password is required</p>").addClass("error-msg").insertAfter(this);
		else if ($(this).val() !== $("#password").val())
			$("<p>Passwords do not match</p>").addClass("error-msg").insertAfter(this);
	});

	function checkIfUsernameAvailable(email) {
		$.ajax({
			url: "check_if_username_available.php",
			type: "post",
			data: encodeURI("username=" + $("#email").val()),
			success: function(data) {
				//alert("DATA: " + data + " TYPE: " + typeof(data));
				if(data == "false") {
					if ($("#email").siblings(".error-msg").length === 0)
						$("<p>Email address already exists in system</p>").addClass("error-msg").insertAfter("#email");
					$("#checkout-btn").prop("disabled", true);
				} else {
					$("#checkout-btn").prop("disabled", false);
				}
			},
			error: function(data) {
				alert("error! " + data);
			}
		});
	}

	function isValidEmail(email) {
		var isEmailRegex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    	return isEmailRegex.test(email);
	}

	function isValidPhoneNumber(phone) {
		var isPhoneRegex = /^(\(\d{3}\) {0,1}\d{3}-\d{4}|(\d-){0,1}\d{3}-\d{3}-\d{4}|\d{10,11})$/;
    	return isPhoneRegex.test(phone);
	}

	function isValidCreditCard(card) {
		var isCreditCardRegex = /^[0-9]{16}$/;
		return isCreditCardRegex.test(card);
	}

	function validateFields() {
		var name = $("#name").val(); //non-empty
		var address = $("#address").val(); //non-empty
		var email = $("#email").val(); //email format
		var phone = $("#phone").val(); //(optional) all numeric
		var credit_card = $("#credit-card").val(); //16 numeric
		var create_account_is_checked = $("#create-account-check").is(':checked');
		var password = $("#password").val();
		var password_verify = $("#password-verify").val();

		if (!name || !address || !isValidEmail(email) || !isValidCreditCard(credit_card)) {
			return false;
		}

		if (phone && !isValidPhoneNumber(phone)) {
			return false;
		}

		if (create_account_is_checked) {
			if (!password || !password_verify)
				return false;
			if (password !== password_verify)
				return false;
		}

		return true;
	}

	$("#checkout-btn").click(function(event) {
		event.preventDefault();
		alert("OK");
		$("#checkout-form").submit();

	});

});