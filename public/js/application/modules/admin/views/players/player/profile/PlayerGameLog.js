/*!
 * Ext JS Library 3.2.1
 * Copyright(c) 2006-2010 Ext JS, Inc.
 * licensing@extjs.com
 * http://www.extjs.com/license
 */

function playerGameLog(name, playerId,  type)
{
Ext.onReady(function(){
if(type == 'keno')
{
	var field = [
	              	{name: 'log_id'}, {name: 'session_id'}, {name: 'player_id'}, {name: 'frontend_id'}, {name: 'bet _amount'}, 
					{name: 'generated_numbers'}, {name: 'selected_numbers'}, {name: 'win_string'}, {name: 'win_amount'},
					{name: 'datetime'}, {name: 'amount _type'}, {name: 'pjp_winstatus'}, {name: 'pjp_win_amount'}, 
					{name: 'wagered_currency'}, {name: 'spin_type'}, {name: 'extra_data'}
				];
	var column = [

                  	{header:"Date Time", dataIndex: 'datetime', sortable: true},
                	{header: "Log ID", width: 100, dataIndex: 'log_id', sortable: true},
                	{header: "Player ID", width: 100, dataIndex: 'player_id', sortable: true},
                	{header: "session  ID", width: 100, dataIndex: 'session_id', sortable: true},
                	{header: "Bet Amount", width: 100, dataIndex: 'bet_amount', sortable: true},
                	{header: "Generated Number", width: 200, dataIndex: 'generated_numbers', sortable: true},
                	{header: "Selected Numbers", width: 200, dataIndex: 'selected_numbers', sortable: true}
	              
	              ];
}

if(type == 'roulette')
{
	var field = [
	              	{name: 'log_id'}, {name: 'session_id'}, {name: 'player_id'}, {name: 'machine_id'}, {name: 'frontend_id'}, {name: 'bet_amount'}, 
					{name: 'generated_numbers'}, {name: 'selected_numbers'}, {name: 'win_string'}, {name: 'win_amount'},
					{name: 'datetime'}, {name: 'amount _type'}, {name: 'pjp_winstatus'}, {name: 'pjp_win_amount'}, 
					{name: 'wagered_currency'}, {name: 'spin_type'}, {name: 'extra_data'}, {name:'bet_string'}
				];
	var column = [

               	{header:"Date Time", dataIndex: 'datetime', sortable: true},
             	{header: "Log ID", width: 100, dataIndex: 'log_id', sortable: true},
             	{header: "Player ID", width: 100, dataIndex: 'player_id', sortable: true},
             	{header: "session  ID", width: 100, dataIndex: 'session_id', sortable: true},
             	{header: "Bet Amount", width: 100, dataIndex: 'bet_amount', sortable: true},
             	{header: "Bet String", width: 100, dataIndex: 'bet_string', sortable: true},
             	{header: "Generated Number", width: 200, dataIndex: 'generated_numbers', sortable: true},
             	{header: "Selected Numbers", width: 200, dataIndex: 'selected_numbers', sortable: true}
	              
	              ];
}

if(type == 'slot')
{
	var field = [
	              	{name: 'log_id'}, {name: 'session_id'}, {name: 'player_id'}, {name: 'wagered_currency'}, 
	              	{name: 'machine_id'}, /*{name: 'frontend_id'}, {name: 'bet_amount'},*/{name: 'bet_coins'}, 
	              	{name: 'bet_lines'}, {name: 'bet_amount'}, {name: 'win_lines'},{name: 'win_amount'}, 
	              	{name: 'datetime'},{name: 'amount_type'}, {name: 'pjp_winstatus'}, {name: 'pjp_id'}, 
	              	{name: 'pjp_rng'}, {name: 'pjp_win_amount'}, 
	              	{name: 'running_machine_id'},{name: 'game_flavour'},{name: 'spin_type'}, {name: 'win_string'}, 
	              	{name:'frontend_id'}
				];
	var column = [

               	{header:"Date Time", dataIndex: 'datetime', sortable: true},
             	{header: "Log ID", width: 100, dataIndex: 'log_id', sortable: true},
             	{header: "Player ID", width: 100, dataIndex: 'player_id', sortable: true},
             	{header: "session  ID", width: 100, dataIndex: 'session_id', sortable: true},
             	{header: "Bet Coins", width: 100, dataIndex: 'bet_coins', sortable: true},
             	{header: "Bet lines", width: 100, dataIndex: 'bet_lines', sortable: true}
             	
	              
	              ];
}
	var store = new Ext.data.JsonStore(
			{
				url:'gamelog/index/playerId/'+playerId+'/type/'+type+'/format/json',
				autoLoad:true,
				root: 'data',
				totalProperty: 'totalCount',
				idProperty : 'aaada',
				fields:field
			});

	
	var pagesize = 15;
	var paging_toolbar = new Ext.PagingToolbar({
	pageSize: pagesize,
	displayInfo: true,
	emptyMsg: 'No data found',
	store: store
	})

	store.load({params:{start:0,limit:pagesize}});

    // create the grid
    var grid = new Ext.grid.GridPanel({
        store: store,
        columns: column,
      
        viewConfig:
		{
			//forceFit:true,
	        enableRowBody:true,
	        showPreview:true
		},
		//bbar:paging_toolbar,
		
		    layout : 'fit',
		    height : 300
       
    });
    
    var winGameLog = new Ext.Window({
    	title: name+'\'s '+type+' log',
    	width:750,
    	height:500,
    	bodyStyle:'background-color:#fff;padding: 10px',
    	items:[grid,
    	       {
    	    	   xtype: 'box',
    	    	   autoEl: {
    	    	   tag: 'h1',
    	    	   html: 'Oh'
    	    	   }
    	       }
    	],
    	buttonAlign: 'right', 
    	buttons: []
    	});
    winGameLog.show();
});
}
