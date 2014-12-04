Ext.ns('com.playdorm');

com.playdorm.AdminPlayerIndex = Ext.extend(Ext.Panel, 
{
	
	
	constructor: function(config)
	{
		
	
		
		
		config = config || {};
		com.playdorm.AdminPlayerIndex.superclass.constructor.call(this, Ext.applyIf(config, 
		{
			layout: 'anchor',
			frame: true,
			closable: true,
			title: 'Player Search',
			//autoScroll:true,
			autoWidth:true,
			items : 
			[
			 	{
			 		xtype : 'com.playdorm.PlayerSearchForm',
			 		ref: 'playerSearchForm',
			 		buttons	:
					  [
					   {
						   text		:'Submit',
						   scale 	: 'medium',
						   width	: 80,
						   handler : this.onSubmitClick.createDelegate(this)
					   }
					   ]
			 	},
			 	{
			 		xtype: 'com.playdorm.PlayerSearchGrid',
			 		ref: 'playerSearchGrid',
			 		height: 200,
			 	//	autoHeight :true,
			 /*		listeners: {
		                resize: function() {
		                    this.setHeight( this.ownerCt.getInnerHeight() );
		                },
		                render: function() {
		                    this.ownerCt.addListener('resize', function() {
		                        Ext.each( this.items.items, function(item) { item.fireEvent('resize'); } );
		                    });
		                }
		            },*/
			 		anchor: '100%' 
			 	}
			],
			listeners: 
			{
				afterrender: this.onInit.createDelegate(this),
				beforeclose:{
			        fn: this.onClose,
			        scope: this
			      }
				
				
			},
			
			
		}));
		
	},
	
	getStore: function()
	{
		console.log("there");
		console.log(this.playerSearchForm.getForm().getValues());
		return this.playerSearchGrid.getSearchGridStore();
	},
	
	onClose : function()
	{
		remakeCookie('com.playdorm.AdminPlayerIndex');
	},
	
	onInit: function()
	{
		//console.log("onInit");
		
		var bbar = this.playerSearchGrid.getBottomToolbar();
		bbar.on('beforechange', this.beforePageUpdate, this);
	},
	
	beforePageUpdate: function(toolbar, params)
	{
		Ext.apply(params, this.playerSearchForm.getForm().getValues());
	},
	
	onSubmitClick: function()
	{
		
	
		this.getStore().load({params: this.playerSearchForm.getForm().getValues()});
	}
});

Ext.reg('com.playdorm.AdminPlayerIndex', com.playdorm.AdminPlayerIndex);