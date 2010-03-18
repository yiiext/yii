<?php
/**
 * This file contains the DefaultController.
 *
 * @author Sebastian Thierer <sebathi@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2009 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */


/**
 * Gii is the web-based Code Generator for the Yii Framework.
 * This controller ads home navigation functionallity
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

	public function actionGenerate(){
		if (isset($_GET['g'])){
			$generatorKey = $_GET['g'];
			if (isset($this->module->generators[$generatorKey])){
				$generator = Yii::createComponent($this->module->generators[$generatorKey]);
				if ($generator->getTitle()===null){
					$generator->title = $generatorKey;
				}
				$form = new ParameterForm();
				if (isset($_POST['ParameterForm'])){
					// Read user parameters
					$form->attributes = $_POST['ParameterForm'];
					
					$fileListForm = new FileListForm();
					
					$fileList = $generator->getFilesToGenerate();
					
					if (isset($_POST['FileListForm'])){
						// Read selected file lists
						$fileListForm->attributes = $_POST['FileListForm'];
						if ($fileListForm->validate()){
							$log = new CLogger();
							$generator->generate($fileListForm->fileList, $log);
							$logs = '';
							foreach($log->getLogs() as $log){
								$logs.=$log[0]."\n";
							}
							$this->render('generator_finish', 
								array(
									'generator'=>$generator, 
									'form'=>$form,  
									'logs'=>$logs
								)
							);
							return;
						}
					}else{
						$fileListForm->fileList = array();
						foreach ($fileList as $target=>$data){
							if ($data[1]==CCodeGenerator::FILE_NOT_EXISTS){ // The file does not exists
								$fileListForm->fileList[]=$target;
							}
						}
					}
					$files = array();
					foreach ($fileList as $target=>$data){
						switch($data[1]){
							case CCodeGenerator::FILE_NOT_EXISTS:
								$files[$target] = $target;
								break;
							case CCodeGenerator::FILE_EXISTS_UNCHANGED:
								$files[$target] = 'Unchanged: ' . $target;
								break;
							case CCodeGenerator::FILE_EXISTS_OVERWRITE:
								$files[$target] = 'Overwrite: ' . $target;
								break;
						} 
					}
					
					$this->render('generator_step2', array('generator'=>$generator, 'form'=>$form, 'files'=>$files, 'fileListForm'=>$fileListForm));
					return;
				} 
				$this->render('generator_step1', array('generator'=>$generator, 'form'=>$form));
				return;
			}
		}else{
			$this->redirect(array('index'));
		}
	}
}