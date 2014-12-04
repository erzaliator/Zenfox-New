function bingoFormCall(){
var bingo = new Ext.form.FormPanel(
    		{

    				title		:'Bingo Form',
				frame		:true,
				bodyStyle	:'padding:10px 10px 10px',
				width		:700,
				renderTo: Ext.getBody(),
				defaultType	: 'textfield',
				defaults	:
								{
										width: 300,
								},
				items		:[
				     		  	{
				     		  		fieldLabel	: 'Game Name',
				     		  		name		: 'gameName',
				     		  		allowBlank	: false,
				     		  		blankText	: 'Please Enter the Game Name',
				     		  	},
				   
				     		  	{
				     		  		fieldLabel	: 'Description',
				     		  		name 		:'description',
				     		  		allowBlank	:true,
				     		  		xtype		:'textarea',
				     		  		height		:50
				     		  	},
				   
				     		  	{ 
				     		  		fieldLabel		:  'Game Flavor', 
				     		  		name			:  'gameFlavor',
				     		  		xtype			:  'Extended.Dropbox',
				     		  		width			:  200,		
				     		  		emptyText		:  'Select Game Flavor....',
				     		  		blankText 		:  'Please Chose Game Flavor',
				     		  		
				     		  		values 			: 
				     		  			 		[
				     		  			  			[ 'RU_US' , 'ru_us' ], 
				     		  			  			[ 'RU_EU' , 'ru_eu' ], 
				     		  			  			[ 'Keno'  , 'keno' ], 
				     		  			  			[ 'ThreeRFiveL' ,'threerfivel' ], 
				     		  			  			[ 'FiveRNineL'  ,'fiverninel' ], 
				     		  			  			[ 'WOF'   ,'wof' ] 
				     		  			  	   ]   		  		
				     		  	},
				     		  	{ 
				     		  		fieldLabel		:  'Game Type', 
				     		  		name			:  'gameType',
				     		  		xtype			:  'Extended.Dropbox',
				     		  		width			:  200,		
				     		  		emptyText		:  'Select Game Type....',
				     		  		blankText		:  'Please Chose Game Type',
				     		  		
				     		  		values 			: 
				     		  			 		[
				     		  			  			[ 'Variable' , 'variable' ], 
				     		  			  			[ 'Fixed'    , 'fixed'    ] 
				     		  			  	   ]   		  		
				     		  	},
						
				     		 
				     		  	{
				     		  		fieldLabel 		:  'Amount Type',
				     		  		name			:  'amountType',
				     		  		xtype			:  'radiogroup',
				     		  		width			:  270,
				     		        allowBlank		:  false,
				     		        
				     		  		items:
				     		  				  [
				     		  				   		{boxLabel: 'Real', name: 'at', inputValue: 'real'},
				     		  				   		{boxLabel: 'Bonus', name: 'at', inputValue: 'bonus'},
				     		  				   		{boxLabel: 'Both', name: 'at', inputValue: 'both'}
				     		  			 	]				     		  		
				     		  	},
				     		  	
				     		  	{
				     		  		fieldLabel		:  'Plot Type', 
				     		  		name			:  'plotType',
				     		  		xtype			:  'Extended.Dropbox',
				     		  		width			:  200,		
				     		  		emptyText		:  'Select Plot Type....',
				     		  		blankText		:  'Please Chose Plot Type',
				     		  		
				     		  		values 			: 
				     		  			 		[
				     		  			  			[ 'Separate' , 'separate' ], 
				     		  			  			[ 'Combined'    , 'combined'    ] 
				     		  			  	   ] 
				     		  	},
				     		  	{
				     		  		fieldLabel		:  'Pattern Name', 
				     		  		name			:  'Pattern Name',
				     		  		xtype			:  'Extended.Dropbox',
				     		  		width			:  200,		
				     		  		emptyText		:  'Select Pattern Name....',
				     		  		blankText		:  'Please Chose Pattern Name',
				     		  		
				     		  		values 			: 
				     		  			 		[
				     		  			  			[ 'Testing' , 'testing' ],  
				     		  			  	   ] 
				     		  	},
				     		  	{
				     		  		fieldLabel	: 'No. of Parts',
				     		  		name		: 'NoOfParts',
				     		  		xtype		: 'numberfield',
				     		  		width		: 80,
				     		  		allowBlank	: false,
				     		  		blankText	: 'Please Enter No. of Parts',
				     		  	},
				     		  	{
				     		  		xtype		: 'fieldset',
				     		  		title		: 'Cards',
				     		  		collapsible	: true,
				     		  		width		: 550,
				     		  		labelPad	: 30,
				     		  		/*fieldLabel	: 'Cards',
				     		  		xtype		: 'compositefield',*/
				     		  		items		:
				     		  			[
				     		  			 	
				     		  			 	{
				     		  			 			fieldLabel	: 'Price',
				     		  			 			name		: 'cardPrice',
				     		  			 			xtype		: 'numberfield',
				     		  			 			width		: 80,
				     		  			 			allowBlank	: false,
				     		  			 			blankText	: 'Please Enter the Card Price',
				     		  			 	},
				     		  			 	
				     		  			 	
				     		  			 	{
				     		  			 			fieldLabel	: 'Minimum',
				     		  			 			name		: 'minimumCards',
				     		  			 			xtype		: 'numberfield',
				     		  			 			width		: 80,
				     		  			 			allowBlank	: false,
				     		  			 			blankText	: 'Please Enter the Minimum Cards',
				     		  			 	},
				     		  			 	{
				     		  			 			fieldLabel	: 'Maximum',
				     		  			 			name		: 'maximumCards',
				     		  			 			xtype		: 'numberfield',
				     		  			 			width		: 80,
				     		  			 			allowBlank	: false,
				     		  			 			blankText	: 'Please Enter the Maximum Cards',
				     		  			 	},
				     		  			 ]
				     		  			
				     		  	},
				     		  	
				     		  	{
				     		  		fieldLabel	: 'Free Ratio',
				     		  		name		: 'freeRatio',
				     		  		xtype		: 'numberfield',
				     		  		width		: 80,
				     		  		allowBlank	: false,
				     		  		blankText	: 'Please Enter the Free Ratio',
				     		  	},
				     		  	{
				     		  		fieldLabel	: 'Buy Time',
				     		  		name		: 'buyTime',
				     		  		xtype		: 'numberfield',
				     		  		width		: 80,
				     		  		allowBlank	: false,
				     		  		blankText	: 'Please Enter the Buy Time',
				     		  	},
				     		  	{
				     		  		fieldLabel	: 'Call Delay',
				     		  		name		: 'callDelay',
				     		  		xtype		: 'numberfield',
				     		  		width		: 80,
				     		  		allowBlank	: false,
				     		  		blankText	: 'Please Enter the Call Delay',
				     		  	},
				     		  	
				     		 	{
				     		  		fieldLabel 		:  'PNJ',
				     		  		name			:  'pnjEnable',
				     		  		xtype			:  'checkboxgroup',
				     		  		width			:  270,
				     		       
				     		  		items:
				     		  				  [
				     		  				   		{boxLabel: 'Enable', name:'PNJenable'},
				     		  			 	  ]				     		  		
				     		  	},
				     		  	{
				     		  		fieldLabel 		:  'Pre Buy',
				     		  		name			:  'preBuy',
				     		  		xtype			:  'checkboxgroup',
				     		  		width			:  270,
				     		       
				     		  		items:
				     		  				  [
				     		  				   		{boxLabel: 'Enable', name:'preBuyenable'},
				     		  			 	  ]				     		  		
				     		  	},
				     		  	
				     		  	{
				     		  		xtype		: 'compositefield',
				     		  		fieldLabel	: 'Return',
				     		  		width		: 400,
				     		  		combineErrors	: false,
				     		  		items 		:[
				     		  		      		  	{
				     		  		      			  		xtype		: 'displayfield',
				     		  		      			  		value	: '( Real )',
				     		  		      		  	},
				     		  		      		  	{
				     		  		      		  			fieldLabel	: 'Real Return',
				     		  		      		  			name		: 'realReturn',
				     		  		      		  			xtype		: 'numberfield',
				     		  		      		  			width		: 80,
				     		  		      		  			allowBlank	: false,
				     		  		      		  			blankText	: 'Please Enter the Real Return',
				     		  		      		  	},
				     		  		
				     		  		      		  	{
				     		  		      		  			xtype		:'displayfield',
				     		  		      		  			value		: '( Bonus  )',
				     		  		      		  	},
				     		  		      		  	{
				     		  		      		  			fieldLabel	: 'Bonus Return',
				     		  		      		  			name		: 'bonusReturn',
				     		  		      		  			xtype		: 'numberfield',
				     		  		      		  			width		: 80,
				     		  		      		  			allowBlank	: false,
				     		  		      		  			blankText	: 'Please Enter the Bonus Return',
				     		  		      		  	},
				     		  		]
				     		  	},
				     		  	{
				     		  		xtype		: 'fieldset',
				     		  		title		: 'Pots',
				     		  		collapsible	: true,
				     		  		width		: 550,
				     		  		labelPad	: 30,
				     		  		items       :
				     		  			[
				     		  			 {
				     		  				xtype		: 'compositefield',
						     		  		fieldLabel	: 'Real',
						     		  		width		: 400,
						     		  		combineErrors	: false,
						     		  		items 		:[
						     		  		      		  	{
						     		  		      			  		xtype		: 'displayfield',
						     		  		      			  		value	: '( Maximum )',
						     		  		      		  	},
						     		  		      		{
								     		  			 		fieldLabel	: 'Maximum Real Pot',
								     		  			 		name		: 'maximumRealPot',
								     		  			 		xtype		: 'numberfield',
								     		  			 		width		: 80,
								     		  			 		allowBlank	: false,
								     		  			 		blankText	: 'Please Enter the Maximum Real Pot',
								     		  			 	},
								     		  				{
					     		  		      		  			xtype		:'displayfield',
					     		  		      		  			value		: '( Minimum  )',
					     		  		      		  	},
								     		  			 	{
								     		  			 		fieldLabel	: 'Minimum Real Pot',
								     		  			 		name		: 'minimumRealPlot',
								     		  			 		xtype		: 'numberfield',
								     		  			 		width		: 80,
								     		  			 		allowBlank	: false,
								     		  			 		blankText	: 'Please Enter the Minimum Real Pot ',
								     		  			 	},
						     		  		      		  	
						     		  		]
				     		  			 },
				     		  			 
				     		  			{
					     		  				xtype		: 'compositefield',
							     		  		fieldLabel	: 'Bonus',
							     		  		width		: 400,
							     		  		combineErrors	: false,
							     		  		items 		:[
							     		  		      		  	{
							     		  		      			  		xtype		: 'displayfield',
							     		  		      			  		value	: '( Maximum )',
							     		  		      		  	},
							     		  		      		{
									     		  			 		fieldLabel	: 'Maximum Bonus Pot',
									     		  			 		name		: 'maximumBonusPot',
									     		  			 		xtype		: 'numberfield',
									     		  			 		width		: 80,
									     		  			 		allowBlank	: false,
									     		  			 		blankText	: 'Please Enter the Maximum Bonus Pot',
									     		  			 	},
									     		  				{
						     		  		      		  			xtype		:'displayfield',
						     		  		      		  			value		: '( Minimum  )',
						     		  		      		  	},
									     		  			 	{
									     		  			 		fieldLabel	: 'Minimum Bonus Pot',
									     		  			 		name		: 'minimumBonusPlot',
									     		  			 		xtype		: 'numberfield',
									     		  			 		width		: 80,
									     		  			 		allowBlank	: false,
									     		  			 		blankText	: 'Please Enter the Minimum Bonus Pot ',
									     		  			 	},
							     		  		      		  	
							     		  		]
					     		  			 },	 
				     		  		]	
				     		  			 
				     		  	},
				       ],
				       
				       buttons:[
				                {
				                	text		: 'Submit',
				                	handler: function() {
				                        if (bingo.form.isValid()) {
				                            var s = '';
				                        
				                            Ext.iterate(bingo.form.getValues(), function(key, value) {
				                                s += String.format("{0} = {1}<br />", key, value);
				                            }, this);
				                        
				                            Ext.Msg.alert('Form Values', s);                        
				                        }
				                    }
				                },

				                {
				                	text:'Reset',
				                	handler : function()
				                			{
				                					bingo.form.reset();	
				                			}
				                }
				                
				                
				                ],
					
				                
				                
				            /*
							 * labelAlign: 'left', // or 'right' or 'top'
							 * labelSeparator: '>>', // takes precedence over
							 * layoutConfig value labelWidth: 65, // defaults to
							 * 100 labelPad: 8 // defaults to 5, must specify
							 * labelWidth to be honored
							 */
				               
				                labelPad : 40,
				                labelWidth : 140
			});}
//bingo.render('bingoform-div');