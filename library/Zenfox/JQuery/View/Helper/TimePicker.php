<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category    ZendX
 * @package     ZendX_JQuery
 * @subpackage  View
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license     http://framework.zend.com/license/new-bsd     New BSD License
 * @version     $Id: DatePicker.php 20165 2010-01-09 18:57:56Z bkarwin $
 */

/**
 * @see Zend_Registry
 */
require_once "Zend/Registry.php";

/**
 * @see ZendX_JQuery_View_Helper_UiWidget
 */
require_once "ZendX/JQuery/View/Helper/UiWidget.php";

/**
 * jQuery Date Picker View Helper
 *
 * @uses 	   Zend_View_Helper_FormText
 * @package    ZendX_JQuery
 * @subpackage View
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zenfox_JQuery_View_Helper_TimePicker extends ZendX_JQuery_View_Helper_UiWidget
{
	/**
	 * Create a jQuery UI Widget Date Picker
	 *
	 * @link   http://docs.jquery.com/UI/Datepicker
	 * @param  string $id
	 * @param  string $value
	 * @param  array  $params jQuery Widget Parameters
	 * @param  array  $attribs HTML Element Attributes
	 * @return string
	 */
	public function timePicker($id, $value = null, array $attribs = array())
	{
		$attribs = $this->_prepareAttributes($id, $value, $attribs);

		$js = sprintf('%s("#%s").clockpick();',
		    ZendX_JQuery_View_Helper_JQuery::getJQueryHandler(),
		    $attribs['id']
		    //$params
		);

		//
		// Add DatePicker callup to onLoad Stack
		//
		$this->jquery->addOnLoad($js);
		
		return $this->view->formText($id, $value, $attribs);
	}
}