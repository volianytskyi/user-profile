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

          <form id="restore_form" class="form-signin" method="POST" action="/<?=$current_locale?>/restore">
            <h4 class="form-signin-heading"><?= _("Restore password") ?></h2>
            <div class="clearfix"></div>
            <label for="email" class="sr-only"><?= _("email") ?></label>
            <input id="email" name="email" class="form-control" autofocus placeholder="<?= _("email_placeholder")?>">
            <input type="hidden" name="<?=CSRF_TOKEN_KEY ?>" value="<?=$secure_token ?>">
            <button class="btn btn-block" type="submit"><?= _("Send")?></button>
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

        $("#restore_form").validate({
              rules: {
                email: {
                  required: true,
                  email: true
                }
              },
              messages: {
                email: {
                  required: "Введите email-адрес",
                  email: "Введите корретный email-адрес"
                }
              }
        });

      </script>
