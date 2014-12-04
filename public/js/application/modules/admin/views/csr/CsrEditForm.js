Ext.ns('com.playdorm');

//Ext.BLANK_IMAGE_URL = '../ext-3.0/resources/images/default/s.gif';

function callCsrEditForm(id, alias, name, preGroups, elabled, groups)
{
	
	console.log(preGroups);
	console.log(groups);
	
	
	Ext.onReady(function() {
		
		function getGroups(groups, name)
		{
			arr1 = [];
			arr2 = [];
			arr3 = [];
			arr4 = [];
			checkboxArray = []; 
			arr1 = groups.split(",");
			for(var j=0;j<arr1.length;j++)
			{
				
				arr2 = arr1[j].split("*");
				arr3.push(arr2[0]);
				arr4.push(arr2[1]);
			checkboxArray.push({name: name, boxLabel: arr2[1], inputValue: arr2[0]}); 
			}
			console.log(arr3);
			console.log(arr4);
			return checkboxArray;
		}
		
		checkboxArrayGroups = []; 
		checkboxArrayGroups = getGroups(groups, 'groups[]');
		
		checkBoxArrayPre = [];
		checkBoxArrayPre = getGroups(preGroups, 'addedgroups[]');
		
	    
	
	                           
	    
	    
	    var form = new Ext.FormPanel({
	      	
	    	border:false,
	    	url: 'admin/editcsr/id/'+id+'/formate/json',
		
			defaultType	: 'textfield',
			
		   
			items:[
					{
						fieldLabel:'Alias', 
						name:'alias', 
						value: alias, 
						
						/*emptyText	:  alias,
						blankText 	:  alias,
						//id			:	"id-csralias",
					    //allowBlank	: 	false,
					
					    listeners	: 	{
					  					invalid: function(field, msg)
					  							{ 
					  								Ext.Msg.alert('', msg);
					  							}
					
					    				}*/
					},
					{
						fieldLabel:'Name', 
						name:'name', 
						value: name, 
						
						/*emptyText	:  name,
						blankText 	:  name,
						//id			:	"id-csrname",
					   //allowBlank	: 	false,
					
					    listeners	: 	{
					  					invalid: function(field, msg)
					  							{ 
					  								Ext.Msg.alert('', msg);
					  							}
					
					    				}*/
					},
					
					{
						fieldLabel	:  'passwd',
						name		:  'passwd',
						inputType: 'password' ,		
						/*emptyText	:  'give password....',
						blankText 	:  'give password....',
						value 		: '',
					    listeners	: 	{
											invalid: function(field, msg)
													{ 
														Ext.Msg.alert('', msg);
													}
										}*/
					},
					{   xtype : 'radiogroup',
					    fieldLabel: 'enabled',  
					    columns: 2, //display the radiobuttons in two columns  
					    items: [  
					          {boxLabel: 'Enable', name: 'enabled', inputValue: 'ENABLED', checked: true},  
					          {boxLabel: 'Disable', name: 'enabled', inputValue: 'DISABLED'},  
					        
					     ]  
					},
					{ 	xtype		: 'checkboxgroup',
			    	   	fieldLabel	: 'Other Groups',
		    		    columns     :  3,
			    		items		: checkboxArrayGroups
			       },
			       { 	xtype		: 'checkboxgroup',
			    	    fieldLabel	: 'Associated Groups',
			    	    columns     :  3,
			    	    items		: checkBoxArrayPre
			       }
	    		 ]	        
	    });
	    
	  
	    var winLogin = new Ext.Window({
	    	title: 'Adjust',
	    	width:400,
	    	height:500,
	    	bodyStyle:'background-color:#fff;padding: 10px',
	    	items:[form],
	    	buttonAlign: 'right', 
	    	buttons: [{
	    				text: 'Save',
	    				handler: function()
	    				{
	    						form.getForm().submit({
	    						success: function(a, b)
	    							{
	    								Ext.Msg.alert('Success', 'ok');
	    							},
	    							failure: function(a, b)
	    							{
	    								Ext.Msg.alert('Failure', 'ok');
	    							}
	    						});
	    				}
	    			}, {
	    				text: 'Reset',
	    				handler: function()
	    				{
	    					form.getForm().reset();
	    				}
	    			}]
	    	});
	    winLogin.show();
	});
}
