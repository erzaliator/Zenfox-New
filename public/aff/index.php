<?php
$trackerId = isset($_GET['trackerId'])?$_GET['trackerId']:1;
$affId = isset($_GET['affid'])?$_GET['affid']:-1;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						<meta name = "keywords" content = "online rummy, 13 card rummy, play rummy, rummy, cash rummy, card games, taash,taashtime,Joining Bonus, Deposit Bonus, free games" />
											<meta name = "description" content = "Taash in hindi means playing cards. Taashtime offers online rummy for free. Play free games including 13 card rummy. Hope you enjoy playing rummy." />
					<title>Online Rummy</title>
  <link href="/css/rummy.tld/global.css" media="screen" rel="stylesheet" type="text/css" ><!-- 
<link rel="stylesheet" href="/css/rummy.tld/css/blueprint/screen.css" type="text/css" media="screen, projection" />
<link rel="stylesheet" href="/css/rummy.tld/css/style.css" type="text/css" />
 -->
<!-- <script src="script/jquery.min.js" type="text/javascript"></script>
<script src="script/custom.js" type="text/javascript"></script>
<script type="text/javascript" src="iepngfix_tilebg.js"></script>
-->

<!--[if lt IE 7]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE7.js"></script>
<![endif]-->
<!--[if lt IE 8]>
  <link rel="stylesheet" href="css/blueprint/ie.css" type="text/css" media="screen, projection">
<![endif]-->

