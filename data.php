<!DOCTYPE html>
<html>
<head>
    <title>DHMC Modreq stats</title>
    <?php include('Util.php'); ?>
</head>
    <body>
        <div class="mods_box">
            <h2>Mods</h2>
            <?php print_mod_requests(requestsByMod_amt((date('Y-m-d H:i:s', time() - (2 * 7 * 24 * 60 * 60))))); ?>
        </div>
        <div class="users_box">
            <h2>Users</h2>
            <?php print_user_requests(requestsByUser_amt(date('Y-m-d H:i:s', time() - (2 * 7 * 24 * 60 * 60))));?>
        </div>
    </body>

<script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>

<script>
    $('.mods_box').on('click', '.mod', function(){
        handle($(this), 'mod');
    });
    $('.users_box').on('click', '.user', function(){
        handle($(this), 'user');
    });

    function handle(elem, type){
        var name = elem.find('.'+type+'_name').text();
        $.ajax('data_ajax.php',
            {
                type: 'POST',
                data: {
                    name: name,
                    type: type
                    //date: 'Some kind of date.'
                },
                dataType: 'html'
            }
        ).done(function(data){
                elem.after(data).slideDown();
                elem.removeClass();
            });
    }

    $('.users_box, .mods_box').on('click', '.req_id', function(){
        var type = "id";
        var id = $(this).text();
        var elem = $(this);
        $.ajax('data_ajax.php',
            {
                type: 'POST',
                data: {
                    id: id,
                    type: type
                    //date: 'Some kind of date.'
                },
                dataType: 'html'
            }
        ).done(function(data){
                elem.after(data).slideDown();
                elem.removeClass();
            });
    });
</script>
</html>