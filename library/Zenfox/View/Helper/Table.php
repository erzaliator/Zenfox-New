<?php
class Zenfox_View_Helper_Table extends Zend_View_Helper_Abstract
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
	public function table($tableContents, $linkField = NULL, $linkArray = NULL, $primaryType = NULL, $commonLinkArr = NULL, $popUp = false)//$tableType = NULL)
	{
		//if($tableType)
		//{
			//if($tableType == "STATIC")
			//{
				
			//}
			/*
			 * if linkField is_array
			 * 	linkArray is Array of Arrays with field_name as the key.
			 * 	Array of Array.primarykey will be the value
			 * 
			 * $linkArray
			 * {
			 * 		"edit":
			 * 				{
			 * 					"$primary_key": "$url",
			 * 					"$primary_key": "$url",
			 * 					"$primary_key": "$url"
			 * 				},
			 *  	"view":
			 * 				{
			 * 					"$primary_key" : "$url",
			 * 					"$primary_key" : "$url",
			 * 					"$primary_key" : "$url"
			 * 				},
			 * }
			 * 
			 * $linkField = Array("view", "edit");
			 */
		//}
		//else
		//{
			
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
					/*prev code
					<tr class="report-head">
					<td><div><?= $field;?></div></td>
					*/
					?>
					<tr>
					<?php
					foreach($data as $field => $value)
					{
						$fieldArray[] = $field;
					?>
						<th><div><?= $field;?></div></th>
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
						if(in_array($field,$linkField) == true)
						{
							if($primaryType)
							{
								?>
								<a href="<?php echo $this->view->url($linkArray[$value.$ind]);?>">
								<?php
								$ind++;
							}
							else
							{
								if($value)
								{
									if($popUp)
									{
										?>
										<a href='#' id='this' onclick='return popitup("<?php echo $this->view->url($linkArray[$value]); ?>", "1")'>
										<?php
									}
									else
									{
										?>
										<a href = "<?php echo $this->view->url($linkArray[$value]);?>">
										<?php
									}
								}
								else
								{
									if($commonLinkArr)
									{
										foreach($commonLinkArr as $cmnLinkField => $fieldValue)
										{
											if(($cmnLinkField == $field) && ($popUp == true))
											{
												?>
												<a href='#' id='this' onclick='return popitup("<?php echo $this->view->url($linkArray[$data[$fieldValue]]); ?>", "1")'>
												<?php
											}
											elseif($cmnLinkField == $field)
											{
												?>
												<a href = "<?php echo $this->view->url($linkArray[$data[$fieldValue]]);?>">
												<?php
											}
										}
									}
								}
							}							
							
							/*
							 * 
							 */
						}
					}
					?>
					<?php
					if(!$value && $commonLinkArr && in_array($field, $linkField))
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
			//return $this->view;
		//}
	}
}
