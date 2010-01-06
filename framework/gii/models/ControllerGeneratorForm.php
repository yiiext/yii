<?php
/**
 * This file contains the ControllerGeneratorForm for the Gii module.
 *
 * @author Sebastian Thierer <sebathi@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2009 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * Gii is the web-based Code Generator for the Yii Framework.
 * 
 * ControllerGeneratorForm class.
 * ControllerGeneratorForm is the data structure for creating new Controllers with the Controller Generator
 * It is used by the 'index' action of 'gii.controllers.generators.ControllerController'
 * 
 * @author Sebastian Thierer <sebathi@gmail.com>
 * @version $Id$
 * @package system.gii
 * @since 1.1
 */
/**
 * ControllerGeneratorForm class.
 * ControllerGeneratorForm is the data structure for creating new Controllers with the Controller Generator
 * 
 */
class ControllerGeneratorForm extends CFormModel
{
	public $controller = '';
	public $actions = 'index';
	public $overwrite;
	
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('controller', 'required'),
			array('overwrite, actions', 'safe'),
			
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'path'=>'Controller path',
			'actions'=>'Action list separated by commas',
			'overwrite'=>'Overwrite all files (Yes if checked)',
		);
	}
	
}
