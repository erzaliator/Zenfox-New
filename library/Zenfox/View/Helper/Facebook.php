<?php
class Zenfox_View_Helper_Facebook extends Zend_View_Helper_Abstract
{
	/**
	 * @var Zend_View_Instance
	 */ 
	public $view; 
	 
	/**
	 * Set view object
	 * 
	 * @param  Zend_View_Interface $view 
	 * @return Zend_View_Helper_Form
	 */ 
	public function setView(Zend_View_Interface $view) 
	{ 
	    $this->view = $view;
	} 
	public function facebook()
	{		
		$siteCode = Zend_Registry::get('siteCode');
		$facebookFile = APPLICATION_PATH . '/site_configs/' . $siteCode . '/facebook.json';
		$fh = fopen($facebookFile, 'r');
		$facebookKeyJson = fread($fh, filesize($facebookFile));
		fclose($fh);
		$facebookConfig = Zend_Json::decode($facebookKeyJson);
		
		$appId = $facebookConfig['application']['appId'];
		
		?>
		
				<div id="fb-root"></div>
		 <script type='text/javascript' src = 'https://connect.facebook.net/en_US/all.js' async = true></script>
<script type="text/javascript">

window.fbAsyncInit = function() {
  FB.init({appId: '<?php echo $appId; ?>', status: true, cookie: true, xfbml: true, oauth : true});

  FB.Event.subscribe('auth.logout', function(response) {
	  if(get_cookie('nikhil'))
	  {
		  var i;
		  for(i = 0; i < 5; i++)
		  {
			  if(!get_cookie('nikhil'))
			  {
				  break;
			  }
			  delete_cookie('nikhil');
		  }
		  var loggedOut = confirm ("You have been logged out from Facebook. Do you wanna log out from Taashtime?");
		  if(loggedOut)
		  {
			  window.location.href = "<?php echo "/auth/logout";?>";
		  }
	  }
  });

  FB.Event.subscribe('edge.create', function(response) {
	  $.ajax({
		  type: "POST",
		  url: "/banking/funcoins",
		  data: {facebook:true},
		  success: function(data){
			  alert(data);
			  document.getElementById("confirm-facebook-like").style.display = "none";
		      document.getElementById("confirm-invite-friends").style.display = "block";
		  }
	  });
  });

};

function facebookLogin() {
	alert("This feature is unavailable at the moment. Please contact Live Help for more information.");
	/*
    FB.login( function (response) {
      if(response.authResponse) {
    	  var accessToken = response.authResponse.accessToken;
    	  var userId = response.authResponse.userID;
    	  window.location.href = "/facebook/facebooklogin/userId/"+userId+"/accessToken/"+accessToken;
    	  FB.api('/me', function(response) {
           // if(set_cookie('nikhil', 2))
            //{
        		//window.location.href = "<?php echo "/facebook/facebooklogin";?>";
            //}
        });
      } else  {
        // not logged in.
      }
    }, {scope:'email'});*/
}

function set_cookie ( name, value, exp_y, exp_m, exp_d, path, domain, secure )
{
  var cookie_string = name + "=" + escape ( value );

  if ( exp_y )
  {
    var expires = new Date ( exp_y, exp_m, exp_d );
    cookie_string += "; expires=" + expires.toGMTString();
  }

  if ( path )
        cookie_string += "; path=" + escape ( path );

  if ( domain )
        cookie_string += "; domain=" + escape ( domain );
  
  if ( secure )
        cookie_string += "; secure";
  
  document.cookie = cookie_string;
  return true;
}

function delete_cookie ( cookie_name )
{
  var cookie_date = new Date ( );  // current date & time
  cookie_date.setTime ( cookie_date.getTime() - 1 );
  document.cookie = cookie_name += "=; expires=" + cookie_date.toGMTString();
}

function get_cookie ( cookie_name )
{
  var results = document.cookie.match ( '(^|;) ?' + cookie_name + '=([^;]*)(;|$)' );

  if ( results )
    return ( unescape ( results[2] ) );
  else
    return null;
}

</script>
		<?php
	}
}
