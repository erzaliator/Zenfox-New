/*!
 * Ext JS Library 3.2.1
 * Copyright(c) 2006-2010 Ext JS, Inc.
 * licensing@extjs.com
 * http://www.extjs.com/license
 */

function playerBuddyList(name, playerId)
{
Ext.onReady(function(){
	
	var field = [
	              	{name: 'id'}, {name: 'login'}, {name: 'email'}
				];
	var column = [

               	{header:"Player Id", dataIndex: 'id', sortable: true},
             	{header: "Login Name", width: 100, dataIndex: 'login', sortable: true},
             	{header: "Email", width: 100, dataIndex: 'email', sortable: true}
	              
	              ];

	var store = new Ext.data.JsonStore(
			{
				url:'player/buddy/playerId/'+playerId+'/format/json',
				autoLoad:true,
				root: 'data',
				totalProperty: 'totalCount',
				idProperty : 'aaa',
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
    	title: name+'\'s buddy',
    	width:750,
    	height:500,
    	bodyStyle:'background-color:#fff;padding: 10px',
    	items:[grid/*,
    	       {
    	    	   xtype: 'box',
    	    	   autoEl: {
    	    	   tag: 'h1',
    	    	   html: 'Oh'
    	    	   }
    	       }*/
    	],
    	buttonAlign: 'right', 
    	buttons: []
    	});
    winGameLog.show();
});
}
