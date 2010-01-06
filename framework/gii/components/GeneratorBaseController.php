<?php
class GeneratorBaseController extends BaseController{

	/**
	 * Copies a list of files from one place to another.
	 * @param array the list of files to be copied (name=>spec).
	 * The array keys are names displayed during the copy process, and array values are specifications
	 * for files to be copied. Each array value must be an array of the following structure:
	 * <ul>
	 * <li>source: required, the full path of the file/directory to be copied from</li>
	 * <li>target: required, the full path of the file/directory to be copied to</li>
	 * <li>callback: optional, the callback to be invoked when copying a file. The callback function
	 *   should be declared as follows:
	 *   <pre>
	 *   function foo($source,$params)
	 *   </pre>
	 *   where $source parameter is the source file path, and the content returned
	 *   by the function will be saved into the target file.</li>
	 * <li>params: optional, the parameters to be passed to the callback</li>
	 * </ul>
	 * @see buildFileList
	 */
	public function copyFiles($fileList, $overwriteAll = false)
	{
		foreach($fileList as $name=>$file)
		{
			$source=strtr($file['source'],'/\\',DIRECTORY_SEPARATOR);
			$target=strtr($file['target'],'/\\',DIRECTORY_SEPARATOR);
			$callback=isset($file['callback']) ? $file['callback'] : null;
			$params=isset($file['params']) ? $file['params'] : null;

			if(is_dir($source))
			{
				$this->ensureDirectory($target);
				continue;
			}

			if($callback!==null)
				$content=call_user_func($callback,$source,$params);
			else
				$content=file_get_contents($source);
				
			if(!is_file($target)){
				$this->ensureDirectory(dirname($target));
			}elseif (!$overwriteAll){
				continue;
			}
			file_put_contents($target,$content);
		}
	}
	/**
	 * Builds the file list of a directory.
	 * This method traverses through the specified directory and builds
	 * a list of files and subdirectories that the directory contains.
	 * The result of this function can be passed to {@link copyFiles}.
	 * @param string the source directory
	 * @param string the target directory
	 * @param string base directory
	 * @return array the file list (see {@link copyFiles})
	 */
	public function buildFileList($sourceDir, $targetDir, $baseDir='')
	{
		$list=array();
		$handle=opendir($sourceDir);
		while($file=readdir($handle))
		{
			if($file==='.' || $file==='..' || $file==='.svn' ||$file==='.yii')
				continue;
			$sourcePath=$sourceDir.DIRECTORY_SEPARATOR.$file;
			$targetPath=$targetDir.DIRECTORY_SEPARATOR.$file;
			$name=$baseDir===''?$file : $baseDir.'/'.$file;
			$list[$name]=array('source'=>$sourcePath, 'target'=>$targetPath);
			if(is_dir($sourcePath))
				$list=array_merge($list,$this->buildFileList($sourcePath,$targetPath,$name));
		}
		closedir($handle);
		return $list;
	}

	/**
	 * Creates all parent directories if they do not exist.
	 * @param string the directory to be checked
	 */
	public function ensureDirectory($directory)
	{
		if(!is_dir($directory))
		{
			$this->ensureDirectory(dirname($directory));
			mkdir($directory);
		}
	}

	/**
	 * Renders a view file.
	 * @param string view file path
	 * @param array optional data to be extracted as local view variables
	 * @param boolean whether to return the rendering result instead of displaying it
	 * @return mixed the rendering result if required. Null otherwise.
	 */
	public function renderFile($_viewFile_,$_data_=null,$_return_=false)
	{
		if(is_array($_data_))
			extract($_data_,EXTR_PREFIX_SAME,'data');
		else
			$data=$_data_;
		if($_return_)
		{
			ob_start();
			ob_implicit_flush(false);
			require($_viewFile_);
			return ob_get_clean();
		}
		else
			require($_viewFile_);
	}

	/**
	 * Converts a word to its plural form.
	 * @param string the word to be pluralized
	 * @return string the pluralized word
	 */
	public function pluralize($name)
	{
		$rules=array(
			'/(x|ch|ss|sh|us|as|is|os)$/i' => '\1es',
			'/(?:([^f])fe|([lr])f)$/i' => '\1\2ves',
			'/(m)an$/i' => '\1en',
			'/(child)$/i' => '\1ren',
			'/(r)y$/i' => '\1ies',
			'/s$/' => 's',
		);
		foreach($rules as $rule=>$replacement)
		{
			if(preg_match($rule,$name))
				return preg_replace($rule,$replacement,$name);
		}
		return $name.'s';
	}

}