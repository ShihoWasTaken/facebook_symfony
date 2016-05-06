$( document ).ready(function() {

    function goToByScroll(id){
        // Remove "link" from the ID
        //id = id.replace("link", "");
        // Scroll
        $('html,body').animate({
                scrollTop: $("#"+id).offset().top - 200},
            'fast');
    }

    $('.comment-container').each(function( index ) {
        $( this ).hide();
    });
    var visible = false;
    var visibleComments = new Array();
    $('.comment-count').click(function()
    {
        var idCount = $(this).attr('id');
        if( $.inArray(idCount, visibleComments) != -1 )
        {
            //$(this).next().next().slideUp('fast');
            $(this).next().next().hide();
            visibleComments = jQuery.grep(visibleComments, function(value) {
                return value != idCount;
            });
            $('#' + idCount).html($('#' + idCount).html().replace("Masquer","Afficher"));
        }
        else
        {
            var idTextArea = idCount.replace("comment-count-", "commentText-")
            //$(this).next().next().slideDown('fast');
            $(this).next().next().show();
            goToByScroll(idTextArea);
            visibleComments.push(idCount);
            $('#' + idTextArea).focus();
            $('#' + idCount).html($('#' + idCount).html().replace("Afficher","Masquer"));
        }
    });


    var originalLeave = $.fn.popover.Constructor.prototype.leave;
    $.fn.popover.Constructor.prototype.leave = function(obj){
        var self = obj instanceof this.constructor ?
            obj : $(obj.currentTarget)[this.type](this.getDelegateOptions()).data('bs.' + this.type)
        var container, timeout;

        originalLeave.call(this, obj);

        if(obj.currentTarget) {
            container = $(obj.currentTarget).siblings('.popover')
            timeout = self.timeout;
            container.one('mouseenter', function(){
                //We entered the actual popover – call off the dogs
                clearTimeout(timeout);
                //Let's monitor popover content instead
                container.one('mouseleave', function(){
                    $.fn.popover.Constructor.prototype.leave.call(self, self);
                });
            })
        }
    };


    $('body').popover({ selector: '[data-popover]', trigger: 'click hover', placement: 'auto', delay: {show: 150, hide: 200}});
});