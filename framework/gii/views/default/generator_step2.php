<?php $this->pageTitle= 'Gii - ' . Yii::app()->name . ' - Controller generator'; ?>
<div class="span-14">
<h1>Gii <?php echo $generator->getTitle(); ?></h1>

<p>This command generates a controller and views associated with the specified actions:</p>

<?php if ($this->module->user->hasFlash('success')){ ?>
<div class="success">
	<?php echo $this->module->user->getFlash('success'); ?>
</div>
<?php } ?>

<?php echo CHtml::beginForm();?>
<?php echo CHtml::activeHiddenField($form, 'parameters'); ?>
<div class="form">
	<div class="row">
		<?php echo CHtml::activeLabel($fileListForm, 'fileList'); ?>
		<?php echo CHtml::activeCheckBoxList($fileListForm, 'fileList', $files); ?>
	</div>
	<div class="button">
		<?php echo CHtml::submitButton("Generate"); ?>
	</div>
</div>
<?php echo CHtml::endForm();?>
</div>
<div class="span-6 last help">
	<?php echo $generator->getHelp(); ?>
</div>