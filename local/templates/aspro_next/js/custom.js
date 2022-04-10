/*
You can use this file with your scripts.
It will not be overwritten when you upgrade solution.
*/
document.addEventListener('DOMContentLoaded', ()=>{
    var serviceText = $('.group_description_block>div');
    if (serviceText.outerHeight() > 0) {
        setTimeout(function(){
        var element = serviceText.find('>h2:first');
        var height = element.offset().top - serviceText.offset().top + 50;
        // var height = serviceText.find('p:nth-of-type(3)').offset().top - serviceText.offset().top + 130;
        console.log(element.text());
        serviceText.css('height', height);
        setTimeout(function(){
            var realHeight = serviceText.get(0).scrollHeight;
                console.log(realHeight);
                // $('<a class="js-show-more">Подробнее</a>').insertAfter( $('.group_description_block>div p:nth-of-type(3)') );
                $('<a class="js-show-more">Подробнее</a>').insertBefore(element);

                $('.js-show-more').click(function(e) {
                    e.preventDefault();
                    $(this).hide('fast');
                    setTimeout(()=>{
                        $(this).parents('.group_description_block>div').css('height', 'auto');
                    },200);
                    $(this).parents('.group_description_block>div').animate({height:realHeight},1000);
                })
        }, 1000)
    },400)
    }

    $('.menu.middle a').on('click',function(){

        ym(54359989, 'reachGoal', 'mobile-phone-click');

    })

});
