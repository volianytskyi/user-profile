
$(document).ready(function () {

  jQuery.validator.addClassRules({
      portal: {
        required: true
      }
  });

  $("#account").validate({
        rules: {
          account_number: {
            required: true,
            number: true,
            minlength: 6,
            maxlength: 6,
            remote: "/actions/check_account_number_unique.php"
          },

          max_devices_count: {
            required: true,
            number: true
          },
          device_login: {
            required: true,
            remote: "/actions/check_device_login_unique.php"
          },
          device_password: {
            required: true
          },
          device_mac: {
            remote: "/actions/check_mac_valid_unique.php"
          },
          status: {
            required: true
          },
          duration: {
            required: true,
            remote: "/actions/check_credits_amount.php"
          }
        },
        messages: {
          account_number: {
            number: "This value must be a number",
            minlength: "Account number must be {0} digits long",
            maxlength: "Account number must be {0} digits long",
            remote: "{0} is already in use, new account number must be unique"
          },
          duration: {
            remote: "Your balance is below {0} credits"
          },
          max_devices_count: {
            number: "This value must be a number"
          },
          portal: {
            required: "It is necessary to choose at least one portal"
          },
          device_login: {
            remote: "{0} is already in use, new login must be unique"
          },
          device_mac: {
            remote: "The value must be a valid MAC-address"
          }
        }
  });
});
