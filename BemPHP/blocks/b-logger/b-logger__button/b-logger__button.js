$(".b-logger__button").click(function(){
    $(".b-logger__text-box").slideToggle(150, function(){
        if ($(".b-logger__text-box").is(':hidden')){
                $(".b-logger__button__arrow_down").addClass("b-logger__button__arrow_up");
        }
        else {
                $(".b-logger__button__arrow_down").removeClass("b-logger__button__arrow_up");
        }
        });
});

