<?php
class ControllerCodeGenerator extends CCodeGenerator {
	
	/**
	 * @var string the directory that contains templates for the model command.
	 * Defaults to null, meaning using 'framework/cli/views/shell/controller'.
	 * If you set this path and some views are missing in the directory,
	 * the default views will be used.
	 */
	public $templatePath;

	/**
	 * (non-PHPdoc)
	 * @see framework/gii/components/CCodeGenerator#getHelp()
	 */
	public function getHelp(){
		return <<<EOD
<h3>USAGE</h3>
  <p>&lt;controller-ID&gt; [action-ID] ...</p>

<h3>DESCRIPTION</h3>
  <p>This command generates a controller and views associated with
  the specified actions.</p>

<h3>PARAMETERS</h3>
<p><strong>controller-ID</strong>: required, controller ID, e.g., 'post'.
   If the controller should be located under a subdirectory,
   please specify the controller ID as 'path/to/ControllerID',
   e.g., 'admin/user'.</p>

   <p>If the controller belongs to a module, please specify
   the controller ID as 'ModuleID/ControllerID' or
   'ModuleID/path/to/Controller' (assuming the controller is
   under a subdirectory of that module).</p>

 <p><strong>action-ID</strong>: optional, action ID. You may supply one or several
   action IDs. A default 'index' action will always be generated.</p>

<h3>EXAMPLES</h3>
<p>Generates the 'post' controller:<br/>
        Parameters: <strong>post</strong></p>

 <p>Generates the 'post' controller with additional actions 'contact'<br/>
   and 'about':
        Parameters: <strong>post contact about</strong></p>

 <p>Generates the 'post' controller which should be located under
   the 'admin' subdirectory of the base controller path:<br/>
        Parameters: <strong>admin/post</strong></p>

 <p>Generates the 'post' controller which should belong to
   the 'admin' module:<br/>
        Parameters: <strong>admin/post</strong></p>

<p>NOTE: in the last two examples, the commands are the same, but
the generated controller file is located under different directories.
Yii is able to detect whether 'admin' refers to a module or a subdirectory.</p>

EOD;
	}
	

	/**
	 * (non-PHPdoc)
	 * @see framework/gii/components/CCodeGenerator#getFilesToGenerate()
	 */
	public function getFilesToGenerate($fileListOnly=true){
		$args = $this->getArguments();
		if ($args!=null){
			$module=Yii::app();
			$controllerID=$args[0];
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
			$args[]='index';
			$actions=array_unique(array_splice($args,1));
	
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
					'params'=>array('controller'=>$controllerClass, 'action'=>$name),
				);
			}
			if ($fileListOnly){
				return $this->checkCopyFiles($list);
			}
			return $list;

		}
		return array();
	}

	/**
	 * (non-PHPdoc)
	 * @see framework/gii/components/CCodeGenerator#generate($files, $log)
	 */
	public function generate($files, $log){

		$possibleFiles = $this->getFilesToGenerate(false);
		
		$list = array();
		foreach($files as $file){
			$fname = substr($file, strlen(dirname($file))+1);
			if (isset($possibleFiles[$fname])){
				$list[$fname] = $possibleFiles[$fname];
			}
		}
		$this->copyFiles($list, $log);
	}

	public function generateController($source,$params)
	{
		if(!is_file($source))  // fall back to default ones
			$source=YII_PATH.'/cli/views/shell/controller/'.basename($source);
		return $this->renderFile($source,array('className'=>$params[0],'actions'=>$params[1]),true);
	}

	public function generateAction($source,$params)
	{
		if(!is_file($source))  // fall back to default ones
			$source=YII_PATH.'/cli/views/shell/controller/'.basename($source);
		return $this->renderFile($source,$params,true);
	}
}