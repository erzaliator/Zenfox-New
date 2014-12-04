Ext.ns('com.playdorm');

com.playdorm.AdminBonusCreate = Ext.extend(Ext.form.FormPanel, 
{
	constructor: function(config)
	{
		config = config || {};
		com.playdorm.AdminBonusCreate.superclass.constructor.call(this, Ext.applyIf(config,
		{
			title		: 'Bonus Create',
			frame		:  true,
			bodyStyle	:  'padding:10px 10px 10px',
			width		:  700,
			labelPad	:  40,
			labelWidth	:  140,
			defaultType	:  'textfield',
			closable	: 'true',
			
			defaults	:
			{
				width: 300,
			},
			items:
			[
			 	{
			 		fieldLabel	:  'Name', 
			 		name		:  'name',
			 		xtype		:  'textfield',
			 		allowBlank  : false,
			 	},
			     		  
		     	 {
				  	fieldLabel	: 'Description',
			  		name		: 'description',
			  		xtype		: 'textarea',
			  		height		:  130,
			  		emptyText	: 'Enter Your Message here ....',
			  		allowBlank	:  true,
		     	 },
			     		  
		     	{
				  	fieldLabel	: 'No of Levels',
			  		name		: 'noOfParts',
			  		xtype		: 'textfield',
			  		allowBlank	:  false,
		     	},
		
			],
			buttons	:
			[
				   {
					   text		:'Submit',
					   scale 	: 'medium',
					   width	: 80,
					   handler : this.onSubmitClick.createDelegate(this)
				   }
			 ]
			
		}));
	},
	
	onSubmitClick: function()
	{
	//	this.getStore().load({params: this.playerSearchForm.getForm().getValues()});
		if (this.form.isValid()) 
		{						
			//this.getEl().mask();
			this.getForm().submit
				({
					url: '/bonus/create/format/json',
					success: function( form , action ){
					//Ext.Msg.alert('success',action.result.msg);
					
					//Ext.getCmp('tab-panel').add({xtype:'panel',closable:true});
					
					var cxtype = 'com.playdorm.AdminBonusProcess';
					var component = Ext.ComponentMgr.types[cxtype];
	    			var c = Ext.getCmp(cxtype);
	    			if (!c)
	    			{
	    				c = new component({id: cxtype});
	    				Ext.getCmp('tab-panel').add(c);
	    			}
	    			Ext.getCmp('tab-panel').activate(c);
	    			
					Ext.getCmp('tab-panel').remove('com.playdorm.AdminBonusCreate');
					//this.getEl().unmask();
					},

					failure : function(form,action)
					{
						Ext.Msg.alert('error',action.response.responseText);
						//this.getEl().unmask();
					}
				});
		}
				
	}
});

Ext.reg('com.playdorm.AdminBonusCreate', com.playdorm.AdminBonusCreate);