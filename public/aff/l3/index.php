<?php

$con = mysql_connect("zenfox-master","zenfox-web","e6e3be2d833cdf5d9d4c7bc2f85cd098");
$hostAddress = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$referrerAddress = $_SERVER['HTTP_REFERER'];
$clientIp = $_SERVER['REMOTE_ADDR'];
mysql_select_db("zenfox", $con);
$sql = "INSERT INTO url_records (referrer_url, url, client_ip, datetime) VALUES ('$referrerAddress', '$hostAddress', '$clientIp', NOW())";
//mysql_query($sql,$con);
mysql_close($con);

setcookie("landingPage", "LANDINGPAGE_3", time() + (86400 * 30), "/", '.'.$_SERVER['HTTP_HOST']);

$trackerId = isset($_GET['trackerId'])?$_GET['trackerId']:1;
$affId = isset($_GET['affid'])?$_GET['affid']:-1;

$idSite = 1;
switch($trackerId)
{
        case 22:
                $idSite = 23;
                break;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NewsLetter</title>
<!--[if lt IE 7]>  <![endif]-->
<!--[if lt IE 7.]>
<script defer type="text/javascript" src="images/pngfix.js"></script>
<![endif]-->

<style type="text/css">

<!--

body{ margin:0px; padding:0px; font-family:Arial, Helvetica, sans-serif; font-size:13px; background: #24377e ; }

#taashm{  margin:0px auto;  padding-top:20px; behavior: url(images/border-radius.htc); }

#taashmin{ }

#taashlogo{ height:137px;    }

#taashlogos{ margin:10px 0px 40px 0px ; text-align:center; background:url(images/logo-bg.gif) top repeat-x #e9e9e9 ; -moz-border-radius: 15px;	-webkit-border-radius: 15px;	border-radius: 15px; height:75px; border:solid 1px #f4f3f3  }

#taashlogos p{ margin:0px; padding:0px; font-size:16px; text-align:center} 

#taashcont{ height:550px; margin-top:50px; background:#fbfbfb; clear:both; width:800px; margin:60px auto 0px auto;  }

#taashcontl, #taashcontr{ float:left; width:375px; margin-left:20px;   }

#taashcontr{ width:360px; color:#000; font-size:12px; margin:-30px 0px 0px 25px}  

#taashcont ul{ margin:0px; padding:0px;}

#taashcont ul li{ margin:5px 0px 0px 10px; padding:0px; color:#000; line-height:12px;  }

.readmore{ text-align:right; padding:0px 20px 0px 0px; margin:-15px 0px 0px 0px;}

.readmore a{ font-size:12px; color:#fff; text-decoration:none;  font-weight:bold ;  text-decoration:none;}

.readmore a:hover{text-decoration:underline;  color:#7c0208; }

.margin{ margin:10px 0px 0px 0px; }

.marginpad{ margin:35px 0px 0px 0px; }

.taashsocial{ height:110px; clear:both ;  color:#fff}

.taashsocial h4{ font-weight:normal; font-size:13px; text-align:center; margin:10px;  }

.taashsocialicons{ width:340px; height:90px; margin: 20px auto 0px auto}

.taashsocialiconsin { margin-top:20px; text-align:center}

.taashsocialiconsin img{ padding:0px 20px 0px 20px}

#taashfooter{ position:relative; height:50px;  padding-top:6px; text-align:center; clear:both}

#taashfooterin{ width:760PX; margin:0px auto; height:40px; padding:8px 20px 0px 20px;  background:url(images/logo-bg.gif) repeat-x #e9e9e9; padding-bottom:6px; clear:both}

.startssl{ width:97px; height:97px; position:absolute; right:0px; top:-51px;  }

.supportedby{ float:left;   padding:15px 10px 0px 0px}

.textbox{ background-color:#FFF;  border:#5574a3 solid 1px; font-size:12px; width:200px; opacity:1;  filter:alpha(opacity=100);  }

.btn{ color:#fff; font-weight:bold; background:#bb2f79; -moz-border-radius: 5px;	-webkit-border-radius: 5px;	border-radius: 5px; border: 1px solid #fff; font-size:14px; cursor:pointer; padding:5px 10px 5px 10px }

.login{ color:#000; }

.login a{ color:#ff2904; text-decoration:none; font-weight:bold }

.login a:hover{ color:#FFF }

.box3 {background:url(images/logo-bg.gif) repeat-x #e9e9e9; 	height: 150px;	padding: 20px 10px 10px 15px;		-moz-border-radius: 15px;	-webkit-border-radius: 15px;	border-radius: 15px; border: 1px solid #b3b5c7;	behavior: url(images/border-radius.htc); }

.box2 {	background:url(images/logo-bg.gif) repeat-x #e9e9e9;  color:#000;			padding: 3px 5px 5px 17px;		-moz-border-radius: 10px;	-webkit-border-radius: 10px;	border-radius: 10px; behavior: url(images/border-radius.htc);}

.box1{	background: #291f5c; 		height: 100px;	padding: 0px;		-moz-border-radius: 15px;	-webkit-border-radius: 15px;	border-radius: 15px; border: 1px solid #2a2369;	behavior: url(images/border-radius.htc); opacity:0.8;  filter:alpha(opacity=80); -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=80)"; /* For IE8 and earlier */}

.box4{	background:url(images/formbg.png) ;			padding: 0px; padding:5px 2px 2px 2px;		-moz-border-radius: 15px;	-webkit-border-radius: 15px;	border-radius: 15px;behavior: url(images/border-radius.htc); }

.box5 { height:85px;		background:url(images/logo-bg.gif) repeat-x #e9e9e9;			padding: 0px 0px 2px 0px;		-moz-border-radius: 10px;	-webkit-border-radius: 10px;	border-radius: 10px;	behavior: url(images/border-radius.htc);}

.box4colorhover{ background-color:#666 }

.box4colorout{ background-color:none }

#taashm h1{ margin:0px 0px 5px 15px; padding:0px; font-size:14px; color:#89265B;   z-index:1    }

#taashm h2{ margin:0px 0px 10px 0px ; padding:0px; font-size:16px; co lor:#000; color:#382e2e; z-index:1; text-align:center   }

.taashfloatr{ position:relative }

.taashtimeicon{ position:absolute; width:165px; height:91px; top:-45px; right:-10px; z-index:1; text-align:right}

.rummylegalm{ margin-top:10px; }

.rummylegall{ float:left; width:245px;  }

.rummylegalr{ float:left; width:122px; margin-left:8px; }

.rummylegalr img{  z-index:0; margin:5px 5px 0px 5px }

.taashlegal{ width:93px; height:90px; float:left ; height:100px; margin:-5px 0px 0px -20px   }

.taashlegalcont{ width:285px;  padding: 5px 0 0 5px; float:left; color: #000;}

.verificationm{ padding:20px; color:#3a3220;  }

.verification{ font-size:16px; font-weight:bold;  text-align:center; height:40px }

.details{ font-size:15px; font-weight:normal; padding-bottom:5px; border-bottom:#cdc8bf solid 2px; margin:10px 0px 10px 0px;  }

.ttcards{ float:left; padding-top:8px; }

.ttbanks{ float:right;}

-->

</style></head>
<body>
<div id="taashm">
  <div id="taashmin">   
    <div id="taashcont">
     <div class="margin" style="margin-top:-78px"><div id="taashlogos"><img src="images/logo-animation.gif" width="228" height="51" /><p>India's favourite Rummy</p></div></div>
      <div id="taashcontl">      
        <div class="margin">
          <div class="taashfloatr">
            <div class="taashtimeicon"><img src="images/cards.png" width="165" height="91" /></div>
          </div>
          <div class="box4" >
            <h1>Rummy Games</h1>
            <div class="box2">
              <ul>
                <li>Most popular Rummy games: Syndicate, Stake, Best of Three.</li>
                <li>Daily Tournaments, Weekly, Monthly and Festival Specials</li>
                <li>Rated the Best Rummy Experience on the web!</li>
                <li>Industry's top class fraud detection and control</li>
              </ul>
            
            </div>
          </div>
        </div>
    <div class="marginpad">
          <div class="taashfloatr">
            <div class="taashtimeicon"><img src="images/phone.png" width="127" height="91" /></div>
          </div>
          <!--div class="box4" >
            <h1>Live Customer Support</h1>
            <div class="box2"> Drop us a line - support@taashtime.com
              or find us on live help. </div>
          </div-->
        </div>
        <div class="marginpad" style="margin-top:22px">
          <div class="box4" >
            <h1>Regular TaashTime Promotions</h1>
            <div class="box2">
              <ul>
                <li>Joining bonus - TaashCash (TRs) 25 + 1000 TaashCoins (T¢)</li>
                <li>Win 20 times your sign-up bonus</li>
                <li>Referal Bonus - Get Rs.500 for every friend you refer</li>
                <li>Daily Deposit bonus upto 100%</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="rummylegalm" style="margin-top:20px">
          <!--div class="marginpad" style="margin-top:22px">
            <div class="margin">
              <div class="box4" >
                <h1>Is Rummy Legal?</h1>
                <div class="box5">
                  <div class="taashlegal"><img src="images/legal.png" width="93" height="90"  alt="100%LEGAL" title="100%LEGAL"/></div>
                  <div class="box2">
			<ul> 
				<li>"Rummy is mainly and preponderantly a game of skill." - <b>Supreme Court verdict.</b></li>
				<li>As Rummy is a game of skill, this activity is protected under the <b>"Indian Constitution - Article 19[1](g)".</b></li>
			</ul>
                  </div>
                </div>
              </div>
            </div>
          </div-->
            <div class="margin">

              <div class="box4" >

                <h1>Is Rummy Legal?</h1>

                <div class="box5">

                  <div class="taashlegal"><img src="images/legal.png" width="93" height="90"  alt="100%LEGAL" title="100%LEGAL"/></div>

                  <div class="taashlegalcont"><ul> 

				<li>"Rummy is mainly and preponderantly a game of skill." - <b>Supreme Court verdict.</b></li>

				<li>As Rummy is a game of skill, this activity is protected under the <b>"Indian Constitution - Article 19[1](g)".</b></li>

			</ul>

                 

                  </div>

                </div>

              </div>

            </div>
          <div class="rummylegalr">
            <div class="margin">
              <!--div class="box4" >
                <h1>Find Us</h1>
                <div class="box5" style="text-align:center"><a href="#"><img src="images/facebook.png" width="25" height="25"  border="0" alt="Facebook" title="Facebook"/></a><a href="#"><img src="images/twitter.png" width="25" height="25"  border="0" alt="Twitter" title="Twitter"/></a><a href="#"><img src="images/orkut.png" width="25" border="0" height="25" alt="Orkut" title="Orkut" /></a><a href="#"><img src="images/g+.png" width="25" height="25"  border="0" alt="Google+" title="Google+"/></a><a href="#"><img src="images/digg.png" width="42" height="25" border="0" alt="Digg" title="Digg" /></a></div>
              </div-->
            </div>
          </div>
        </div>
      </div>
      <div id="taashcontr">
        <h2>Play Now for free!</h2>
        <div class="box3">
<form method="post" action="http://taashtime.com/auth/signup/trackerId/<?=$trackerId?>/affid/<?=$affId?>/" enctype="application/x-www-form-urlencoded">
          <table width="100%" border="0">
            <tr>
              <td width="37%" height="25">User Name</td>
              <td width="63%"><label>
                  <input type="text" name="login" id="textfield" class="textbox" />
                </label></td>
            </tr>
            <tr>
              <td height="25">Password</td>
              <td><label>
                  <input type="password" name="password" id="textfield1" class="textbox" />
                </label></td>
            </tr>
            <tr>
              <td height="25">Confirm Password</td>
              <td><label>
                  <input type="password" name="confirmPassword" id="textfield2" class="textbox" />
                </label></td>
            </tr>
            <tr>
              <td height="25">E-mail</td>
              <td><label>
                  <input type="text" name="email" id="textfield3" class="textbox" />
                </label></td>
            </tr>
            <tr>
              <td>
<input type="hidden" name="terms" value="0"><input type="checkbox" name="terms" id="terms" value="1" checked="yes" style="" class="text">I agree to <a href="/content/terms/trackerId/<?=$trackerId?>/affid/<?=$affId?>/">Terms &amp; Conditions</a>
</td>
              <td><table width="100%" border="0">
                  <tr>
                    <td align="right"><label>
                        <input type="submit" name="button" id="button" value="Register and Play" class="btn" />
                    </label></td>
                    <!--<td align="right" class="login">Already Registered? <br />
                      <a href="#" >Login Now</a></td>-->
                  </tr>
                </table></td>
            </tr>
          </table>
        </div>
        <div class="marginpad" style="margin-top:25px">
          <div class="box4" >
            <h1>Supported Payment Options</h1>
            <div class="box2">
              <ul>
                <li>Internet Banking (All major banks)</li>
                <li>Cash on Delivery</li>
                <li>Credit cards & Debit cards (Coming soon)</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="marginpad" style="margin-top:45px">
          <div class="taashfloatr">
            <div class="taashtimeicon"><img src="images/lock.png" width="74" height="86" /></div>
          </div>
          <div class="box4" >
            <h1>Safe & Secure</h1>
            <div class="box2">
              <ul>
                <li>SSL Certified</li>
                <li>Fraud Prevention Mechanisms</li>
                <li>100% secure bank transactions</li>
              </ul>
            </div>
          </div>
        </div>
      </div><!--div id="taashfooterin" ><div class="supportedby">Supported by:</div>
      <img src="images/sbi.png" width="66" height="25" border="0"  alt="SBI" title="SBI"/><img src="images/axis bank-01.png" width="103" height="33" border="0" hspace="5" alt="AxisBank" title="AxisBank" /><img src="images/icici-01.png" width="103" height="33" border="0" alt="icici"  title="icici"/><img src="images/hdfc bank-01.png" width="142" height="33"  border="0" alt="hdfc" title="hdfc"/><img src="images/Ghar play-01.png" width="68" height="27"  border="0" alt="ghar" title="ghar"/><img src="images/tech process-01.png" width="73" height="27"  border="0" alt="techprocess" title="techprocess"/><img src="images/18+.png" width="39" height="39" border="0"  alt="18+" title="18+"/>
      
    </div>
    </div-->
<div id="taashfooterin" >

      <div class="supportedby">Supported by:</div> <div class="ttcards" > <img src="images/ttcards.png" width="175" height="34" /></div> <div class="ttbanks" ><img src="images/sbi.png" width="66" height="25" border="0"  alt="SBI" title="SBI"/><img src="images/axis bank-01.png" width="103" height="33" border="0" hspace="5" alt="AxisBank" title="AxisBank" /><img src="images/icici-01.png" width="103" height="33" border="0" alt="icici"  title="icici"/><img src="images/hdfc bank-01.png" width="142" height="33"  border="0" alt="hdfc" title="hdfc"/><img src="images/18+.png" /></div></div>

    </div>
    <!--div id="taashfooter">
      <div class="startssl"><img src="images/startssl.png" width="97" height="97" border="0"  alt="SSL" title="SSL"/></div></div>
  </div-->
</div>
<script type="text/javascript">
                        var pkBaseURL = "http://taashtime.com/piwik/";
                        document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
                        </script><script type="text/javascript">
                        try {
                        var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", <?=$idSite?>);
                                                piwikTracker.trackPageView();

                                                
                        piwikTracker.enableLinkTracking();
                        } catch( err ) {}
                        </script><noscript><p><img src="http://taashtime.com/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>


</body>
</html>
