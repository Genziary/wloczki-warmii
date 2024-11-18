$(document).ready(function(){
    var $mySlides = $("#slides");
    var module_key = $(".nivojsheader").attr('data-modulekey');
    var module_link = $(".nivojsheader").attr('data-modulelink');
    var moduleurl = $(".nivojsheader").attr('data-moduleurl');
    var $url_ajax = module_link+'modules/ybc_nivoslider/ajax_ybc_nivoslider.php?secure_key='+module_key;
    console.log($url_ajax);
    console.log(moduleurl);
    $mySlides.sortable({
        opacity: 0.6,
        cursor: "move",
        update: function(event, ui) {
            var sliders = [];
            $('#slides > div').each(function(e){
                var _idmenu = $(this).attr('data-id');
                sliders.push(_idmenu);
            });
            //var order = $(this).sortable("serialize") + "&action=updateSlidesPosition";
            $.ajax({
                url: moduleurl,
                type: 'POST',
                dataType: 'json',
                data: {
                    ajax: 1,
                    action: 'updateSlidesPosition',
                    slides: sliders,
                },
                success: function (json) {
                    $(this).removeClass('loading');
                    if (json) {
                        var html = '<div class="growl-message">Sorting successful.</div>';
                        showSaveMessage(html,true);
                    }
                },
                error: function () {

                }
            });

        }
    });
    $mySlides.hover(function() {
            $(this).css("cursor","move");
        },
        function() {
            $(this).css("cursor","auto");
        });
});
function showSaveMessage(message, type){
    if( ! $('.ets_nivo_alert').length ){
        $('body').append('<div class="default ets_nivo_alert" id="growls"></div>');
    }
    html = '<div class="growl growl-notice growl-medium"><div class="growl-close">x</div>'+message+'</div>';
    $('.ets_nivo_alert').append(html);
    if(type!='error'){
        setTimeout(function(){
            $('.ets_nivo_alert').empty();
        },3000);
    }
    $(document).on('click','.ets_nivo_alert .growl-close',function(){
        $('.ets_nivo_alert').empty();
    });
}