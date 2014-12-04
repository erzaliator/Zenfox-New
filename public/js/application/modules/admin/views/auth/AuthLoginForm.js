Ext.ns('com.playdorm');

com.playdorm.AuthLoginForm = Ext.extend(Ext.form.FormPanel, 
{
	constructor: function(config)
	{
		config = config || {};
		com.playdorm.AuthLoginForm.superclass.constructor.call(this, Ext.applyIf(config,
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
				  	fieldLabel	: 'User Name*',
			  		name		: 'userName',
			  		id			: 'userName',
			  		xtype		: 'textfield',
			  		emptyText	: 'Enter Your User Name..',
			  		//allowBlank	:  true,
		     	 },
			     		  
		     	{
				  	fieldLabel	: 'Password',
			  		name		: 'password',
			  		id			: 'password',
			  		xtype		: 'textfield',
			  		emptyText	: 'Enter Password ....',
			  		//allowBlank	:  true,
		     	}				
			]
		}));
	}
});

Ext.reg('com.playdorm.AuthLoginForm', com.playdorm.AuthLoginForm);