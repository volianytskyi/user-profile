<?php

include __DIR__ . '/topnav.php'

?>

    <div class="container">
      <form id="portal" method="post" action="/portals/<?=$id?>">
        <h4><?= _("portal_info")?></h4>

        <div class="form-group row">
          <label class="col-sm-3 col-form-label" for="name"><?= _("name")?></label>
          <div class="col-sm-9">
            <input id="name" class="form-control" name="name" type="text" value="<?=$name?>">
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 col-form-label" for="login">API Login</label>
          <div class="col-sm-9">
            <input id="api_login" type="text" name="api_login" class="form-control" value="<?=$api_login?>">
          </div>
        </div>

        <div class="form-group row">
          <label for="api_pass" class="col-sm-3 col-form-label">API Password</label>
          <div class="col-sm-9">
            <input id="api_pass" type="text" name="api_pass" class="form-control" value="<?=$api_pass?>">
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 col-form-label" for="login">API URL
          </label>
          <div class="col-sm-9">
            <input id="api_url" type="text" name="api_url" class="form-control" value="<?=$api_url?>">
          </div>
        </div>

        <input type="hidden" name="<?=CSRF_TOKEN_KEY ?>" value="<?=$secure_token ?>">

        <div class="form-group">
          <div class="col-md-6">
            <a href="/portals"><button type="button" class="btn"><?= _("cancel")?></button></a>
            <button id="new_portal" type="submit" class="btn"><?= _("submit")?></button>
          </div>
        </div>
      </form>
    </div>


    <script>

      jQuery(document).ready(function($) {

        $.validator.methods.url = function( value, element ) {
          return this.optional( element ) || /^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,}))\.?)(?::\d{2,5})?(?:[\/?#]\S*)?$/i.test( value );
        }

          $("#portal").validate({
                rules: {
                  name: {
                    required: true
                  },
                  api_login: {
                    required: true
                  },
                  api_pass: {
                    required: true
                  },
                  api_url: {
                    required: true,
                    url: true
                  }
                }
          });
      });

    </script>
