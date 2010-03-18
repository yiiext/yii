<?php
/**
 * This file contains the BaseController.
 *
 * @author Sebastian Thierer <sebathi@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2009 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * Gii is the web-based Code Generator for the Yii Framework.
 * This controller is the base controller for all Gii controllers.
 * 
 * @author Sebastian Thierer <sebathi@gmail.com>
 * @version $Id$
 * @package system.gii
 * @since 1.1
 */
class BaseController extends CController {

	private $breadcrumbs = array();
	public $layout = 'gii.views.layouts.main';
	
	/**
	 * Gets actual breadcrumbs
	 * @return unknown_type
	 */
	public function getBreadcrumbs(){
		return $this->breadcrumbs;
	}
	
	/**
	 * Sets actual breadcrumbs
	 * @param array $value
	 */
	public function setBreadcrumbs($value){
		if (CPropertyValue::ensureArray($value)){
			$this->breadcrumbs = $value;
		}else{
			throw new CException('Breadcrumbs must be an array');
		}
	}

}