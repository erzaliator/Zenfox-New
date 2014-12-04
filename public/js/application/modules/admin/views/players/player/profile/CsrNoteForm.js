

function insertCsrNoteForm(playerId)
{
	console.log(playerId);
	TabId = '/en_GB/player/view/playerId/'+playerId;
	type = 'confirmed';
	 var c = Ext.getCmp(TabId);
	 Ext.getCmp('tab-panel').remove(c);
	Ext.onReady(function() {
		var form = new Ext.FormPanel({
	      	
	    	border:false,
	    	url: 'player/view/insertCsrNote/true/playerId/'+playerId+'/format/json',
		
			defaultType	: 'textfield',
			
		   
			items:[
					{
						xtype		: 	'textarea',
						fieldLabel	:	'Note', 
						name		:	'note', 
						width		: 	200,
						heignt		: 	200,
						id			:	"CSRNOTE",
					   
					}
	    		 ]	        
	    });
	    
		var csrNoteWin = new Ext.Window({
			title: 'Adjust',
			width:400,
			height:300,
			bodyStyle:'background-color:#fff;padding: 10px',
			items: form,
			buttonAlign: 'right', 
			buttons: [{
				text: 'Save',
				handler: function()
				{
						form.getForm().submit({
						success: function(a, b)
							{
							
							
								newtab('Player',playerId ,'/en_GB/player/view/playerId/','confirmed');
								
								Ext.Msg.alert('Success', 'ok');
								csrNoteWin.close();
							},
							failure: function(a, b)
							{
								Ext.Msg.alert('Failure', 'ok');
							}
						});
				}
			}, {
				text: 'Reset',
				handler: function()
				{
					newtab('Player',playerId ,'/en_GB/player/view/playerId/','confirmed');
					form.getForm().reset();
				}
			},
			{
				text: 'close',
				handler:function()
				{
					newtab('Player',playerId ,'/en_GB/player/view/playerId/','confirmed');
					csrNoteWin.close();
				}
			}
						
					]
		});

		csrNoteWin.show();

});
}