<?php

class ControllerController extends GeneratorBaseController{
	
	public $templatePath = null;
	
	public function actionIndex(){
		$form = new ControllerGeneratorForm();
		if (isset($_POST['ControllerGeneratorForm'])){
			$form->attributes = $_POST['ControllerGeneratorForm'];
			if ($form->validate()){
				$module=Yii::app();
					$controllerID=$form->controller;
					
					if(($pos=strrpos($controllerID,'/'))===false)
					{
						$controllerClass=ucfirst($controllerID).'Controller';
						$controllerFile=$module->controllerPath.DIRECTORY_SEPARATOR.$controllerClass.'.php';
						$controllerID[0]=strtolower($controllerID[0]);
					}
					else
					{
						$last=substr($controllerID,$pos+1);
						$last[0]=strtolower($last);
						$pos2=strpos($controllerID,'/');
						$first=substr($controllerID,0,$pos2);
						$middle=$pos===$pos2?'':substr($controllerID,$pos2+1,$pos-$pos2);
			
						$controllerClass=ucfirst($last).'Controller';
						$controllerFile=($middle===''?'':$middle.'/').$controllerClass.'.php';
						$controllerID=$middle===''?$last:$middle.'/'.$last;
						if(($m=Yii::app()->getModule($first))!==null)
							$module=$m;
						else
						{
							$controllerFile=$first.'/'.$controllerClass.'.php';
							$controllerID=$first.'/'.$controllerID;
						}
			
						$controllerFile=$module->controllerPath.DIRECTORY_SEPARATOR.str_replace('/',DIRECTORY_SEPARATOR,$controllerFile);
					}
			
					$explodedActions = explode(',', $form->actions);
					$actions = array('index'); 
					foreach($explodedActions as $action){
						$actions[] = trim($action);
					}
					$actions=array_unique($actions);

					//var_dump($actions);die();
					$templatePath=$this->templatePath===null?YII_PATH.'/gii/templates/controller':$this->templatePath;
			
					$list=array(
						basename($controllerFile)=>array(
							'source'=>$templatePath.DIRECTORY_SEPARATOR.'controller.php',
							'target'=>$controllerFile,
							'callback'=>array($this,'generateController'),
							'params'=>array($controllerClass, $actions),
						),
					);
			
					$viewPath=$module->viewPath.DIRECTORY_SEPARATOR.str_replace('/',DIRECTORY_SEPARATOR,$controllerID);
					foreach($actions as $name)
					{
						$list[$name.'.php']=array(
							'source'=>$templatePath.DIRECTORY_SEPARATOR.'view.php',
							'target'=>$viewPath.DIRECTORY_SEPARATOR.$name.'.php',
							'callback'=>array($this,'generateAction'),
							'params'=>array(),
						);
					}
					
					// Verify if the files will overwrite any existing file if overwrite is not selected 
					$startCopy = true;
					if (!$form->overwrite){
						foreach($list as $files){
							if (file_exists($files['target'])){
								$startCopy = false;
								$form->addError('overwrite', 'The file "' . $files['target'] . '" already exists. Enable overwrite all if you want to overwrite it.');
							}	
						}
					}

					if ($startCopy){
						$this->copyFiles($list, true);
						$this->module->user->setFlash('success', 'The controller "' . $controllerID . '" has been created succesfuly.' );
						$this->redirect(array('index'));
					}
			
			}
		}
		$this->render('index', array('form'=>$form));
	

	}

	public function generateController($source,$params)
	{
		if(!is_file($source))  // fall back to default ones
			$source=YII_PATH.'/gii/views/generators/controller/'.basename($source);
		return $this->renderFile($source,array('className'=>$params[0],'actions'=>$params[1]),true);
	}

	public function generateAction($source,$params)
	{
		if(!is_file($source))  // fall back to default ones
			$source=YII_PATH.'/cli/views/shell/controller/'.basename($source);
		return $this->renderFile($source,array(),true);
	}
}