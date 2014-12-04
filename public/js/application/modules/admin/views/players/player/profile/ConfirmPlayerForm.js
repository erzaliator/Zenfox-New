Ext.ns('com.playdorm');

//Ext.BLANK_IMAGE_URL = '../ext-3.0/resources/images/default/s.gif';

function confirmPlayerForm(code , playerId)
{


com.playdorm.ConfirmPlayerForm = {
	init: function(){	
	


this.form= new Ext.FormPanel({
	border:false,
	url: 'player/confirmplayer/code/'+code+'/format/json',
	defaults:{xtype:'textfield'},	
	items:[
		
{
    xtype: "label",
    name: "rotate",
    id: 'label_id',
    text: "Confirm Player with ID "+playerId+" and Code "+code,
    cls: 'x-form-item-label x-form-item' /*apply ext styles*/
}
		
	]
});

var win = new Ext.Window({
	title: 'Comfirm player',
	layout:'fit',
	bodyStyle:'background-color:#fff;padding: 10px',
	items:this.form,
	buttonAlign: 'right', 
	buttons: [{

        text: 'Confirm',
        waitMsg:'Please Wait...',
        handler: function()

        {

		com.playdorm.ConfirmPlayerForm.form.getForm().submit({

                success: function(a, b)

                {

                    Ext.Msg.alert('Success', 'ok');

                },

                failure: function(a, b)

                {

                    Ext.Msg.alert('Failure', 'ok');

                }

            });

        }

    }]
});

win.show();
	}	
}

Ext.onReady(com.playdorm.ConfirmPlayerForm.init,com.playdorm.ConfirmPlayerForm);
}