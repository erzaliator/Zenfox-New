/* <![CDATA[ */
$(document).ready(function(){
/* CONFIG */
/* set start (sY) and finish (fY) heights for the list items */

sY = 24; /* height of li.sub */
fY = 165; /* height of maximum sub lines * sub line height */
/* end CONFIG */

/* open first list item */
animate (fY)

$(".navigation .sub").click(function() {
	if (this.className.indexOf('clicked') != -1 ) {
		animate(sY)
		$(this)			.removeClass('clicked')
						.css("background", "#eee url(/images/out.gif) no-repeat 5px 8px")
						.css("color", "#000");
		}
		else {
		animate(sY)
		$('.clicked')	.removeClass('clicked')
						.css("background", "#eee url(/images/out.gif) no-repeat 5px 8px")
						.css("color", "#000");
		$(this)			.addClass('clicked');
		animate(fY)
	}
});

function animate(pY) {
$('.clicked').animate({"height": pY + "px"}, 500);
}

$(".navigation .sub")		.hover(function(){
$(this)					.css("background", "#ddd url(/images/down.gif) no-repeat 5px 8px")
						.css("color", "#c00");
},function(){
if (this.className.indexOf('clicked') == -1) {
$(this)					.css("background", "#eee url(/images/out.gif) no-repeat 5px 8px")
						.css("color", "#000");
}
});

});