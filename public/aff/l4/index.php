<?php

$con = mysql_connect("zenfox-master","zenfox-web","e6e3be2d833cdf5d9d4c7bc2f85cd098");
$hostAddress = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$referrerAddress = $_SERVER['HTTP_REFERER'];
$clientIp = $_SERVER['REMOTE_ADDR'];
mysql_select_db("zenfox", $con);
$sql = "INSERT INTO url_records (referrer_url, url, client_ip, datetime) VALUES ('$referrerAddress', '$hostAddress', '$clientIp', NOW())";
//mysql_query($sql,$con);
mysql_close($con);

setcookie("landingPage", "LANDINGPAGE_4", time() + (86400 * 30), "/", '.'.$_SERVER['HTTP_HOST']);

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
<title>Taashtime Online Rummy Registration</title>
<style type="text/css">
<!--
body {	margin: 0px;}
.ttld1m{ width:800px; height:600px; margin:10px auto;background:#e2e2e2; background-image:url(/css/images/ttld1mbg.png ); background-position:10px 19px ; background-repeat:no-repeat ; font-family:Verdana, Geneva, sans-serif; font-size:14px }
.ttld1top{ height:545px; clear:both}
.ttld1left{ float:left; margin-left:250px; width:282px; }
.ttld1right{ float:left; margin-left:20px; width:240px; }
.ttld1logo{ padding:10px 0px 10px 0px; text-align:center}
.ttld1logocap{ padding:0px; text-align:center; font-family:Verdana, Geneva, sans-serif; font-size:16px; font-smooth:always; }
.ttld1logocap span{ color:#7c0101}
.ttld1whyplay{ margin:27px 0px 0px 0px; -webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius: 10px; border:#1c1c1c solid 3px; padding:10PX }
.ttld1whyplayhed{ font-size:17px;  font-smooth:always; font-family:Copperplate Gothic Light, Verdana, Geneva, sans-serif; color:#15326b; text-align:center ; font-weight:bold;  }
.ttld1playrummy{ margin:10px 0px 0px 0px; }
.ttld1playrummy ul{ margin:0px 0px 0px 20px; padding:0px; }
.ttld1playrummy ul li{ margin:0px; padding:10px 0px 10px 0px; position:relative ; color:#0c0c0c; font-size:16px; font-smooth:always;}
.ttld1playrummy ul li span{ position:absolute; right:0px; top:0px; padding:-10px 0px 10px 0px  }
.ttld1playrummy ul li p{ padding-left:35px}
.ttld1playimg{ background:url(/css/images/ttld1playimg.png ) no-repeat center 10px; height:127px;}
.ttld1joinnow{ margin:0px; -webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius: 10px; border:#1c1c1c solid 3px; padding:10PX ; font-size:12px}
.ttld1joinnowhed{ font-family:Verdana, Geneva, sans-serif; font-weight:bold; font-size:16px; text-align:center  }
.ttld1joinnow ul{ margin:0px; padding:0px}
.ttld1joinnow ul li{ margin:0px; padding:0px; list-style:none; line-height:22px}
.ttld1joinnow input{ border:#1f4588 solid 1px; width:90%}
.ttld1joinnowbtn{ background:url(/css/images/ttld1btnreg.gif) repeat-x; padding:3px 10px 5px 10px; border:#7da252 solid 1px; height:25px; -webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius: 10px; font-weight:bold; cursor:pointer; }
.ttld1terms{ font-size:10px; padding:5px 0px 5px 0px}
.ttld1speciality{  font-size:18px;  font-smooth:always; font-family:Copperplate Gothic Light, Verdana, Geneva, sans-serif; color:#15326b; text-align:center; margin:10px 0px 10px 0px; font-weight:bold }
.ttld1specialitybot{  margin:0px; -webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius: 10px; border:#1c1c1c solid 3px; padding:10PX ; font-size:12px }
.ttld1specialitybot ul{ margin:0px 0px 0px 10px; padding:0px; }
.ttld1specialitybot ul li{ margin:0px; padding:0px; line-height:18px; }
.ttld1bot{ background:#b5b5b5; height:50px; clear:both; padding:5px 0px 0px 0px}
.ttld1support{ float:left; width:86px; font-size:11px; padding:20px 0px 0px 2px}
.ttld1supportimg{ float:left; }
-->

</style>
</head>
<body>
<div class="ttld1m">
  <div class="ttld1top">
    <div class="ttld1left">
      <div class="ttld1logo"><img src="/css/images/ttld1logo.png" width="256" height="62" /></div>
      <div class="ttld1logocap">Indias's Most Trusted <span>Rummy</span></div>
      <div class="ttld1whyplay">
        <div class="ttld1whyplayhed">Why Play at TAASHTIME?</div>
        <div class="ttld1playrummy">
          <ul>
            <li style="height:55px">Play Rummy <br />
              win prizes <span ><img src="/css/images/ttld1winprizes.png" width="80" height="54"  /></span></li>
            <li style="height:70px">100% Legal <br />
              to
   play Rummy <span><img src="/css/images/ttld1100legal.png" width="73" height="74" /></span></li>
            <li style="height:55px">30% Bonus <br />
              with
  every purchase <span><img src="/css/images/ttld130bonus.png" width="69" height="47" /></span></li>
            <li style="height:92px">Completely<br />

  Safe & Secure
              <p><img src="/css/images/ttld1100safe.png" width="113" height="45" /></p>
              <span><img src="/css/images/ttld1secure.png" width="81" height="104" /></span></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="ttld1right">
      <div class="ttld1playimg"></div>
      <div class="ttld1joinnow">
        <div class="ttld1joinnowhed">Join Now</div>
        <div>
        <form enctype="application/x-www-form-urlencoded" action="http://taashtime.com/auth/signup/trackerId/<?=$trackerId ?>/affid/<?=$affId ?>" method="post">
          <ul>
            <li>
              <label >Username </label>
              <br />
              <input type="text"  value="" id="login" name="login">
            </li>
            <li>
              <label  for="password">Password</label>
              <br />
              <input type="password"  value="" id="password" name="password">
            </li>
            <li>
              <label for="confirmPassword">Confirm Password </label>
              <input type="password" value="" id="confirmPassword" name="confirmPassword">
            </li>
            <li>
              <label class="required" for="email">E - mail</label>
              <br />
              <input type="text"  value="" id="email" name="email">
            </li>
            <li>
              <input type="checkbox"   name="terms" style="width:inherit" >
              <span class="ttld1terms">I agree to <a href="/content/terms/trackerId/<?=$trackerId?>/affid/<?=$affId?>">Terms &amp; Conditions</a></span></li>
            <br />
            <li style="text-align:right">
              <input type="submit" value="Register" id="submit" name="submit" class="ttld1joinnowbtn" style="width:inherit">
            </li>
          </ul>
          </form>
        </div>
      </div>
      <div class="ttld1speciality">Taashtime Specialty</div>
      <div class="ttld1specialitybot">
        <ul>
          <li>Innovative game play</li>
          <li> Friendliest customer support</li>
          <li> Rewards with every game</li>
        </ul>
      </div>
    </div>
  </div>
  <div class="ttld1bot">
    <div class="ttld1support">Supported by :</div>
    <div class="ttld1supportimg"><img src="/css/images/ttld1support.png" width="710" height="44" /></div>
  </div>
</div>
</body>
</html>
