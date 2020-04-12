<nav class="navbar navbar-expand-lg fixed-top">
  <div class="container">
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <select id="language" onchange="setLocale(this.value)" class="btn btn-block">
              <?php foreach ($locales as $locale): ?>
                <option class="btn btn-block" value="<?=$locale?>" <?php if($current_locale === $locale) {echo ' selected ';} ?>><?= _("$locale") ?></option>
              <?php endforeach; ?>
            </select>
        </li>
      </ul>
    </div>
  </div>
</nav>

      <div class="container col-md-4">

          <form id="login_form" class="form-signin" method="POST" action="/<?=$current_locale?>/sign-in">
            <h4 class="form-signin-heading"><?= _("client_profile") ?></h2>
            <div class="clearfix"></div>
            <label for="login" class="sr-only"><?= _("email") ?></label>
            <input id="login" name="login" class="form-control" placeholder="<?= _("email_placeholder")?>" autofocus>
            <label for="password" class="sr-only"><?= _("password") ?></label>
            <input name="password" type="password" id="password" class="form-control" placeholder="<?= _("password")?>">
            <input type="hidden" name="<?=CSRF_TOKEN_KEY ?>" value="<?=$secure_token ?>">
            <button class="btn btn-block" type="submit"><?= _("sign_in")?></button>
          </form>
      </div>

      <script type="text/javascript" >

        function setLocale(lang)
        {
          var path = window.location.pathname;
          var pos = path.search(/(en|ru|ua)/);
          if(pos === -1)
          {
            path = '/' + lang + path;
          }
          else if (pos === 1)
          {
            path = path.replace(/(en|ru|ua)/, lang);
          }
          window.location.replace(window.location.origin + path);
        }

        $("#login_form").validate({
              rules: {
                login: {
                  required: true,
                  email: true
                },
                password: {
                  required: true,
                  minlength: 6,
                }
              },
              messages: {
                login: {
                  required: "Необходимо ввести логин (email-адрес)",
                  email: "Введите корректный email-адрес"
                },
                password: {
                  required: "Введите пароль",
                  minlength: "Минимальная длина пароля - 6 символов",
                }
              }
        });

      </script>
