<?php

require_once dirname(__FILE__).'/../forms/TagForm.php';
require_once dirname(__FILE__).'/../forms/PageRequestForm.php';
require_once dirname(__FILE__).'/../forms/EditTagForm.php';
require_once dirname(__FILE__).'/../forms/EmailTemplateForm.php';
require_once dirname(__FILE__).'/../forms/EditTemplateForm.php';



class Admin_TemplateController extends Zenfox_Controller_Action
{
	public function indexAction()
	{
		
	}
	
	public function createtagAction()
	{
		$form = new Admin_TagForm();		
		$this->view->form = $form;
		if($this->getRequest()->isPost())
		{		
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$name = $data['name'];
				$query = $data['query'];
				$tag = new EmailTag();
				$result = $tag->createTag('$'.$data['name'] , $data['query']);
				if(!$result)
				{
					$this->_helper->FlashMessenger(array('error' => 'Tag With this name already exists'));
					echo 'Tag With this name already exists';
				}
				else
				{
					$this->_helper->FlashMessenger(array('error' => 'Tag Created Successfully'));
					echo 'Tag Created Successfully';
				}
			}
		}
	}
	
	public function listalltagsAction()
	{
		$form = new Admin_PageRequestForm();
		$this->view->form = $form;
		$offset = $this->getRequest()->pages;
		if($offset)
		{
			$itemsPerPage = $this->getRequest()->item;
			$result = $tag->listAll($itemsPerPage);
			$this->view->paginator = $result[0];
			$this->view->contents = $result[1];
		}
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$tag = new EmailTag();
				$result = $tag->listAll($data['page']);
				$this->view->paginator = $result[0];
				$this->view->contents = $result[1];
			}
		}
	}
	
	public function edittagAction()
	{
		$id = $this->getRequest()->source_id;
 		echo $id;
		$tag = new EmailTag();
		$result = $tag->getQuery($id);
		$form = new Admin_EditTagForm();
		$this->view->form = $form->setForm($result[0]['query']);
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$result = $tag->editTag($id,$data['query']);
				if($result)
				{
					echo 'Edit Successful';
				}
			}
		}
	}
	
	public function createtemplateAction()
	{
		
		//TODO Take frontend from //from csr you get gms_group_id -> frontend;
		//frontend, gmsgroup_frontend, gms_group
		
		
		$frontendobject = new Frontend();
		$frontends = $frontendobject->getFrontends();
		
		$length = count($frontends);
		$index = 0;
		while($index < $length )
		{
			$newfrontends[$frontends[$index]['id']] = $frontends[$index]['name'];
			$index++;
		}
		
		$form = new Admin_EmailTemplateForm();
		$this->view->form = $form->setFrontend($newfrontends);
		
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$values = $form->getValues();
				$template = new EmailTemplate();
				
				$path = Zend_Registry::getInstance()->get('UploadTemplateFile');
				
				$oldpath =$path. $values[bodyfile];
				$name = $_FILES["bodyfile"]["name"];
				$today = new Zend_Date();
				$currentTime = $today->get(Zend_Date::W3C);
				$file1name = "CREATETEMPLATE_".$currentTime."_";
				$newpath = $path.$file1name.$name;
					
				rename($oldpath, $newpath);
				$file=fopen($newpath,"r") or exit("Unable to open file!");
				$contents = fread($file, filesize($newpath));
				
				$lastdata = $template->getlastdata($values['name'],$values['category'],$values['frontend_id'],$values['subject'],$contents, $values['domain']);

				if(!empty($lastdata))
				{
					$this->_helper->FlashMessenger(array('error' => 'Template set already'));
				}
				else 
				{
					$result = $template->addTemplate($values['name'],$values['category'],$values['frontend_id'],$values['subject'],$contents, $values['domain']);

					if($result == true)
					{
						$this->_helper->FlashMessenger(array('message' => 'Template saved successfully.'));
					}
					else
					{
						$this->_helper->FlashMessenger(array('error' => 'Error while saving template.'));
					}	
				
				}
				
				
			}				
		}
	}
	
	public function listallAction()
	{
		$template = new EmailTemplate();
				
		$dataArray = $template->adminList();

		
				
		if($dataArray === false)
		{
			echo "Some error occurred while fetching the templates.";
		}
		elseif ( count($dataArray) >= 1 )
		{
			foreach ($dataArray as $data)
			{
				
				$newTable[] = $data;		
			}
			
			$this->view->data = $newTable;
		
		}	
		else
		{
			$this->view->error = 'No templates found.';
		}		
	}
	
	public function viewtemplateAction()
	{
		$request = $this->getRequest();
		$id = $request->id;
		
		$template = new EmailTemplate();
		$dataArray = $template->adminGetDetails($id);
		
		if($dataArray == false)
		{	
			echo 'Some error occurred while fetching the details.';	
		}
		else
		{
			$this->view->data = $dataArray;
		}
	}
	
	public function deletetemplatelistdummyAction()
	{
		$idArray = $_POST['id'];
		$session = new Zend_Auth_Storage_Session();
		$origSession = $session->read();

		$origSession['template_id'] = $idArray;
		$session->write($origSession);
		//$language = 'en_GB';
		print_r($session->read());
		exit();
		
		$language = Zend_Locale;
		
		//$this->_redirect($language.'/template/deletetemplatelist');
	}
	
	public function deletetemplatelistAction()
	{
		//print_r($_GET);
		//$idArray = $_POST['id'];
		$session = new Zend_Auth_Storage_Session();
		$idArray = $session->read();
		print_r($idArray);
		exit();
		
		$template = new EmailTemplate();
		$templateList = $template->fetchTemplates($idArray);
		if($templateList == false)
		{
			echo 'Some error occurred while fetching the templates';
		}
				
		$this->view->tableData = $templateList;
		$form = new Admin_DeleteTemplateForm();
		
		
		
		
		$this->view->form = $form;
		//$_POST = '';
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$template = new EmailTemplate();
				//$result = $template->deleteTemplates($idArray);
				echo 'In the post';
				$values = $form->getValues();
				$hidden = $values['hidden'];
				

				if($result == true)
				{
					echo 'Successfully deleted';
				}
				else
				{
					echo 'Unsuccessful deletion';
				}
			
			}
		}
			
	}
	
	
	
	public function edittemplateAction()
	{
		$request = $this->getRequest();
		$id = $request->id;
		
		$template = new EmailTemplate();
		$templateList = $template->fetchTemplates($id);
		
		
		$frontendobject = new Frontend();
		$frontends = $frontendobject->getFrontends();
		
		$length = count($frontends);
		$index = 0;
		while($index < $length )
		{
			$newfrontends[$frontends[$index]['id']] = $frontends[$index]['name'];
			$index++;
		}
		
		$form = new Admin_EditTemplateForm();
		$form->setFormData($templateList[0],$newfrontends);
		
		
		$this->view->form = $form;
		
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$path = Zend_Registry::getInstance()->get('UploadTemplateFile');
				
				if(!empty($_FILES["bodyfile"]["name"]))
				{
					$oldpath =$path. $data[bodyfile];
					$name = $_FILES["bodyfile"]["name"];
					$today = new Zend_Date();
					$currentTime = $today->get(Zend_Date::W3C);
					$file1name = "EDITTEMPLATE_".$currentTime."_";
					$newpath = $path.$file1name.$name;
					
					rename($oldpath, $newpath);
					$file=fopen($newpath,"r") or exit("Unable to open file!");
					$contents = fread($file, filesize($newpath));
					
					$data["body"] = $contents;
				}
				$template = new EmailTemplate();
				$result = $template->editTemplate($data ,$id);

				if($result == true)
				{
					$templateList = $template->fetchTemplates($id);
		
					$frontends = $frontendobject->getFrontends();
			
					$length = count($frontends);
					$index = 0;
					while($index < $length )
						{
						$newfrontends[$frontends[$index]['id']] = $frontends[$index]['name'];
						$index++;
					}
			
					$form->setFormData($templateList[0],$newfrontends);
					
					$this->_helper->FlashMessenger(array('error' => 'Template updated successfully.'));
				}
				else
				{
					$this->_helper->FlashMessenger(array('message' => 'Template update not successfull.'));
				}
			}
		}
		
	}	
	
	public function deletetemplateAction()
	{
		$request = $this->getRequest();
		$id = $request->id;
		
		$template = new EmailTemplate();
		
		
		$result = $template->deleteTemplates(array($id));
		
		if($result == true)
		{
			echo 'Successfully deleted';
		}
		else
		{
			echo 'Unsuccessful deletion';
		}
		
		
	}
	
	
}