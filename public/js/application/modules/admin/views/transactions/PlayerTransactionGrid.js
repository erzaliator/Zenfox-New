Ext.ns('com.playdorm');

com.playdorm.AdminTransactionAllplayertransactionGrid = Ext.extend(Ext.grid.GridPanel, 
{
	
	constructor: function(config)
	{
	/*var store1 = Ext.Ajax.request({
		  loadMask: true,
		  url:'player/transactiondetail/transId/1/format/json',
		 // params: {id: "1"},
		  success: function(resp) {
		    
		}
	});*/
		config = config || {};
		
		com.playdorm.AdminTransactionAllplayertransactionGrid.superclass.constructor.call(this, Ext.applyIf(config, 
		{
			frame: true,
			loadMask: true,
			autoHeight: true,
			columns:[
			 	    {
			 	        header: "Player Id",
			 	        dataIndex: 'player_id',
			 	        renderer : this.renderTopic,
			 	        width: 10,
			 	        sortable: true
			 	       // hidden:true
			 	    },
			 	    {
			 	        header: "Merchant Trans Id",
			 	        dataIndex: 'merchant_trans_id',
			 	        width: 10,
			 	        sortable: true,
			 	       // hidden:true
			 	       
			 	    },
			 	    {
			 	        header: "Audit Id",
			 	        dataIndex: 'audit_id',
			 	        width: 10,
			 	        sortable: true,
			 	        hidden:true
			 	    },
			 	   {
			 	        header: "Amount",
			 	        dataIndex: 'amount',
			 	        width: 10,
			 	        sortable: true,
			 	     //   hidden: true
			 	    },
			 	   {
			 	        header: "Note",
			 	        dataIndex: 'note',
			 	        width: 10,
			 	        sortable: true,
			 	      //  hidden: true
			 	    },
			 	   {
			 	        header: "Game Flavour",
			 	        dataIndex: 'game_flavour',
			 	        width: 10,
			 	        sortable: true,
			 	      //  hidden: true
			 	    },
			 	    
			 	    
			],
			
			
		
			store: this.getSearchGridStore(),
			viewConfig:
			{
				forceFit:true,
		        enableRowBody:true,
		        showPreview:true
		        
			},
			 bbar: new Ext.PagingToolbar({
			        pageSize: 10,
			        store: this.getSearchGridStore(),
			        displayInfo: true,
			    })
		}));
	},

	getSearchGridStore: function()
	{
		if (!this.searchGridStore)
		{
			this.searchGridStore = new Ext.data.JsonStore(
			{
				url:'/transaction/allplayertransaction/format/json',
				root: 'transactions',
				totalProperty: 'totalCount',
				//idProperty : 'Player Id',
				//remoteSort : true,
				fields:['player_id' 		, 'source_id' 		, 'audit_id' 			, 'merchant_trans_id', 
				        'card_id'			, 'game_flavour'	, 'running_machine_id'	, 'session_id', 
				        'gamelog_id'		, 'amount'			, 'amount_type'			, 'transaction_currency',
				        'notes'				, 'frontend_id'		, 'trans_start_time'	, 'trans_end_time', 
				        'parent_id'			, 'processed'		, 'error'				, 'cash_balance', 
				        'bb_balance'	  	, 'real_change'		, 'bonus_change'		, 'tracker_id', 'csr_id', 
				        'conversion_rate' 	, 'converted_amount', 'bonus_scheme_id'		, 'bonus_level_id',
				        'loyalty_points_left', 'total_loyalty_points', 'user_name']
			});
			//console.log(this.searchGridStore);
		}
		
		return this.searchGridStore;
	},
	
	renderTopic: function (value, p, record)
	{
        /*return String.format(
                '<a href="/en_GB/player/view/id/{0}" onClick="newtab(\'{1}\',\'{2}\',\'{3}\')">{0}</a>',
                value);*/
		//console.log(value);
		var username = record.data.user_name;
		return String.format(
                '<a href="#" onClick="newtab(\'Player\',\'{0}\',\'/en_GB/player/view/playerId/\',\'confirmed\',\'{1}\')">{0}</a>',
                value, username);
	},

});

Ext.reg('com.playdorm.AdminTransactionAllplayertransactionGrid', com.playdorm.AdminTransactionAllplayertransactionGrid);