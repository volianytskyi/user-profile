<div class="col-md-12">
    <div class="col-middle">
        <div class="text-center text-center">
          <?php if(isset($error_number)): ?>
            <h1 class="error-number"><?=$error_number ?></h1>
          <?php endif; ?>
            <h4><?=$message ?></h4>
            <a href="/<?=$locale?>"><?= _("home")?></a>
        </div>
    </div>
</div>
