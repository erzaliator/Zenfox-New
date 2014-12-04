<?php
// -- Piwik Tracking API init --
//require_once PIWIK_INCLUDE_PATH . '/PiwikTracker.php';
//PiwikTracker::$URL = '/piwik/';
//echo PIWIK_INCLUDE_PATH;
class Zenfox_View_Helper_Piwiktracker extends Zend_View_Helper_Abstract
{
	public $view;
	
	public function setView(Zend_View_Interface $view)
	{
		$this->view = $view;
	}
	
	public function piwiktracker($idSite = NULL)
	{
		$frontController = Zend_Controller_Front::getInstance();
		$trackerId = $frontController->getRequest()->getParam('trackerId');
		$session = new Zenfox_Auth_Storage_Session();
		$storedData = $session->read();
		if(!$trackerId)
		{
			$trackerId = $storedData['authDetails'][0]['tracker_id'];
		}
		$goals = new Piwik_Goal_Controller();
		$user = new Piwik_User_Controller();
		
		if($trackerId)
		{
			$frontendId = Zend_Registry::get('frontendId');
			$varName = 'FRONTEND_' . $frontendId . '_IDSITE';
			$trackerDetail = new TrackerDetail();
			$idSite = $trackerDetail->getVariableValue($trackerId, $varName);
			if(!$idSite)
			{
				$varName = 'FRONTEND_' . $frontendId . '_URL';
				$url = $trackerDetail->getVariableValue($trackerId, $varName);
				$siteManager = new Piwik_Site_Controller();
				$idSite = $siteManager->getSitesIdFromSiteUrl($url);
				
				if(!$idSite)
				{
					$manager = new Piwik_Site_Controller();
					$frontend = new Frontend();
					$siteName = 'Tracker-' . $trackerId . '-F' . $frontendId;
					$frontendData = $frontend->getFrontendById($frontendId);
					$url = $frontendData[0]['url'] . '/trackerId/' . $trackerId;
					$idSite = $manager->addSite($siteName, $url, 'Asia/Kolkata');
					$affiliateTracker = new AffiliateTracker();
					$trackerData = $affiliateTracker->getAffiliateTracker($trackerId);
					if($trackerData)
					{
						$affiliateId = $trackerData['affiliate_id'];
						$affiliate = new Affiliate();
						$login = $affiliate->getAliasFromAffiliateId($affiliateId);
					}
					if($login)
					{
						$user->setUserAccess($login, 'admin', $idSite);
						$goals->addGoal($idSite, 'Deposits', 'url', 'banking/index', 'contains');
						$goals->addGoal($idSite, 'Registrations', 'url', 'auth/confirm', 'contains');
						$trackerDetail = new TrackerDetail();
				        $varName = 'FRONTEND_' . $frontendId . '_URL';
				        $varValue = $url;
				        $trackerDetail->addTrackerDetails($trackerId, $varName, $varValue);
				        $trackerDetail = new TrackerDetail();
				        $varName = 'FRONTEND_' . $frontendId . '_IDSITE';
				        $varValue = $idSite;
				        $trackerDetail->addTrackerDetails($trackerId, $varName, $varValue);
					}
					//$goals = new Piwik_Goal_Controller();
				}
			}
			$aff_id = $frontController->getRequest()->getParam('aff_id');
			$playerId = $storedData['id'];
			$accountVariable = new AccountVariable();
			if(!$aff_id)
			{
				$affSession = new Zend_Session_Namespace('aff_id');
				$aff_id = $affSession->value;
				if($playerId && !$aff_id)
				{
					$varName = 'CV_AFF-ID';
					$varData = $accountVariable->getData($playerId, $varName);
					$aff_id = $varData['varValue'];
				}
			}
			if($aff_id)
			{
				if($playerId)
				{
					$varName = 'CV_AFF-ID';
					$varData = $accountVariable->getData($playerId, $varName);
					if(!$varData)
					{
						$data['playerId'] = $playerId;
						$data['variableName'] = $varName;
						$data['variableValue'] = $aff_id;
						$accountVariable->insert($data);
					}
				}
				$affiliateTracker = new AffiliateTracker();
				$trackerData = $affiliateTracker->getAffiliateTracker($trackerId);
				if($trackerData)
				{
					$affiliateId = $trackerData['affiliate_id'];
					$affiliate = new Affiliate();
					$login = $affiliate->getAliasFromAffiliateId($affiliateId);
				}
				$user->setUserAccess($login, 'admin', $idSite);
				$goalId = $goals->getGoal($idSite, 'aff_id', 'contains');
				if(!$goalId)
				{
					$goals->addGoal($idSite, $trackerId . '-AFF_ID-'. $aff_id, 'url', 'aff_id', 'contains');
				}
				$goalId = $goals->getGoal($idSite, $aff_id . '/banking/index', 'contains');
				if(!$goalId)
				{
					$goals->addGoal($idSite, $trackerId . '-AFF_ID-'. $aff_id . '-Depositor', 'url', $aff_id . '/banking/index', 'contains');
				}
				$goalId = $goals->getGoal($idSite, $aff_id . '/auth/confirm', 'contains');
				if(!$goalId)
				{
					$goals->addGoal($idSite, $trackerId . '-AFF_ID-'. $aff_id . '-Registration', 'url', $aff_id . '/auth/confirm', 'contains');
				}
			}
		}
		?>
		<!-- Server Code -->
		<!-- Piwik
			<script type="text/javascript">
			var pkBaseURL = (("https:" == document.location.protocol) ? "https://piwik.playdorm.com/" : "http://piwik.playdorm.com/");
			document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
			</script><script type="text/javascript">
			try {
			var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", <?//=$idSite?>);
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
			var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", <?//=$idSite?>);
			piwikTracker.trackPageView();
			piwikTracker.enableLinkTracking();
			} catch( err ) {}
			</script><noscript><p><img src="/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>
			 End Piwik Tag -->
		<?php
		// Example 1: Tracks a pageview for Website id = {$IDSITE}
		$controller = $frontController->getRequest()->getControllerName();
		$action = $frontController->getRequest()->getActionName();
		$pattern = $controller . '/' . $action;
		if((($controller == 'banking' && $action == 'deposit')) || (($controller == 'transaction') && ($action == 'index')) && !$idSite)
        {
       		$idSite = 1;
        }
		if($aff_id)
       	{
       		$pattern = $aff_id . '/' . $pattern;
       	}
		$goalId = $goals->getGoal($idSite, $pattern, 'contains');
		$goalSession = new Zend_Session_Namespace('goalSession');
		if($goalId)
		{
			if($goalSession->value)
			{
				$this->__addPiwik($idSite, $controller, $action, $aff_id);
				//echo '<img src="'. Piwik_getUrlTrackPageView( $idSite = $idSite, $customTitle = 'This title will appear in the report Actions > Page titles') . '" alt="" />';
			}
			else
			{
				//echo '<img src="" alt="" />';
			}
		}
		else
		{
			$this->__addPiwik($idSite, $controller, $action, $aff_id);
			//echo '<img src="'. Piwik_getUrlTrackPageView( $idSite = $idSite, $customTitle = 'This title will appear in the report Actions > Page titles') . '" alt="" />';
		}
		$goalSession->unsetAll();
		// Example 2: Triggers a Goal conversion for Website id = {$IDSITE} and Goal id = 2
		// $customRevenue is optional and is set to the amount generated by the current transaction (in online shops for example)
		

	}
	
