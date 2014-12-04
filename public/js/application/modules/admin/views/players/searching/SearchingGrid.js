Ext.ns('com.playdorm');

com.playdorm.PlayerSearchGrid = Ext.extend(Ext.grid.GridPanel, 
{
	constructor: function(config)
	{
		config = config || {};
		
		com.playdorm.PlayerSearchGrid.superclass.constructor.call(this, Ext.applyIf(config, 
		{
			frame: true,
			loadMask: true,
		//	autoHeight: true,
			columns:[
			 	    {
			 	        header: "Player Id",
			 	        dataIndex: 'Player Id',
			 	        renderer : this.renderTopic,
			 	        width: 10,
			 	        sortable: true,
			 	    },
			 	    {
			 	        header: "User Name",
			 	        dataIndex: 'User Name',
			 	        width: 10,
			 	        sortable: true
			 	    },
			 	    {
			 	        header: "Email",
			 	        dataIndex: 'Email',
			 	        width: 10,
			 	        sortable: true
			 	    },
			 	   {
			 	        header: "Type",
			 	        dataIndex: 'Type',
			 	        width: 10,
			 	        sortable: true,
			 	        hidden: true
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
				url:'/searching/index/format/json',
				root: 'players',
				totalProperty: 'totalCount',
				idProperty : 'Player Id',
				//remoteSort : true,
				fields:['Player Id' , 'User Name' , 'Email' , 'Type']
			});
		}
		return this.searchGridStore;
	},
	
	renderTopic: function (value, p, record)
	{
        /*return String.format(
                '<a href="/en_GB/player/view/id/{0}" onClick="newtab(\'{1}\',\'{2}\',\'{3}\')">{0}</a>',
                value);*/
		//console.log(record.data);
		var type = record.data.Type;
		return String.format(
                '<a href="#" onClick="newtab(\'Player\',\'{0}\',\'/en_GB/player/view/playerId/\',\'{1}\',\'{2}\')">{0}</a>',
                value, record.data.Type, record.data['User Name']);
	},
/*	listeners: {
			    rowclick:function(grid, rowIndex,cellIndex, e) {
			    var playerId = grid.store.data.items['0'].data['Player Id'];
			    var type = grid.store.data.items['0'].data['Type'];    
			   var  cxtype = 'com.playdorm.PlayerProfileGrid';
				try {
	    			
		    		//if (cxtype == 'com.playdorm.AdminPlayerIndex')
		    		{
		    			var component = Ext.ComponentMgr.types[cxtype];
		    			//console.log(Ext.ComponentMgr.types);
		    			console.log(component);
		    			
		    			if (!component)
		    			{
		    				Ext.Msg.alert('something wrong !!!');
		    				return;
		    			}
		    			var c = Ext.getCmp(cxtype);
		    			console.log('c');
		    			console.log(c);
		    			if (!c)
		    			{
		    				c = new component({
		    					
		    					id		: cxtype,
		    					title	: 'profile'});
		    				//console.log(c);
		    				Ext.getCmp('tab-panel').add(c);
		    			}
		    			Ext.getCmp('tab-panel').activate(c);
		    			
		    		}
		    		/*else
		    		{
		    			newtab = Ext.getCmp('tab-panel').add(eval(n.attributes.description.toString()));
		    			Ext.getCmp('tab-panel').setActiveTab(newtab);
		    			Ext.getCmp('tab-panel').doLayout();
		    		}*//*
		    		}catch(e){alert(e.message); }
			    }
	}*/
});

Ext.reg('com.playdorm.PlayerSearchGrid', com.playdorm.PlayerSearchGrid);