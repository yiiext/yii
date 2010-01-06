<?php $this->pageTitle= 'Gii - ' . Yii::app()->name . ' - Controller generator'; ?>
<div class="span-14">
<h1>Gii controller generator</h1>

<p>This command generates a controller and views associated with the specified actions:</p>

<?php if ($this->module->user->hasFlash('success')){ ?>
<div class="success">
	<?php echo $this->module->user->getFlash('success'); ?>
</div>
<?php } ?>
<div class="form">
<?php echo CHtml::beginForm(); ?>

	<?php echo CHtml::errorSummary($form); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<?php echo CHtml::activeLabelEx($form,'controller'); ?>
		<?php echo CHtml::activeTextField($form,'controller') ?>
	</div>

	<div class="row">
		<?php echo CHtml::activeLabelEx($form,'actions'); ?>
		<?php echo CHtml::activeTextField($form,'actions') ?><em> separated by commas</em>
	</div>

	<p class="note">Example: <strong>index,create,delete,update</strong></p>

	<div class="row">
		<?php echo CHtml::activeCheckBox($form,'overwrite') ?>
		<?php echo CHtml::activeLabelEx($form,'overwrite'); ?>
	</div>
	<div class="row submit">
		<?php echo CHtml::submitButton('Generate'); ?>
	</div>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->

</div>
<div class="span-6 last help">
	<h4>Parameters description:</h4>
 	<p><strong>Controller ID:</strong> (required)<br/>
 	Controller ID, <em>e.g., 'post'</em>.<br/>
 	If the controller should be located under a subdirectory, please specify the controller ID 
 	as <em>'path/to/ControllerID', e.g., 'admin/user'.</em><br/>
    If the controller belongs to a module, please specify
    the controller ID as <em>'ModuleID/ControllerID' or
    'ModuleID/path/to/Controller'</em> (assuming the controller is
    under a subdirectory of that module).</p>
	<h4>EXAMPLES</h4>
 	<ul>
 		<li>Generates the 'post' controller:<br/>Controller: <em>post</em></li>
 		<li>Generates the 'post' controller which should be located under the 'admin' subdirectory of the base controller path:<br />Controller <em>admin/post</em></li>
 		<li>Generates the 'post' controller which should belong to the 'admin' module:<br/>Controller <em>admin/post</em></li>
 	</ul>
	<p><em>NOTE: in the last two examples, the commands are the same, but
the generated controller file is located under different directories.
Yii is able to detect whether 'admin' refers to a module or a subdirectory.</em></p>

</div>