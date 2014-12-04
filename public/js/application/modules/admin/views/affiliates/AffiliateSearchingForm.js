Ext.ns('com.playdorm');

com.playdorm.AffiliateSearchingForm = Ext.extend(Ext.form.FormPanel, 
{
	constructor: function(config)
	{
		config = config || {};
		com.playdorm.AffiliateSearchingForm.superclass.constructor.call(this, Ext.applyIf(config,
		{
			labelWidth	: 100,
			frame		:true,
			bodyStyle	:'padding:10px 10px 10px',
			defaultType	: 'textfield',
			defaults	:
			{
					width: 450
			},
			items		:
			[
     			{
     		  		fieldLabel 		:  'Select Field',
     		  		name			:  'selectField',
     		  		xtype			:  'radiogroup',
     		  		width			:  350,
     		  		allowBlank 		:  false,
     		  		columns			:  2,
     		  		items:
     		  		[
  				  		{boxLabel: 'Alias', name:'searchField' , inputValue:'alias' , checked: true},
  				   		{boxLabel: 'Account ID', name:'searchField' , inputValue:'accountID'},
  				   		{boxLabel: 'First Name', name:'searchField' , inputValue:'firstName'},
  				   		{boxLabel: 'Last Name', name:'searchField' , inputValue:'lastName'},
  				   		{boxLabel: 'Email ID', name:'searchField' , inputValue:'emailID'},
  				   		{boxLabel: 'Company', name:'searchField' , inputValue:'company'},
  				   		{boxLabel: 'Tracker Name', name:'searchField' , inputValue:'trackerName'},
 		  			]				     		  		
     		  	},
			     		  	
     		  	{
     		  		fieldLabel	: 'Enter String',
     		  		name		: 'searchString',
     		  		allowBlank	:  false,
     		  		blankText	: 'Please Enter the String',
     		  	},
			     		  	
     		  	{
     		  		fieldLabel 		:  'Match String',
     		  		name			:  'match',
     		  		xtype			:  'radiogroup',
     		  		width			:  270,
     		  		allowBlank 		:  true,
     		  		items:
 		  		    [
 	     			   {boxLabel: 'Enable', name:'match' , inputValue:'1'},
 	     			   {boxLabel: 'Disable', name:'match' , inputValue:'0' , checked : true},
 		  			]				     		  		
     		  	},
			     		  	
     		  	{
     		  		fieldLabel 		:  'Sorting Order',
     		  		name			:  'order',
     		  		xtype			:  'radiogroup',
     		  		width			:  350,
     		  		allowBlank 		:  false,
     		  		items:
 		  				  [
 		  				   		{boxLabel: 'Ascending Order', name:'order' , inputValue:'ASC' , checked:true},
 		  				   		{boxLabel: 'Descending Order', name:'order' , inputValue:'DESC'},
 		  			 	  ]				     		  		
     		  	},
			     		  	
     		  	{
     		  		fieldLabel		:  'Items Per Page', 
     		  		name			:  'items',
     		  		xtype			:  'com.playdorm.Dropbox',
     		  		width			:  120,		
     		  		emptyText		:  'Select a value....',
     		  		blankText		:  'Please choose a value',
     		  		value			:  '10',
     		  		values 			: 
     		  			 		[
     		  			  			[ 10 , '10' ], 
     		  			  			[ 20 , '20' ],
     		  			  			[ 30 , '30' ]
     		  			  	   ] 
     		  	},
			     		  	
			     		  	
     		],
		}));
	}
});

Ext.reg('com.playdorm.AffiliateSearchingForm', com.playdorm.AffiliateSearchingForm);