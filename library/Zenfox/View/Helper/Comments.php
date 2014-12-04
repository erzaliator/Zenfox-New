<?php
class Zenfox_View_Helper_Comments extends Zend_View_Helper_Abstract
{
	public $view;
	
	public function setView(Zend_View_Interface $view)
	{
		$this->view = $view;
	}
	
	public function comments()
	{
		$jquery = $this->view->jQuery();
        $jquery->enable();
		$jqHandler = ZendX_JQuery_View_Helper_JQuery::getJQueryHandler();
		$function = '$(window).scroll(function()' .
		'{' .
			' $("#message_box").animate({top:$(window).scrollTop()+"px" },{queue: false, duration: 350});' .
		'});' .
		'$(document).ready(function()' .
		'{' .
			'var count = 0;' .
			'$("#comment").hide();' .
			'$(".paly-report-forms").hide();' .
			'$("a.nik").hide();' .
			'$(".pagination").hide();' .
			'$("#close_message").click(function()' .
			'{' .
				'if(count%2 == 0)' .
				'{' .
					'$("#comment").show();' .
					'$("a.nik").show();' .
					'$("a.nik").click(function(event)' .
					'{' .
						'$(".paly-report-forms").show();' .
						'$("a.nik").hide();' .
						'$(".pagination").show();' .
						
						'event.preventDefault();' .
					'});' .
				'}' .
				'else' .
				'{' .
					'$("#comment").hide();' .
					'$(".paly-report-forms").hide();' .
					'$("a.nik").hide();' .
					'$(".pagination").hide();' .
				'}' .
				'count++;' .
			'});' .
		'})';
		$jquery->addOnload($jqHandler . $function);
        return '';
	}
}