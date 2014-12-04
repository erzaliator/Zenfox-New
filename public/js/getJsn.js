/**
 * 
 */

$.jqplot.config.enablePlugins = true;
//url1 = "/tracker/uniquevisitors";
//url2 = "/tracker/visitors";

//getIt(url1,url2);


function getIt(url1, url2)
{ 
	var line1 = url1;
	var line2 = url2;

$.getJSON(url1,
  {
    tags: "cat",
    tagmode: "any",
    format: "json"
  },
  function(data) {
	  var series0 = data.series;
	 
	  
	  $.getJSON(url2,
			  {
			    tags: "cat",
			    tagmode: "any",
			    format: "json"
			  },
			  function(data) {
				  var series1 = data.series;
				
				 
				  console.log(series0);
				  console.log(series1);
				//  console.log(s);
				  var lab1 = line1.split("/");
				  var lab2 = line2.split("/");
				  if(lab1[2] == 'uniquevisitors') var label1 = 'Unique visits';
				  if(lab1[2] == 'visitors') var label1 = 'Visits';
				  if(lab2[2] == 'uniquevisitors') var label2 = 'Unique visits';
				  if(lab2[2] == 'visitors') var label2 = 'Visits';
				  
				/* l1 = [["2011-06-03",0],["2011-06-02",3],["2011-06-01",0],["2011-05-31",0],["2011-05-30",0],["2011-05-29",0],["2011-05-28",0]];
				 l2 =  [["2011-06-03",0],["2011-06-02",3],["2011-06-01",0],["2011-05-31",0],["2011-05-30",0],["2011-05-29",0],["2011-05-28",0]];*/
				 //console.log(l1);
				 
				 
				  sr = {
						 axesDefaults: {
							 					labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
				                				tickRenderer: $.jqplot.CanvasAxisTickRenderer 
				               
						 				},
						 				
						 				
						 axes: 			{				
							 					xaxis: {
												          renderer:$.jqplot.DateAxisRenderer,
												          tickOptions:{formatString:'%#d-%b-%y'}
					         
					        							},
						        
										        yaxis: {
												        	min:0,
												        	//max:5,
												        	tickInterval: 1,
												        	labelRenderer: $.jqplot.AxisLabelRenderer
												           // renderer: $.jqplot.LogAxisRenderer,
												            //tickOptions:{formatString:'$%.2f'}
										        		}
						 				},
					      
			 				legend:		{show:true},
			 				
					        series:		[ {label:label2}, {label:label1}, {showLabel:true}, {showLabel:true}],
					        
					        cursor:		{zoom:true},
					        
					        highlighter:{show:true},
					        
					        neighborThreshold: 0
					    }
		
			
				
				  $("#chartdiv").empty();
				  plot = $.jqplot('chartdiv', [series1,series0]  ,sr);
				  
			  });
  });

}