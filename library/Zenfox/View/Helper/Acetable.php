<?php
class Zenfox_View_Helper_Acetable extends Zend_View_Helper_Abstract
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
	
	public function acetable($tableContents, $linkField = NULL, $linkArray = array())
	{
		$temp = 0;
		
		foreach($tableContents as $data)
		{
			if(!$temp)
			{
				?>
				<table class = "complete-head" width="100%" border="0" cellspacing="0" cellpadding="0">
					<tbody>
						<tr>
							<?php 
							foreach($data as $field => $value)
							{
								$fieldArray[] = $field;
								?>
								<td><?=$field ?></td>
								<?php
							}
							?>
						</tr>
					</tbody>
				</table>
				<?php
				break;
			}
		}
		?>
		<table class = "complete-body" width="100%" border="0" cellspacing="0" cellpadding="0">
				<?php
				foreach($tableContents as $index => $data)
				{					
					?>
					<tr>
					<?php
					foreach($data as $field => $value)
					{
						?>
						<td>
						<?php
						$flag = 0;
						if($linkField && $linkArray)
						{
							if(in_array($field,$linkField) == true)
							{
								if($value)
								{
									?>
									<a href = "<?php echo $this->view->url($linkArray[$value]);?>">
									<?php
									$flag = 1;
								}
							}
						}							
						if(!$value && $linkField && in_array($field, $linkField))
						{
							echo $field;
						}
						else
						{
							echo $value;
						}
						if($flag)
						{
							?>
							</a>
							<?php
						}
						?>
						</td>
						<?php
					}
					?>
					</tr>
					<?php
				}
				?>
		</table>
		<?php
	}
}
