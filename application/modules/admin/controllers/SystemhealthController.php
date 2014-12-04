<?php
require_once(dirname(__FILE__) . '/../forms/contactform.php');
//require_once(dirname(__FILE__) . '/../forms/contactform2.php');

class Admin_SystemhealthController extends Zenfox_Controller_Action
{
	public function indexAction()
	{
		$form = new admin_ContactForm();
		$tags = new SystemTag();
			$value = $tags->getAllTags();
			$n=count($value);
			
			while($n>=0)
			{
				$newindex[$n]=$value[$n][id];
				$newvalue[$newindex[$n]] = $value[$n][tag];
				$n--;
			}
			
			$form->setvalue($newvalue);
			$this->view->form = $form->getform();
		//echo "in controller";
		if ($this->getRequest()->isPost()) 
		 { 
		 	
		 	if($form->isValid($_POST))
			{
				$this->view->form = "";
				//print_r($_POST);
				$entered = $form->getvalues();
				//print_r($entered);
				$health= new SystemHealth();
				$value = $health->gethealth($_POST["tag"],$_POST["report_type"],$_POST["time"]);
				//print_r($value);
				//echo "in system healthcontroller...........";
				if(!empty($value))
				{
					$index=0;
					$n=count($value);
					//exit();
					while($n>0)
					{
						$newvalue=$value[$n-1][value];
						$newstime=$value[$n-1][start_time];
						$newetime=$value[$n-1][end_time];
						$n--;
						$actualvalue[$index] = $newvalue;
						$actualstime[$index] = $newstime;
						$actualetime[$index] = $newetime;
						$index++;
						
					}
					//print_r($actualetime);
					//exit();
					$entered[tag] = $value[0][tag];
					//echo ($entered[tag]);
					//exit();
						//print_r($actualvalue);
					$this->view->value=$actualvalue;
					$this->view->stime=$actualstime;
					$this->view->etime=$actualetime;
					$this->view->valueentered=$entered;
					// 				$form = new forms_ContactForm2();
					// 				$form->setfinalvalue($actualvalue,$entered);
					// 				$this->view->form = $form->getform2();
				}
				else{
					//echo "no value in db";
					$this->view->valuestime=array('error' => '9');
				}
			}	
			
			
		}
		
		/* else{
			$tags = new SystemTag();
			$value = $tags->getAllTags();
			$n=count($value);
			
			while($n>=0)
			{
				$newindex[$n]=$value[$n][id];
				$newvalue[$newindex[$n]] = $value[$n][tag];
				$n--;
			}
			
			$form->setvalue($newvalue);
			$this->view->form = $form->getform();
		} */
	}
	
		
	
}
