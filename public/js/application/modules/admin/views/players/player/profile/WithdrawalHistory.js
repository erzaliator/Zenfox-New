/*!
 * Ext JS Library 3.2.1
 * Copyright(c) 2006-2010 Ext JS, Inc.
 * licensing@extjs.com
 * http://www.extjs.com/license
 */

function withdrawalHistory(name, playerId,  type)
{
Ext.onReady(function(){
	var hide = true;
	var title = 'Withdrawal';
	if(type =='CREDIT_DEPOSITS') 
		{
			hide = false;
			title = 'Deposite';
		}	

	var store = new Ext.data.JsonStore(
			{
				url:'withdrawal/index/playerId/'+playerId+'/type/'+type+'/format/json',
				autoLoad:true,
				root: 'data',
				totalProperty: 'totalCount',
				idProperty : 'assda',
				fields:[
				        {name: 'Merchant Transaction Id'},
						{name: 'start time'},
						{name: 'end time'},           
						{name: 'amount'}, 
						{name: 'base currency'},
						{name: 'transaction status'}
						         
					]
			});
	
	var pagesize = 15;
	var paging_toolbar = new Ext.PagingToolbar({
	pageSize: pagesize,
	displayInfo: true,
	emptyMsg: 'No data found',
	store: store
	})

	store.load({params:{start:0,limit:pagesize}});

    // create the grid
    var grid = new Ext.grid.GridPanel({
        store: store,
        columns: [
            {header:"Merchant Transaction Id" , width:100, dataIndex:'Merchant Transaction Id', sortable:true, hidden: hide},
            {header: "Start Time", width: 100, dataIndex: 'start time', sortable: true},
            {header: "End Time", width: 100, dataIndex: 'end time', sortable: true},
            {header: "Amount", width: 100, dataIndex: 'amount', sortable: true},
            {header: "Base Currency", width: 100, dataIndex: 'base currency', sortable: true},
            {header: "Transaction Status", width: 100, dataIndex: 'transaction status', sortable: true}
        ],
      //  renderTo:'example-grid',
       
        viewConfig:
		{
			forceFit:true,
	        enableRowBody:true,
	        showPreview:true
		},
		//bbar:paging_toolbar,
		
		    layout : 'fit',
		    height : 400
       
    });
   
    
    var winWithdrawal = new Ext.Window({
    	title: name+'\'s '+title+' History',
    	width:750,
    	height:500,
    	bodyStyle:'background-color:#fff;padding: 10px',
    	items:[grid,
    	       {
    	    	   xtype: 'box',
    	    	   autoEl: {
    	    	   tag: 'h1'
    	    	   
    	    	   }
    	       }
    	],
    	buttonAlign: 'right', 
    	buttons: []
    	});
    winWithdrawal.show();
});
}

function showTransactionSlip(playerId)
{
	Ext.onReady(function(){
		console.log(playerId);
		
		
		var store1 = Ext.Ajax.request({
			  loadMask: true,
			  url:'player/transactiondetail/transId/1/format/json',
			 // params: {id: "1"},
			  success: function(resp) {
			    // resp is the XmlHttpRequest object
			    var data = Ext.decode(resp.responseText).data;
			    
			    console.log(data['0']['amount']);
			    var winWithdrawal = new Ext.Window({
			    	title:data['0']['name']+'s  deposit gateway detail',
			    	
			    	bodyStyle:'background-color:#fff;padding: 10px',
			    	layout: {
			    	    type: 'table',
			    	    columns: 4,
			    	    padding: 10
			    	},
			    	items: [
						{html:'Name:',colspan:2},
						{html:' '},
						{html:data['0']['name']},
						
						{html:'Address:',colspan:2},
						{html:' '},
						{html:data['0']['address']},
						
						{html:'Bank Name:',colspan:2},
						{html:' '},
						{html:data['0']['bank_name']},
						
						{html:'Payment Method:',colspan:2},
						{html:' '},
						{html:data['0']['payment_method']},
						
						{html:'Gateway ID',colspan:2},
						{html:' '},
						{html:data['0']['gateway_id']},
					
						{html:'Gateway Transaction Id:',colspan:2},
						{html:' '},
						{html:data['0']['gateway_trans_id']},
						
			    	    {html:'Amount:',colspan:2},
			    	    {html:' '},
			    	    {html:data['0']['amount']}
			    	    
			    	]/*
			    	items:[
			    	       {
			    	    	   xtype: 'box',
			    	    	   autoEl: {
			    	    	  // tag: 'h1',
			    	    	   html: 'amount :'+data['0']['amount']
			    	    	   }
			    	       }
			    	]*/,
			    	buttonAlign: 'right', 
			    	buttons: []
			    	});
			    winWithdrawal.show();
			}
		});
	});
}
