Ext.ns('com.playdorm');

com.playdorm.TicketReplyForm = Ext.extend(Ext.form.FormPanel, 
{
	constructor: function(config)
	{
		config = config || {};
		com.playdorm.TicketReplyForm.superclass.constructor.call(this, Ext.applyIf(config,
		{
			frame		: true,
			bodyStyle	:'padding:10px 10px 10px',
			defaultType	: 'textfield',
			defaults	: { width: 290 },
		    labelPad 	: 40,
 		    labelWidth 	: 140,
			items:
			[
			 	{	
				  	fieldLabel	: 'Message',
			  		name		: 'reply_msg',
			  		xtype		: 'textarea',
			  		height		:  130,
			  		emptyText	: 'Enter Your Message here ....',
			  		//allowBlank	:  true,
		     	 },
			     		  
		     	{
				  	fieldLabel	: 'Note',
			  		name		: 'note',
			  		xtype		: 'textarea',
			  		height		:  90,
			  		emptyText	: 'Leave a Note here ....',
			  		//allowBlank	:  true,
		     	},
			 
				{
					fieldLabel	:  'Ticket Status',
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
				}
				
			]
		}));
	}
});

Ext.reg('com.playdorm.TicketReplyForm', com.playdorm.TicketReplyForm);