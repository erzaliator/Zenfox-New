window.fbAsyncInit = function() 
{
	FB.init({appId: '00c8acaf15e4634fda64d7399047da6b', status: true, cookie: true, xfbml: true});
	FB.Event.subscribe('auth.sessionChange', function(response)
	{
		if (response.session) 
		{
			FB.login(function(response)
			{
				if (response.session)
				{
					if (response.perms)
					{
						//alert('user logined and grated some permission');
						//alert(response.perms);
						location.reload();
					}
					else
					{
						FB.logout();
						//alert('Please re-login and grant the permission');
					}
				}
				else 
				{
					//alert('user is not logined');
				}
			}, {perms:'email, read_friendlists, user_location'});
		}
		else
		{
			//location.reload();
			//alert("I am logged out");
			window.location.href = "http://playdorm.com/auth/logout";
		}
	});
};
(function()
{
	var e = document.createElement('script');
	e.async = true;
	e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
	document.getElementById('fb-root').appendChild(e);
}());
