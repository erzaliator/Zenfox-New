Ext.ns('com.playdorm');

com.playdorm.AdminTransactionAllplayertransactionForm = Ext.extend(Ext.form.FormPanel, 
{
	constructor: function(config)
	{
		config = config || {};
		com.playdorm.AdminTransactionAllplayertransactionForm.superclass.constructor.call(this, Ext.applyIf(config,
		{
			frame		: true,
			bodyStyle	:'padding:10px 10px 10px',
			defaultType	: 'textfield',
			defaults	: { width: 450 },
		    labelPad 	: 40,
 		    labelWidth 	: 140,
			items:
			[
				 {
					fieldLabel : 'player Id',
					
					name		: 'player_id'
					
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
			  	fieldLabel	:  'Transaction Type', 
					name		:  'trans_type',
					xtype		:  'com.playdorm.Dropbox',
					width		:	290,
					emptyText	:  'Select Transaction Tyye....',
					blankText 	:  'Please Chose Ticket Status',
					value           :  'CREDIT_DEPOSITS' ,
					values 		: 
					[
						[ 'CREDIT_DEPOSITS'   ,'CREDIT_DEPOSITS' ],
						[ 'AWARD_WINNINGS'   ,'AWARD_WINNINGS' ],
						[ 'PLACE_WAGER'   ,'PLACE_WAGER' ],
						[ 'WITHDRAWAL_REQUEST' , 'WITHDRAWAL_REQUEST'],
						[ 'WITHDRAWAL_FLOWBACK'   ,'WITHDRAWAL_FLOWBACK' ],
						[ 'WITHDRAWAL_ACCEPT' , 'WITHDRAWAL_ACCEPT'],
						[ 'WITHDRAWAL_REJECT','WITHDRAWAL_REJECT'],
						[ 'CONVERT_BONUS_REAL','CONVERT_BONUS_REAL'],
						[ 'CREDIT_BONUS','CREDIT_BONUS'],
						[ 'CREDIT_BUDDY_BONUS','CREDIT_BUDDY_BONUS'],
						[ 'ADJUST_BANK','ADJUST_BANK'],
						[ 'ADJUST_WINNINGS','ADJUST_WINNINGS'],
						[ 'ADJUST_BONUS_WINNINGS','ADJUST_BONUS_WINNINGS'],
						[ 'ADJUST_BONUS_BANK','ADJUST_BONUS_BANK'],
						[ 'LOCK_FUNDS','LOCK_FUNDS'],
						[ 'UNLOCK_FUNDS','UNLOCK_FUNDS'],
						[ 'PLACE_WAGER_LOCK','PLACE_WAGER_LOCK'],
						[ 'AWARD_WINNINGS_LOCK','AWARD_WINNINGS_LOCK']
				]   		
			},
			{
				
			  		fieldLabel	:  'Status',
			  		name		:  'status',
			  		xtype		:  'checkboxgroup',
			  		allowBlank	:  true,
					columns         :   2,
			  		items		:
			  		[
					 	{ boxLabel: 'PROCESSED'        , name: 'status[]' , inputValue: 'PROCESSED', checked: true},
					 	{ boxLabel: 'STARTED'       , name: 'status[]' , inputValue: 'STARTED', checked: true},
					 	{ boxLabel: 'ERROR'          , name: 'status[]' , inputValue: 'ERROR', checked: true},
					 	{ boxLabel: 'UNPROCESSED'   , name: 'status[]' , inputValue: 'UNPROCESSED', checked: true}
						
					 ]
			  	
				
			}, 	
				{
					fieldLabel	:  'Items Per Page', 
					name		:  'items_per_page',
					xtype		:  'com.playdorm.Dropbox',
					width		:  70,		
					value		:  '10',
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
						[ 100 , '100'],
				] 
				}, 	
		]
		}));
	}
});

Ext.reg('com.playdorm.AdminTransactionAllplayertransactionForm', com.playdorm.AdminTransactionAllplayertransactionForm);