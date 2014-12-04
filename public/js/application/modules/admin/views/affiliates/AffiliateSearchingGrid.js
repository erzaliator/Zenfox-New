Ext.ns('com.playdorm');

/*function newtab(AffiliateID)
{
	var TabID = '/en_GB/affiliatesearch/view/id/' + AffiliateID;
	var cxtype = 'com.playdorm.AffiliateSearchingView';
	var component = Ext.ComponentMgr.types[cxtype];
	if (!component)
	{
		alert('Error !');
		return;
	}
	var c = Ext.getCmp(cxtype);
	if (!c)
	{
		c = new component({id: TabID,title: 'Affiliate '+AffiliateID+' Profile'});
		Ext.getCmp('tab-panel').add(c);
	}
	Ext.getCmp('tab-panel').activate(c);
}
*/
com.playdorm.AffiliateSearchingGrid = Ext.extend(Ext.grid.GridPanel, 
{
	constructor: function(config)
	{
		config = config || {};
		
		com.playdorm.AffiliateSearchingGrid.superclass.constructor.call(this, Ext.applyIf(config, 
		{
			frame: true,
			loadMask: true,
			
			columns:[
			 	    {
			 	        header: "Affiliate Id",
			 	        dataIndex: 'Id',
			 	        renderer : this.renderTopic,
			 	        width: 10,
			 	        sortable: true,
			 	    },
			 	    {
			 	        header: "User Name",
			 	        dataIndex: 'Alias',
			 	        width: 10,
			 	        sortable: true
			 	    },
			 	    {
			 	        header: "Email",
			 	        dataIndex: 'Email',
			 	        width: 10,
			 	        sortable: true
			 	    },
			],
			store: this.getSearchGridStore(),
			viewConfig:
			{
				forceFit:true,
		        enableRowBody:true,
		        showPreview:true
			},
			 bbar: new Ext.PagingToolbar({
			        pageSize: 10,
			        store: this.getSearchGridStore(),
			        displayInfo: true,
			    })
		}));
	},

	getSearchGridStore: function()
	{
		if (!this.searchGridStore)
		{
			this.searchGridStore = new Ext.data.JsonStore(
			{
				url:'/affiliatesearch/index/format/json',
				root: 'affiliates',
				totalProperty: 'totalCount',
				idProperty : 'Id',
				//remoteSort : true,
				//data : {"totalCount":1,"affiliates":[{"Id":"1","Alias":"nik","Email":"nikg4u@gmail.com"}]},
				fields:['Id' , 'Alias' , 'Email']
			});
		}
		return this.searchGridStore;
	},
	
	renderTopic: function (value, p, record)
	{
        /*return String.format(
                '<a href="/en_GB/player/view/id/{0}" onClick="newtab(\'{1}\',\'{2}\',\'{3}\')">{0}</a>',
                value);*/
		return String.format(
                '<a href="#" onClick="newtab(\'Affiliate\',\'{0}\',\'en_GB/affiliatesearch/view/affiliateId/\')">{0}</a>',
                value);

	}
});

Ext.reg('com.playdorm.AffiliateSearchingGrid', com.playdorm.AffiliateSearchingGrid);