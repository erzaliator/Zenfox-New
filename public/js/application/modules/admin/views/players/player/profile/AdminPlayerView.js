Ext.ns('com.playdorm');

com.playdorm.AdminPlayerView = Ext.extend(	Ext.Panel , 
{
	constructor :function(config)
	{
		config = config || {};
		com.playdorm.AdminPlayerView.superclass.constructor.call(this,Ext.applyIf( config , 
		{
			
			title : 'Players Profile',
			layout:'fit',
			closable : true,
			items:
				[
				 {
					 //xtype: 'com.playdorm.GroupTabPanel',
					 xtype : 'grouptabpanel',
					 tabWidth : 120,
					 activeGroup:0,
					 items : 
					[
					 {
						 expanded: true,
		                    items: 
							[
								{
								    title: 'Player',
								    //iconCls: 'x-icon-templates',
								    
								    //html : "<center><h2><br><br><br><br>Hello Player.... <br><br>Player Info</h2></center>",
								    // tabTip: 'Configuration tabtip',
								    // style: 'padding: 10px;',
								    // html: /*Ext.example.shortBogusMarkup*/
									// "hell out this example.js"
								}, 
							 {
		                        title: 'Edit',
		                        iconCls: 'editCls',
		                        // tabTip: 'Configuration tabtip',
		                        // style: 'padding: 10px;',
		                        // html: /*Ext.example.shortBogusMarkup*/ "hell
								// out this example.js"
		                        xtype : 'com.playdorm.AdminReconciliationIndex',
		                        
		                    },
		                    {
		                        title: 'Balance',
		                        iconCls: 'balanceCls',
		                    },
		                    
		                    {
		                        title: 'View',
		                        iconCls: 'viewCls',
		                    },
		                    
		                    {
		                        title: 'Report',
		                        iconCls: 'reportCls',
		                    }
		                    
							/*
							 * { title: 'Email Templates', //iconCls:
							 * 'x-icon-templates', tabTip: 'Templates tabtip',
							 * style: 'padding: 10px;', html: "well noew woek
							 * starts !!!!!!" }
							 */
		                    ]  
					 }
					]
				 }
				 
				]
		}
			))
	}
	
});

Ext.reg('com.playdorm.AdminPlayerView' , com.playdorm.AdminPlayerView)