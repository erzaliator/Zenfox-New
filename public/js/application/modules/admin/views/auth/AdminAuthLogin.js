Ext.ns('com.playdorm');

com.playdorm.AdminAuthLogin = Ext.extend(Ext.form.FormPanel, 
{
	constructor: function(config)
	{
		config = config || {};
		com.playdorm.AdminTicketCreate.superclass.constructor.call(this, Ext.applyIf(config,
		{
			title		: 'Login',
			frame		:  true,
			id : 			'adminauthlogin',
			bodyStyle	:  'padding:10px 10px 10px',
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
			 		fieldLabel	:  'User Name*',
			 		id			: 'userName',
			 		name		:  'userName',
			 		xtype		:  'textfield',		
			 		emptyText	:  'Enter User Name..',
			 	},
			     
			 	{
				  	fieldLabel	: 'Password',
			  		name		: 'password',
			  		id 			: 'password',
			  		emptyText	: 'Enter Password..',
			  		xtype		:  'textfield',
		     	 },
		
			],
			buttons	:
			[
				   {
					   text		:'Submit',
					   id 		: 'submit',
					   scale 	: 'medium',
					   width	: 80,
					   handler : this.onSubmitClick.createDelegate(this)
				   }
			 ]
			
		}));
	},
	
	
	onSubmitClick: function()
	{
		ticketForm = this ;
		if (ticketForm.form.isValid()) 
		{
			//ticketForm.getEl().mask();
			ticketForm.getForm().submit
				({
					url: '/auth/login/format/json',
					waitTitle : 'Log In',
					waitMsg : 'Logging ...',
					/*success: function( form , action )
						{
							//Ext.Msg.alert('Success',action.result.msg);
							//var box = Ext.MessageBox.wait('Please wait while I do something or other', 'Performing Actions');
							//box.hide();
							ticketForm.getEl().unmask();
							ticketForm.form.reset();
							this.onSuccess();
							
						},*/
					success : this.onSuccess(),
					failure : function(form,action)
						{
							Ext.Msg.alert('Error In Saving',action.result.msg);
							//ticketForm.getEl().unmask();
						}
				});
		}
		
		
	},
	
	
	onSuccess : function()
	{
		//Ext.Msg.alert('Success' , action.result.msg);
		/*Removing the Form after submission */
		top.location.href = location.protocol + "//" + location.host + "/auth/login";
		
		//Ext.get("com.playdorm.AdminTicketCreate").pause(1000);
		//sleep(5);
		
		/*Chaning the title of tab here */
		//Ext.getCmp("tab-panel").getItem("com.playdorm.AdminTicketCreate").setTitle("Ticket View");
		
		/*Removing the form items*/
		/*Ext.getCmp("tab-panel").getItem("com.playdorm.AdminTicketCreate").remove("ticketStatus");
		Ext.getCmp("tab-panel").getItem("com.playdorm.AdminTicketCreate").remove("accountId");
		Ext.getCmp("tab-panel").getItem("com.playdorm.AdminTicketCreate").remove("subject");
		Ext.getCmp("tab-panel").getItem("com.playdorm.AdminTicketCreate").remove("reply_msg");
		Ext.getCmp("tab-panel").getItem("com.playdorm.AdminTicketCreate").remove("note");
		*/
		//Ext.getCmp("tab-panel").getItem("com.playdorm.AdminTicketCreate").remove("submit");
		
		/*
		var a = new Ext.form.TextField({
		    fieldLabel: 'Text fa',
		    name: 'text_field_a',
		    frame : true,
		    allowBlank: false,
		    id : 'aaa'
		});
		//var a = new com.playdorm.ReconciliationForm();
		
		//Ext.getCmp("tab-panel").getItem("com.playdorm.AdminTicketCreate").add(this ,a);
		
		Ext.getCmp("tab-panel").getItem("com.playdorm.AdminTicketCreate").body.update(Ext.getCmp('aaa').body());
		Ext.getCmp("tab-panel").getItem("com.playdorm.AdminTicketCreate").doLayout();*/
		
		//setTimeout("alert('hello')",5000);
		

		//Ext.getCmp("tab-panel").remove("com.playdorm.AdminTicketCreate");
				
	},
	
	addIt : function()
	{
		//Ext.Msg.alert('success' , 'hello');	
	}
	
});

Ext.reg('com.playdorm.AdminAuthLogin', com.playdorm.AdminAuthLogin);