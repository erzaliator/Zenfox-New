Ext.ns('com.playdorm');

com.playdorm.AdminReconciliationIndex = Ext.extend(Ext.Panel , 
{
	constructor: function( config )
	{
		config = config || {};
		com.playdorm.AdminReconciliationIndex.superclass.constructor.call(this , Ext.applyIf( config,
		{
			layout	: 'anchor',
			frame	: 'true',
			closable: 'true',
			title	: 'Reconciliation',
			autoScroll:true,
			items	:
				[
				 {
					 xtype	: 'com.playdorm.ReconciliationForm',
					 ref	: 'ReconciliationForm',
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
					xtype: 'com.playdorm.ReconciliationGrid',
				 	ref: 'ReconciliationGrid',
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
		return this.ReconciliationGrid.getGridStore();
	},
	
	onInit: function()
	{
			var bbar = this.ReconciliationGrid.getBottomToolbar();
			bbar.on('beforechange' , this.beforePageUpdate , this);
	},
	
	beforePageUpdate: function()
	{
		Ext.apply(params , this.ReconciliationForm.getForm().getValues());
	},
	
	onSubmitClick: function()
	{
		this.getStore().load({params: this.ReconciliationForm.getForm().getValues()});
	}
	
});


Ext.reg( 'com.playdorm.AdminReconciliationIndex', com.playdorm.AdminReconciliationIndex );