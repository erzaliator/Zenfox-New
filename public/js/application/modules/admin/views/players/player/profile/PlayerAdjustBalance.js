Ext.ns('com.playdorm');

//Ext.BLANK_IMAGE_URL = '../ext-3.0/resources/images/default/s.gif';
function callForm(playerId, val1, val2, val3, val4)
{
	console.log(playerId);

TabId = '/en_GB/player/view/playerId/'+playerId;
type = 'confirmed';
 var c = Ext.getCmp(TabId);
 Ext.getCmp('tab-panel').remove(c);
 
com.playdorm.PlayerAdjustBalance = {
	init: function(){	
	


this.form= new Ext.FormPanel({
	border:false,
	url: 'player/adjustbalance/playerId/'+playerId+'/format/json',
	//defaults:{xtype:'textfield'},	
	items:[
		
		{
			xtype:'textfield',
			fieldLabel:'Bank', 
			name:'bank', 
			value:'0.0', 
			id:"id-bank"
			//label: 'use -/+ sign before amount to credit or debit..'	
		},
		{
			  fieldLabel	:  'Action',
 			  name			:  'bank_action',
 			  xtype			:  'radiogroup',
 			  allowBlank	:  false,
 			  columns		:  4,
 			  items:
 			  [
				   {boxLabel: 'Debit', name:'bank_action' , inputValue:'DEBIT'},
				   {boxLabel: 'Credit', name:'bank_action' , inputValue:'CREDIT', checked: true}
				  
			  ]				
		},
		{
			xtype:'textfield',
			fieldLabel:'Winnings', 
			name:'winnings',
			value:'0.0', 
			id:"id-winnings",
			//emptyText: 'use -/+ sign before amount to credit or debit..'
		},
		{
			  fieldLabel	:  'Action',
 			  name			:  'winnings_action',
 			  xtype			:  'radiogroup',
 			  allowBlank	:  false,
 			  columns		:  4,
 			  items:
 			  [
				   {boxLabel: 'Debit', name:'winnings_action' , inputValue:'DEBIT'},
				   {boxLabel: 'Credit', name:'winnings_action' , inputValue:'CREDIT', checked: true}
				  
			  ]				
		},
		{
			xtype:'textfield',
			fieldLabel:'Bonus', 
			name:'bonus', 
			value:'0.0', 
			id:"id-bonus",
			//emptyText: 'use -/+ sign before amount to credit or debit..'
		},
		{
			  fieldLabel	:  'Action',
			  name			:  'bonus_action',
			  xtype			:  'radiogroup',
			  allowBlank	:  false,
			  columns		:  4,
			  items:
			  [
				   {boxLabel: 'Debit', name:'bonus_action' , inputValue:'DEBIT'},
				   {boxLabel: 'Credit', name:'bonus_action' , inputValue:'CREDIT', checked: true}
				  
			  ]				
		},
		{
			xtype:'textfield',
			fieldLabel:'Bonus Winnings', 
			name:'bonusWinnings', 
			value:'0.0', 
			id:"id-bonusWinnings",
			
		},
		{
			  fieldLabel	:  'Action',
			  name			:  'bonus_winnings_action',
			  xtype			:  'radiogroup',
			  allowBlank	:  false,
			  columns		:  4,
			  items:
			  [
				   {boxLabel: 'Debit', name:'bonus_winnings_action' , inputValue:'DEBIT'},
				   {boxLabel: 'Credit', name:'bonus_winnings_action' , inputValue:'CREDIT', checked: true}
				  
			  ]				
		}
	]
});

var win = new Ext.Window({
	title: 'Adjust',
	width:400,
	height:300,
	bodyStyle:'background-color:#fff;padding: 10px',
	items:[this.form/*,{html:'use -/+ sign before amount to credit or debit..'}*/],
	buttonAlign: 'right', 
	buttons: [
				{
				    text: 'Save',
				    handler: function(){
									com.playdorm.PlayerAdjustBalance.form.getForm().submit({
																							success: function(f,a){
																							newtab('Player',playerId ,'/en_GB/player/view/playerId/','confirmed');
																							Ext.Msg.alert('Success', 'It worked');
																							win.close();
																							},
																							
																							failure: function(f,a){
																							newtab('Player',playerId ,'/en_GB/player/view/playerId/','confirmed');
																							if (a.failureType === Ext.form.Action.CONNECT_FAILURE){
																								Ext.Msg.alert('Failure', 'Server reported:'+a.response.status+' '+a.response.statusText);
								

																							}
																							if (a.failureType === Ext.form.Action.SERVER_INVALID){
																								Ext.Msg.alert('Warning', a.result.errormsg);
																							}
																							}
																						});
				    					}
				},
				{ 
				    	text: 'Reset',
				    	handler: function() { 
				    					com.playdorm.PlayerAdjustBalance.form.getForm().reset(); 
				    					} 
			    },
				{
				    	text: 'close', 
				    	handler: function(){	
										win.close();
										newtab('Player',playerId ,'/en_GB/player/view/playerId/','confirmed');
										}
				}
			]
});

win.show();
	}	
}

Ext.onReady(com.playdorm.PlayerAdjustBalance.init,com.playdorm.PlayerAdjustBalance);
}