<!--Google Analytics-->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-27546725-1']);
  _gaq.push(['_setDomainName', 'taashtime.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>


</head>
<body class="index">
<div class="container">
  <div id="login-header" class="span-24">
    <div class="span-4 live-tables">
      <div class="left pad-t-9 pad-l-5">Live Tables:</div>

      <div class="live-tables-number right pad-r-5">
      74      </div>
    </div>
    <div class="span-16 prepend-2 login-container">
  <div class="login-box">
	<form id="player-login-form" enctype="application/x-www-form-urlencoded" action="/auth/login" method="post"><dl class="zend_form">
<ul><li><label for="userName" class="required">Username *</label>

<input type="text" name="userName" id="userName" value="" class="text"></li>

<li><label for="password" class="required">Password *</label>

<input type="password" name="password" id="password" value="" class="text"></li>
<li class="login_form_button">
<input type="submit" name="submit" id="submit" value="Log In"></li>
<li class="facebook_button">
<input type="hidden" name="facebookLogin" value="" id="facebookLogin">
<a href = "#" onClick="facebookLogin()"><img src="/images/facebook-login-button.png" /></a></li>
<li>
<input type="hidden" name="fgPassword" value="" id="fgPassword">
<a href = "/en_IN/auth/forgotpassword/trackerId/<?=$trackerId?>/affid/<?=$affId?>/">Forgot Password</a></li></dl></form>      </div>

    </div>

    
  </div>
  <div id="nav-bar" class="span-24">
    <div class="span-6 pad-t-10"><a href ="/index/index/trackerId/<?=$trackerId?>/affid/<?=$affId?>/"><img src="/css/rummy.tld/images/logo-animation.gif" width="238" height="51" alt="Taash Logo" /></a></div>
    <div class="span-25 last prepend-1">
    <ul id="main-menu"> <li><a href="/home/index/trackerId/<?=$trackerId?>/affid/<?=$affId?>/" class="home-icon"><p class="menu-pad"><img src="/css/rummy.tld/images/my-home.png"></img></p></a></li>

<li>

<a href="/en_IN/game/index/trackerId/<?=$trackerId?>/affid/<?=$affId?>/"><p class="menu-pad">Play Rummy</p></a>

    </li>

<li>

<a href="/en_IN/content/legal/trackerId/<?=$trackerId?>/affid/<?=$affId?>/"><p class="menu-pad">Is it Legal?</p></a>

    </li>

<li>

<a href="/en_IN/promotions/index/trackerId/<?=$trackerId?>/affid/<?=$affId?>/"><p class="menu-pad">Promotions</p></a>

<ul id="nav-menu-sub" style="display:none;">

<li>

<a href="/en_IN/promotions/index/trackerId/<?=$trackerId?>/affid/<?=$affId?>/"><p class="menu-pad">Promotions</p></a>

</li>

</ul>

    </li>

<li>

<a href="/en_IN/help/howtoplay/trackerId/<?=$trackerId?>/affid/<?=$affId?>/"><p class="menu-pad">How to Play</p></a>

</li><li><img src="/css/rummy.tld/images/top-menu-pipe.png"/></li>
</ul>    <!-- 
      <ul id="main-menu">
        <li><a href="#" title="">
          <p class="menu-pad">Home</p>
          </a></li>
        <li><a href="#" title="">
          <p class="menu-pad">Join Now!</p>
          </a> </li>
        <li><a href="#" title="" >
          <p class="menu-pad">Rummy</p>
          </a></li>
        <li class="headlink"><a href="#" title="Test">
          <p class="menu-pad">Legality</p>
          </a> </li>
        <li class="headlink"><a href="#" title="Test">
          <p class="menu-pad">Promotions</p>
          </a> </li>
        <li class="headlink"><a href="#" title="Test">
          <p class="menu-pad">Winners</p>
          </a> </li>
        <li class="headlink"><a href="#" title="Test">
          <p class="menu-pad">Players Guide</p>
          </a> </li>
        <li><img src="images/top-menu-pipe.png"/></li>
      </ul>
      -->
    </div>
  </div>
  <div id="layout" class="span-24 home-banner">
	<div id="after-banner"><img src="/css/rummy.tld/images/web-banner-01.jpg" alt="Play Now!"/></div>
    <div id="left-column" class="span-16">
      <div id="home-banner-left" class="left">
<img src="/css/rummy.tld/images/main_banner_1.jpg" width="683" height="373" border="0" usemap="#play" />

		<map name="play">
			<area shape="rect" coords="522,321,678,363" href="/game/index/trackerId/<?=$trackerId?>/affid/<?=$affId?>/" />
		</map>
<!--
        <h1 class="color-white">Best Online Rummy <br />
          Playing Experience!</h1>
        <ul id="home-bullet">
          <li>Exciting rewards</li>
          <li>Gifts, vouchers and many thrilling prizes</li>
          <li>Healthy competition and camaraderie</li>
          <li>Play with friends and family online</li>
          <li>Invite your friends and have a private room</li>
        </ul>
        <p><a href="/game"><img src="/css/rummy.tld/images/home-play-now.png" width="175" height="55" alt="Play Now!" /></a></p>
-->

      </div>


<div class="home-content left">
      <div class="promo-box left">
      <div class="deposite">

      <div class="depositebg">
      <h2>BEST OF 3</h2>
      <div class="depositein">
      <h3><span>Three Rummy </span></h3>
      <h3><span>Games</span></h3>
      <h3>Maintain the least</h3>
      <h3>count and become
      </h3>

      <h3> a winner</h3>
      
      </div>
      <div class="btn"><a href="/game/quickjoin/flavour/BestOfThreeRummy/amount_type/FREE/trackerId/<?=$trackerId?>/affid/<?=$affId?>/"><img src="/css/rummy.tld/images/join now.png" width="148" height="44" alt="JoinNow" title="JoinNow" /></a></div>
      </div>
      </div>
      <!--
      <div class="promo-top"><img src="/css/rummy.tld/images/promo-1-top.png" alt="" width="198" height="94" /></div>
      <div class="promo-content">
      <h3><strong>On Sign-up for Rummy Players!</strong></h3>
      <p class="pad-t-20"><img src="/css/rummy.tld/images/play-now-small.png" width="132" height="38" alt="Play Now!" /></p>
      </div>
      <div><img src="/css/rummy.tld/images/promo-bottom.png" width="198" height="14" alt="Promotion 1" /></div>
      
      <img src="/css/rummy.tld/images/join.jpg" alt="Promotion 1" border="0" usemap="#joinMap"/>
      <map name="joinMap">
      <area shape="rect" coords="91,257,187,286" href="" />
      </map>-->
      </div>
      <div class="promo-box right">

      <div class="deposite">
              <div class="taashplay">
                <h2>STAKE</h2>
      <div class="depositein">
                  <h3><span>Quickest</span></h3>
      
      <h3> <span>Rummy Game</span></h3>
      <h3>Earn a multiple of </h3>

      <h3>loser's count </h3>
      
      </div>
      <div class="btnlast"><a href="/game/quickjoin/flavour/Indian_Rummy/amount_type/FREE/trackerId/<?=$trackerId?>/affid/<?=$affId?>/"><img src="/css/rummy.tld/images/referbtn.png" width="148" height="44" alt="Refer" title="Refer" /></a></div>
              </div>
      </div>
      <!--
                <div class="promo-top"><img src="/css/rummy.tld/images/promo-3-top.png" alt="" width="198" height="94" /></div>
                <div class="promo-content">
      <h3><strong>When you refer your friends!</strong></h3>
                  <p class="pad-t-20"><img src="/css/rummy.tld/images/play-now-small.png" width="132" height="38" alt="Play Now!" /></p>
                </div>
                <div><img src="/css/rummy.tld/images/promo-bottom.png" width="198" height="14" alt="Promotion 1" /></div>
      
                <img src="/css/rummy.tld/images/refer.jpg" alt="Promotion 1" border="0" usemap="#referMap" />
      <map name="referMap">
      				<area shape="rect" coords="91,257,187,286" href="/index/invite" />
      			</map>-->
      </div>
      <div style="margin-left:15px;" class="promo-box left">

            <div class="deposite">
      <div class="referbg">
      <h2>SYNDICATE</h2>
                <div class="depositein">
      <h3><span>101 & 201 </span></h3>
      <h3><span>Pool Rummy</span></h3>
       
       
      <h3>Last Man Standing</h3>

                   <h3>wins!!!</h3>
      </div>
      <div class="btnlast"><a href="/game/quickjoin/flavour/MPPRummy/amount_type/FREE/trackerId/<?=$trackerId?>/affid/<?=$affId?>/"><img src="/css/rummy.tld/images/depositbtn.png" width="148" height="44" alt="Deposit" title="Deposit" /></a></div>
      </div>
      </div>
      <!--<div class="promo-top"><img src="/css/rummy.tld/images/promo-2-top.png" alt="" width="198" height="94" /></div>-->
            <!-- 
      	<div class="promo-top"><img src="/css/rummy.tld/images/deposit-bonus.png" alt="" width="198" height="94" /></div>
                <div class="promo-content">
                  <h3><strong>On First Deposit!!</strong></h3>
                  <p class="pad-t-20"><img src="/css/rummy.tld/images/play-now-small.png" style="margin-top: 22px;" width="132" height="38" alt="Play Now!" /></p>
      </div>
      <div><img src="/css/rummy.tld/images/promo-bottom.png" width="198" height="14" alt="Promotion 1" /></div>
                
      <img src="/css/rummy.tld/images/deposit.jpg" alt="Promotion 1" border="0" usemap="#depositMap"/>
      <map name="depositMap">
      				<area shape="rect" coords="91,257,187,286" href="/banking/deposit" />
      </map>-->
      </div>

      </div>

      <div class="home-content left">
        <div id="wit-title">
          <h2 class="color-pink"><strong>What Is TAASH Time?</strong></h2>
        </div>
        <div id="wit-body" class="clear">
          <div id="wit-body-left" class="left">
            <p>Taashtime is a site dedicated to providing the best online card playing experience. The traditional Indian Rummy is their first game and it will be followed up by several others. The primary purpose of taashtime is to provide whole entertainment for the individual and their family, friends and colleagues. Taashtime is conceived as and created to be a means of entertainment and not a means for earning large amounts of money nor enabling players to do so. </p>

            <p>Taashtime is building an exciting rewards program for all their players. Players can earn gifts, vouchers and many more thrilling prizes. As the site grows, so will the number and size of the
              prizes distributed. </p>
            <p><!--a href="#"><strong>Learn More</strong></a--></p>
          </div>
          <div id="wit-body-right" class="right"><img src="/css/rummy.tld/images/taash-image.png" width="158" height="214" alt="Taash" /></div>
        </div>
      </div>
      <div class="home-content left">
        <div id="testi-title"></div>

        
        <div id="testi-body">
<div class="clear"></div>
          <p><a href="/testimonial/view/trackerId/<?=$trackerId?>/affid/<?=$affId?>/"><strong>More...</strong></a></p>
          <p><a href="/testimonial/write/trackerId/<?=$trackerId?>/affid/<?=$affId?>/"><strong>Write Testimonial</strong></a></p>
        </div>
        <!-- 
          <div id="testi-left" class="left">
            <div id="testi-photo" class="left"><img src="images/testi-photo.png" width="77" height="98" alt="Testimonial Photo" /></div>
            <div id="testi-content" class="right">
              <p>This site is great. I have played on other sites but the feel of this site is fantastic! I wish them all the success going forward!</p>
              <p><strong>Geetha Madhuri</strong></p>
            </div>
          </div>
          <div id="testi-right" class="right">
            <div id="testi-photo" class="left"><img src="images/testi-photo.png" width="77" height="98" alt="Testimonial Photo" /></div>
            <div id="testi-content" class="right">
              <p>This site is great. I have played on other sites but the feel of this site is fantastic! I wish them all the success going forward!</p>
              <p><strong>Geetha Madhuri</strong></p>
            </div>
          </div>
          <div id="testi-left" class="left">
            <div id="testi-photo" class="left"><img src="images/testi-photo.png" width="77" height="98" alt="Testimonial Photo" /></div>
            <div id="testi-content" class="right">
              <p>This site is great. I have played on other sites but the feel of this site is fantastic! I wish them all the success going forward!</p>
              <p><strong>Geetha Madhuri</strong></p>
            </div>
          </div>
          <div id="testi-right" class="right">
            <div id="testi-photo" class="left"><img src="images/testi-photo.png" width="77" height="98" alt="Testimonial Photo" /></div>
            <div id="testi-content" class="right">
              <p>This site is great. I have played on other sites but the feel of this site is fantastic! I wish them all the success going forward!</p>
              <p><strong>Geetha Madhuri</strong></p>
            </div>
          </div>
          <div class="clear"></div>
          <p><a href="#"><strong>More Players Speak</strong></a></p>
          -->
          <img src="/images/rummy.tld/legal.png" width="60" height="45">According to supreme court ruling, now rummy is fully legal in India. So continue Taashtiming, Play more, and Earn more!! :)</img>
      </div>

    </div>
    <div id="right-column" class="span-7 last right">
      <div id="join-now-top"></div>
      <!-- 
        <h2 class="pad-t-20"><strong>Join Now!</strong></h2>
         <div id="get-blurb" class="right"><img src="/css/rummy.tld/images/get-25-blurb.png" width="97" height="98" alt="Get Rs. 25/-!" /></div>
         -->
        			
	
    		    	<div id="join-now">
	    	<h2 class="pad-t-20"><strong>JOIN NOW!</strong></h2>
	    	<div id="get-blurb-home" class="right"><img src="/css/rummy.tld/images/get-25-blurb.png" width="97" height="98" alt="Get Rs. 25/-!" /></div>
	    	<div class="reg" id="regForm">

	    		<form id="player-registration-form" enctype="application/x-www-form-urlencoded" action="/auth/signup/trackerId/<?=$trackerId?>/affid/<?=$affId?>/" method="post"><dl class="zend_form">
<dt id="affId-label">&#160;</dt>
<dd id="affId-element">
<input type="hidden" name="affId" value="" id="affId"></dd>
<dt id="trackerId-label">&#160;</dt>
<dd id="trackerId-element">
<input type="hidden" name="trackerId" value="18" id="trackerId"></dd>
<dt id="buddyId-label">&#160;</dt>
<dd id="buddyId-element">
<input type="hidden" name="buddyId" value="" id="buddyId"></dd>
<ul><li><label for="login" class="required">Username *</label>

<input type="text" name="login" id="login" value="" class="text"></li>
<li><label for="password" class="required">Password *</label>

<input type="password" name="password" id="password" value="" class="text"></li>
<li><label for="confirmPassword" class="required">Confirm Password *</label>

<input type="password" name="confirmPassword" id="confirmPassword" value="" class="text"></li>
<li><label for="email" class="required">EmailID *</label>

<input type="text" name="email" id="email" value="" class="text"></li>
<li>
<input type="hidden" name="terms" value="0"><input type="checkbox" name="terms" id="terms" value="1" style="width:300px" class="text">
I agree to <a href = "/content/terms/trackerId/<?=$trackerId?>/affid/<?=$affId?>/">Terms & Conditions</a></li>
<li class="facebook_button">

<input type="hidden" name="facebookLogin" value="" id="facebookLogin">
<a href = "#" onClick="facebookLogin()"><img src="/images/facebook-login-button.png" /></a></li>
<li class="login_form_button">
<input type="submit" name="submit" id="submit" value="Submit"></li></ul></dl></form>	    		</div>
	    		</div>
	    		<!-- 
	    		<div id="break">&nbsp; &nbsp; 
</div>
-->
	    		        <!-- 
        <div id="reg-form">
          <form id="player-registration-form" action="" method="post">
            <p class="bottom">
              <input type="text" value="Username" id="login" name="login" class="text">
            </p>
            <div id="get-blurb" class="right"><img src="images/get-25-blurb.png" width="97" height="98" alt="Get Rs. 25/-!" /></div>
            <div class="clear"></div>
            <p class="bottom">
              <input type="text" value="Password" id="password" name="password" class="text">
            </p>
            <p class="bottom">
              <input type="text" value="Confirm password" id="confirmPassword" name="confirmPassword" class="text">
            </p>
            <p class="bottom">
              <input type="text" value="Email id" id="email" name="email" class="text">
            </p>
            <p class="pad-t-20">
              <input type="image" id="submit" name="submit" src="images/join-now.png">
            </p>
            <p class="bottom pad-t-20"><img src="images/fb-connect.png" width="196" height="27" /></p>
          </form>
        </div>
         -->
      <div id="join-now-bottom"></div>
     
<!-- 
<div id="help-top"></div>
<div id="help-back">
-->
<!-- 
</div>
<div id="help-bottom"></div>      
--> 

  
 <!--     <div class="home-content left"><img src="/css/rummy.tld/images/grame-platform.png" width="267" height="209" alt="Game Platform" /></div> -->

      <div class="home-content left">
       
        <!-- <script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script> -->
        <fb:like-box href="http://www.facebook.com/taashtime" width="267" show_faces="true" border_color="" stream="true" header="true"></fb:like-box>
      </div>
						<div class="home-content left">
					<div id="help-top">Did You Know??</div>
						<div id="help-back">
													<p><strong>How to contact Customer Service?</strong></p>

																<p class="bottom">There are many ways to contact customer care service. These are: a)Submit a coupon, b) Click on live help or c) Write to customersupprt@taashtime.com.</p>
																<br>
																<p><strong>What is live help?</strong></p>
																<p class="bottom">At the bottom of every page on the Taashtime site, there is a link of Live Help, clicking on which, you can get live customer care support, even during the game play.</p>
																<br>
																<p><strong>What are Live Tables?</strong></p>
																<p class="bottom">These are the number of game tables on Taashtime. Players must join one of these tables in order to play. Currently 30 live tables are available with different games like- 2,3,4,5,6 player rummy.</p>

																<br>
														</div>
						<div id="help-bottom"></div>
						</div>
					
    </div>
  </div>
