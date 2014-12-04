<?php
class Zenfox_View_Helper_Checkbox extends Zend_View_Helper_Abstract
{
	public $view;
	
	public function setView(Zend_View_Interface $view) 
	{ 
	    $this->view = $view;
	} 
	
	public function checkbox($tableContents, $fieldHead ,$checkTitle, $checkField = NULL, $linkField = NULL, $linkArray = NULL,$controller, $action)
	{
		$temp = 0;
		?>
		<table cellpadding="0" cellspacing="0" border="1" width="100%" class="paly-report-forms">
		<form action=<?php echo $this->view->url(array('controller' => $controller,'action' =>$action));?> method="post">
		<?php
		//$form = $this->view->form();
		$counter = 0;
		
		foreach($tableContents as $data)
		{
			
			if(!$temp)
			{
				?>
				<tr class="report-head">
				
				<?php
				foreach($fieldHead as $field)
				{
				?>
					<td><div><?= $field;?></div></td>
				<?php
				}
				?>
				<?php if($checkField && $checkTitle)
				{?>
					<td><div><?= $checkTitle;?></div></td>
				<?php
				 }?>
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
			foreach($data as $field => $value)
			{
				?>
				<td><div>
				<?php
				
				if($linkField && $linkArray)
				{
					//if($linkField == $field)
						//print_r($linkField);
					if(in_array($field,$linkField) == true)
					{
						?>
						<a href = "<?php echo $this->view->url($linkArray[$field]);?>">
						<?php
					}
				}
				
				if($field == $checkField)
				{
					$checkValue = $value;
				}
				
				
				
				?>
				<?= $value;?></div></td>
				<?php
			}
			
			if($checkField)
			{
			?>	
			<td><div>		
			<?php
				
			 	//echo '<input type="checkbox" name='.$checkField.'[] '.'value='.$checkValue.'>';
			 	echo $this->view->formCheckbox($checkField,$checkValue,array('checked' => false));		 		
			        											   											
			?>
			</div></td>
			
			<?php 
			}?>
			
			</tr>

			<?php
				
	
		}
		?>
		<input type="submit" value="<?php echo $checkTitle?>"></input>
		</form>
		</table>
		<?php 
		//exit();
	}
	


/*public function checkbox($tableContents, $checkTitle, $checkField = NULL,  $linkField = NULL, $linkArray = NULL,$controller, $action)
	{
		$temp = 0;
		?>
		<table cellpadding="0" cellspacing="0" border="1" width="100%" class="paly-report-forms">
		<form action=<?php echo $this->view->url(array('controller' => $controller,'action' =>$action));?> method="get">
		<?php
		$counter = 0;
		
		foreach($tableContents as $data)
		{
			
			if(!$temp)
			{
				?>
				<tr class="report-head">
				
				<?php
				foreach($data as $field => $value)
				{
				?>
					<td><div><?= $field;?></div></td>
				<?php
				}
				?>
				<?php if($checkField && $checkTitle)
				{?>
					<td><div><?= $checkTitle;?></div></td>
				<?php
				 }?>
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
			foreach($data as $field => $value)
			{
				?>
				<td><div>
				<?php 
				
				if($linkField && $linkArray)
				{
					if($linkField == $field)
					{
						?>
						<a href = "<?php echo $this->view->url($linkArray[$value]);?>">
						<?php
					}
				}
				
				if($field == $checkField)
				{
					$checkValue = $value;
				}
				
				
				
				?>
				<?= $value;?></div></td>
				<?php
			}
			
			if($checkField)
			{
			?>	
			<td><div>		
			<?php
				
			 	echo '<input type="checkbox" name='.$checkField.'value='.$checkValue.'>';
			?>
			</div></td>
			
			<?php 
			}?>
			
			</tr>

			<?php
				
	
		}
		?>
		<input type="submit" value="<?php echo $checkTitle?>"></input>
		</form>
		</table>
		<?php 
		
	}*/
}
		
	
