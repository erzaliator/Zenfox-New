
Ext.ns('com.playdorm');

com.playdorm.AdminAdminListallcsrs = Ext.extend(Ext.grid.GridPanel, 
{
	constructor: function(config)
	{
		config = config || {};
		
		com.playdorm.AdminAdminListallcsrs.superclass.constructor.call(this, Ext.applyIf(config, 
		{
			frame: true,
			loadMask: true,
			closable: 'true',
			title	: 'Csrs',
			
			//defaults : { autoWidth : true,},
			//width : '200',
			columns:[
			 	   
			        
			 	    {
			 	        header: "ID",
			 	        dataIndex: 'id',
			 	      //  hidden : true,
			 	        renderer : this.renderTopic,
			 	       // width: 10,
			 	        sortable: true
			 	    },
			 	    {
			 	        header: "Alias",
			 	        dataIndex: 'Alias',
			 	     //  hidden : true,
			 	      //  width: 10,
			 	        sortable: true
			 	    },
			 	   {
			 	        header: "Associated Groups",
			 	        dataIndex: 'Associated Groups',
			 	      //  hidden : true,
			 	      //  width: 10,
			 	        sortable: true
			 	    },
			 	   {
			 	        header: "Enabled/Disabled",
			 	        dataIndex: 'Enabled/Disabled',
			 	       // width: 10,
			 	        sortable: true
			 	    },
			 	   {
			 	        header: "Other Groups",
			 	        dataIndex: 'Other Groups',
			 	       // width: 10,
			 	        sortable: true
			 	    }
			 	   ,
			 	   {
			 	        header: "Pre Groups",
			 	        dataIndex: 'Pre Groups',
			 	       // width: 10,
			 	        sortable: true
			 	    }
			 	  
			],
			store: this.getGridStore(),
			viewConfig:
			{
				forceFit:true,
		        enableRowBody:true,
		        showPreview:true
			}/*,
			 bbar: new Ext.PagingToolbar({
			        pageSize: 10,
			        store: this.getGridStore(),
			        displayInfo: true,
			    })*/
		}));
	},
	
	getGridStore: function()
	{
		
			this.searchGridStore = new Ext.data.JsonStore(
			{
				url:'admin/listallcsrs/format/json',
				autoLoad:true,
				root: 'csrView',
				totalProperty: 'totalCount',
				idProperty : 'CsrView Id',
				fields:['id' , 'Alias' , 'Name' , 'Associated Groups' , 'Enabled/Disabled' ,'Other Groups', 'Pre Groups']
			});
		
		return this.searchGridStore;
	},
	
	renderTopic: function (value, p, record)
	{
		//console.log(record.data['Associated Groups']);
		var type = record.data.Type;
		return String.format(
                '<a href="#" onClick="callCsrEditForm(\'{0}\',\'{1}\',\'{2}\',\'{3}\',\'{4}\',\'{5}\')">{0}</a>',
                value,
                record.data['Alias'], 
                record.data['Name'],
                record.data['Associated Groups'], 
                record.data['Enabled/Disabled'], 
                record.data['Other Groups']);
	}
	
});

Ext.reg('com.playdorm.AdminAdminListallcsrs', com.playdorm.AdminAdminListallcsrs);