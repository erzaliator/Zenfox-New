Ext.ns('com.playdorm');

com.playdorm.AdminAdminCreatecsr = Ext.extend(Ext.form.FormPanel, 
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
	    	
		com.playdorm.AdminAdminCreatecsr.superclass.constructor.call(this, Ext.applyIf(config,
		{  
			frame		: true,
			bodyStyle	:'padding:10px 10px 10px',
			defaultType	: 'textfield',
			
			closable: 'true',
			title	: 'Create Csr',
			defaults	: { width: 450 },
		    labelPad 	: 40,
 		    labelWidth 	: 140,
			items:
			[
    		  {
    			  	fieldLabel:'alias', 
    				name:'alias', 
    				
    				emptyText	:  'please give csr alias....',
    				blankText 	:  'please give csr alias...',
    				id			:	"id-alias",
    			    allowBlank	: 	false,

                    listeners	: 	{
    			  					invalid: function(field, msg)
    			  							{ 
    			  								Ext.Msg.alert('', msg);
    			  							}

                    				}
    		  },
    		  
    		  {
    				fieldLabel	:  'passwd',
    				name		:  'passwd',
    				inputType: 'password' ,		
    				emptyText	:  'Previous password....',
    				blankText 	:  'Previous password....',
                    listeners	: 	{
	  					invalid: function(field, msg)
	  							{ 
	  								Ext.Msg.alert('', msg);
	  							}

        				}
    		  },
    		radios,
    		{
    			  xtype : 'remotecheckboxgroup',
    			  fieldLabel : 'Groups',
    			  name: 'groups',
    			  columns:1,
    			  id:'check',
    			  
    			  url: 'admin/createcsr/getGms/true/format/json',
    			  method:'post',
    			  reader: new Ext.data.JsonReader(
    			  {
    			    totalProperty: 'num',
    			    root: 'data',
    			    fields: [{name: 'id'}, {name: 'groups'}, {name: 'description'}]
    			  }),
    			  fieldId: 'sa',
    			  fieldName: 'description',
    			  fieldLabel: 'groups',
    			  fieldValue: 'id'
    			                    
    			}
    		  
			],
			
			buttons: [{
                text: 'Create',
                type: 'submit',
                handler: function(){
                    var form = Ext.getCmp('com.playdorm.AdminAdminCreatecsr').getForm();
                    if(form.isValid())
                        form.submit({
                            waitMsg:'Loading...',
                        	url	   : 'admin/createcsr/from/extjs/format/json',
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

Ext.reg('com.playdorm.AdminAdminCreatecsr', com.playdorm.AdminAdminCreatecsr);