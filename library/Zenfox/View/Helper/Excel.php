<?php
require_once ('phpexcel/PHPExcel.php');
class Zenfox_View_Helper_Excel extends Zend_View_Helper_Abstract
{
	public $view;
	
	public function setView(Zend_View_Interface $view)
	{
		$this->view = $view;
	}
	
	public function excel($excelReport, $from, $to)
	{
		//Zenfox_Debug::dump($excelReport,'s',true,true);
		$from = explode(' ', $from);
		$fromDate = $from[0];
		$to = explode(' ', $to);
		$toDate = $to[0];
		$this->getExcelSheet($excelReport, $fromDate, $toDate);
	}
	
	public function getExcelSheet($excelReport, $from, $to)
	{
		$session = new Zend_Auth_Storage_Session();
		$storedData = $session->read();
		$creator = 'CSR-' . $storedData['id'];
		$modifier =  'CSR-' . $storedData['id'];
		
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator($creator);
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getProperties()->setLastModifiedBy($modifier);
		$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
		$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
		$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
		
		foreach($excelReport as $mainIndex => $data)
		{
			foreach($data as $index => $value)
			{
				$char = chr(64 + $index) . $mainIndex;
				$objPHPExcel->getActiveSheet()->SetCellValue($char, $value);
			}
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('System Report');
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		
		$report = '/tmp/SystemReport_' . $from . '_' . $to . '.xlsx';
		$objWriter->save($report);
		
		//PROBLEM IN DOWNLOADING
		//$readObjPHPExcel = PHPExcel_IOFactory::load($report);
		$this->downloadExcelSheet($report);
	}
	
	public function downloadExcelSheet($fileName)
	{
		$file = $fileName;
	
		if (file_exists($file)) 
		{
		    header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename='.basename($file));
		    header('Content-Transfer-Encoding: binary');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($file));
		    ob_clean();
		    flush();
		    readfile($file);
		    exit();
		}
	}
	
}