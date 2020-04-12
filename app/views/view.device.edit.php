<?php

include __DIR__ . '/topnav.php'

?>

    <div class="container">
      <form id="device_info" method="post" action="/devices/<?=$id ?>">
        <h4><?= _("device_info")?></h4>

        <div class="form-group row">
          <label class="col-sm-3 col-form-label" for="name"><?= _("name")?></label>
          <div class="col-sm-9">
            <p id="name" class="form-control" name="name" type="text"><?=$name ?></p>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 col-form-label" for="created"><?= _("created")?></label>
          <div class="col-sm-9">
            <p id="created" class="form-control" name="name" type="text"><?=$created ?></p>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 col-form-label" for="portal"><?= _("device_type")?></label>
          <div class="col-sm-9">
            <select class="form-control" id="device_type_id" name="device_type_id">
              <?php foreach($device_types as $device_type): ?>
                <option value="<?=$device_type['id'] ?>" <?php if($device_type['id'] == $device_type_id){echo ' selected ';} ?>><?=$device_type['name'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 col-form-label" for="created"><?= _("hardware_id")?></label>
          <div class="col-sm-9">
            <p id="hardware_id" class="form-control" name="hardware_id" type="text"><?=$hardware_id ?></p>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 col-form-label" for="login"><?= _("login")?></label>
          <div class="col-sm-9">
            <p id="login" class="form-control" name="login" type="text"><?=$login ?></p>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 col-form-label" for="pass"><?= _("password")?></label>
          <div class="col-sm-9">
            <input id="pass" value="<?=$pass ?>" class="form-control" name="pass" type="text">
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 col-form-label" for="expired"><?= _("expire_date")?></label>
          <div class="col-sm-9">
            <p id="expired" class="form-control" name="expired" type="text"><?=_($expired) ?></p>
          </div>
        </div>

        <input type="hidden" name="<?=CSRF_TOKEN_KEY ?>" value="<?=$secure_token ?>">

        <div class="form-group">
          <div class="col-md-6">
            <a href="/devices"><button type="button" class="btn"><?= _("cancel")?></button></a>
            <button id="new_type" type="submit" class="btn"><?= _("submit")?></button>
          </div>
        </div>
      </form>

      <form id="payment" method="post" action="<?=$paypal_action ?>">
        <h4><?= _("Payment Info")?></h4>

        <div class="form-group row">
          <label class="col-sm-3 col-form-label" for="duration"><?= _("Duration")?></label>
          <div class="col-sm-9">
            <select onchange="getPaymentInfo()" class="form-control" id="duration" name="duration">
              <option selected value="0"><?=_("Select duration") ?></option>
              <?php foreach($durations as $duration): ?>
                <option value="<?=$duration ?>"><?=sprintf(_("%d months"), $duration) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 col-form-label" for="new_expired"><?= _("expire_date")?></label>
          <div class="col-sm-9">
            <p id="new_expired" class="form-control" name="new_expired" type="text"></p>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 col-form-label" for="price"><?= _("Price")?></label>
          <div class="col-sm-6">
            <p id="price" class="form-control" name="price" type="text"></p>
          </div>
          <div class="col-sm-3">
            <p id="currency" class="form-control" name="currency" type="text"></p>
          </div>
        </div>

        <input type="hidden" id="device_id" value="<?=$id ?>">

        <input type="hidden" name="<?=CSRF_TOKEN_KEY ?>" value="<?=$secure_token ?>">


        <input type="hidden" name="cmd" value="<?=$cmd ?>">
        <input type="hidden" name="business" value="<?= $receiver ?>">
        <input id="paypalItemName" type="hidden" name="item_name" value="<?=$item_name ?>">
        <input id="paypalAmmount" type="hidden" name="amount" value="0">
        <input type="hidden" name="return" value="<?=$return_url ?>">
        <input type="hidden" id="custom" name="custom" value="<?=$custom ?>">
        <input id="currency_code" type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="lc" value="<?=$lc ?>">
        <input type="hidden" name="no_shipping" value="1">
        <input id="paypalQuantity" type="hidden" name="quantity" value="0">

        <div class="form-group">
          <div class="col-md-6">
            <a href="/devices"><button type="button" class="btn"><?= _("cancel")?></button></a>
            <button id="submit-payment" type="submit" class="btn"><?= _("Submit Payment")?></button>
          </div>
        </div>
      </form>
    </div>


    <script>

      function getPaymentInfo() {
        var deviceId = document.getElementById("device_id").value;
        var duration = document.getElementById("duration").value;
        addCustomParam('duration', duration);
        var url = 'https://'+window.location.host+'/payment/info/'+deviceId+'/'+duration;
        $.post(url, function(data) {
           var info = JSON.parse(data).results; //console.log(info);
           document.getElementById("new_expired").innerHTML = info.new_expired_date;
           document.getElementById("price").innerHTML = info.price;
           document.getElementById("paypalAmmount").value = info.price;
           document.getElementById("currency").innerHTML = info.currency;
           document.getElementById("currency_code").value = info.currency;
           addCustomParam('tariff', info.tariff);
        });
      }

      function addCustomParam(key, value)
      {
        var custom = JSON.parse(decodeURIComponent(document.getElementById("custom").value));
        custom[key] = value;
        document.getElementById("custom").value = encodeURIComponent(JSON.stringify(custom));
      }

      jQuery(document).ready(function($) {

          $.validator.methods.url = function( value, element ) {
          return this.optional( element ) || /^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,}))\.?)(?::\d{2,5})?(?:[\/?#]\S*)?$/i.test( value );
        }

          $("#device_info").validate({
                rules: {
                  pass: {
                    required: true
                  },
                  device_type_id: {
                    required: true
                  }
                }
          });
      });

    </script>
