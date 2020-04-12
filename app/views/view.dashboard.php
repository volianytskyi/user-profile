<?php

include __DIR__ . '/topnav.php'

?>

    <div class="container">
      <h4><?=_("My Transactions")?></h4>
    </div>

    <table id="transactions" class="table responsive-utilities">

      <thead>
        <tr class="headings">
          <th><?=_("Id")?></th> <!-- 0 -->
          <th><?=_("Payment System")?></th> <!-- 1 -->
          <th><?=_("Status")?></th> <!-- 2 -->
          <th><?= _("Type")?></th> <!-- 3 -->
          <th><?= _("Price")?></th> <!-- 4 -->
          <th><?= _("Currency")?></th> <!-- 5 -->
          <th><?= _("Date")?></th> <!-- 6 -->
          <th><?= _("User")?></th> <!-- 7 -->
          <th><?= _("Device")?></th> <!-- 8 -->
          <th></th> <!-- 9 device_id -->
        </tr>
      </thead>

    </table>


    <script>
      $(document).ready(function() {
        var transactionsTable = $('#transactions').dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": 'https://'+window.location.host+'/datatables/transactions/',
            "columnDefs": [
              {
                "targets": 8,
                "render": function(data, type, row, meta){
                    return '<a href="/devices/'+row[9]+'">'+data+'</a>';
                }
              },
              {
                "targets": [9,7],
                "visible": false,
              },
              {
                "targets": 3,
                "render": function(data, type, row, meta) {
                  switch(data) {
                    case 'web_accept':
                      return 'Single Payment';
                    case 'test_account':
                      return 'Test Account';
                    default:
                      return null;
                  }
                }
              }
            ]
          });
        });
    </script>
