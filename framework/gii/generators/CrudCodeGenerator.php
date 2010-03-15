<?php
class CrudCodeGenerator	 extends CCodeGenerator {
	
	public $title = 'CRUD Generator';
	
	public function getFilesToGenerate(){
		return array();
	}

	public function generate($files, $log){
		return false;
	}
	
	public function getHelp(){
		return "<h3>Parameters description:</h3>
				 	<p><strong>Controller ID:</strong> (required)<br/>
				 	Controller ID, <em>e.g., 'post'</em>.<br/>
				 	If the controller should be located under a subdirectory, please specify the controller ID 
				 	as <em>'path/to/ControllerID', e.g., 'admin/user'.</em><br/>
				    If the controller belongs to a module, please specify
				    the controller ID as <em>'ModuleID/ControllerID' or
				    'ModuleID/path/to/Controller'</em> (assuming the controller is
				    under a subdirectory of that module).</p>
					<h3>EXAMPLES</h3>
				 	<ul>
				 		<li>Generates the 'post' controller:<br/>Controller: <em>post</em></li>
				 		<li>Generates the 'post' controller which should be located under the 'admin' subdirectory of the base controller path:<br />Controller <em>admin/post</em></li>
				 		<li>Generates the 'post' controller which should belong to the 'admin' module:<br/>Controller <em>admin/post</em></li>
				 	</ul>
					<p><em>NOTE: in the last two examples, the commands are the same, but
				the generated controller file is located under different directories.
				Yii is able to detect whether 'admin' refers to a module or a subdirectory.</em></p>
				";
	}
}