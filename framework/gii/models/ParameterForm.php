<?php
/**
 * This file contains the ParameterForm for the Gii module.
 *
 * @author Sebastian Thierer <sebathi@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2009 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * Gii is the web-based Code Generator for the Yii Framework.
 * 
 * ParameterForm class.
 * ParameterForm is used to ask the user which parameters to use 
 * with the selected generator.
 * 
 * @author Sebastian Thierer <sebathi@gmail.com>
 * @version $Id$
 * @package system.gii
 * @since 1.1
 */
class ParameterForm extends CFormModel
{
	public $parameters;
	
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('parameters', 'safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'parameters'=>"Parameters",
		);
	}
	
	public function getArguments(){
		return preg_split('/[\s,]+/',rtrim($this->parameters,';'),-1,PREG_SPLIT_NO_EMPTY);
	}
}
