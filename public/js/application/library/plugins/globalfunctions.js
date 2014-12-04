function newtab(Title, Id, url, type, name)
{
	console.log(Title);
	console.log(Id);
	console.log(url);
	console.log(name);
	var cookieStr = Title+'*'+Id+'*'+url+'*'+type+'*'+name;
	if(getCookie('playerTab'))
	{
		setCookie('playerTab' , getCookie('playerTab')+'+'+cookieStr);
	}
	else
	{
		setCookie('playerTab' , cookieStr);
	}
	
	var TabID = url + Id;
	var cxtype = 'panel';
	var component = Ext.ComponentMgr.types[cxtype];
	//console.log(Ext.ComponentMgr.types);
	console.log(Ext.ComponentMgr.types[cxtype]);
	if (!component)
	{
		alert('Error !');
		return;
	}
	var c = Ext.getCmp(cxtype);
	if(c)
	{
		console.log('created one');
		Ext.getCmp('tab-panel').close(c);
	}
	if (!c)
	{
		c = new component({
				id: TabID,
				title: Title +' '+ name +'\'s Profile',
				autoLoad : {url : TabID+'/accountType/'+type+'/format/json'},
				closable:true,
				frame:true,
				autoScroll:true,
				height:400,
				listeners:{
					activate : function(panel){
		            panel.getUpdater().refresh();
		         }
		      }});
		Ext.getCmp('tab-panel').add(c);
		
	//	console.log(Ext.ComponentMgr.types);
	}
	Ext.getCmp('tab-panel').activate(c);
	
}



function callReplyPanel(ticketId,userId)
{
	
	console.log(ticketId);
	
	
	var cxtype = 'panel';
	var component = Ext.ComponentMgr.types[cxtype];
	//console.log(Ext.ComponentMgr.types);
	console.log(Ext.ComponentMgr.types);
	if (!component)
	{
		alert('Error !');
		return;
	}
	var c1 = Ext.getCmp(cxtype);
	if (!c1)
	{
		c1 = new component({id: 'Ticket ID - '+ticketId , title: 'Ticket ID - '+ticketId,
			autoLoad : {url : 'ticket/reply/ticket_id/'+ticketId+'/id/'+userId+'/ticketType/player/format/json'},closable:true,frame:true,
			listeners:{
				activate : function(panel){
	            panel.getUpdater().refresh();
	         }
	      }});
		Ext.getCmp('tab-panel').add(c1);
		/*c1.on('render', function() {
			c1.getUpdater().startAutoRefresh(5, 'ticket/reply/ticket_id/'+ticketId+'/id/'+userId+'/ticketType/player/format/json');
		});*/
	//	console.log(Ext.ComponentMgr.types);
	}
	Ext.getCmp('tab-panel').activate(c1);
}


function addReconciliation()
{
	var cxtype = 'com.playdorm.AdminReconciliationIndex';
	var component = Ext.ComponentMgr.types[cxtype];
	//console.log(Ext.ComponentMgr.types);
	console.log(Ext.ComponentMgr.types);
	if (!component)
	{
		alert('Error !');
		return;
	}
	var c = Ext.getCmp(cxtype);
	if (!c)
	{
		c = new component({id: cxtype});
		//console.log(c);
		Ext.getCmp('tab-panel').add(c);	
	}
	Ext.getCmp('tab-panel').activate(c);

}



