Ext.ns('com.playdorm');

com.playdorm.AdminAffiliatesearchIndex = Ext.extend(Ext.Panel, 
{
	constructor: function(config)
	{
		config = config || {};
		com.playdorm.AdminAffiliatesearchIndex.superclass.constructor.call(this, Ext.applyIf(config, 
		{
			layout: 'anchor',
			frame: true,
			closable: true,
			title: 'Affiliate Search',
			//autoScroll:true,
			autoWidth:true,
			items : 
			[
			 	{
			 		xtype : 'com.playdorm.AffiliateSearchingForm',
			 		ref: 'AffiliateSearchForm',
			 		buttons	:
					  [
					   {
						   text		:'Submit',
						   scale 	: 'medium',
						   width	: 80,
						   formBind : true,
						   handler : this.onSubmitClick.createDelegate(this)
					   }
					   ]
			 	},
			 	{
			 		xtype: 'com.playdorm.AffiliateSearchingGrid',
			 		ref: 'AffiliateSearchGrid',
			 		//height: 300,
			 		autoHeight :true,
			 		anchor: '100%' 
			 	}
			],
			listeners: 
			{
				afterrender: this.onInit.createDelegate(this)
			}
		}));
	},
	
	getStore: function()
	{
		return this.AffiliateSearchGrid.getSearchGridStore();
	},
	
	onInit: function()
	{
		var bbar = this.AffiliateSearchGrid.getBottomToolbar();
		bbar.on('beforechange', this.beforePageUpdate, this);
	},
	
	beforePageUpdate: function(toolbar, params)
	{
		Ext.apply(params, this.AffiliateSearchForm.getForm().getValues());
	},
	
	onSubmitClick: function()
	{
		this.getStore().load({params: this.AffiliateSearchForm.getForm().getValues()});
	}
});

Ext.reg('com.playdorm.AdminAffiliatesearchIndex', com.playdorm.AdminAffiliatesearchIndex);