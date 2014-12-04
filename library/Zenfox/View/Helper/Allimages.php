<?php
class Zenfox_View_Helper_Allimages extends Zend_View_Helper_Abstract
{
	public $view;
	
	public function setView(Zend_View_Interface $view)
	{
		$this->view = $view;
	}
	
	public function allimages($pageAddress, $isplayerLoggedIn = false)
	{
		$webConfig = Zend_Registry::getInstance()->isRegistered('webConfig')?Zend_Registry::getInstance()->get('webConfig'):'';
		$imagesDir = $webConfig['cssDir']?$webConfig['cssDir']:'null';
		$cdnImageServer = $webConfig['cdnImageServer'];
		
		switch($pageAddress)
		{
			case 'index':
				$this->_beforeLogin($cdnImageServer);
				break;
			case 'index-index':
				$this->_afterLogin($cdnImageServer);
				break;
		}
	}
	
	private function _afterLogin($cdnImageServer)
	{
		?>
		<img src="<?=$cdnImageServer ?>/css/rummy.tld/images/web-banner-02.jpg" alt="Play Now!"  border="0" usemap="#main-banner" />
		<map name="main-banner">
			<area shape="rect" coords="79,296,240,340" href="/tournament/list" />
			<area shape="rect" coords="392,198,553,239" href="/game/quickjoin/amountType/FREE" />
			<area shape="rect" coords="393,296,553,338" href="/game" />
			<area shape="rect" coords="725,296,882,339" href="/index/invite" />
			<area shape="rect" coords="867,356,940,369" href="/promotions/referfriend" />
			<area shape="rect" coords="519,356,624,368" href="/banking/deposit" />
		</map>
		<?php
	}
	
	private function _beforeLogin($cdnImageServer)
	{
		?>
		<div id="home-banner-left" class="left">
			<img src="<?=$cdnImageServer ?>/css/rummy.tld/images/main-page.jpg" width="683" height="373" border="0" usemap="#play" />
			<map name="play">
				<area shape="rect" coords="174,313,509,338"  href="/index/winner" />
				<area shape="rect" coords="263,157,421,256"  href="/banking/funcoins" />
				<area shape="rect" coords="10,308,21,364"  href="/content/terms" />
			</map>
		</div>
		<?php 
	}
}