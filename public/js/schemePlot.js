/*
$(document).ready(function(){
        var s1 = [2, 6, 7, 10];
        var ticks = ['a', 'b', 'c', 'd'];
        
        plot1 = $.jqplot('chartdiv', [s1], {
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                }
            },
            highlighter: { show: false }
        });
    
        $('#chartdiv').bind('jqplotDataClick', 
            function (ev, seriesIndex, pointIndex, data) {
                $('#info1').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );
    });
    */

/*
$.jqplot('chartdiv',  [[[1, 2],[3,5.12],[5,13.1],[7,33.6],[9,85.9],[11,219.9]]],
{
  legend:{show:true},
  title:'Scheme Details',
  axes:{yaxis:{min:-10, max:240}},
  series:[{color:'#5FAB78', label:'Scheme Details', lineWidth:5, showMarker:false}]
});
*/

//$(document).ready(fetchData());
$.jqplot.config.enablePlugins = true;

function fetchData(url) {
   $.ajax({
      url:      url,
      method:   "GET",
      dataType: "json",
      success:  function(data) {
         var series = [data.series];
         
		 var options = {
						  //legend:{show:true},
						  title:'Visits',
						 axesDefaults: {
				                labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
				                tickRenderer: $.jqplot.CanvasAxisTickRenderer, 
				            },
						 
						  axes: {
						        xaxis: {
						          renderer:$.jqplot.DateAxisRenderer,
						          tickOptions:{formatString:'%#d-%b-%y'},
						     /*     min:'May 30, 2008',
						          fontSize: '3',
						          showMark: false,
						          //min:'August 1, 2007',
						          tickInterval: "1 days",
						          labelRenderer: $.jqplot.AxisLabelRenderer,
						          label: "date",
						          showLabel: true*/
						          
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
						  series:[{color:'#5FAB78', label:'Scheme Details', lineWidth:1, showMarker:true}],
						  cursor:{zoom:true},
						  highlighter:{show:true},
						  neighborThreshold: 0
						};
		//alert("Plotting");
         plot = $.jqplot('chartdiv', series, options);
		alert("Done");
      }
   });

   //setTimeout(fetchData, 1000);
}
/*function call()
{
	fetchData();
}*/
//call();
