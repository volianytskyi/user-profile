$(document).ready(function () {
        $('input.tableflat').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    });

    $("#account").validate({
          rules: {
            duration: {
              remote: "/actions/check_credits_amount.php"
            }
          },
          messages: {
            duration: {
              remote: "Your balance is below {0} credits"
            }
          }
    });

    var accountNumber = document.getElementById('account_number').innerHTML;

      var table = $('#devices').DataTable( {
        //"processing": true,
        "serverSide": true,
        "ajax": "ssp/devices.php?n="+accountNumber,
        "columnDefs": [
          {
            "targets": 0, //id
            "visible": false,
            "searchable": false
          },
          {
            "targets": 1, //ip
            "render": function(data, type, row, meta){
                var imageSource;

                $.ajax({
                  async: false,
                  type: "POST",
                  url: "actions/get_customer_country.php",
                  data: "device_ip="+row[1],
                  success: function(src){
                    (src) ? imageSource = "images/png/"+src+".png" : imageSource = 'undefined';
                  }
                });

                return (imageSource != 'undefined') ? '<img data-toggle="tooltip" data-placement="top" title="'+row[1]+'" src="' + imageSource + '" >' : 'undefined';
            }
          },
          {
            "targets": 2, //mac
            "render": function(data, type, row, meta){
              var data = 'data-login="'+row[3]+'" data-pass="'+row[4]+'" data-name="'+row[5]+'" data-mac="'+row[2]+'"';
              return '<a href="#" class="btn" data-toggle="modal" data-target="#devmodal" '+data+'>'+row[2]+'</a></td>';
            }
          },
          {
            "targets": 6, //delete
            'bSortable': false,
            "searchable": false,
            "render": function(data, type, row, meta){
              var action = '/actions/delete_device.php?id='+row[0];
              return '<button class="btn" data-href="'+action+'" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash"></i></button>';
            }
          }
        ],
        "dom": 't'
    });

    $('#devmodal').on('show.bs.modal', function (event) {
     var button = $(event.relatedTarget);
     var login = button.data('login');

     var details;
     $.ajax({
       async: false,
       type: "POST",
       url: "actions/get_device_details.php",
       data: "login="+login,
       success: function(src){
         details = JSON.parse(src);
       }
     });

     var mac = button.data('mac');
     var name = button.data('name');
     var pass = button.data('pass');
     var modal = $(this);
     $(event.currentTarget).find('input[name="device_login"]').val(login);
     $(event.currentTarget).find('input[name="device_password"]').val(pass);
     $(event.currentTarget).find('input[name="device_name"]').val(name);
     $(event.currentTarget).find('input[name="device_mac"]').val(mac);
     $(event.currentTarget).find('input[name="login"]').val(login);

     $(event.currentTarget).find('input[name="serial_number"]').val(details.stb_sn);
     $(event.currentTarget).find('input[name="device_model"]').val(details.stb_type);
     var active;
     (details.last_active == '0000-00-00 00:00:00') ? active = 'never' : active = details.last_active;
     $(event.currentTarget).find('input[name="last_active"]').val(active);
     $(event.currentTarget).find('input[name="device_ip"]').val(details.ip);
   });

   $("#device_modal").validate({
         rules: {
           device_password: {
             required: true
           }
         }
   });

    $.fn.dataTable.ext.errMode = 'throw';

    $("#device").validate({
          rules: {
            device_login: {
              required: true,
              remote: "/actions/check_device_login_unique.php"
            },
            device_password: {
              required: true
            },
            device_mac: {
              remote: "/actions/check_mac_valid_unique.php"
            },
            status: {
              required: true
            }
          },
          messages: {
            device_login: {
              remote: "{0} is already in use, new login must be unique"
            },
            device_mac: {
              remote: "The value must be a valid MAC-address"
            }
          }
    });

});

$('#confirm-delete').on('show.bs.modal', function(e) {
$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
});
