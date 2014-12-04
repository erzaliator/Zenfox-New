<?php
class Zenfox_View_Helper_Dateform extends Zend_View_Helper_Abstract
{
	public $view;
	
	public function setView(Zend_View_Interface $view)
	{
		$this->view = $view;
	}
	
	public function dateform($fromDate, $toDate, $fromHour, $toHour, $fromMinute, $toMinute, $fromPM, $toPM, $items, $formType = NULL)
	{
		?>
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
		<!-- link rel="stylesheet" href="/resources/demos/style.css" /-->
		<script>
		$(function() {
		$('#from_date').datepicker({
		    //comment the beforeShow handler if you want to see the ugly overlay
		    beforeShow: function() {
		        setTimeout(function(){
		            $('.ui-datepicker').css('z-index', 99999999999999);
					
		        }, 0);
		    },
			dateFormat:"yy-mm-dd",
			changeMonth:true,
			changeYear:true,
			yearRange:"2010:2014"
			
		});
		$("#to_date").datepicker({"dateFormat":"yy-mm-dd","changeMonth":true,"changeYear":true,"yearRange":"2010:2014"});
		});
		</script>
		
		<div style="line-height:30px">
		<form id="player-date-selection-form" method="post" action="" enctype="application/x-www-form-urlencoded" name="player-date-form">
		<dl class="zend_form">
		<?php 
		if($formType == 'gamelog')
		{
			?>
			<dt id="gamelog-type-label"><label class="optional">Select Game</label></dt>
			<dd id="gamelog-type-element">
			<label><input type="radio" onclick="submitGamelog()" value="bingo" id="gamelog-type-bingo" name="type">Bingo</label>
			<br>
			<label><input type="radio" onclick="submitGamelog()" value="slot" id="gamelog-type-slot" name="type">Slots</label>
			<br>
			<label><input type="radio" onclick="submitGamelog()" value="roulette" id="gamelog-type-roulette" name="type">Roulette</label>
			<br>
			<label><input type="radio" onclick="submitGamelog()" checked="checked" value="keno" id="gamelog-type-keno" name="type">Keno</label></dd>
			<?php 
		}
		?>
		<ul>
		<li>
		<label class="required" for="from_date">From Date</label>
		<input id="from_date" class="text" type="text"  name="from_date" value="<?=$fromDate ?>">
		</li>
		<li>
		<label class="required" for="from_time">Time</label>
		<!--<input id="from_time" type="text" value="00:00" name="from_time">-->
		<select id="h_from_time" class="report_time" name="h_from_time">
		<option value="1" <?=($fromHour == 1 || $fromHour == 13)?"selected":"" ?>>1</option>
		<option value="2" <?=($fromHour == 2 || $fromHour == 14)?"selected":"" ?>>2</option>
		<option value="3" <?=($fromHour == 3 || $fromHour == 15)?"selected":"" ?>>3</option>
		<option value="4" <?=($fromHour == 4 || $fromHour == 16)?"selected":"" ?>>4</option>
		<option value="5" <?=($fromHour == 5 || $fromHour == 17)?"selected":"" ?>>5</option>
		<option value="6" <?=($fromHour == 6 || $fromHour == 18)?"selected":"" ?>>6</option>
		<option value="7" <?=($fromHour == 7 || $fromHour == 19)?"selected":"" ?>>7</option>
		<option value="8" <?=($fromHour == 8 || $fromHour == 20)?"selected":"" ?>>8</option>
		<option value="9" <?=($fromHour == 9 || $fromHour == 21)?"selected":"" ?>>9</option>
		<option value="10" <?=($fromHour == 10 || $fromHour == 22)?"selected":"" ?>>10</option>
		<option value="11" <?=($fromHour == 11 || $fromHour == 23)?"selected":"" ?>>11</option>
		<option value="12" <?=($fromHour == 12 || $fromHour == 00)?"selected":"" ?>>12</option>
		</select>
		:
		<select id="m_from_time" class="report_time" name="m_from_time">
		<option value="00" <?=($fromMinute == 0)?"selected":"" ?>>00</option>
		<option value="05" <?=($fromMinute >= 1 && $fromMinute <= 5)?"selected":"" ?>>05</option>
		<option value="10" <?=($fromMinute >= 6 && $fromMinute <= 10)?"selected":"" ?>>10</option>
		<option value="15" <?=($fromMinute >= 11 && $fromMinute <= 15)?"selected":"" ?>>15</option>
		<option value="20" <?=($fromMinute >= 16 && $fromMinute <= 20)?"selected":"" ?>>20</option>
		<option value="25" <?=($fromMinute >= 21 && $fromMinute <= 25)?"selected":"" ?>>25</option>
		<option value="30" <?=($fromMinute >= 26 && $fromMinute <= 30)?"selected":"" ?>>30</option>
		<option value="35" <?=($fromMinute >= 31 && $fromMinute <= 35)?"selected":"" ?>>35</option>
		<option value="40" <?=($fromMinute >= 36 && $fromMinute <= 40)?"selected":"" ?>>40</option>
		<option value="45" <?=($fromMinute >= 41 && $fromMinute <= 45)?"selected":"" ?>>45</option>
		<option value="50" <?=($fromMinute >= 46 && $fromMinute <= 50)?"selected":"" ?>>50</option>
		<option value="55" <?=($fromMinute >= 51 && $fromMinute <= 55)?"selected":"" ?>>55</option>
		</select>
		<select id="p_from_time" class="report_time" name="p_from_time">
		<option selected="" value="am">am</option>
		<option value="pm" <?=($fromPM)?"selected":"" ?>>pm</option>
		</select>
		</select>
		</li>
		<li>
		<label class="required" for="to_date">To Date</label>
		<input id="to_date" class="text" type="text"  name="to_date" value="<?=$toDate ?>">
		</li>
		<li>
		<label class="required" for="to_time">Time</label>
		<!--<input id="to_time" type="text" value="" name="to_time">-->
		<select id="h_to_time" class="report_time" name="h_to_time">
		<option value="1" <?=($toHour == 1 || $toHour == 13)?"selected":"" ?>>1</option>
		<option value="2" <?=($toHour == 2 || $toHour == 14)?"selected":"" ?>>2</option>
		<option value="3" <?=($toHour == 3 || $toHour == 15)?"selected":"" ?>>3</option>
		<option value="4" <?=($toHour == 4 || $toHour == 16)?"selected":"" ?>>4</option>
		<option value="5" <?=($toHour == 5 || $toHour == 17)?"selected":"" ?>>5</option>
		<option value="6" <?=($toHour == 6 || $toHour == 18)?"selected":"" ?>>6</option>
		<option value="7" <?=($toHour == 7 || $toHour == 19)?"selected":"" ?>>7</option>
		<option value="8" <?=($toHour == 8 || $toHour == 20)?"selected":"" ?>>8</option>
		<option value="9" <?=($toHour == 9 || $toHour == 21)?"selected":"" ?>>9</option>
		<option value="10" <?=($toHour == 10 || $toHour == 22)?"selected":"" ?>>10</option>
		<option value="11" <?=($toHour == 11 || $toHour == 23)?"selected":"" ?>>11</option>
		<option value="12" <?=($toHour == 12 || $toHour == 00)?"selected":"" ?>>12</option>
		</select>
		:
		<select id="m_to_time" class="report_time" name="m_to_time">
		<option value="00" <?=($toMinute == 0)?"selected":"" ?>>00</option>
		<option value="05" <?=($toMinute >= 1 && $toMinute <= 5)?"selected":"" ?>>05</option>
		<option value="10" <?=($toMinute >= 6 && $toMinute <= 10)?"selected":"" ?>>10</option>
		<option value="15" <?=($toMinute >= 11 && $toMinute <= 15)?"selected":"" ?>>15</option>
		<option value="20" <?=($toMinute >= 16 && $toMinute <= 20)?"selected":"" ?>>20</option>
		<option value="25" <?=($toMinute >= 21 && $toMinute <= 25)?"selected":"" ?>>25</option>
		<option value="30" <?=($toMinute >= 26 && $toMinute <= 30)?"selected":"" ?>>30</option>
		<option value="35" <?=($toMinute >= 31 && $toMinute <= 35)?"selected":"" ?>>35</option>
		<option value="40" <?=($toMinute >= 36 && $toMinute <= 40)?"selected":"" ?>>40</option>
		<option value="45" <?=($toMinute >= 41 && $toMinute <= 45)?"selected":"" ?>>45</option>
		<option value="50" <?=($toMinute >= 46 && $toMinute <= 50)?"selected":"" ?>>50</option>
		<option value="55" <?=($toMinute >= 51 && $toMinute <= 55)?"selected":"" ?>>55</option>
		</select>
		<select id="p_to_time" class="report_time" name="p_to_time">
		<option value="am">am</option>
		<option value="pm" <?=($toPM)?"selected":"" ?>>pm</option>
		</select>
		</select>
		</li>
		<li>
		<label class="optional" for="page">Result per page</label>
		<select id="page" name="page">
		<option value="10" <?=($items == 10)?"selected":"" ?>>10</option>
		<option value="20" <?=($items == 20)?"selected":"" ?>>20</option>
		<option value="30" <?=($items == 30)?"selected":"" ?>>30</option>
		<option value="40" <?=($items == 40)?"selected":"" ?>>40</option>
		<option value="50" <?=($items == 50)?"selected":"" ?>>50</option>
		</select>
		</li>
		<li class="login_form_button ttsaveprofilelibg">
		<input id="submit" type="submit" value="Submit" name="submit">
		</li>
		</ul>
		</dl>
		</form>
		 </div>            
		
		
		
				
		<?php
	}
}
