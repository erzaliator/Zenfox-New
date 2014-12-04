<?php

class admin_ContactForm extends Zend_Form
{
	public $taglist;
	public function getform($options = null) 
    { 
       
        $this->setName('contact_us');
       
        
        $title = new Zend_Form_Element_Select('tag');
        $title->setLabel('Select Tag')
              ->setMultiOptions($this->taglist)
              ->setRequired(true);
        
        $reporttype = new Zend_Form_Element_Select('report_type');
        $reporttype->setLabel('Report Type')
        			->setMultiOptions(array('EOH'=>'EOH', 'EOD'=>'EOD','EOw'=>'EOw', 'EOm'=>'EOm'))
        			->setRequired(true);
               
//         $starttime = new Zend_Form_Element_Text('start_time');
//         $starttime->setLabel('Start Time')
//                   ->setRequired(true)
//                   ->addValidator('NotEmpty');

        
        $time =new ZendX_JQuery_Form_Element_DatePicker('time',
        		array('jQueryParams' => array('dateFormat' => 'yy-mm-dd'))
        );
        $time->setLabel('date')
        ->setRequired(true);

//         $endtime = new Zend_Form_Element_Text('end_time');
//         $endtime->setLabel('End Time')
//                  ->setRequired(true)
//                  ->addValidator('NotEmpty');
             
        
//         $endtime =new ZendX_JQuery_Form_Element_DatePicker('end_time',
//         		array('jQueryParams' => array('dateFormat' => 'yy-mm-dd','label'=>'end'))
//         );
//         $endtime->setLabel('End Time');
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Get Health');
        
        $this->addElements(array($title, $reporttype, 
            $starttime,$time,  $submit));
        return $this;
        
    } 
	public function setvalue($values)
	{
		$this->taglist=$values;
	}
}

