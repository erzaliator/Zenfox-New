Ext.ns('com.playdorm');

com.playdorm.PlayerProfileGrid = Ext.extend(Ext.grid.GridPanel, 
{
	constructor: function(config)
	{
		config = config || {};
		
		com.playdorm.PlayerProfileGrid.superclass.constructor.call(this, Ext.applyIf(config, 
				{
					frame: true,
					loadMask: true,
				//	autoHeight: true,
					columns:[
					 	    {
					 	        header: "Player Id",
					 	        dataIndex: 'Player Id',
					 	        renderer : this.renderTopic,
					 	        width: 10,
					 	        sortable: true,
					 	    },
					 	    {
					 	        header: "User Name",
					 	        dataIndex: 'User Name',
					 	        width: 10,
					 	        sortable: true
					 	    },
					 	    {
					 	        header: "Email",
					 	        dataIndex: 'Email',
					 	        width: 10,
					 	        sortable: true
					 	    },
					 	   {
					 	        header: "Type",
					 	        dataIndex: 'Type',
					 	        width: 10,
					 	        sortable: true,
					 	        hidden: true
					 	    },
					 	    
					],
					
					
				
					store: new Ext.data.JsonStore(
			                {
			                    // load using HTTP
			                	
			                    url: '/searching/index/format/json',
			                    autoLoad: true,
			                    fields: [
			                        {name: 'Player Id', type: 'string'},
			                        {name: 'User Name', type: 'string'},
			                        {name: 'Email', type: 'string'},
			                        {name: 'Type', type: 'string'}
			                    ],
			                    sortInfo:{field:'username', direction:'ASC'}
			                }
			            ),
					
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
						
						url:'/searching/index/format/json',
						root: 'players',
						totalProperty: 'totalCount',
						idProperty : 'Player Id',
						//remoteSort : true,
						fields:['Player Id' , 'User Name' , 'Email' , 'Type']
					});
					console.log(Ext.getCmp('com.playdorm.PlayerProfileGrid'));
				}
				return this.searchGridStore;
			}
});

			
Ext.reg('com.playdorm.PlayerProfileGrid', com.playdorm.PlayerProfileGrid);