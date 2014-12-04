Ext.ns('com.playdorm');

com.playdorm.ReconciliationGrid = Ext.extend(Ext.grid.GridPanel, 
{
	constructor: function(config)
	{
		config = config || {};
		
		com.playdorm.ReconciliationGrid.superclass.constructor.call(this, Ext.applyIf(config, 
		{
			frame: true,
			loadMask: true,
			//defaults : { autoWidth : true,},
			//width : '200',
			columns:[
			 	   
			         {
			 	        header: "Date & Time",
			 	        dataIndex: 'DateTime',
			 	       // width: 10,
			 	        sortable: true
			 	    },
			 	    {
			 	        header: "Game ID",
			 	        dataIndex: 'Game Id',
			 	        hidden : true,
			 	       // width: 10,
			 	        sortable: true
			 	    },
			 	    {
			 	        header: "Game Type",
			 	        dataIndex: 'Game Type',
			 	       hidden : true,
			 	      //  width: 10,
			 	        sortable: true
			 	    },
			 	   {
			 	        header: "Transcation ID",
			 	        dataIndex: 'Audit Id',
			 	      //  hidden : true,
			 	      //  width: 10,
			 	        sortable: true
			 	    },
			 	   {
			 	        header: "Transcation Type",
			 	        dataIndex: 'Transaction Type',
			 	       // width: 10,
			 	        sortable: true
			 	    },
			 	  /* {
			 	        header: "Amount",
			 	        dataIndex: 'Amount',
			 	        width: 10,
			 	        sortable: true
			 	    },*/
			 	   {
			 	        header: "Amount Type",
			 	        dataIndex: 'Amount Type',
			 	      //  hidden : true,
			 	       // width: 10,
			 	        sortable: true
			 	    },
			 	    
			 	   {
			 	        header: "Real Balance",
			 	        dataIndex: 'Real Balance',
			 	     //   hidden : true,
			 	       // width: 10,
			 	        sortable: true
			 	    },
			 	   {
			 	        header: "Bonus Balance",
			 	        dataIndex: 'Bonus Balance',
			 	        hidden : true,
			 	       // width: 10,
			 	        sortable: true
			 	    },
			 	   {
			 	        header: "Total Balance",
			 	        dataIndex: 'Amount',
			 	      //  width: 10,
			 	        sortable: true
			 	    },
			 	    
			 	   {
			 	        header: "Currency",
			 	        dataIndex: 'Currency',
			 	        hidden : true,
			 	      //  width: 10,
			 	        sortable: true
			 	    },
			 	    
			 	   {
			 	        header: "Real Change",
			 	        dataIndex: 'Real Sub',
			 	    //    hidden:true,
			 	       // width: 10,
			 	        sortable: true
			 	    },
			 	    
			 	   {
			 	        header: "Bonus Change",
			 	        dataIndex: 'Bonus Sub',
			 	    //    hidden:true,
			 	       // width: 10,
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
			        pageSize: 10,
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
				url:'reconciliation/index/format/json',
				root: 'reconciliation',
				totalProperty: 'totalCount',
				idProperty : 'Audit Id',
				fields:['Audit Id' , 'Transaction Type' , 'Amount Type' , 'Currency' , 'Amount' , 'Real Balance','Bonus Balance','Balance' , 'Real Sub' , 'Bonus Sub' , 'Processed' , 'Game Id', 'Game Type','DateTime' ]
			});
		}
		return this.searchGridStore;
	},
	
});

Ext.reg('com.playdorm.ReconciliationGrid', com.playdorm.ReconciliationGrid);