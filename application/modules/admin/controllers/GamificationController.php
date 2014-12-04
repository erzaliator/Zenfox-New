<?php
require_once dirname(__FILE__).'/../forms/CreateVariablesForm.php';
require_once dirname(__FILE__).'/../forms/CreateBadgesForm.php';
//require_once dirname(__FILE__).'/../forms/CreateBonusesForm.php';
require_once dirname(__FILE__).'/../forms/UserForm.php';

//for the image uploading part in createbadges
use Zend\Form\Element;
use Zend\Form\Form;

class Admin_GamificationController extends Zenfox_Controller_Action
{
	public function init()
	{
		parent::init();
		$this->_redirector = $this->_helper->getHelper('Redirector');
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch->setAutoJsonSerialization(false);
		$contextSwitch->addActionContext('index', 'json')
						->addActionContext('edit', 'json')				
              	->initContext();
	}
	public function indexAction()
	{
		print "This should load everything. This is printing without View";
	}

	public function createvariableAction()
	{
		/*
		$form=new Admin_CreateVariablesForm();
		$this->view->form = $form;
		$offset = $this->getRequest()->page;  
		*/

		$form = new Admin_CreateVariablesForm();
        $this->view->form = $form;
	}	
	public function createbadgeAction()
	{
		//doctrine/models has the tables defined. where is the insertion takign place?
		$form = new Admin_CreateBadgesForm();
        $this->view->form = $form;
        $request = $this->getRequest();
		if($request->isPost())
		{
			if($form->isValid($_POST))
			{
				if($form->isValid($_POST))
				{
					$servername = "localhost";
					$username = "root";
					$password = "kaveri";
					$dbname = "zenfox";

					// Create connection
					$conn = new mysqli($servername, $username, $password, $dbname);
					// Check connection
					if ($conn->connect_error) {
					    die("Connection failed: " . $conn->connect_error);
					    echo "unsuccessfully";
					}
					else
						echo "successfully";

					$sql = "INSERT INTO 
					gamification_user_badge (client_id, app_id, badge_id, badge_title, url, body, gamification_variable, max_value)
					VALUES (". $_POST['client_id'] .", ". $_POST['app_id'] .", ". $_POST['badge_id'] .", '". $_POST['badge_title'] ."', '". $_POST['url'] ."', '". $_POST['body'] ."', '". $_POST['gamification_variable'] ."', ". $_POST['max_value'] .")";

					if ($conn->query($sql) === TRUE) {
					    echo "New record created successfully";
					} else {
					    echo "Error: " . $sql . "<br>" . $conn->error;
					}
					
					$conn->close();
				}
			}
			/*if($gameGroupForm->isValid($_POST))
			{
				$gameGroupConfig = new GameGroupConfig();
				$gameGroupConfig->insertGameGroup($_POST);
				$gameGroup = new Gamegroup();
				$gameGroupId = $gameGroup->getIdByGameGroupName($_POST['name']);
				$flavour = new Flavour();
				$gameFlavours = $flavour->getGameFlavours();
				foreach($gameFlavours as $gameFlavour)
				{
					if($_POST[$gameFlavour])
					{
						$runningMachineIds = $_POST[$gameFlavour];
						foreach($runningMachineIds as $runningMachineId)
						{
							$gameGroupConfig->insertGameGameGroup($gameFlavour,$runningMachineId,$gameGroupId);
						}
					}
				}
				$this->view->form = '';
				echo 'Game group is added';
			}*/
		}
	}	

	/*public function createbonusAction()
	{
		$form = new Admin_CreateBonusesForm();
        $this->view->form = $form;
	}	*/
}
