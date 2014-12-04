<?php
class Zenfox_View_Helper_Game extends Zend_View_Helper_Abstract
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
	
	public function game($gameDetails, $groupName)
	{
		$i = 0;
		if($groupName == 'slots')
		{
			foreach($gameDetails as $type => $gameType)
	                {
				for($j = 0; $j < 2; $j++)
				{
					$i = 0;
					foreach($gameType as $game)
		                        {
						if($j == 0)
						{
							if($i == 0)
							{
								?>
		                                                <div id="slots-flavor-25-<?=$type?>" style="background: none repeat scroll 0px 0px rgb(205, 34, 43); position: absolute; z-index: 100; margin-top: -25px; margin-left: -20px; font-weight: bold; color: rgb(255, 255, 255);width:65px">
        		                                                <a href="javascript:void(0);" style="text-decoration:none;color:#fff"><p class="left" style="margin:5px;">25 Lines</p></a>
                		                                </div>
								<ul id="<?=strtolower($groupName . '-' . $type . '-25')?>">
	                                	                <?php
							}
							if($game['maxBetlines'] >= 25)
							{
								$runningMachineId = $game['runningMachineId'];
				                                $machineId = $game['machineId'];
				                                $flashFile = $game['machineName'].'.swf';
                                				?>
                                                        	<li>
                                                                	<div>
                                                                        	<a href = "<?php echo $this->view->url(array(
                                                                                        'controller' => 'game',
                                                                                        'action' => 'game',
                                                                                        'flavour' => $game['gameFlavour'],
                                                                                        'machineId' => $game['runningMachineId'],
                                                                                        'amountType' => $game['amountType']
                                                                                        ));
                                                                                ?>" onclick="window.open('<?php echo $this->view->url(array(
                                                                                                'controller' => 'game',
                                                                                                'action' => 'game',
                                                                                                'flavour' => $game['gameFlavour'],
                                                                                                'machineId' => $game['runningMachineId'],
                                                                                                'amountType' => $game['amountType']
                                                                                                ));
                                                                                        ?>','<?=$game['gameFlavour'] . $game['runningMachineId']?>','width=800,height=600,scrollbars=no,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0'); return false">
                                                                	                <img src="/images/thumbnails/<?php echo $game['gameFlavour']."_".$machineId."_s.png"?>"  border="0" />
											<p>
		                                                                                <span class='machine-name'>
                			                                                                <?=$game['machineName']?>
                                        		                                        </span>
                                                        	                        </p>
                                                        	                </a>
                                                                	</div>
                                                        	</li>
                                                        	<?php
							}
						}
						else
						{
							if($i == 0)
							{
								?>
        	                                                <div id="slots-flavor-9-<?=$type?>" style="background: none repeat scroll 0px 0px rgb(205, 34, 43); position: absolute; z-index: 100; margin-left: -20px; font-weight: bold; color: rgb(255, 255, 255);width:65px">
                	                                                <a href="javascript:void(0);" style="text-decoration:none;color:#fff"><p class="left" style="margin:5px;">9 Lines</p></a>
                        	                                </div>
                                	                        <ul id="<?=strtolower($groupName . '-' . $type . '-9')?>" style="margin-top:20px;">
                                        	                <?php
							}
							if($game['maxBetlines'] < 25)
                                                        {
                                                                $runningMachineId = $game['runningMachineId'];
                                                                $machineId = $game['machineId'];
                                                                $flashFile = $game['machineName'].'.swf';
                                                                ?>
                                                                <li>
                                                                        <div>
                                                                                <a href = "<?php echo $this->view->url(array(
                                                                                        'controller' => 'game',
                                                                                        'action' => 'game',
                                                                                        'flavour' => $game['gameFlavour'],
                                                                                        'machineId' => $game['runningMachineId'],
                                                                                        'amountType' => $game['amountType']
                                                                                        ));
                                                                                ?>" onclick="window.open('<?php echo $this->view->url(array(
                                                                                                'controller' => 'game',
                                                                                                'action' => 'game',
                                                                                                'flavour' => $game['gameFlavour'],
                                                                                                'machineId' => $game['runningMachineId'],
                                                                                                'amountType' => $game['amountType']
                                                                                                ));
                                                                                        ?>','<?=$game['gameFlavour'] . $game['runningMachineId']?>','width=800,height=600,scrollbars=no,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0'); return false">
                                                                                        <img src="/images/thumbnails/<?php echo $game['gameFlavour']."_".$machineId."_s.png"?>"  border="0" />
                                                                                        <p>
                                                                                                <span class='machine-name'>
                                                                                                        <?=$game['machineName']?>
                                                                                                </span>
                                                                                        </p>
                                                                                </a>
                                                                        </div>
                                                                </li>
                                                                <?php
                                                        }
						}
						$i++;
					}
					?>
                                                </ul>
                                              <?php

				}
			}
		}
		else
		{
		foreach($gameDetails as $type => $gameType)
		{
			?>
			<ul id="<?=strtolower($groupName . '-' . $type)?>">
			<?php 
			foreach($gameType as $game)
			{
				$runningMachineId = $game['runningMachineId'];
				$machineId = $game['machineId'];
				$flashFile = $game['machineName'].'.swf';
				?>
							<li>
								<div>
									<a href = "<?php echo $this->view->url(array(
											'controller' => 'game',
											'action' => 'game',
											'flavour' => $game['gameFlavour'],
											'machineId' => $game['runningMachineId'],
											'amountType' => $game['amountType']
											));
										?>" onclick="window.open('<?php echo $this->view->url(array(
												'controller' => 'game',
												'action' => 'game',
												'flavour' => $game['gameFlavour'],
												'machineId' => $game['runningMachineId'],
												'amountType' => $game['amountType']
												));
											?>','<?=$game['gameFlavour'] . $game['runningMachineId']?>','width=800,height=600,scrollbars=no,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0'); return false">
										<img src="/images/thumbnails/<?php echo $game['gameFlavour']."_".$machineId."_s.png"?>"  border="0" />
										<p>
										<span class='machine-name'>
										<?=$game['machineName']?>
										</span>
										</p>
									</a>
								</div>
							</li>
							<?php
							$i++;
			}
			?>
			</ul>
			<?php 
		}
		}
	}
}
