<?php

include __DIR__ . '/topnav.php'

?>

    <div class="container">
      <form name="test_account_form" id="device" method="post" action="/devices/test">
        <h4><?= _("test_account_welcome_message")?></h4>

        <?php foreach ($device_types as $device_type): ?>
          <div class="form-group row">
            <div class="radio col-sm-3">
              <label class="col-form-label" for="device_type">
                <input hardware_id="<?=$device_type['hardware_id']?>" type="radio" name="device_type" value="<?=$device_type['id']?>"><?=$device_type['name']?>
              </label>
            </div>
            <div id="hardware_id" class="col-sm-4">

            </div>
          </div>
        <?php endforeach; ?>

        <input type="hidden" name="<?=CSRF_TOKEN_KEY ?>" value="<?=$secure_token ?>">

        <div class="form-group">
          <div class="col-md-6">
            <a href="/<?=$current_locale?>/dashboard"><button type="button" class="btn"><?= _("cancel")?></button></a>
            <button id="new_portal" type="submit" class="btn"><?= _("submit")?></button>
          </div>
        </div>
      </form>
    </div>


    <script>

    $('input[type=radio]').change( function() {
      var hardwareId = document.getElementById('hardware_id');
      if(this.getAttribute('hardware_id') == 'mac')
      {
       hardwareId.innerHTML = '<input id="mac" class="form-control mac" name="mac" type="text" placeholder="Enter the mac-address">';

       const mac = new Cleave('.mac', {
           delimiter: ':',
           blocks: [2, 2, 2, 2, 2, 2],
           uppercase: true
       });

      }
      else
      {
        hardwareId.innerHTML = '';
      }
    });

      jQuery(document).ready(function($) {

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
                  }
                },
                messages: {
                  device_type: {
                    required: "Необходимо указать тип устройства"
                  },
                  mac: {
                    required: "Необходимо указать MAC-адрес",
                    pattern: "Введите корректный MAC-адрес"
                  }
                }
          });
      });


    </script>
