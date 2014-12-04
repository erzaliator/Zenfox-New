Ext.ns('com.playdorm');

com.playdorm.AdminTransactionAllplayertransaction = Ext.extend(Ext.Panel, 
{
	constructor: function(config)
	{
		
		config = config || {};
		com.playdorm.AdminTransactionAllplayertransaction.superclass.constructor.call(this, Ext.applyIf(config, 
		{
			layout		: 'anchor',
			frame		: true,
			closable	: true,
			title		: 'Transactions',
			autoScroll	: true,
			autoWidth	: true,
			items 		: 
			[
			 	{
			 		xtype 	: 'com.playdorm.AdminTransactionAllplayertransactionForm',
			 		ref	  	: 'playerTransactionForm',
			 		buttons	:
					  [
					   {
						   text		: 'Submit',
						   scale 	: 'medium',
						   width	: 80,
						   handler 	: this.onSubmitClick.createDelegate(this)
					   }
					   ]
			 	},
			 	{
			 		xtype	: 'com.playdorm.AdminTransactionAllplayertransactionGrid',
			 		ref		: 'playerTransactionGrid',
			 		height	: 100,
			 	//	autoHeight :true,
			 		listeners	: {
		                resize	: function() {
		                    this.setHeight(this.ownerCt.getInnerHeight());
		                },
		                render: function() {
		                    this.ownerCt.addListener('resize', function() {
		                        Ext.each( this.items.items, function(item) { item.fireEvent('resize'); } );
		                    });
		                }
		            }//,
			 		//anchor: '100%' 
			 	},
			 	
			 	{html:"<a href='/transaction/allplayertransaction/download/true/format/json' target='_blank'>download</a>"}
			],
			listeners: 
			{
				afterrender: this.onInit.createDelegate(this),
				beforeclose:{
			        fn: this.onClose,
			        scope: this
			      }
			}
		}));
	},
	
	getStore: function()
	{
		console.log("there");
		console.log(this.playerTransactionForm.getForm().getValues());
		return this.playerTransactionGrid.getSearchGridStore();
	},
	
	onClose : function()
	{
		remakeCookie('com.playdorm.AdminTransactionAllplayertransaction');
	},
	
	onInit: function()
	{
		//console.log("onInit");
		
		var bbar = this.playerTransactionGrid.getBottomToolbar();
		bbar.on('beforechange', this.beforePageUpdate, this);
	},
	
	beforePageUpdate: function(toolbar, params)
	{
		Ext.apply(params, this.playerTransactionForm.getForm().getValues());
	},
	
	onSubmitClick: function()
	{
		
	
		this.getStore().load({params: this.playerTransactionForm.getForm().getValues()});
	}
});

Ext.reg('com.playdorm.AdminTransactionAllplayertransaction', com.playdorm.AdminTransactionAllplayertransaction);