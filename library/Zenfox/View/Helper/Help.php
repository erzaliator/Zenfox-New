<?php
class Zenfox_View_Helper_Help extends Zend_View_Helper_Abstract
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
	
	public function help($page = false)
	{
		$authSession = new Zend_Auth_Storage_Session();
		$storedData = $authSession->read();
		
		$siteCode = Zend_Registry::getInstance()->get('siteCode');
		$fileName = APPLICATION_PATH . "/site_configs/" . $siteCode . "/help.json";
		$fh = fopen($fileName, "r");
		$helpJson = fread($fh, filesize(($fileName)));
		fclose($fh);
		$helpArray = Zend_Json::decode($helpJson);
		
		//Zenfox_Debug::dump($helpArray, 'help');
		
		$frontend = Zend_Controller_Front::getInstance();
		$controller = $frontend->getRequest()->getControllerName();
		$action = $frontend->getRequest()->getActionName();
		
		$currentPage = $controller . '-' . $action;
		if($currentPage == 'index-index')
		{
			?>
			<div class="home-content left">
				
			<div id="help-top">Download Taashtime</div>
			<div id="help-back">
			<div id="flashcontent" style="width:215px; height:180px;">
			<strong>Please upgrade your Flash Player</strong>
			This is the content that would be shown if the user does not have Flash Player 6.0.65 or higher installed.
			</div>
			<script type="text/javascript" src="/games/air/badge/swfobject.js"></script>
			<script type="text/javascript">
			// <![CDATA[
				
			// version 9.0.115 or greater is required for launching AIR apps.
			var so = new SWFObject("/games/air/badge/AIRInstallBadge.swf", "Badge", "215", "180", "9.0.115", "#FFFFFF");
			so.useExpressInstall('/games/air/badge/expressinstall.swf');
				
			// these parameters are required for badge install:
			so.addVariable("airversion", "1.0"); // version of AIR runtime required
			so.addVariable("appname", "Taashtime"); // application name to display to the user
			so.addVariable("appurl", "http://taashtime.tld/games/air/application/TaashTime.air"); // absolute URL (beginning with http or https) of the application ".air" file
				
			// these parameters are required to support launching apps from the badge (but optional for install):
			so.addVariable("appid", "TaashTime"); // the qualified application ID (ex. com.gskinner.air.MyApplication)
			so.addVariable("pubid", ""); // publisher id
				
			// this parameter is required in addition to the above to support upgrading from the badge:
			so.addVariable("appversion", "1.0.2"); // AIR application version
				
			// these parameters are optional:
			so.addVariable("image", "/games/air/badge/demoImage.jpg"); // URL for an image (JPG, PNG, GIF) or SWF to display in the badge (205px wide, 170px high)
			so.addVariable("appinstallarg", "installed from web"); // passed to the application when it is installed from the badge
			so.addVariable("applauncharg", "launched from web"); // passed to the application when it is launched from the badge
			so.addVariable("helpurl", "http://taashtime.tld/help/howtoplay"); // optional url to a page containing additional help, displayed in the badge's help screen
			so.addVariable("hidehelp", "false"); // hides the help icon if "true"
			so.addVariable("skiptransition", "false"); // skips the initial transition if "true"
			so.addVariable("titlecolor", "#00AAFF"); // changes the color of titles
			so.addVariable("buttonlabelcolor", "#00AAFF"); // changes the color of the button label
			so.addVariable("appnamecolor", "#00AAFF"); // changes the color of the application name if the image is not specified or loaded
				
			// these parameters allow you to override the default text in the badge:
			// supported strings: str_error, str_err_params, str_err_airunavailable, str_err_airswf, str_loading, str_install, str_launch, str_upgrade, str_close, str_launching, str_launchingtext, str_installing, str_installingtext, str_tryagain, str_beta3, str_beta3text, str_help, str_helptext
			so.addVariable("str_err_airswf", "<u>Running locally?</u><br/><br/>The AIR proxy swf won't load properly when this demo is run from the local file system."); // overrides the error text when the AIR proxy swf fails to load
				
			so.write("flashcontent");
				
			// ]]>
			</script>
			</div>
			<div id="help-bottom"></div>
			</div>
			
		<?php 
		}
		foreach($helpArray as $pageAddress => $help)
		{
			if($page)
			{
				if($currentPage == $pageAddress)
				{
					?>
					<div class="home-content left">
												
					<?php
					if($storedData && ($pageAddress != 'index-index'))
					{
						?>
						<div id="help-top">TAASH Game Platform</div>
						<div id="help-back">
						<?php
						foreach($help as $content)
						{
							$totalHelpElements = count($content);
							foreach($content as $index => $data)
							{
								if($index == "que")
								{
									?>
														<p><strong><?php echo $data; ?></strong></p>
														<?php 
													}
													else
													{
														?>
														<p class="bottom"><?php echo $data;?></p>
														<?php
													}
													if(($totalHelpElements > 0) && !($index == "que"))
													{
														$totalHelpElements--;
														?>
														<br>
														<?php 
													}
												}
											}
											?>
											</div>
											<div id="help-bottom"></div>
											<?php 
					}
					else
					{
						$webConfig = Zend_Registry::getInstance()->isRegistered('webConfig')?Zend_Registry::getInstance()->get('webConfig'):'';
						$imagesDir = $webConfig['cssDir']?$webConfig['cssDir']:'null';
						$cdnImageServer = $webConfig['cdnImageServer'];
						?>
						<img src="<?=$cdnImageServer ?>/css/rummy.tld/images/main_page.png" width="265" height="430" border="0" usemap="#map" />
						
						<map name="map">
						
						<area shape="rect" coords="37,307,238,329"  href="/banking/deposit" />
						</map>
						<?php
					}
					
					?>
						
						</div>
					<?php
				}
			}
			else
			{
				foreach($help as $content)
				{
					foreach($content as $index => $data)
					{
						if($index == "que")
						{
							?>
							<p><strong><?php echo $data; ?></strong></p>
							<?php 
						}
						else
						{
							?>
							<p class="bottom"><?php echo $data;?></p>
							<?php
						}
					}
				}
			}
		}
	} 
}