<?php
class Zenfox_View_Helper_Jsonmenu extends Zend_View_Helper_Abstract {
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
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
	
	public function jsonmenu($links) {
	
		$index = 0;
		$index1 = 0;
		$parentName = array ();
		$parentNameFinal = array ();
		foreach($links as $key=>$value){
			
			$arr = explode('-' , $links[$key]['linkAddress']); 
			$links[$key]['linkAddress'] = 'com.playdorm.'.ucfirst($arr[0]).ucfirst($arr[1]).ucfirst($arr[2]) ;
			//ucfirst ( string $str )
		}
		
		
		?>[<?php
		
		foreach ( $links as $key => $value ) {
			
			if ($links [$key] ['parentName'] == 'not'){
				?>
				{text : '<?php echo $links [$key] ['linkName'];?>',cxtype: '<?php echo $links [$key] ['linkAddress'];?>' ,leaf:true},
				<?
				
			}
			
			
			if ($links [$key] ['parentName'] != 'not') {
				
				$parentName [$index]['id'] = $links [$key] ['parentId'];
				$parentName [$index]['name'] = $links [$key] ['parentName'];
				$index++;
			}
		}
		
		for($j = 0; $j < count ( $parentName ) - 1; $j ++) {
			
			for($i = $j + 1; $i < count ( $parentName ); $i ++) {
				if ($parentName [$j]['id'] == $parentName [$i]['id']) {
					$parentName [$i]['id'] = 'null';
				}
			}
		}
		
		foreach ( $parentName as $key=>$value ) {
			if ($parentName[$key]['id'] != 'null') {
				$parentNameFinal [$index1]['id'] = $parentName[$key]['id'];
				$parentNameFinal [$index1]['name'] = $parentName[$key]['name'];
				$index1++;
				
			}
		
		}
		//
		//print_r($parentNameFinal);
		
		foreach ( $parentNameFinal as $key=>$value ) {
			?>
			  { text    : '<?php echo $parentNameFinal[$key]['name'];?>',
			     cxtype  : '' , 
			      children : [ 
			     <?php
			foreach ( $links as $key1 => $value1 ) {
				if ($links [$key1] ['parentId'] == $parentNameFinal[$key]['id']) {
					
					?>
			   	
				    		{text : '<?php echo $links [$key1] ['linkName'];?>',cxtype: '<?php echo $links [$key1] ['linkAddress'];?>' ,leaf:true}, 
			  <?php
				}
			}
			?>
							] 
			     } ,
			
			<?php
		}
		?>]<?php
	
	}

}
?> 