	private function __addPiwik($idSite, $controller, $action, $aff_id = NULL)
	{
		/*$frontController = Zend_Controller_Front::getInstance();
		$baseUrl = $frontController->getRequest()->getBasePath();*/

		$siteCode = Zend_Registry::getInstance()->get('siteCode');
		if(file_exists ( APPLICATION_PATH . '/site_configs/' . $siteCode . '/zenfoxAnalytics.json' ))
		{
			$siteConfigFile = APPLICATION_PATH . '/site_configs/' . $siteCode . '/zenfoxAnalytics.json';
			$fh = fopen($siteConfigFile, 'r');
			$siteJson = fread($fh, filesize($siteConfigFile));
			fclose($fh);
			$siteConfig = Zend_Json::decode($siteJson);
			$defaultIdSite = $siteConfig['idSite'];
		}
		$url = "https://" . $_SERVER['HTTP_HOST'];
		?>
			<script type="text/javascript">
			var pkBaseURL = "<?=$url?>/piwik/";
			document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
			</script><script type="text/javascript">
			try {
			
			var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
    piwikTracker.trackPageView();
    var piwik2 = Piwik.getTracker(pkBaseURL + "piwik.php", 2);
    piwik2.trackPageView();
			<?php
				if($aff_id)
				{ 
					?>
						piwikTracker.setCustomVariable(
							  1, // Index, the number from 1 to 5 where this Custom Variable name is stored
							  "AFF-ID-<?=$aff_id?>", // Name, the name of the variable, for example: Gender, VisitorType
							  "1", // Value, for example: "Male", "Female" or "new", "engaged", "customer"
							  "page" // Scope of the Custom Variable, "visit" means the Custom Variable applies to the current visit
						);
					<?php
				}
			?>
			piwikTracker.trackPageView();
			piwikTracker.enableLinkTracking();
			} catch( err ) {}
			</script><noscript><p><img src="<?=$url?>/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>
<script type="text/javascript">
			var pkBaseURL = "<?=$url?>/piwik/";
			document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
			</script><script type="text/javascript">
			try {
			var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", <?=$defaultIdSite?>);
			<?php
				if($aff_id)
				{
					?>
						piwikTracker.setCustomVariable(
							1, // Index, the number from 1 to 5 where this Custom Variable name is stored
							"AFF-ID-<?=$aff_id?>", // Name, the name of the variable, for example: Gender, VisitorType
							"1", // Value, for example: "Male", "Female" or "new", "engaged", "customer"
							"page" // Scope of the Custom Variable, "visit" means the Custom Variable applies to the current visit
						);
					<?php
				}
				?>
			piwikTracker.trackPageView();
			piwikTracker.enableLinkTracking();
			} catch( err ) {}
			</script><noscript><p><img src="<?=$url?>/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>
			
		<?php
	}
}