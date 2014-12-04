Ext.ns('com.playdorm');

com.playdorm.AdminAdminCreategroup = Ext.extend(Ext.form.FormPanel, 
{
	constructor: function(config)
	{
		config = config || {};
	/*---------------------Form Generation Data-------------------------------	
		var messages = new Ext.data.JsonStore({
			  url: 'admin/createcsr/format/json',
			  root: 'options',
			  fields: [
			    {name: 'text', mapping: 'message'}
			  ],
			  listeners: {
			    load: messagesLoaded
			  }
			});
			messages.load({params: {id: "1"}});

			// and when loaded, you can take advantage of
			// all the possibilities provided by Store
			function messagesLoaded(messages) {
			  messages.each(function(msg){
			    alert(msg.get("text"));
			  });
			}
			--------------------Form Generation Data------------------
		//var data = new Ext.data.JsonReader({}, [ 'id', 'name']); 
		var store= new Ext.data.JsonStore({  
			url: 'admin/createcsr/getGms/true/format/json'  ,  
	        root: 'data',  
	        totalProperty: 'num',  
	        fields: [  
	            {name:'id', type: 'string'},  
	            {name:'name', type: 'string'},  
	            {name:'description', type: 'string'},  
	        ],
	        listeners: {
			    load: messagesLoaded
			  }
	}); 
		function messagesLoaded(messages) {
			  var pass = 1;
			  
			}
	    
		var comboRemote=new Ext.form.ComboBox({  
		    fieldLabel:'Data Base',  
		    name:'cmb-DBs',  
		    forceSelection: true,  
		    store: store, //assigning the store  
		    emptyText:'pick one...',  
		    triggerAction: 'all',  
		    editable:false,  
		    displayField:'name',  
		    valueField: 'id'  
		}); 
		-------------*/	
		var radios = new Ext.form.RadioGroup({  
		    fieldLabel: 'enabled',  
		     columns: 2, //display the radiobuttons in two columns  
		     items: [  
		          {boxLabel: 'Enable', name: 'enabled', inputValue: 'ENABLED', checked: true},  
		          {boxLabel: 'Disable', name: 'enabled', inputValue: 'DISABLED'},  
		        
		     ]  
		});  
		
	    if(true){
	    	
		com.playdorm.AdminAdminCreategroup.superclass.constructor.call(this, Ext.applyIf(config,
		{  
			frame		: true,
			bodyStyle	:'padding:10px 10px 10px',
			defaultType	: 'textfield',
			 layout: 'form',
			closable: 'true',
			title	: 'Create Group',
			defaults	: { width: 450 },
		    labelPad 	: 40,
 		    labelWidth 	: 140,
			items:
			[
    		  {
    			  	fieldLabel:'Name', 
    				name:'name', 
    				
    				emptyText	:  'please give group name....',
    				blankText 	:  'please give group name....',
    				id			:	"id-name",
    			    allowBlank	: 	false,

                    listeners	: 	{
    			  					invalid: function(field, msg)
    			  							{ 
    			  								Ext.Msg.alert('', msg);
    			  							}
    		  						}
    		  },
    		  
    		  {
				  	fieldLabel	: 'Description',
			  		name		: 'desc',
			  		xtype		: 'textarea',
			  		height		:  90,
			  		emptyText	: 'Leave a Note here ....',
			  		//allowBlank	:  true,
		     	},radios,
    			{
    		  		fieldLabel	:  'Menu',
    		  		name		:  'menus',
    		  		xtype		:  'checkboxgroup',
    		  		allowBlank	:  true,
    				columns         :   2,
    		  		items		:
    		  		[
    				 	{ boxLabel: 'Bingo'        		, name: 'menus[]' 	, inputValue: '2' },
    				 	{ boxLabel: 'Slots'       		, name: 'menus[]' 	, inputValue: '5' },
    				 	{ boxLabel: 'Keno'          	, name: 'menus[]' 	, inputValue: '8' },
    				 	{ boxLabel: 'Roulette'   		, name: 'menus[]' 	, inputValue: '12' },
    					{ boxLabel: 'Group'    			, name: 'menus[]' 	, inputValue: '16' },
    					{ boxLabel: 'Csr'    			, name: 'menus[]' 	, inputValue: '17' },
    					{ boxLabel: 'Ticket'     		, name: 'menus[]' 	, inputValue: '25' },
    					{ boxLabel: 'Player Search'    	, name: 'menus[]' 	, inputValue: '28' }
    				 ]
    		  	},
    		
    		{
    			  xtype : 'remotecheckboxgroup',
    			  fieldLabel : 'Groups',
    			  name: 'csrs[]',
    			  columns:6,
    			  id:'checkCsrs',
    			  layout: 'form',
    			  url: 'admin/creategroup/getCsrs/true/format/json',
    			  method:'post',
    			  reader: new Ext.data.JsonReader(
    			  {
    			    totalProperty: 'num',
    			    root: 'data',
    			    fields: [{name: 'id'}, {name: 'alias'}, {name: 'name'}]
    			  }),
    			  fieldId: 'sa',
    			  fieldName: 'name',
    			  fieldLabel: 'alias',
    			  fieldValue: 'id'
    			                    
    			}
			],
			
			buttons: [{
                text: 'Create',
                type: 'submit',
                handler: function(){
                    var form = Ext.getCmp('com.playdorm.AdminAdminCreategroup').getForm();
                    if(form.isValid())
                        form.submit({
                           // waitMsg:'Loading...',
                        	url	   : 'admin/creategroup/format/json',
                            success: function(form,action) {
                               /* newForm.windowConfig.close();
                                window.location = action.result.data.url;*/
                        	Ext.MessageBox.alert('Created');
                            },
                            failure: function(form,action){
                            	console.log(action);
                                Ext.MessageBox.alert('Erro');
                            }
                        });
                }

            }]
		}));}
	}
});

Ext.reg('com.playdorm.AdminAdminCreategroup', com.playdorm.AdminAdminCreategroup);