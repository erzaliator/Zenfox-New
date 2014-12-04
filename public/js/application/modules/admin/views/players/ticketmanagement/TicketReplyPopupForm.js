function callTicketReplyForm(csrId, ticketId, userId)
{
	console.log(csrId);
	var csrIds = csrId.split('*');
	console.log(csrIds);
	
	dropBoxArray = [];
	for(var j=0;j<csrIds.length-1;j++)
	{
		dropBoxArray.push([ csrIds[j] , csrIds[j] ]); 
	}
	
	var c =Ext.getCmp('Ticket ID - '+ticketId);
	Ext.getCmp('tab-panel').remove(c);
	
com.playdorm.TicketReplyPopupForm = {
	init: function(){	
	
	console.log(dropBoxArray);
	
	
    var data = new Array(2)

    for (i=0; i <2; i++)
    	data[i]=new Array(2)

    data[0][0] = "OPEN"
    	data[0][1] = "OPEN"
    
    		data[1][0] = "FORWARDED"
    			data[1][1] = "FORWARDED"
  

  
    
   

this.form= new Ext.FormPanel({
	border:false,
	url : 'ticket/reply/ticket_id/'+ticketId+'/id/'+userId+'/ticketType/player/format/json',
	defaults:{xtype:'textfield'},	
	items:[
		 	{	
			  	fieldLabel	: 'Message',
		  		name		: 'reply_msg',
		  		xtype		: 'textarea',
		  		height		:  130,
		  		width		:  300,
		  		emptyText	: 'Enter Your Message here ....',
		  		allowBlank	:	false,
		  		 listeners	: 	{
  					invalid: function(field, msg)
  							{ 
  								Ext.Msg.alert('', msg);
  							}

    				}
		  		//allowBlank	:  true,
	     	 },
		     		  
	     	{
			  	fieldLabel	: 'Note',
		  		name		: 'note',
		  		xtype		: 'textarea',
		  		height		:  90,
		  		width		:  300,
		  		emptyText	: 'Leave a Note here ....',
		  		allowBlank	:  true,
	     	},
		 
			{
				fieldLabel	:  'Ticket Status',
				name		:  'ticket_status',
				xtype		:  'com.playdorm.Dropbox',		
				emptyText	:  'Select Ticket Status....',
				blankText 	:  'Please Chose Ticket Status',
				value           :  '',
				values 		: data,
				allowBlank	:	false,
				listeners	: {
								invalid : function(field , msg){Ext.Msg.alert('',msg);}
							  }
					/*[
					 	[ 'OPEN'   ,'Open' ],
					 	[ 'FORWARDED' , 'Forwarded']
					 ]  */ 		
			},
			{
				fieldLabel	:  'CSR ID',
				name		:  'csrId',
				xtype		:  'com.playdorm.Dropbox',		
				emptyText	:  'Select csr Id....',
				blankText 	:  'Please Chose csr Id',
				value           :  '',
				values 		: dropBoxArray,
				allowBlank	:	false,
				listeners	: {
								invalid : function(field , msg){Ext.Msg.alert('',msg);}
							  }
						
			},
				
			
			
		]
});

var win = new Ext.Window({
	title: 'Reply to ticket Id - '+ticketId,
	//title: 'Adjust',
	
	bodyStyle:'background-color:#fff;padding: 10px',
	items: this.form,
	buttonAlign: 'right', 
	buttons: [{
		text: 'Save',
		handler: function()
		{
		
		com.playdorm.TicketReplyPopupForm.form.getForm().submit({
				waitMsg: 'Please wait...',
				success: function(a, b)
					{
					
					
						//newtab('Player',playerId ,'/en_GB/player/view/playerId/','confirmed');
						callReplyPanel(ticketId,userId);
						Ext.Msg.alert('Success', 'ok');
						win.close();
					},
					failure: function(a, b)
					{
						callReplyPanel(ticketId,userId);
						Ext.Msg.alert('Failure', 'ok');
					}
				});
		}
	}, {
		text: 'Reset',
		handler: function()
		{
			//newtab('Player',playerId ,'/en_GB/player/view/playerId/','confirmed');
			com.playdorm.TicketReplyPopupForm.getForm().reset();
		}
	},
	{
		text: 'close',
		handler:function()
		{
			callReplyPanel(ticketId,userId);
			//callReplyPanel('Player',playerId ,'/en_GB/player/view/playerId/','confirmed');
			win.close();
		}
	}
				
			]
});

win.show();
	}	
}

Ext.onReady(com.playdorm.TicketReplyPopupForm.init,com.playdorm.TicketReplyPopupForm);
}