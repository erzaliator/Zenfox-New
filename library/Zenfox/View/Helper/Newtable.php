<?php
class Zenfox_View_Helper_Newtable extends Zend_View_Helper_Abstract
{
	public $view;
	
	public function setView(Zend_View_Interface $view) 
	{ 
	    $this->view = $view;
	} 
	
	public function newtable($tableContents, $fieldHead, array $linkField = NULL, array $linkArray = NULL)
	{
		$temp = 0;
		?>
		<table cellpadding="0" cellspacing="0" border="1" width="100%" class="paly-report-forms">
		<?php
		$counter = 0;
		//print_r($tableContents);print_r($linkField);exit();
		
		foreach($tableContents as $data)
		{
		
			if(!$temp)
			{
				?>
				<tr class="report-head">
				<?php
				foreach($fieldHead as $field )
				{
				?>
					<td><div><?= $field;?></div></td>
				<?php
				}
				?>
				</tr>
				<?php				
		
			}
			$temp++;
			if(($counter%2) == 0)
			{
				?>	
				<tr class="odd-style1">
				<?php
			}
			else
			{
				?>
				<tr class="even-style1">
				<?php
			}
			$counter++;
			//print_r($data); exit();
			foreach($data as $field => $value)
			{
				?>
				<td><div>
				<?php 
				$flag=0;
				
				if($linkField && $linkArray)
				{
					if(in_array($field,$linkField) == true)
					{
						//echo $field;
						?>
						<a href = "<?php echo $this->view->url($linkArray[$field]);?>">
						<?php
						$flag = 1;
					}
				}
				?>
				<?php echo $value;
				if($flag == 1)
				{
					echo '</a>';
				}?>
				</div></td>
				<?php
			}
			?>
			</tr>

			<?php
			//exit();	
		
		}
		?>
		</table>
		<?php 
		
	}
	
}