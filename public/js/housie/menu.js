/*$(document).ready(function(){
    $(".navigation li").mouseenter(function(){
		
        $(this).find(".nav-menu-sub").show();
        $(this).addClass("current-link-bg");

       

        if($(this).hasClass('last')) {
            $(this).removeClass("st2").addClass("blue-bg").addClass("c-tr");
        }
    }).mouseleave(function(){
      $(this).find(".nav-menu-sub").hide();
      $(this).removeClass("current-link-bg");
      
    });
    });*/

 /* Menu */
function initMenu(){
    $("ul.navigation li ul").addClass("nav-menu-sub");
    $(".navigation li").mouseenter(function(){
        $(this).find(".nav-menu-sub").show();
        $(this).addClass("current-link-bg");

       

        if($(this).hasClass('last')) {
            $(this).removeClass("st2").addClass("blue-bg").addClass("c-tr");
        }
    }).mouseleave(function(){
      $(this).find(".nav-menu-sub").hide();
      $(this).removeClass("current-link-bg");
      
    });
    };
$(document).ready(function() {initMenu();});