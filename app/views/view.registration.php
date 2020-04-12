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

          <form id="register_form" class="form-signin" method="POST" action="/<?=$current_locale?>/register">
            <h4 class="form-signin-heading"><?= _("client_profile") ?></h2>
            <div class="clearfix"></div>
            <label for="name" class="sr-only"><?= _("username") ?></label>
            <input id="name" name="name" class="form-control" placeholder="<?= _("username_placeholder")?>" autofocus>
            <label for="email" class="sr-only"><?= _("email") ?></label>
            <input id="email" name="email" class="form-control" placeholder="<?= _("email_placeholder")?>">
            <input type="hidden" name="<?=CSRF_TOKEN_KEY ?>" value="<?=$secure_token ?>">
            <button class="btn btn-block" type="submit"><?= _("register")?></button>
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

        $("#register_form").validate({
              rules: {
                email: {
                  required: true,
                  email: true
                },
                name: {
                  required: true,
                }
              },
              messages: {
                email: {
                  required: "Введите email-адрес",
                  email: "Введите корректный email-адрес"
                },
                name: {
                  required: "Введите имя пользователя",
                }
              }
        });

      </script>
