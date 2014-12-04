Ext.ns('com.playdorm');

com.playdorm.AdminTicketReply = Ext.extend(Ext.Panel, 
{
	constructor: function(config)
	{
		config = config || {};
		com.playdorm.AdminTicketReply.superclass.constructor.call(this, Ext.applyIf(config, 
		{
			layout: 'anchor',
			frame: true,
			closable: true,
			title: 'Ticket Reply',
			//autoScroll:true,
			autoWidth:true,
			items : 
			[
					{
						xtype: 'com.playdorm.TicketReplyGrid',
						ref: 'TicketReplyGrid',
						//height: 300,
						autoHeight :true,
						anchor: '100%' 
					},
					
					{
			 		xtype : 'com.playdorm.TicketReplyForm',
			 		ref: 'TicketReplyForm',
			 		buttons	:
					  [
					   {
						   text		:'Reply',
						   scale 	: 'medium',
						   width	: 80,
						   handler : this.onSubmitClick.createDelegate(this)
					   }
					   ]
			 	},
			 	
			],
			listeners: 
			{
				afterrender: this.onInit.createDelegate(this)
				//beforerender : this.onInit().createDelegate(this)
			}
		}));
	},
	
	getStore: function()
	{
		return this.TicketReplyGrid.getGridStore();
		//alert("getstore");
	},
	
	onInit: function()
	{
		//this.TicketReplyGrid.getGridStore();
		//this.beforePageUpdate();
		
		/*var bbar = this.TicketReplyGrid.getBottomToolbar();
		bbar.on('beforechange', this.beforePageUpdate, this);*/
		this.getStore().load();
		//alert("oninit");
	},
	
	beforePageUpdate: function(toolbar, params)
	{
		Ext.apply(params/*, this.TicketReplyForm.getForm().getValues()*/);
		//alert("beforeupdates");
	},
	
	onSubmitClick: function()
	{
		//this.getStore().load({params: this.TicketReplyForm.getForm().getValues()});
		this.getStore().load();
		//alert("ondubmt");
	}
});

Ext.reg('com.playdorm.AdminTicketReply', com.playdorm.AdminTicketReply);