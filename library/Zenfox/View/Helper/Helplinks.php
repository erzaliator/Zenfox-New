<?php
class Zenfox_View_Helper_Helplinks extends Zend_View_Helper_Abstract
{
	public $view;
	
	public function setView(Zend_View_Interface $view)
	{
		$this->view = $view;
	}
	
	public function helplinks($pages, $helpContent, $helpTableId = NULL)
	{
		?>  
		<div id = "help_links">
		<table cellpadding="0" cellspacing="0" width="100%" border="0" id="page-layout">
      <tr>
		<td valign="top" class="left-nav">
		<ul id="navigation">
		<?php
		$this->_getLink($pages, false);
		?>
		</ul>
		</td>
		<td width="8px">&nbsp;</td>
          <td class="body-content" valign="top">
        <?=$helpContent; ?>
        </td>
        </tr>
        </table>
        </div>
		<?php
	}
	
	protected function _getLink($data, $helpTableId)
	{
		$help = new Help();
		foreach($data as $linkData)
		{
			if($helpTableId)
			{
				?>
				<ul>
				<?php
			}
			?>
			<li>
			<a href = "<?=$linkData['url'] ?>"><?=$linkData['title'] ?></a>
			<?php 
			if($linkData['page'])
			{
				$this->_getLink($linkData['page'], true);
				?>
				</ul>
				<?php
			}
			?>
			</li>
			<?php
			$helpTableId = false;
		}
	}
}