function initMenu() {
  $('.left-nav ul.navigation ul').hide();
   $('.left-nav ul.navigation li.active ul').show();
  $('.left-nav ul.navigation li a').click(
    function() {
      var checkElement = $(this).next();
      if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
        return false;
        }
      if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
        $('.left-nav ul.navigation ul:visible').slideUp('normal');
        checkElement.slideDown('normal');
        return false;
        }
      }
    );
  }
$(document).ready(function() {initMenu();});