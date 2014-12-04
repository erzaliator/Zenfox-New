<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script>
	$(function(){
		$("#static-menu,#static-menu1").hide();
		$(".header-menu .tournament a").click(function(){	
				event.preventDefault();
			$("#static-menu").slideToggle();			   
		});
		$(".header-menu .offer a").click(function(){	
				event.preventDefault();
			$("#static-menu1").slideToggle();			   
		});
	});
</script>