




<script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>

<script>
    $('.mod').click(function(){
        handle($(this), 'mod');
    });
    $('.user').click(function(){
        handle($(this), 'user');
    });
    function handle(elem, type){
        var name = elem.contents();
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
        );
    }
</script>