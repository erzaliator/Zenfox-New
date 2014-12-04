Ext.ns('com.playdorm');

com.playdorm.AdminTicketCreate = Ext.extend(Ext.form.FormPanel, 
{
	constructor: function(config)
	{
		config = config || {};
		com.playdorm.AdminTicketCreate.superclass.constructor.call(this, Ext.applyIf(config,
		{
			title		: 'Ticket Create',
			frame		:  true,
			id : 			'adminticketcreate',
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
			 		fieldLabel	:  'Ticket Status',
			 		id			: 'ticketStatus',
			 		name		:  'ticketStatus',
			 		xtype		:  'com.playdorm.Dropbox',		
			 		emptyText	:  'Select Ticket Status....',
			 		blankText 	:  'Please Chose Ticket Status',
			 		value           :  'Open',
			 		values 		: 
			 			[
			 			 	[ 'OPEN'   ,'Open' ],
			 			 	[ 'FORWARDED' , 'Forwarded']
			 			 ]   		
			 	},
			     
			 	{
				  	fieldLabel	: 'User Name',
			  		name		: 'userName',
			  		id 			: 'userName',
			  		emptyText	: 'User name ...',
			  		allowBlank	: false,
			  		blankText	: 'Please Enter the User Name',
		     	 },
		     	 
		     	{
				  	fieldLabel	: 'Account Id',
			  		name		: 'accountId',
			  		id 			: 'accountId',
			  		emptyText	: 'Account Id ...',
			  		allowBlank	: false,
			  		blankText	: 'Please Enter the User Name',
		     	 },
			     		  
		     	 {
				  	fieldLabel	: 'Subject',
			  		name		: 'subject',
			  		id			: 'subject',
			  		emptyText	: 'Subject ....',
			  		allowBlank	: false,
			  		blankText	: 'Please Enter the Subject here',
		     	 },
			     		  
		     	 {
				  	fieldLabel	: 'Message',
			  		name		: 'reply_msg',
			  		id 			: 'reply_msg',
			  		xtype		: 'textarea',
			  		height		:  130,
			  		emptyText	: 'Enter Your Message here ....',
			  		//allowBlank	:  true,
		     	 },
			     		  
		     	{
				  	fieldLabel	: 'Note',
			  		name		: 'note',
			  		id			: 'note',
			  		xtype		: 'textarea',
			  		height		:  90,
			  		emptyText	: 'Leave a Note here ....',
			  		//allowBlank	:  true,
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
					url: '/ticket/create/format/json',
					waitTitle : 'Ticket Create Data',
					waitMsg : 'Saving ...',
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
		
		Ext.get("com.playdorm.AdminTicketCreate").fadeOut({
		    endOpacity: 1, //can be any value between 0 and 1 (e.g. .5)
		    easing: 'easeOut',
		    duration: 1,
		    remove: false,
		    useDisplay: true,
		    //reset : true,
		});
		
		
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
		
		var cxtype = 'com.playdorm.AdminTicketView';
		var component = Ext.ComponentMgr.types[cxtype];
		var c = Ext.getCmp(cxtype);
		if (!c)
		{
			c = new component({id: cxtype});
			Ext.getCmp('tab-panel').add(c);
		}
		Ext.getCmp('tab-panel').activate(c);

		//Ext.getCmp("tab-panel").remove("com.playdorm.AdminTicketCreate");
				
	},
	
	addIt : function()
	{
		//Ext.Msg.alert('success' , 'hello');	
	}
	
});

Ext.reg('com.playdorm.AdminTicketCreate', com.playdorm.AdminTicketCreate);