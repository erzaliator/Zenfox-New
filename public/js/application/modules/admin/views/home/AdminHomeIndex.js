Ext.ns('com.playdorm');

com.playdorm.AdminHomeIndex = Ext.extend(Ext.Panel, 
{
	constructor: function(config)
	{
		config = config || {};
		com.playdorm.AdminHomeIndex.superclass.constructor.call(this, Ext.applyIf(config, 
		{
			layout: 'anchor',
			frame: true,
			closable: true,
			title: 'Home',
			//autoScroll:true,
			autoWidth:true,
	
		}));
		top.location.href = location.protocol + "//" + location.host + "/home";
		
	}
});

Ext.reg('com.playdorm.AdminHomeIndex', com.playdorm.AdminHomeIndex);