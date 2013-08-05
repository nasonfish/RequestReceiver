<!DOCTYPE html>
<html>
<head>
    <title>DHMC Modreq stats</title>
    <?php include('Util.php'); ?>
</head>
    <body>
        <div class="users-box">
            <h2>Users</h2>
            <?php print_user_requests(requestsByUser_amt(date('Y-m-d H:i:s', time() - (2 * 7 * 24 * 60 * 60))));?>

        </div>
    <body>

<script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>

<script>
    $('.mod').click(function(){
        handle($(this), 'mod');
    });
    $('.user').click(function(){
        handle($(this), 'user');
    });

    function handle(elem, type){
        var name = elem.find('.user_name').text();
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
                elem.after(data);
            });
    }

    $('.req_id').click(function(){
        var id = $(this).text();
        alert(id);
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
                $(this).after(data);
            });
    });
</script>
</html>