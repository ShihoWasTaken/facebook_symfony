$( document ).ready(function() {

    $('.comment-container').each(function( index ) {
        $( this ).hide();
    });
    var visible = false;
    $('.comment-count').click(function()
    {
        if(visible)
        {
            $(this).next().next().slideUp('fast');
        }
        else
        {
            $(this).next().next().slideDown('fast');
        }
        visible = !visible;
    });

});