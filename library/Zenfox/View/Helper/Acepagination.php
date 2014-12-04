<?php
class Zenfox_View_Helper_Acepagination extends Zend_View_Helper_Abstract
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
	
	public function acepagination($pages, $searchFields = array())
	{
		$front = Zend_Controller_Front::getInstance();
		$controller = $front->getRequest()->getControllerName();
		$action = $front->getRequest()->getActionName();
		if($pages['pageCount'])
		{
			?>
			<div class="paginationControl">
				
			<!-- First page link -->
			<?php
			if(isset($pages['previous']))
			{
				$urlString = "";
				$urlString = '/' . $controller . '/' . $action . '/page/' . $pages['first'] . '/items/' . $pages['itemCountPerPage']; 
				if($searchFields)
				{
					foreach($searchFields as $index => $value)
					{
						$urlString = $urlString . '/' . $index . '/' . $value;
					}
				}
				?>
				<a href="<?= $urlString?>">&lt;&lt; First</a>
				<?php
			}
			else
			{
				?>
				<span class="disabled">First</span>
				<?php
			}
			?>	
			
			<!-- Previous page link -->
			<?php
			if(isset($pages['previous']))
			{
				$urlString = "";
				$urlString = '/' . $controller . '/' . $action . '/page/' . $pages['previous'] . '/items/' . $pages['itemCountPerPage']; 
				if($searchFields)
				{
					foreach($searchFields as $index => $value)
					{
						$urlString = $urlString . '/' . $index . '/' . $value;
					}
				}
				?>
				<a href="<?= $urlString?>">&lt; Previous</a>
				<?php
			}
			else
			{
				?>
				<span class="disabled">&lt; Previous</span>
				<?php
			}
			?>
							
			<!-- Numbered page links -->
			<?php
			foreach ($pages['pagesInRange'] as $page)
			{
				if($page != $pages['current'])
				{
					$urlString = "";
					$urlString = '/' . $controller . '/' . $action . '/page/' . $page . '/items/' . $pages['itemCountPerPage']; 
					if($searchFields)
					{
						foreach($searchFields as $index => $value)
						{
							$urlString = $urlString . '/' . $index . '/' . $value;
						}
					}
					?>
					<a href="<?= $urlString ?>"><?= $page; ?></a>
					<?php
				}
				else
				{
					?><span class="current"><?php echo $page;?></span><?php 
				}
			}
			?>
				
			<!-- Next page link -->
			<?php
			if(isset($pages['next']))
			{
				$urlString = "";
				$urlString = '/' . $controller . '/' . $action . '/page/' . $pages['next'] . '/items/' . $pages['itemCountPerPage']; 
				if($searchFields)
				{
					foreach($searchFields as $index => $value)
					{
						$urlString = $urlString . '/' . $index . '/' . $value;
					}
				}
				?>
				<a href="<?= $urlString ?>">Next &gt;</a>
				<?php
			}
			else
			{
				?>
				<span class="disabled">Next &gt;</span>
				<?php
			}
			?>
				
			<!-- Last page link -->
			<?php
			if(isset($pages['next']))
			{
				$urlString = "";
				$urlString = '/' . $controller . '/' . $action . '/page/' . $pages['last'] . '/items/' . $pages['itemCountPerPage']; 
				if($searchFields)
				{
					foreach($searchFields as $index => $value)
					{
						$urlString = $urlString . '/' . $index . '/' . $value;
					}
				}
				?>
				<a href="<?= $urlString ?>">Last &gt;&gt;</a>
				<?php
			}
			else
			{
				?>
				<span class="disabled">Last</span>
				<?php
			}
			?>
			</div>
			<?php
		}
	}
}
