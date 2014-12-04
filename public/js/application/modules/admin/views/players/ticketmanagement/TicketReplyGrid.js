Ext.ns('com.playdorm');

com.playdorm.TicketReplyGrid = Ext.extend(Ext.Panel, 
{
	constructor: function(config, ne)
	{
		config = config || {};
		
		com.playdorm.TicketReplyGrid.superclass.constructor.call(this, Ext.applyIf(config, 
		{
			 border:false,
			    height: 200,
			    layout:'fit', 
			    autoLoad: { 
		            url: 'http://www.google.com', 
		            renderer: 'component', 
		            params: { 
		                userId: 1 
		            } 
		        }
			   
	
}))}});

Ext.reg('com.playdorm.TicketReplyGrid', com.playdorm.TicketReplyGrid);