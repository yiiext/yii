<?php
/**
 * This file contains the GDefaultController.
 *
 * @author Sebastian Thierer <sebathi@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2009 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */


/**
 * Gii is the web-based Code Generator for the Yii Framework.
 * This controller ads login, logout and home navigation functionallity
 * 
 * @author Sebastian Thierer <sebathi@gmail.com>
 * @version $Id$
 * @package system.gii
 * @since 1.1
 */
class DefaultController extends BaseController {

	/**
	 * Gii Home Page 
	 */
	public function actionIndex(){
		$this->render('index');
	}

	/**
	 * Displays the Gii login page
	 */
	public function actionLogin()
	{
		Yii::import('gii.models.LoginForm');
		$model=new LoginForm;
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate())
				$this->redirect(array('/gii'));
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current Gii user and redirect to Gii Login.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(array('/gii'));
	}

}