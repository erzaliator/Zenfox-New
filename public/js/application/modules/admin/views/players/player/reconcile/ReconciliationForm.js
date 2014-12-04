Ext.ns('com.playdorm');

com.playdorm.ReconciliationForm = Ext.extend(Ext.form.FormPanel, 
{
	constructor: function(config)
	{
		config = config || {};
		com.playdorm.ReconciliationForm.superclass.constructor.call(this, Ext.applyIf(config,
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
	    			  fieldLabel	: 'player Id',
	    			  name		: 'playerId',
		  			  allowBlank	: false,
		  		      blankText	: 'Please Enter the String',
	    		  },
	
	    		/*  {
		  		fieldLabel	: 'Search In',
		  		name		: 'searchIn',
				xtype       : 'radiogroup',
		  		allowBlank  : false,
				columns     : 3,
				items       :
				[
					{boxLabel: 'Player ID'   , name:'searchIn' , inputValue:'accountID' , checked: true},
					{boxLabel: 'Email'   , name:'searchIn' , inputValue:'email' },
					{boxLabel: 'Alias'   , name:'searchIn' , inputValue:'alias' },
				]     
			},*/
		  	
		  	{
		  		fieldLabel	: 'From',
		  		name		: 'from',
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
			 			name		: 'from_date',
			 			xtype		: 'datefield',
			 			emptyText	: 'From Date',
			 			value : (new Date).clearTime(),
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
			 			//anchor		: '100 ,100',
			 			emptyText	: 'From Time',
			 			allowBlank	: false,
			 			width		: 100,
			 			//editable	: false,
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
	  			 		name		: 'to_date',
	  			 		xtype		: 'datefield',
	  			 		emptyText	: 'To Date',
	  			 		//editable	: false,
			 			value : (new Date).clearTime(),
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
	  			 		emptyText	: 'To Time',
	  			 		allowBlank	: false,
	  			 		width		: 100,
	  			 		//editable	: false,
	  			 		value 		: '00:00',
	  			 		minValue	: '00:00',
	  			 		maxValue	: '23:30',
	  			 		format :'H:i',
	  			 		increment : 30,
	  			 	},
		  			
		  		]
		  	},
	 		  	
		  	{
		  		fieldLabel	:  'Amount Type',
		  		name		:  'amountType',
		  		xtype		:  'checkboxgroup',
		  		allowBlank	:  false,
		  		items		:
		  		[
				 	{ boxLabel: 'Real' , name: 'amount_type[]' , inputValue: 'REAL' , checked: true},
				 	{ boxLabel: 'Bonus' , name: 'amount_type[]' , inputValue: 'BONUS', checked: true},
				 	{ boxLabel: 'Both' , name: 'amount_type[]' , inputValue: 'BOTH', checked: true},
				 ]
		  	},
	 		  	
		  	{
		  		fieldLabel	:  'Transaction Type',
		  		name		:  'transactionType',
		  		xtype		:  'checkboxgroup',
		  		allowBlank	:  true,
				columns         :   2,
		  		items		:
		  		[
				 	{ boxLabel: 'Winning'        , name: 'transaction_type[]' , inputValue: 'AWARD_WINNINGS', checked: true},
				 	{ boxLabel: 'Deposits'       , name: 'transaction_type[]' , inputValue: 'CREDIT_DEPOSITS', checked: true},
				 	{ boxLabel: 'Wager'          , name: 'transaction_type[]' , inputValue: 'PLACE_WAGER', checked: true},
				 	{ boxLabel: 'Bonus Credit'   , name: 'transaction_type[]' , inputValue: 'CREDIT_BONUS', checked: true},
					{ boxLabel: 'Bonus Debit'    , name: 'transaction_type[]' , inputValue: 'bonusDebit', checked: true},
					{ boxLabel: 'Real Credit'    , name: 'transaction_type[]' , inputValue: 'realCredit', checked: true},
					{ boxLabel: 'Real Debit'     , name: 'transaction_type[]' , inputValue: 'realDebit', checked: true},
					{ boxLabel: 'Withdrawals'    , name: 'transaction_type[]' , inputValue: 'withdrawals', checked: true}
				 ]
		  	},
		  	
		  	{
		  		fieldLabel	:  'Items Per Page', 
		  		name		:  'page',
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
		  		] 
		  	}
			]
		}));
	}
});

Ext.reg('com.playdorm.ReconciliationForm', com.playdorm.ReconciliationForm);