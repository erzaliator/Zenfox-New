Ext.ns('com.playdorm');

com.playdorm.TicketViewForm = Ext.extend(Ext.form.FormPanel, 
{
	constructor: function(config)
	{
		config = config || {};
		com.playdorm.TicketViewForm.superclass.constructor.call(this, Ext.applyIf(config,
		{
			frame		: true,
			bodyStyle	:'padding:10px 10px 10px',
			defaultType	: 'textfield',
			defaults	: { width: 290 },
		    labelPad 	: 40,
 		    labelWidth 	: 140,
			items:
			[
				/*{
						fieldLabel	: 'Enter String',
						name		: 'enterString',
						allowBlank	: false,
						blankText	: 'Please Enter the String',
					},
				
				{
				        fieldLabel   : 'Search In',
				        name        : 'searchIn',
				        xtype       : 'radiogroup',
				        allowBlank  : false,
				        columns     : 3,
				        items       :
					[
				               {boxLabel: 'Player ID'   , name:'searchIn' , inputValue:'accountID' , checked: true},
				               {boxLabel: 'Ticket ID'   , name:'searchIn' , inputValue:'ticketID' },
				               {boxLabel: 'User Name'   , name:'searchIn' , inputValue:'userName' },
					]  
				},*/
					
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
				  	fieldLabel	:  'Ticket Status', 
						name		:  'ticket_status',
						xtype		:  'com.playdorm.Dropbox',
						width		:	290,
						emptyText	:  'Select Ticket Status....',
						blankText 	:  'Please Chose Ticket Status',
						value           :  'Open' ,
						values 		: 
						[
							[ 'Open'   ,'OPEN' ],
							[ 'Close'   ,'CLOSE' ],
							[ 'Pending'   ,'PENDING' ],
							[ 'Forwarded' , 'FORWARDED'],
							[ 'Dispatch'   ,'DISPATCH' ],
					]   		
				},
					  	
					{
						fieldLabel	:  'Items Per Page', 
						name		:  'items_per_page',
						xtype		:  'com.playdorm.Dropbox',
						width		:  70,		
						value		:  '20',
						values 		: 
						[
							[ 10 , '10' ], 
							[ 20 , '20' ],
							[ 30 , '30' ],
							[ 40 , '40' ], 
							[ 50 , '50' ],
							[ 60 , '60' ],
							[ 70 , '70' ], 
							[ 80 , '80' ],
							[ 90 , '90' ],
							[ 100 , '100' ],
					] 
					}, 	
			]
		}));
	}
});

Ext.reg('com.playdorm.TicketViewForm', com.playdorm.TicketViewForm);