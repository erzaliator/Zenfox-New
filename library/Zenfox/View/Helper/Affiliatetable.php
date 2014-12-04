<?php
class Zenfox_View_Helper_Affiliatetable extends Zend_View_Helper_Abstract
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
	public function affiliatetable($tableContents, $displayContent, $linkField = NULL, $linkArray = NULL)
	{
		/*Zenfox_Debug::dump($tableContents, 'table');
		Zenfox_Debug::dump($displayContent, 'dosplay', true, true);*/
			$temp = 0;
			?>
			<table cellpadding="0" cellspacing="0" border="1" width="100%" class="paly-report-forms">
			<?php
			$counter = 0;
			//echo "<table cellpadding='0' cellspacing='2' border='1'>";
			foreach($tableContents as $data)
			{
				//Zenfox_Debug::dump($data, 'data');
				if(!$temp)
				{
					?>
					<tr class="report-head">
					<?php
					foreach($data as $field => $value)
					{
						$fieldArray[] = $field;
					?>
						<td><div><?= $field;?></div></td>
					<?php
					}
					?>
					</tr>
					<?php				
					/*echo "<tr>";
					foreach($data as $field => $value)
					{
						echo "<td><b>" . $field . "</b></td>";
					}
					echo "</tr>";*/
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
				$index = 0;
				foreach($data as $field => $value)
				{
					?>
					<td><div>
					<?php 
					if($fieldArray[$index] != $field)
					{
						while($fieldArray[$index] != $field)
						{
							echo NULL;
							?></div></td><td><div>
							<?php
							$index++;
						}
					}
					$index++;
					if($linkField && $linkArray)
					{
						if(in_array($field, $linkField) == true)
						{
							?>
								<a href = "<?php echo $this->view->url($linkArray[$value], null, true);?>">
							<?php
						}
					}
					if(!$value)
					{
						echo $field;
					}
					else
					{
						echo $value;
					} 
					?>
					</div></td>
					<?php
				}
				?>
				</tr>
	
				<?php
					
				/*echo "<tr>";
				foreach($data as $field => $value)
				{
					echo "<td>";
					if($linkField && $linkArray)
					{
						if($linkField == $field)
						{
							?>
							<a href = "<?php echo $this->view->url($linkArray[$value]);?>">
							<?php
						}
					}
					echo $value . "</td>";
				}
				echo "</tr>";*/
			}
			?>
			</table>
			<?php 
				$temp = 0;
			?>
			<table cellpadding="0" cellspacing="0" border="1" width="100%" class="paly-report-forms">
			<?php 
			$counter = 0;
			//echo "<table cellpadding='0' cellspacing='2' border='1'>";
			foreach($displayContent as $data)
			{
				//Zenfox_Debug::dump($data, 'data');
				if(!$temp)
				{
					foreach($data as $field => $value)
					{
						?>
					<tr class="odd-style1">
					<?php
						$fieldArray[] = $field;
					?>
						<td><div><?= $field;?></div></td>
						<td><div><?= $value;?></div></td></tr>
					<?php
					}
					?>
					
					<?php				
					/*echo "<tr>";
					foreach($data as $field => $value)
					{
						echo "<td><b>" . $field . "</b></td>";
					}
					echo "</tr>";*/
				}
			}
				?>
			</table>
			<?php 
			//return $this->view;
		//}
	}
}
