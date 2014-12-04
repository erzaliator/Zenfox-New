Ext.ns('com.playdorm');

com.playdorm.TicketViewGrid = Ext.extend(Ext.grid.GridPanel, 
{
	constructor: function(config)
	{
		config = config || {};
		
		com.playdorm.TicketViewGrid.superclass.constructor.call(this, Ext.applyIf(config, 
		{
			frame: true,
			loadMask: true,
			columns:[
			         {
			 	        header: "Ticket Id",
			 	        dataIndex: 'ticket_id',
			 	      //  width: 10,
			 	        renderer: this.renderTopic,
			 	        sortable: true
			 	    },
			 	    {
			 	        header: "User Id",
			 	        dataIndex: 'user_id',
			 	      //  width: 10,
			 	        sortable: true,
			 	        hidden:true,
			 	    },
			 	    {
			 	        header: "Subject",
			 	        dataIndex: 'subject',
			 	        //width: 10,
			 	        sortable: true
			 	    },
			 	   {
			 	        header: "Start Date",
			 	        dataIndex: 'start_date',
			 	        //width: 10,
			 	        sortable: true
			 	    },
			 	   {
			 	        header: "Status",
			 	        dataIndex: 'ticket_status',
			 	        //width: 10,
			 	        sortable: true
			 	    },
			 	  
			],
			store: this.getGridStore(),
			viewConfig:
			{
				forceFit:true,
		        enableRowBody:true,
		        showPreview:true
			},
			 bbar: new Ext.PagingToolbar({
			        pageSize: 100,
			        store: this.getGridStore(),
			        displayInfo: true,
			    })
		}));
	},
	
	getGridStore: function()
	{
		if (!this.searchGridStore)
		{
			this.searchGridStore = new Ext.data.JsonStore(
			{
				url:'ticket/view/format/json',
				root: 'ticketdetails',
				totalProperty: 'totalCount',
				idProperty : 'ticket_id',
				fields:['ticket_id' ,'user_id' , 'subject' ,'start_date' , 'ticket_status' ]
			});
		}
		return this.searchGridStore;
	},
	
	renderTopic: function(value, p, record)
	{
		console.log(record.data.ticket_id);
		return String.format(
	            '<b><a href="#" onclick="callReplyPanel({0},{1})">{0}</a>',
	            record.data.ticket_id, record.data.user_id);	
	}
	
	
});


Ext.reg('com.playdorm.TicketViewGrid', com.playdorm.TicketViewGrid);