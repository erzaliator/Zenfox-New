<?php
class Player_RummygamelogController extends Zenfox_Controller_Action
{
	public function init()
	{
		parent::init();
		
		$contextSwitch = $this->_helper->getHelper('contextSwitch');
		$contextSwitch->addActionContext('index', 'json')
              		->initContext();
	}
	
	public function indexAction()
	{
		/*$filePath = "/home/nikhil/Downloads/gamelog_archive_99613.txt";
		$fh = fopen($filePath, 'r');
		$fileData = fread($fh, filesize($filePath));
		fclose($fh);
		$data['success'] = true;
		$data['gameLog'] = $fileData;
		$this->view->result = $data;*/
		//Zenfox_Debug::dump($fileData, 'fileData', true, true);
		/*if($this->getRequest()->isPost())
		{
			$gameFlavour = $this->getRequest()->getParam('gameFlavour');
			$sessionId = $this->getRequest()->getParam('sessionId');
			$gameId = $this->getRequest()->getParam('gameId');
			
			$cefGamelog = new CefGamelog();
			$archiveId = $cefGamelog->getArchiveId($gameFlavour, $sessionId, $gameId);
			
			$cefGamelogArchive = new CefGamelogArchive();
			$gameLog = $cefGamelogArchive->getGamelog($sessionId, $archiveId);
			
			$data['success'] = true;
			$data['gameLog'] = $gameLog;
			$this->view->result = $data;
		}
		else
		{
			$data['success'] = false;
			$this->view->result = $data;
		}*/
		//OLD CODE START HERE

			/*$gameFlavour = $this->getRequest()->getParam('gameFlavour');
                        $sessionId = $this->getRequest()->getParam('sessionId');
                        $gameId = $this->getRequest()->getParam('gameId');

                        $cefGamelog = new CefGamelog();
                        $archiveId = $cefGamelog->getArchiveId($gameFlavour, $sessionId, $gameId);

                        $cefGamelogArchive = new CefGamelogArchive();
                        $gameLog = $cefGamelogArchive->getGamelog($sessionId, $archiveId);

                        $data['success'] = true;
                        $data['gameLog'] = $gameLog;
                        $this->view->result = $data;*/

		//END HERE

		//NEW CODE

		$gameFlavour = $this->getRequest()->getParam('gameFlavour');
		$sessionId = $this->getRequest()->getParam('sessionId');
		$gameId = $this->getRequest()->getParam('gameId');
		$gameLog = "";
		
		$cefGamelog = new CefGamelog();
		$archiveId = $cefGamelog->getArchiveId($gameFlavour, $sessionId, $gameId);
			
		if($archiveId)
		{
			$cefGamelogArchive = new CefGamelogArchive();
			$gameLog = $cefGamelogArchive->getGamelog($sessionId, $archiveId);
		}
		
		if(!$gameLog)
		{
			$fileName = $gameFlavour . '-' . $sessionId . '-' . $gameId . '.tgz';
			$extractFileName =  $gameFlavour . '-' . $sessionId . '-' . $gameId;
			
			$filter = new Zend_Filter_Decompress(array(
								'adapter' => 'Tar', //Or 'Tar', or 'Gz'
								'options' => array(
								'target' => '/tmp'
						)
					));
			$filePath = "/home/nikhil/archive_dir/";
			for($i = 1; $i <= 2; $i++)
			{
				$filePath .= "slave" . $i . "/cefGamelogArchive/" . $fileName;
				if(file_exists($filePath))
				{
					$filter->filter($filePath);
					$dir = new DirectoryIterator('/tmp/'. $extractFileName);
					foreach ($dir as $fileinfo)
					{
						if (!$fileinfo->isDot())
						{
							$filePath = $fileinfo->getPathName();
							if($filePath == "/tmp/" . $extractFileName . "/gamelog.json")
							{
								$fh = fopen($filePath, 'r');
								$gameLog = fread($fh, filesize($filePath));
							}
						}
					}
					/* foreach(glob($filePath.'*.*') as $v){
						unlink($v);
					} */
					break;
				}
				else
				{
					echo "not found";
				}
			}
		}
		$data['success'] = true;
		$data['gameLog'] = $gameLog;
		$this->view->result = $data;

	}
}