/*
 Extending the ComboBox drop down menu 
 */

Ext.ns('com.playdorm');

com.playdorm.Dropbox = Ext.extend(Ext.form.ComboBox ,{
	constructor: function(datastore)
	{
			com.playdorm.Dropbox.superclass.constructor.call(this, Ext.applyIf( datastore , 
					{
				xtype			:  'combo',
 		  		width			:   200,
                mode			: 'local',
                triggerAction	:  'all',
                forceSelection	:   true,
                editable		:   false,
                typeAhead		:   true,
                allowBlank		:   false,
                
                displayField	:   'name',
                valueField		:   'value',
                
                store			: new Ext.data.ArrayStore
 		  							({ 
 		  									id	   : 0,
 		  									fields : ['name' , 'value' ],
 		  									data   : datastore.values
 		  							}) 
					} 
				));
	}
});
		

Ext.reg('com.playdorm.Dropbox', com.playdorm.Dropbox);