/*******************************************************************/
/* Pixie: The Small, Simple, Site Maker.                           */
/*-----------------------------------------------------------------*/
/* Licence: GNU General Public License v3                   	   */
/* Title: Installer javascript.					   */
/*******************************************************************/

    var $j = jQuery.noConflict();

    $j(function() { 
$j.fn.wait = function(time, type) {
        time = time || 5000;
        type = type || "fx";
        return this.queue(type, function() {
            var self = this;
            setTimeout(function() {
                $j(self).dequeue();
            }, time);
        });
    return false; 
    };

$j('#bg-wrap').fadeIn('slow');

$j(document).ready(function(){
$j(function(form) {
function loadPage() {
$j('.extra').append("<p class=\"return-switch-span\">Click here to <a class=\"return-switch-link\" href=\"javascript:void(0);\">hide these settings</a></p>");
$j('#switch').prepend("<p class=\"switch-span\">Click here for <a class=\"switch-link\" href=\"javascript:void(0);\">extra settings</a></p>");
      $j('.switch-link').click(function (event) { 
      event.preventDefault();
$j('.extra').fadeIn('slow');
$j('html, body').animate({ scrollTop: 500 }, 0);
$j('.switch-span').fadeOut(0);
      });
$j('.return-switch-link').click(function (event) { 
      event.preventDefault();
$j('.extra').fadeOut('slow');
$j('.switch-span').fadeIn('slow');
      });
    $j('.error').show().wait().slideDown('slow').slideUp(function() { 
$j('#placeholder p.toptext').prepend("<div class=\"error-text\">Please click here to see the <a class=\"error-show\" href=\"javascript:void(0);\">error message</a> again.<br/><br/></div>");
$j('.error-text').fadeOut(450).fadeIn(450);
      $j('.error-show').click(function (event) { 
      event.preventDefault();
$j('.error').slideDown();
$j('.error-text').fadeOut(1000).replaceWith("<div class=\"error-text\">Please correct the error and then try again.<br/><br/></div>").fadeIn(2500);
      });
      });
    return true; 
    };
	loadPage();

});

});

$j(function(){

    if ($j('#pixieicon').length >= 1) { $j('#pixieicon').wait(2500).fadeOut('slow'); }

    if ($j('input#username').length >= 1) {

	$j('input#username').one('focus', function(event) {

	    if ($j('input#username').val() === '') {
		var realName = null;
		realName = $j('input#realname').val();
		realName = (realName).toLowerCase();

		    function getWord(str, pos) {
		    var SplitString = str.split(' ');
		    return (SplitString[parseInt(pos) - 1]);

		    }

		userName = getWord(realName, 1);
		$j(this).val(userName);
	    }
	});

    }

});

}); 
