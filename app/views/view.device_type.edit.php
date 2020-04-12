<?php

include __DIR__ . '/topnav.php'

?>

    <div class="container">
      <form id="device_type" method="post" action="/types/<?=$id ?>">
        <h4><?= _("device_type_info")?></h4>

        <div class="form-group row">
          <label class="col-sm-3 col-form-label" for="name"><?= _("name")?></label>
          <div class="col-sm-9">
            <input id="name" value="<?=$name ?>" class="form-control" name="name" type="text">
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 col-form-label" for="portal"><?= _("hardware_id")?></label>
          <div class="col-sm-9">
            <select class="form-control" id="hardware_id" name="hardware_id">
              <?php foreach($hw_id_types as $hw_id): ?>
                <option value="<?=$hw_id ?>" <?php if($hw_id == $hardware_id){echo ' selected ';} ?>><?=$hw_id ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 col-form-label" for="portal"><?= _("portal")?></label>
          <div class="col-sm-9">
            <select class="form-control" id="portal_id" name="portal_id">
              <?php foreach($portals as $portal): ?>
                <option value="<?=$portal['id'] ?>" <?php if($portal['id'] == $portal_id) {echo ' selected ';} ?>><?=$portal['name'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <input type="hidden" name="<?=CSRF_TOKEN_KEY ?>" value="<?=$secure_token ?>">

        <div class="form-group">
          <div class="col-md-6">
            <a href="/types"><button type="button" class="btn"><?= _("cancel")?></button></a>
            <button id="new_type" type="submit" class="btn"><?= _("submit")?></button>
          </div>
        </div>
      </form>
    </div>


    <script>

      jQuery(document).ready(function($) {

        $.validator.methods.url = function( value, element ) {
          return this.optional( element ) || /^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,}))\.?)(?::\d{2,5})?(?:[\/?#]\S*)?$/i.test( value );
        }

          $("#device_type").validate({
                rules: {
                  name: {
                    required: true
                  },
                  portal_id: {
                    required: true
                  }
                }
          });
      });

    </script>
