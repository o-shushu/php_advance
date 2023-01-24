$(function() {
    $(".log_in").hide();
    var top = $(window).height(); 
    $(document).scroll(function(){
        var scrTop = $(window).scrollTop(); 
        if(scrTop >= top){
            $('.jump').css({'display':'block'});
        }else{
            $('.jump').css({'display':'none'});
        
        }
    });

    $(window).scroll(function () {
        // var elemPos = $('.container').offset().top; 
        scroll = $(window).scrollTop();
        if (scroll > 54 ) {
            $('.container').css({'position':'fixed','top':'0','width':'100%','background-color':'rgba(0,0,0,0.5)'});
        }else {
            $('.container').css({'position':'','top':'','width':'','background-color':''});
        }

    });

    var counta = 0;
    $(".sidebtn").click(function(){
        counta++;
        if(counta % 2 !== 0){
            $(".side-menu").css("display", "block");
        }else{
            $(".side-menu").css("display", "none"); 
        }
    });
   
  
    var p1_element = document.getElementById("logIn");
    $(".hidebackground").click(function(){
        $(".log_in").hide();
        $(".hidebackground").hide();
        p1_element.classList.remove("transformed-state");
    });

    // var p2_element = document.getElementsByClassName("log_in");
    $(".signbtn").click(function(){
        $(".hidebackground").show(); 
        $(".log_in").show();  
        $(".side-menu").hide();
        $(".log_in").addClass("transformed-state");
    });
    
    
    $('#jump').click(function () 
    {
        $('html, body').animate(
            {
            scrollTop: '0px'
        },
        500);
        return false;
    });

    $("#start").click(function (){
        $('html, body').animate({
            scrollTop: $("#content1").offset().top
        }, 1000);
    });

    $("#keikenn").click(function (){
        $('html, body').animate({
            scrollTop: $("#content4").offset().top
        }, 1000);
    });
 
});


