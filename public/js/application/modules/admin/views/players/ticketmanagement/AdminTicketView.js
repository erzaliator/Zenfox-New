Ext.ns('com.playdorm');

com.playdorm.AdminTicketView = Ext.extend(Ext.Panel , 
{
	constructor: function( config )
	{
		config = config || {};
		com.playdorm.AdminTicketView.superclass.constructor.call(this , Ext.applyIf( config,
		{
			layout	: 'anchor',
			frame	: 'true',
			closable: 'true',
			title	: 'Ticket View',
			autoScroll:true,
			items	:
				[
				{
					 xtype	: 'com.playdorm.TicketViewForm',
					 ref	: 'TicketViewForm',
					 buttons: 
						 [
						  {		
							  text	: 'Submit',
							  scale	: 'medium',
							  width	: 80,
							  handler: this.onSubmitClick.createDelegate(this)
						  }
						 ]
				 },
				 
				 {
					xtype: 'com.playdorm.TicketViewGrid',
				 	ref: 'TicketViewGrid',
				 	autoHeight:true,
				 	anchor: '100%' 
				 }
				 
				],
				
				listeners:
				{
					afterrender: this.onInit.createDelegate(this),
				}
		
		}));
	},
	
	getStore: function()
	{
		return this.TicketViewGrid.getGridStore();
	},
	
	onInit: function()
	{
			var bbar = this.TicketViewGrid.getBottomToolbar();
			bbar.on('beforechange' , this.beforePageUpdate , this);
	},
	
	beforePageUpdate: function()
	{
		Ext.apply(params , this.TicketViewForm.getForm().getValues());
	},
	
	onSubmitClick: function()
	{
		this.getStore().load({params: this.TicketViewForm.getForm().getValues()});
	}

});


Ext.reg( 'com.playdorm.AdminTicketView', com.playdorm.AdminTicketView );