<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#">
      <img src="/images/logo.png" width="150" height="30" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="/"><?= _("home")?>
            <span class="sr-only">(current)</span>
          </a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?= _("my_devices")?>
          </a>
            <div class="dropdown-menu">
              <a href="/<?=$current_locale?>/devices" class="dropdown-item"><?= _("list")?> </a>
              <a href="/<?=$current_locale?>/devices/new" class="dropdown-item"><?= _("test_account")?> </a>
              <a href="/<?=$current_locale?>/devices/register" class="dropdown-item"><?= _("register_existing")?> </a>
            </div>
        </li>

        <?php if($payment_history): ?>
          <li class="nav-item">
            <a class="nav-link" href="/<?=$current_locale?>/transactions"><?= _("Transactions")?></a>
          </li>
        <?php endif; ?>

        <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?= _("affiliated_devices")?>
          </a>
            <div class="dropdown-menu">
              <a href="/<?=$current_locale?>/affiliated" class="dropdown-item"><?= _("list")?> </a>
              <a href="/<?=$current_locale?>/affiliated/new" class="dropdown-item"><?= _("add_new")?> </a>
            </div>
        </li> -->

        <?php if($can_manage_settings): ?>
          <?php if($can_manage_portals): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= _("middleware_setup")?>
              </a>
                <div class="dropdown-menu">
                  <a href="/<?=$current_locale?>/portals" class="dropdown-item"><?= _("list")?></a>
                  <a href="/<?=$current_locale?>/portals/new" class="dropdown-item"><?= _("add_new")?></a>
                </div>
            </li>
        <?php endif; ?>
        <?php if($can_manage_device_types): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?= _("device_types")?>
            </a>
              <div class="dropdown-menu">
                <a href="/<?=$current_locale?>/types" class="dropdown-item"><?= _("list")?></a>
                <a href="/<?=$current_locale?>/types/new" class="dropdown-item"><?= _("add_new")?></a>
              </div>
          </li>
        <?php endif; ?>
      <?php endif; ?>

      <li class="nav-item">
        <a class="nav-link" href="/<?=$current_locale?>/profile"><?= _("Profile")?></a>
      </li>

        <li class="nav-item">
          <a class="nav-link" href="/logout"><?= _("logout")?></a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?= _("$current_locale")?>
          </a>
            <div class="dropdown-menu">
              <?php foreach ($locales as $locale): ?>
                <a href="#" onclick="changeLocale(event)" lang="<?=$locale?>" class="dropdown-item"><?= _("$locale")?></a>
              <?php endforeach; ?>

            </div>
        </li>

      </ul>
    </div>
  </div>
</nav>
