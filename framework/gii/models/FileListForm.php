<?php
/**
 * This file contains the FileListForm for the Gii module.
 *
 * @author Sebastian Thierer <sebathi@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2009 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * Gii is the web-based Code Generator for the Yii Framework.
 * 
 * FileListForm class.
 * Used to reproduce the file list form for Generators
 * 
 * @author Sebastian Thierer <sebathi@gmail.com>
 * @version $Id$
 * @package system.gii
 * @since 1.1
 */
class FileListForm extends CFormModel
{
	public $fileList;
	
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('fileList', 'required'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'fileList'=>"Files to generate",
		);
	}
}