</div>
</div>

<div class="footer">
  <div class="container pad-t-20">

    <div class="span-4 append-1 black-link line-links">
      <p class="bottom"><strong>TAASH Time</strong></p>
      <p class="bottom"><a href="/content/about/trackerId/<?=$trackerId?>/affid/<?=$affId?>/">About TAASH Time</a></p>
      <p class="bottom"><a href="/content/legal/trackerId/<?=$trackerId?>/affid/<?=$affId?>/">Legality</a></p>
      <p class="bottom"><a href="/content/terms/trackerId/<?=$trackerId?>/affid/<?=$affId?>/">Terms And Conditions</a></p>
      <p class="bottom"><a href="/content/withdrawterms/trackerId/<?=$trackerId?>/affid/<?=$affId?>/">Withdrawal Terms</a></p>

      <p><a href="/content/contact/trackerId/<?=$trackerId?>/affid/<?=$affId?>/">Contact Us</a></p>
    </div>
    <div class="span-4 append-1 black-link line-links">
      <p class="bottom"><strong>Games</strong></p>
      <p class="bottom"><a href="/game/index/trackerId/<?=$trackerId?>/affid/<?=$affId?>/">Play Rummy</a></p>
      <p class="bottom"><a href="/index/winner/trackerId/<?=$trackerId?>/affid/<?=$affId?>/">Winners Zone</a></p>
      <p class="bottom"><a href="/faq/index/trackerId/<?=$trackerId?>/affid/<?=$affId?>/">Taash FAQ</a></p>

      <p class="bottom"><a href="/content/awards/trackerId/<?=$trackerId?>/affid/<?=$affId?>/">Taash Awards</a></p>
      <p class="bottom"><a href="http://taashtime.com/blog">Blogs</a></p>
      <p class="bottom"><a href="/affiliate/program">Affiliate Program</a></p>
      <p><a href="/help/howtoplay/trackerId/<?=$trackerId?>/affid/<?=$affId?>/">Players Guide</a></p>
    </div>
    <div class="span-6 line-links">
      <p class="bottom"><strong>Exciting Offers!</strong></p>

      <p><img src="/css/rummy.tld/images/offers.png" width="193" height="131"></p>
      <p class="black-link"><a href="/auth/signup/trackerId/<?=$trackerId?>/affid/<?=$affId?>/"><strong>Join Now!</strong></a></p>
    </div>
    <div class="span-6 last prepend-1">
      <p><img src="/css/rummy.tld/images/taashlogo-bottom.png"></p>
      <p class="small line-small">Taashtime is a site dedicated to providing the best online card playing experience. The traditional Indian Rummy is their first game and it will be followed up by several others.</p>
      <p class="small line-small">Copyright © 2011 TaashTime.com - All rights reserved.</p>

      <p class="small black-link"><a href="/content/privacypolicy/trackerId/<?=$trackerId?>/affid/<?=$affId?>/">Privacy Policy</a> | <a href="#">Site Map</a></p>
    </div>
  </div>
