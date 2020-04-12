<?php

include __DIR__ . '/topnav.php'

?>

    <div class="container">
      <form id="user_info" method="post" action="/profile/save">
        <h4><?= _("profile_info")?></h4>

        <div class="form-group row">
          <label class="col-sm-3 col-form-label" for="username"><?= _("username")?></label>
          <div class="col-sm-9">
            <input id="username" class="form-control" name="username" type="text" value="<?=$username?>">
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 col-form-label" for="password"><?=_("password")?></label>
          <div class="col-sm-9">
            <input id="password" type="text" name="password" class="form-control">
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 col-form-label" for="password2"><?=_("repeat_password")?></label>
          <div class="col-sm-9">
            <input id="password2" type="text" name="password2" class="form-control">
          </div>
        </div>

        <input type="hidden" name="<?=CSRF_TOKEN_KEY ?>" value="<?=$secure_token ?>">

        <div class="form-group">
          <div class="col-md-6">
            <a href="/dashboard"><button type="button" class="btn"><?= _("cancel")?></button></a>
            <button id="submit_userinfo" type="submit" class="btn"><?= _("submit")?></button>
          </div>
        </div>
      </form>
    </div>


    <script>

      $("#user_info").validate({
            rules: {
              username: {
                required: true
              },
              password: {
                equalTo: "#password2"
              },
              password2: {
                equalTo: "#password"
              }
            },
            messages: {
              username: {
                required: "Необходимо ввести имя пользователя"
              },
              password: {
                equalTo: "Пароль не совпадает"
              },
              password2: {
                equalTo: "Пароль не совпадает"
              }
            }
      });

    </script>
