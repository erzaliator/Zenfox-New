Ext.ns('com.playdorm');

//Ext.BLANK_IMAGE_URL = '../ext-3.0/resources/images/default/s.gif';

function callPlayerEditForm(playerId , firstName, lastName, email, sex, dateOfBirth, address, city, state, country, pin, phone, securityQuestion, hint, securityAnswer)
{console.log(playerId);

TabId = '/en_GB/player/view/playerId/'+playerId;
type = 'confirmed';
 var c = Ext.getCmp(TabId);
 Ext.getCmp('tab-panel').remove(c);

var firstNameLabel = 'not present';
var lastNameLabel = 'not present';
var emailLabel = 'not present';
var sexLabel = 'not present';
var dateOfBirthLabel = 'not present';
var stateLabel = 'not present';
var addressLabel = 'not present';
var cityLabel = 'not present';
var pinLabel = 'not present';
var phoneLabel = 'not present';
var securityQuestionLabel = 'not present';
var hintLabel = 'not present';
var countryLabel = 'not present';


console.log(firstName);
if(firstName != '')firstNameLabel=firstName;
console.log(lastName);
if(lastName != '')lastNameLabel=lastName;
console.log(email);
if(email != '')emailLabel=email;
console.log(sex);
if(sex != '')sexLabel=sex;
console.log(dateOfBirth);
if(dateOfBirth != '')dateOfBirthLabel=dateOfBirth;
console.log(state);
if(state != '')stateLabel=state;
console.log(address);
if(address != '')addressLabel=address;
console.log(city);
if(city != '')cityLabel=city;
console.log(pin);
if(pin != '')pinLabel=pin;
console.log(phone);
if(phone != '')phoneLabel=phone;
console.log(securityQuestion);
if(securityQuestion != '')securityQuestionLabel=securityQuestion;
console.log(hint);
if(hint != '')hintLabel=hint;
console.log(country);
if(country != '')countryLabel=country;

com.playdorm.PlayerEditForm = {
	init: function(){	
	


form= new Ext.FormPanel({
	border:false,
	url: 'searching/edit/id/'+playerId+'/format/json',
	defaults:{xtype:'textfield'},	
	items:[
		
		{
			fieldLabel:'firstName', 
			name:'first_name', 
			value: firstName, 
			emptyText	:  firstNameLabel,
			blankText 	:  firstNameLabel,
			id:"firstName2222"
			
		},{
			fieldLabel:'lastName', 
			name:'last_name',
			value: lastName, 
			emptyText	:  lastNameLabel,
			blankText 	:  lastNameLabel,
			id:"lastName2222"
		},{
			fieldLabel	:  'sex',
			name		:  'sex',
			xtype		:  'com.playdorm.Dropbox',		
			
			blankText 	:  sexLabel,
			value           :  sex,
			values 		: 
				[
				 	[ 'M'   ,'M' ],
				 	[ 'F' , 'F']
				 ]   		
		},{
 			fieldLabel	: 'Date',
 			name		: 'dateofbirth',
 			xtype		: 'datefield',
 			emptyText	: dateOfBirthLabel,
 			value		: dateOfBirth,
 			//editable	: false,
 			format		: 'Y-m-d',
 		},{
			fieldLabel:'address', 
			name:'address', 
			emptyText	:  addressLabel,
			blankText 	:  addressLabel,
			value           :  address,
			id:"id-address222"
		},{
			fieldLabel:'city', 
			name:'city', 
			emptyText	:  cityLabel,
			blankText 	:  cityLabel,
			value           :  city,
			id:"id-city222"
		},{
			fieldLabel:'state', 
			name:'state', 
		//	value:'', 
			id:"id-state2222",
			emptyText	:  stateLabel,
			blankText 	: stateLabel,
			value           :  state
			
		},{
			fieldLabel:'country', 
			name:'country', 
		//	value:'', 
			id:"id-country2222",
			emptyText	:  countryLabel,
			blankText 	: countryLabel,
			value           :  country
			
		},{
			fieldLabel:'pin', 
			name:'pin', 
		//	value:'', 
			id:"id-pin222",
			emptyText	:  pinLabel,
			blankText 	: pinLabel,
			value           :  pin
		},{
			fieldLabel:'phone', 
			name:'phone', 
		//	value:'', 
			id:"id-phone222",
			emptyText	:  phoneLabel,
			blankText 	: phoneLabel,
			value           :  phone
		},{
			fieldLabel:'securityQuestion', 
			name:'question', 
		//	value:'', 
			id:"id-securityQuestion222",
			emptyText	:  securityQuestionLabel,
			blankText 	: securityQuestionLabel,
			value           :  securityQuestion
		},{
			fieldLabel:'hint', 
			name:'hint', 
		//	value:'', 
			id:"id-hint222",
			value: ''
		},{
			fieldLabel:'securityAnswer', 
			name:'answer', 
		//	value:'', 
			id:"id-securityAnswer222",
			value: ''
		},{
	  		fieldLabel	:  'newsletter',
	  		name		:  'newsletter',
	  		xtype		:  'checkboxgroup',
	  		allowBlank	:  true,
			//columns         :   2,
	  		items		:
	  		[
			 	{ boxLabel: 'newsletter'        , name: 'newsletter' , inputValue: '1' },
			 	
			 ]
	  	}
		
	]
});

var win = new Ext.Window({
	title: 'Adjust',
	width:400,
	height:500,
	bodyStyle:'background-color:#fff;padding: 10px',
	items:form,
	buttonAlign: 'right', 
	buttons: [
				{
				    text: 'Save',
				    handler: function(){
					       form.getForm().submit({
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
				    }},
				{ text: 'Reset', handler: function() { form.getForm().reset(); } }
			]
});

win.show();
	}	
}

Ext.onReady(com.playdorm.PlayerEditForm.init,com.playdorm.PlayerEditForm);
}