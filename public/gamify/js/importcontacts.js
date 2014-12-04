
	function sendinvites(event)
	{
		event.preventDefault();
		
		contacts = document.getElementById("total_contacts").value;
		message = document.getElementById("message_box").value;
		
		index = 1;
		emails = "";
		while(index <= contacts)
		{
			if(document.getElementById("check_"+index).checked == true)
				{
					if(emails == "")
					{
						emails = document.getElementById("email_"+index).value;
					}
					else
					{
						emails = emails+','+document.getElementById("email_"+index).value;
					}
				}
			
			
			index++;
		}

		$(_modalorbar).remove();
		
		var notifications = new $.inviteNotificationCenter({
	        bubble:{
	            useColors:true
	        },
	        
	        serverSideSave:false,
	        serverSideGet:false,
	        serverSideGetNew:false,
	        serverSideDelete:false,
	    });

	    notifications.initMenu({
	        projects:'#projects',
	        tasks:'#tasks',
	        messages:'#messages'
	    });
	    
	   
		$.ajax({
	        url:'http://taashtime.tld/index/invite',
	        data:{
	            emails:    emails,
	            message:   message,
	            ajaxcall: "true",
	        },
	        type: "POST",
	        success:function(value){
	        	
	        	var result = { 
	        		     "message"    :   "<b>Congratulation!! Your invitation has been sent to your friends. Your account will be credited as soon as your friends join TaashTime.</b>", 
	        		     "type"       :   "modal", 
	        		     "icon" :   "/importcontacts/images/service providers images/"+"invite-"+ _providerbox +".png",
	        		     "title": "SUCCESS"
	        		};
	        	
	        	 notifications.createNotification(result, 1);
	        
	             
	        },
	        error:function(result) {
	            alert("failed");
	        }
	    });
		
		
	}
    
    function toggleAll(element) 
	{
    	
    	var form = document.forms.send_invites, z = 0;
    	//alert(form[z].length);
    	for(z=0; z<form.length;z++)
		{
    		//alert(form[z].value);
		if(form[z].type == 'checkbox')
			form[z].checked = element.checked;
	   	}
	}
    
    function getimportcontactsForm(ServiceProvider)
	{
    	
    	_providerbox = ServiceProvider;
		 var notifications = new $.inviteNotificationCenter({
		        bubble:{
		            useColors:true
		        },
		        
		        serverSideSave:false,
		        serverSideGet:false,
		        serverSideGetNew:false,
		        serverSideDelete:false,
		    });

		    notifications.initMenu({
		        projects:'#projects',
		        tasks:'#tasks',
		        messages:'#messages'
		    });
		
		$.ajax({
	        url:'http://taashtime.tld/OpenInviter/importcontacts.php',
	       
	        success:function(value){
	        	
	        	var result = $.parseJSON(value);
	        	 result.result["type"] = "modal";
				 result.result["title"] =  "Import Contacts from";
				 result.result["icon"] = '/importcontacts/images/service providers images/'+'invite-'+ _providerbox +'.png';
	        	 notifications.createNotification(result.result, 1);
	             
	        },
	        error:function(result) {
	        	var result = { 
	        		     "message"    :   "<b>Some Error Occured</b>", 
	        		     "type"       :   "modal", 
	        		     "icon" :   "/importcontacts/images/service providers images/"+"invite-"+ _providerbox +".png",
	        		     "title": "FAILED"
	        		};
	        	 notifications.createNotification(result, 1);
	        }
	    });

	}
    
    function SubmitimportcontactsForm(event)
	{
    	
    	event.preventDefault();
    	email = document.getElementById("email").value;
    	password = document.getElementById("password").value;
    	
    	$(_modalorbar).remove();
    	
    	var notifications = new $.inviteNotificationCenter({
		        bubble:{
		            useColors:true
		        },
		        
		        serverSideSave:false,
		        serverSideGet:false,
		        serverSideGetNew:false,
		        serverSideDelete:false,
		    });

		    notifications.initMenu({
		        projects:'#projects',
		        tasks:'#tasks',
		        messages:'#messages'
		    });
		
		    
		    
		$.ajax({
	        url:'http://taashtime.tld/OpenInviter/importcontacts.php',
	        type : "POST",
	        data:{
	        	provider_box : _providerbox,
	        	email_box : email,
	        	password_box : password
	 	        },
	        success:function(value){
	        	
	        	var result = $.parseJSON(value);
	        	 if(result.result["type"] == "modal")
				 {
					  result.result["title"] =  "Import Contacts from";
					  result.result["icon"] = '/importcontacts/images/service providers images/'+'invite-'+ _providerbox +'.png';
				 }
	        	 else
	        	 {
	        		 result.result["title"] =  "Select and Invite";
					 result.result["icon"] = '/importcontacts/images/service providers images/'+'invite-'+ _providerbox +'.png';
	        	 }
				 notifications.createNotification(result.result, 1);
	             
	        },
	        error:function(result) {
	            alert("failed");
	        }
	    });

	}
    
    function popupclose(modalorbar)
    {
    	_modalorbar = modalorbar;
    }