<?php

include __DIR__ . '/topnav.php';

?>

<table id="example" class="table responsive-utilities">

  <thead>
    <tr class="headings">
      <th><?= _("name")?> </th>
      <th><?= _("device_type")?> </th>
      <th><?= _("mac")?> </th>
      <th><?= _("login")?> </th>
      <th><?= _("password")?> </th>
      <th><?= _("status")?> </th>
      <th><?= _("expire_date")?> </th>
    </tr>
  </thead>

  <tbody>
    <?php foreach($devices as $device): ?>
      <tr class="even pointer">
        <td class=" "><?=$device['name']?></td>
        <td class=" "><?=$device['device_type']?></td>
        <td class=" "><a href="/devices/<?=$device['id']?>"><?=$device['hardware_id']?></a></td>
        <td class=" "><a href="/devices/<?=$device['id']?>"><?=$device['login']?></a></td>
        <td class=" "><?=$device['pass']?></td>
        <td class=" "><?=($device['status']) ? 'on' : 'off'; ?></td>
        <td class=" "><?=_($device['expired'])?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>

</table>
