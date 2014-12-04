Ext.state.Manager.setProvider(new Ext.state.CookieProvider());

Ext.onReady(function()
{
	
    var treePanel = new Ext.tree.TreePanel(
    {
    	id: 'tree-panel',
    	border :false,
        autoScroll: true,
        iconCls : 'treeCls',
        // tree-specific configs:
        rootVisible: false,
        useArrows: true,
        
        loader: new Ext.tree.TreeLoader({
            dataUrl:'/menu/jsonmenu'
        }),
        
        root: new Ext.tree.AsyncTreeNode(),
    	plugins:[new Ext.ux.state.TreePanel()]
    });
    
	/* Assign the changeLayout function to be called on tree node click.*/
    treePanel.on('click', function(n)
    {
    	//var sn = this.selModel.selNode || {}; // selNode is null on initial selection

    	if(n.leaf)// && n.id != sn.id)
    	{ 
    		/* ignore clicks on folders and currently selected node*/
    		//Ext.Msg.alert(n.attributes.dd);
    		var cxtype = n.attributes.cxtype;
    		console.log(cxtype);
    		if(cxtype == 'com.playdorm.AdminSearchingIndex')cxtype ='com.playdorm.AdminPlayerIndex';
    		
    		try {
    			
    		//if (cxtype == 'com.playdorm.AdminPlayerIndex')
    		{
    			if(getCookie('tab'))
    			{
    				var cookieStr = getCookie('tab')+'+'+cxtype;
    				setCookie('tab',cookieStr);
    			}
    			else
    			{
    				setCookie('tab',cxtype);
    			}
    			
    			var component = Ext.ComponentMgr.types[cxtype];
    			//console.log(Ext.ComponentMgr.types);
    			console.log(component);
    			
    			if (!component)
    			{console.log(component);
    				Ext.Msg.alert('something wrong !!!');
    				return;
    			}
    			var c = Ext.getCmp(cxtype);
    			console.log(c);
    			if (!c)
    			{
    				c = new component({id: cxtype});
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
    		}*/
    		}catch(e){Ext.Msg.alert(e.message); }
    	}
    });

    var contentPanel = 
    {
		id: 'content-panel',
		region: 'center', // this is what makes this panel into a region within the containing layout
		layout : 'border',
		autoScroll:true,
		frame : true,

		items : 
		[{
			id : 'tab-panel',
			region: 'center',
			xtype  : 'tabpanel',
			height: 500,
			//autoScroll:true ,
			activeTab : 0,
			frame : true,
			border : false,
			items: [welcome]
		},
		]
	};

    new Ext.Viewport(
    {
		title: 'Home Page',
		id : 'admin-home-index',
        renderTo: Ext.getBody(),
		layout: 'border',
		//autoHeight:true,
		items: 
		[{
			xtype: 'box',
			region: 'north',
			applyTo: 'header',
			height: 70
		},
		{
	    	id: 'tree-menu',
	        region:'west',
			title : 'Menu',
			autoScroll : true,
	        width: 275,
	        collapsible: true,
			items: [treePanel]
		},
		{
			id: 'bottom-panel',
			region : 'south',
			height : 30,
			html : 'Bottom Panel',
		},
			contentPanel
		]
    });
    
    
    if(getCookie('tab'))
	{
		var cxtypeStr = getCookie('tab');
		
		tabArr = [];
		tabArr = cxtypeStr.split('+');
		console.log(tabArr);
		for(var i=0 ; i<tabArr.length; i++)
		{
			cxtype = tabArr[i];
			var component = Ext.ComponentMgr.types[cxtype];
			//console.log(Ext.ComponentMgr.types);
			console.log(component);
			
			if (!component)
			{console.log(component);
				Ext.Msg.alert('something wrong !!!');
				return;
			}
			var c = Ext.getCmp(cxtype);
			console.log(c);
			if (!c)
			{
				c = new component({id: cxtype});
				//console.log(c);
				Ext.getCmp('tab-panel').add(c);
			}
			Ext.getCmp('tab-panel').activate(c);
		}
	}
		
	if(getCookie('playerTab'))
	{
		var playerTab = getCookie('playerTab');
		playerTabArr = [];
		playerTabArr = playerTab.split('+');
		for(var j=0 ; j<playerTabArr.length; j++)
		{
			arr = playerTabArr[j].split('*');
			newtab(arr[0],arr[1],arr[2],arr[3],arr[4]);
			//console.log(arr);
		}
		
	}
});