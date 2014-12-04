/*
 * jQuery timepicker
 * 
 * Replaces a 24-hour date in a text input with a set of pulldowns to select hour, minute, and am/pm
 *
 * Copyright (c) 2010 Wade Shearer
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php) 
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 *
 * Version 1.0
 *
 * Original concept by Jason Huck
 */

(function($) {
	jQuery.fn.clockpick = function() {
		this.each(function() {
			
			alert('hi');
			// get the ID and value of the current element
			var i = this.id;
			var v = $(this).val();
			
			// the options we need to generate
			var hrs = new Array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');
			var mins = new Array('00', '05', '10', '15', '20', '25', '30', '35', '40', '45', '50', '55');
			var ap = new Array('am', 'pm');
			
			// get time (from input or current if blank)
			var d;
			var h;
			var m;
			
			if(v.length == 5) {
				h = parseInt(v.substr(0, 2), 10);
				m = parseInt(v.substr(3, 2), 10);
			} else {
				d = new Date;
				h = d.getHours();
				m = d.getMinutes();
			}

			// round minutes up to nearest option
			for(mn in mins) {
				if(m <= parseInt(mins[mn], 10)) {
					m = parseInt(mins[mn], 10);
					break;
				}
			}
			
			var p = (h >= 12 ? 'pm' : 'am');
			
			// adjust hour to 12-hour format
			if(h > 12) h = h - 12;
			if(h == 00) h = 12;

			// increment hour if we push minutes to next 00
			if(m > 55) {
				m = 00;
				
				switch(h) {
					case(11):
						h += 1;
						p = (p == 'am' ? 'pm' : 'am');
						break;
					
					case(12):
						h = 1;
						break;
					
					default: 
						h += 1;
						break;
				}
			}

			// build the new DOM objects
			var output = '';

			var hVal;
			output += '<select id="h_' + i + '" class="h timepicker">';
			for(hr in hrs) {
				output += '<option value="' + hrs[hr] + '"';
				if(parseInt(hrs[hr], 10) == h) { output += ' selected'; hVal = h; }
				output += '>' + hrs[hr] + '</option>';
			}
			output += '</select> : ';
			
			var mVal;
			output += '<select id="m_' + i + '" class="m timepicker">';
			for(mn in mins) {
				output += '<option value="' + mins[mn] + '"';
				if(parseInt(mins[mn], 10) == m) { output += ' selected'; mVal = m; }
				output += '>' + mins[mn] + '</option>';
			}
			output += '</select> ';
			
			var pVal;
			output += '<select id="p_' + i + '" class="p timepicker">';
			for(pp in ap) {
				output += '<option value="' + ap[pp] + '"';
				if(ap[pp] == p) { output += ' selected'; pVal = p; }
				output += '>' + ap[pp] + '</option>';
			}
			output += '</select>';
			
			// adjust hour to 24-hour format
			if((hVal < 12) && (p == 'pm')) hVal = hVal + 12;
			if(hVal == 00) hVal = 12;

			// write into original input, hide original input, and append new replacement inputs
			$(this).val(hVal + ':' + mVal).css('display', 'none').after(output);
		});
		
		$('select.timepicker').change(function() {
			var i = this.id.substr(2);
			var h = $('#h_' + i).val();
			var m = $('#m_' + i).val();
			var p = $('#p_' + i).val();
			
			// adjust hour to 24-hour format
			if(p == 'pm' && h != 12) {
				h = parseInt(h) + 12;
			} else if(p == 'am' && h == 12) {
				h = 00;
			}
			
			var v = h + ':' + m;
			
			$('#' + i).val(v);
		});
		
		return this;
	};
})(jQuery);
