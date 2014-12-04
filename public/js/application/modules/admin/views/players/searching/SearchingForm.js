Ext.ns('com.playdorm');

com.playdorm.PlayerSearchForm = Ext.extend(Ext.form.FormPanel, 
{
	constructor: function(config)
	{
		config = config || {};
		com.playdorm.PlayerSearchForm.superclass.constructor.call(this, Ext.applyIf(config,
		{
			frame		: true,
			bodyStyle	:'padding:10px 10px 10px',
			defaultType	: 'textfield',
			defaults	: { width: 650 },
 		    labelWidth 	: 140,
			items:
			[
    		  {
     			  fieldLabel	:  'Select Field',
     			  name			:  'searchField',
     			  xtype			:  'radiogroup',
     			  allowBlank	:  false,
     			  columns		:  6,
     			  items:
     			  [
 				   {boxLabel: 'Login Name', name:'searchField' , inputValue:'login' , checked: true},
 				   {boxLabel: 'Player ID', name:'searchField' , inputValue:'player_id'},
 				   {boxLabel: 'Email ID', name:'searchField' , inputValue:'email'},
 				   {boxLabel: 'Password', name:'searchField' , inputValue:'password'},
 				   {boxLabel: 'Registrations', name:'searchField' , inputValue:'registration'},
 				   {boxLabel: 'Depositors', name:'searchField' , inputValue:'depositor'}
				  ]				     		  		
     		  },
     		 {
					fieldLabel	: 'From',
					xtype		: 'compositefield',
					name		: 'from',
					combineErrors	: false,
					items		:
					[
			 		{
			 			xtype	: 'displayfield',
			 			value	: '  Date  : ',
			 		},
			
			 		{
			 			fieldLabel	: 'Date',
			 			name		: 'start_date',
			 			xtype		: 'datefield',
			 			emptyText	: 'From Date',
			 			value		: (new Date()).clearTime(),
			 			//editable	: false,
			 			format		: 'Y-m-d',
			 		},
						 		
			 		{
			 			xtype	: 'displayfield',
			 			value	: '  Time  : ',
			 		},
			 		
			 		{
			 			fieldLabel	: 'Time',
			 			name		: 'from_time',
			 			xtype		: 'timefield',
			 			// anchor : '100 ,100',
			 			emptyText	: 'From Time',
			 			width		: 100,
			 			value 		: '00:00',
	  			 		minValue	: '00:00',
	  			 		maxValue	: '23:30',
	  			 		format :'H:i',
	  			 		increment : 30,
			 			
			 		}
				]
				},
				  	
				{
					fieldLabel	: 'To',
					name		: 'to',
					xtype		: 'compositefield',
					combineErrors	: false,
					items		:
					[
					 	{
					 		xtype	: 'displayfield',
					 		value	: '  Date  : ',
					 	},
					 	
					 	{
					 		fieldLabel	: 'Date',
					 		name		: 'end_date',
					 		xtype		: 'datefield',
					 		emptyText	: 'To Date',
					 		value		: (new Date()).clearTime(),
					 		//editable	: false,
					 		format		: 'Y-m-d',
					 	},
				
						{
					 		xtype	: 'displayfield',
					 		value	: '  Time  : ',
					 	},
					  	
					 	{
					 		fieldLabel	: 'Time',
					 		name		: 'to_time',
					 		xtype		: 'timefield',
					 		// anchor : '100 ,100',
					 		value 		: '00:00',
		  			 		minValue	: '00:00',
		  			 		maxValue	: '23:30',
		  			 		format :'H:i',
		  			 		increment : 30,
					 		width		: 100,
					 		
					 	},
						
					]
				},
     		  {
     			  fieldLabel	: 'Enter String',
     			  name		: 'searchString',
     			  width 		: 200,
     			  blankText	: 'Please Enter the String'
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
     			  fieldLabel 		:  'Account Type',
     			  name			:  'accountType',
     			  xtype			:  'radiogroup',
     			  width			:  350,
     			  allowBlank 		:  false,
     			  items:
     			  [
     				{boxLabel: 'Confirmed Accounts', name:'accountType' , inputValue:'confirmed' , checked:true},
     				{boxLabel: 'Unconfirmed Accounts', name:'accountType' , inputValue:'unconfirmed'},
     			  ]				     		  		
     		  },

     		  {
     			  fieldLabel	:  'Items Per Page', 
     			  name			:  'items',
     			  xtype			:  'com.playdorm.Dropbox',
     			  width			:  70,		
     			  value			:  '10',
     			  values		: 
     			  [
     				   [ 10 , '10' ],
     				   [ 20 , '20' ],
     				   [ 30 , '30' ]
     		      ] 
     		  }
			]
		}));
	}
});

Ext.reg('com.playdorm.PlayerSearchForm', com.playdorm.PlayerSearchForm);