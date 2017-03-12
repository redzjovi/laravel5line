function j_validate(data)
{
    $('.label-error').empty();
    if (data.status == 0) {
        $.each(data.errors, function(key, value) {
            $('label[name="'+ key +'_error"]').html(value);
        });
    } else {
        
    }
}