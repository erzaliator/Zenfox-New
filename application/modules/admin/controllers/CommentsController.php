<?php
require_once dirname(__FILE__) . '/../forms/SearchCommentsForm.php';
class Admin_CommentsController extends Zenfox_Controller_Action
{
	public function showallAction()
	{
		$comments = new Comments();
		$offset = $this->getRequest()->pages;
		$searchField = $this->getRequest()->field;
		if(!$offset)
		{
			$offset = 1;
		}
		if($searchField)
		{
			$index = $this->getRequest()->index;
			$result = $comments->getCommentsByField($index, $searchField, $offset, 25);
			$this->view->searchField = $searchField;
			$this->view->index = $index;
		}
		else
		{
			$result = $comments->getAllComments($offset, 25);
		}
		$this->view->paginator = $result['paginator'];
		$this->view->content = $result['content'];
	}
	
	public function statusAction()
	{
		$commentId = $this->getRequest()->id;
		$currentStatus = $this->getRequest()->status;
//		$offset = $this->getRequest()->pages;
//		$itemsPerPage = $this->getRequest()->items;
		$comments = new Comments();
		if($comments->changeStatus($commentId, $currentStatus))
		{
			$this->view->message = 'The status is updated successfully.';
			//$this->view->link = 'http://' . $_SERVER['SERVER_NAME'] . '/comments/showall/pages/' . $offset;
		}
		else
		{
			$this->view->message = 'The status is not updated.';
		}
	}
	
	public function showAction()
	{
		$comments = new Comments();
		$form = new Admin_SearchCommentsForm();
		$this->view->form = $form;
		$offset = $this->getRequest()->pages;
		//print('cOffset - ' . $offset);
		if($offset)
		{
			$itemsPerPage = $this->getRequest()->items;
			$searchString = $this->getRequest()->field;
			$searchIndex = $this->getRequest()->index;
			if($searchIndex)
			{
				$indexes = explode(',', $searchIndex);
				$searchingFields = explode(',', $searchString);
			}
			$totalIndexes = count($indexes);
			for($i = 0; $i < $totalIndexes; $i++)
			{
				$searchFields[$indexes[$i]] = $searchingFields[$i];
			}
			//Zenfox_Debug::dump($searchFields, 'field');
			$from = $this->getRequest()->from;
			$to = $this->getRequest()->to;
			$result = $comments->searchByFields($searchFields, $from, $to, $offset, $itemsPerPage);
			
		}
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$offset = 1;
				$data = $form->getValues();
				//Zenfox_Debug::dump($data, 'data', true, true);
				foreach($data as $index => $value)
				{
					if(($index == 'page_address') || ($index == 'user_name') || ($index == 'topic') || ($index == 'enabled'))
					{
						if($data[$index])
						{
							$searchFields[$index] = $value;
							$searchingIndex[] = $index;
						}
					}
				}
				//Zenfox_Debug::dump($searchFields, 'search');
				$from = $data['from_date'] . ' ' . $data['from_time'];
				$to = $data['to_date'] . ' ' . $data['to_time'];
				//$data['page'] = 1;
				$result = $comments->searchByFields($searchFields, $from, $to, $offset, $data['page']);
				if($searchingIndex)
				{
					$searchString = implode(',', $searchFields);
					$searchIndex = implode(',', $searchingIndex);
				}
			}
		}
		if($result)
		{
			$this->view->paginator = $result['paginator'];
			$this->view->content = $result['content'];
			$this->view->searchString = $searchString;
			$this->view->searchIndex = $searchIndex;
			$this->view->from = $from;
			$this->view->to = $to;
			$this->render('showall');
		}
	}
}