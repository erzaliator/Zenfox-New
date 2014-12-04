Ext.onReady(function(){
var login = new Ext.form.FormPanel({
    
    id: 'login-form',
    title: 'Please Login',
    height : 340,
    defaults: {
        allowBlank  :   false,
        width: 280,
        msgTarget: 'side',
        
        labelStyle : 'font-weight:bold',
        style: {
            //width: '95%',
            marginBottom: '20px'
        }
       },
    defaultType: 'textfield',
    
    items: [
         {
            xtype: 'box',
            id : 'image',
            autoEl: {html: '<img src="/images/login.jpg"/>'}
         },
         {
        	 
            fieldLabel  :   'User Name',
            id : 'userName',
            name        :   'userName',
            emptyText   :   'User Name',
            blankText   :    'Enter Username' 
         },
        
        {
            fieldLabel: 'Password',
            id : 'password',
            name: 'password',
            inputType: 'password',
        }
    ],
    buttons: [
             {
			   	text: 'Login',
			   	id : 'login',
			   	scale : 'medium',
			   	iconCls : 'loginbutton',
				handler: function(){
					if (login.form.isValid()) 
					{						
						login.getEl().mask();
						login.getForm().submit
							({
								url: '/auth/login/',
								waitMsg : 'Authenticating...',
								success: function( form , action ){
								login.getEl().unmask();

								Ext.get("userName").ghost('b', {
								    easing: 'easeOut',
								    duration: 1,
								    remove: false,
								    useDisplay: false
								});
								
								Ext.get("password").ghost('b', {
								    easing: 'easeOut',
								    duration: 1,
								    remove: false,
								    useDisplay: false
								});
								
								Ext.get("image").ghost('b', {
								    easing: 'easeOut',
								    duration: 1,
								    remove: false,
								    useDisplay: false
								});
								
								Ext.get("login-form").ghost('b', {
								    easing: 'easeOut',
								    duration: 1.5,
								    remove: false,
								    useDisplay: false
								});
								Ext.get("login-form").pause(3);
											window.location = '/home';
										},
							
								failure: function(form , action ){
											//Ext.get("userName").highlight();
											
											//Ext.get("userName").fadeIn({ endOpacity: 1, duration: 2});
											
											Ext.get("userName").frame( "ff0000", 3, { duration: 1 });
											Ext.get("password").frame( "ff0000", 3, { duration: 1 });
											
											info("Invalid UserName or Pasword !!");
											/*Ext.get("userName").ghost('b', {
											    easing: 'easeOut',
											    duration: .5,
											    remove: false,
											    useDisplay: false
											});*/
											
											/*Ext.get("userName").highlight("ffff9c", {
											    attr: "background-color", //can be any valid CSS property (attribute) that supports a color value
											    endColor:"00000",
											    easing: 'easeIn',
											    duration: 1
											});*/
											
											/*Ext.get("userName").puff({
											    easing: 'easeOut',
											    duration: .5,
											    remove: false,
											    useDisplay: false
											});*/
											
											/*Ext.get("userName").scale(
												    [12],
												    [123], {
												        easing: 'easeOut',
												        duration: .35
												    }
												);*/
											
											/*Ext.get("userName").shift({ x: 200, height: 50, opacity: .8 });*/
											
											/*Ext.get("userName").slideIn('t', {
											    easing: 'easeOut',
											    duration: .5
											});*/
											
											/*Ext.get("userName").slideOut('t', {
											    easing: 'easeOut',
											    duration: .5,
											    //remove: false,
											    //useDisplay: false
											});
											*/
											
											/*Ext.get("userName").switchOff({
											    easing: 'easeIn',
											    duration: .3,
											    remove: false,
											    useDisplay: false
											});*/
											login.getEl().unmask();
										}
										
							});	
						};
					}
				}
			,
            {
			   	text: 'Reset',
			   	scale : 'medium',
				handler : function()
                {
                    login.form.reset();
                }
		    }
              ],
             
    layoutConfig: {
        labelSeparator: ''
    },
    
   
    border : true,
    width   : 500,
    labelWidth: 140,
    labelAlign : 'right',
    
    buttonAlign : 'center',
  });

login.render('login-div');


function info(msg) {
    new Ext.ux.window.MessageWindow({
         title:'Authentication Failure !!!',
        html:msg || 'No information available',
        origin:{offY:-210,offX:-150},
        autoHeight:true,
        width : 200,
        //iconCls:'icon-info',
        help:false,
        hideFx:{delay:1000, mode:'standard'},
        listeners:{
            render:function(){
            //    Ext.ux.Sound.play('generic.wav');
            }
        }
    }).show(Ext.getDoc());
}
});