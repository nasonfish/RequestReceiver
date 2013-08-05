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
            elem.removeClass().addClass(type + '_li');
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
            elem.removeClass().addClass('id_li');
        });
});