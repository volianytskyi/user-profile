<?php

include __DIR__ . '/topnav.php'

?>

<table id="example" class="table responsive-utilities">

  <thead>
    <tr class="headings">
      <th><?= _("name")?> </th>
      <th>API Login </th>
      <th>API Password </th>
      <th>API URL </th>
      <th class="no-link last"><span class="nobr"><?= _("delete")?></span>
    </tr>
  </thead>

  <tbody>
    <?php foreach($portals as $portal): ?>
      <tr class="even pointer">
        <td class=" "><a href="/portals/<?=$portal['id']?>"><?=$portal['name']?></a></td>
        <td class=" "><?=$portal['api_login']?></td>
        <td class=" "><?=$portal['api_pass']?></td>
        <td class=" "><?=$portal['api_url']?></td>
        <td class=" last"><button class="btn" data-href="/portals/delete/<?=$portal['id']?>" data-toggle="modal" data-target="#confirm-delete"><?= _("delete")?></button></td>
      </tr>
    <?php endforeach; ?>
  </tbody>

</table>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
              <?= _("delete_portal_welcome_message")?>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= _("cancel")?></button>
                <a class="btn btn-danger btn-ok"><?= _("delete")?></a>
            </div>
        </div>
    </div>
</div>

<script>
  $('#confirm-delete').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });
</script>