</div>
 <link rel="stylesheet" href="/css/rummy.tld/jquery-ui-1.8.9.custom.css" type="text/css" media="screen">

<script type="text/javascript" src="/js/jquery_zenfox.js"></script>

		
				<div id="fb-root"></div>
		 <script type='text/javascript' src = 'https://connect.facebook.net/en_US/all.js' async = true></script>
<script type="text/javascript">

window.fbAsyncInit = function() {
  FB.init({appId: '204326862920157', status: true, cookie: true, xfbml: true,
          session : null  });

  FB.Event.subscribe('auth.logout', function(response) {
	  if(get_cookie('facebook'))
	  {
		  var i;
		  for(i = 0; i < 5; i++)
		  {
			  if(!get_cookie('facebook'))
			  {
				  break;
			  }
			  delete_cookie('facebook');
		  }
		  var loggedOut = confirm ("You have been logged out from Facebook. Do you wanna log out from Taashtime?");
		  if(loggedOut)
		  {
			  window.location.href = "/auth/logout";
		  }
	  }
  });

};

function facebookLogin() {
    FB.login( function (response) {
      if(response.authResponse) {
    	  var accessToken = response.authResponse.accessToken;
    	  var userId = response.authResponse.userID;
    	  window.location.href = "/facebook/facebooklogin/userId/"+userId+"/accessToken/"+accessToken;
      } else  {
        // not logged in.
      }
    }, {scope:'email'});
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
				<!-- Server Code -->
		<!-- Piwik
			<script type="text/javascript">
			var pkBaseURL = (("https:" == document.location.protocol) ? "https://piwik.playdorm.com/" : "http://piwik.playdorm.com/");
			document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
			</script><script type="text/javascript">
			try {
			var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", );
			piwikTracker.trackPageView();
			piwikTracker.enableLinkTracking();
			} catch( err ) {}
			</script><noscript><p><img src="http://piwik.playdorm.com/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>
		End Piwik Tag -->
		<!-- Piwik 
			<script type="text/javascript">
			var pkBaseURL = (("https:" == document.location.protocol) ? "/piwik/" : "/piwik/");
			document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
			</script><script type="text/javascript">
			try {
			var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", );
			piwikTracker.trackPageView();
			piwikTracker.enableLinkTracking();
			} catch( err ) {}
			</script><noscript><p><img src="/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>
			 End Piwik Tag -->
					<script type="text/javascript">
			var pkBaseURL = "http://taashtime.com/piwik/";
			document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
			</script><script type="text/javascript">
			try {
			var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
						piwikTracker.trackPageView();

						
			piwikTracker.enableLinkTracking();
			} catch( err ) {}
			</script><noscript><p><img src="http://taashtime.com/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>

			
		  <!-- begin olark code --><script type='text/javascript'>/*{literal}<![CDATA[*/window.olark||(function(i){var e=window,h=document,a=e.location.protocol=="https:"?"https:":"http:",g=i.name,b="load";(function(){e[g]=function(){(c.s=c.s||[]).push(arguments)};var c=e[g]._={},f=i.methods.length;while(f--){(function(j){e[g][j]=function(){e[g]("call",j,arguments)}})(i.methods[f])}c.l=i.loader;c.i=arguments.callee;c.f=setTimeout(function(){if(c.f){(new Image).src=a+"//"+c.l.replace(".js",".png")+"&"+escape(e.location.href)}c.f=null},20000);c.p={0:+new Date};c.P=function(j){c.p[j]=new Date-c.p[0]};function d(){c.P(b);e[g](b)}e.addEventListener?e.addEventListener(b,d,false):e.attachEvent("on"+b,d);(function(){function l(){return["<head></head><",z,' onload="var d=',B,";d.getElementsByTagName('head')[0].",y,"(d.",A,"('script')).",u,"='",a,"//",c.l,"'",'"',"></",z,">"].join("")}var z="body",s=h[z];if(!s){return setTimeout(arguments.callee,100)}c.P(1);var y="appendChild",A="createElement",u="src",r=h[A]("div"),G=r[y](h[A](g)),D=h[A]("iframe"),B="document",C="domain",q;r.style.display="none";s.insertBefore(r,s.firstChild).id=g;D.frameBorder="0";D.id=g+"-loader";if(/MSIE[ ]+6/.test(navigator.userAgent)){D.src="javascript:false"}D.allowTransparency="true";G[y](D);try{D.contentWindow[B].open()}catch(F){i[C]=h[C];q="javascript:var d="+B+".open();d.domain='"+h.domain+"';";D[u]=q+"void(0);"}try{var H=D.contentWindow[B];H.write(l());H.close()}catch(E){D[u]=q+'d.write("'+l().replace(/"/g,String.fromCharCode(92)+'"')+'");d.close();'}c.P(2)})()})()})({loader:(function(a){return "static.olark.com/jsclient/loader0.js?ts="+(a?a[1]:(+new Date))})(document.cookie.match(/olarkld=([0-9]+)/)),name:"olark",methods:["configure","extend","declare","identify"]});olark.identify('8609-194-10-7825');/*]]>{/literal}*/</script><!-- end olark code -->
<!-- Begin Olark Addon Code --><script type='text/javascript'>/*Updating the nickname*/olark('api.chat.updateVisitorNickname', {snippet:'' })</script><!-- EndOlark Addon Code -->
<!-- Start of the Pzyche Tag 
<script type="text/javascript">
    var pzy = document.createElement('script');
    pzy.type = 'text/javascript';
    var method = 'pzyche';
    pzy.async = false;
    pzy.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 's3.amazonaws.com/embed.j.im/' + method + '.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(pzy, s);
</script>
 End of the Pzyche Tag -->
<script type="text/javascript" src="https://www.startssl.com/seal.js"></script>

<!-- Tracker Script -->
<script type ="text/javascript" src="http://static.adohana.com/oa.js?usr=befa5c621cbbceace92907c751f8d506"></script>

</body>
</html>

