<?php

include __DIR__ . '/topnav.php'

?>

<table id="example" class="table responsive-utilities">

  <thead>
    <tr class="headings">
      <th><?= _("device_type")?> </th>
      <th><?= _("portal")?> </th>
      <th class="no-link last"><span class="nobr"><?= _("delete")?></span>
    </tr>
  </thead>

  <tbody>
    <?php foreach($device_types as $type): ?>
      <tr class="even pointer">
        <td class=" "><a href="/types/<?=$type['id']?>"><?=$type['name']?></a></td>
        <td class=" "><?=$type['portal_name']?></td>
        <td class=" last"><button class="btn" data-href="/types/delete/<?=$type['id']?>" data-toggle="modal" data-target="#confirm-delete"><?= _("delete")?></button></td>
      </tr>
    <?php endforeach; ?>
  </tbody>

</table>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <?= _("device_type_delete_welcome_message")?>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= _("cancel")?></button>
                <a class="btn btn-danger btn-ok"><?= _("cancel")?></a>
            </div>
        </div>
    </div>
</div>

<script>
  $('#confirm-delete').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });
</script>
