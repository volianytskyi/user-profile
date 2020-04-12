<?php

include __DIR__ . '/topnav.php'

?>

    <div class="container">
      <form name="test_account_form" id="device" method="post" action="/devices/register">
        <h4><?= _("device_register_welcome_message")?></h4>

        <?php foreach ($device_types as $device_type): ?>
          <div class="form-group row">
            <div class="radio col-sm-3">
              <label class="col-form-label" for="device_type">
                <input hardware_id="<?=$device_type['hardware_id']?>" type="radio" name="device_type" value="<?=$device_type['id']?>"><?=$device_type['name']?>
              </label>
            </div>

            <div id="hardware_id" class="col-sm-4">

            </div>
            <div id="secure_hash" class="col-sm-4">

            </div>

          </div>
        <?php endforeach; ?>

        <input type="hidden" name="<?=CSRF_TOKEN_KEY ?>" value="<?=$secure_token ?>">

        <div class="form-group">
          <div class="col-md-6">
            <a href="/dashboard"><button type="button" class="btn"><?= _("cancel")?></button></a>
            <button id="new_portal" type="submit" class="btn"><?= _("submit")?></button>
          </div>
        </div>
      </form>
    </div>


    <script>






      jQuery(document).ready(function($) {

        $('input[type=radio]').change( function() {
          var hardwareId = document.getElementById('hardware_id');
          var secureHash = document.getElementById('secure_hash');
          if(this.getAttribute('hardware_id') == 'mac')
          {

           hardwareId.innerHTML = '<input id="mac" class="form-control mac" name="mac" type="text" placeholder="Enter the mac-address">';
           secureHash.innerHTML = '<input id="mac_hash" class="form-control mac_hash" name="mac_hash" type="text" placeholder="Enter the secure hash">';

           const mac_hash = new Cleave('.mac_hash', {
               delimiter: '-',
               blocks: [4, 4, 4, 4],
               uppercase: true
           });

           const mac = new Cleave('.mac', {
               delimiter: ':',
               blocks: [2, 2, 2, 2, 2, 2],
               uppercase: true
           });

          }
          else if(this.getAttribute('hardware_id') == 'custom_hash')
          {
            hardwareId.innerHTML = '<input id="login" class="form-control" name="login" type="text" placeholder="Enter app login">';
            secureHash.innerHTML = '<input id="custom_hash" class="form-control custom_hash" name="custom_hash" type="text" placeholder="Enter the secure hash">';

            const custom_hash = new Cleave('.custom_hash', {
                delimiter: '-',
                blocks: [4, 4, 4, 4, 4],
                uppercase: true
            });

          }

        });

        $.validator.addMethod( "pattern", function( value, element, param ) {
        	if ( this.optional( element ) ) {
        		return true;
        	}
        	if ( typeof param === "string" ) {
        		param = new RegExp( "^(?:" + param + ")$" );
        	}
        	return param.test( value );
        }, "Please, enter the valid mac-address" );

          $("#device").validate({
                rules: {
                  device_type: {
                    required: true
                  },
                  mac: {
                    required: true,
                    pattern: /^([0-9A-Fa-f]{2}:){5}([0-9A-Fa-f]{2})$/
                  },
                  login: {
                    required: true
                  },
                  mac_hash: {
                    required: true
                  },
                  custom_hash: {
                    required: true
                  }
                },
                messages: {
                  device_type: {
                    required: "Необходимо указать тип утсройства"
                  },
                  mac: {
                    required: "Необходимо указать MAC-адрес",
                    pattern: "Введите корретный MAC-адрес"
                  },
                  login: {
                    required: "Необходимо ввести логин"
                  },
                  mac_hash: {
                    required: "Необходимо ввести проверочный код"
                  },
                  custom_hash: {
                    required: "Необходимо ввести проверочный код"
                  }
                }
          });

      });

    </script>
