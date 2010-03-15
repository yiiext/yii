<?php $this->pageTitle= 'Gii - ' . Yii::app()->name . ' - Controller generator'; ?>
<div class="span-14">
<h1>Gii <?php echo $generator->getTitle(); ?></h1>

<p>This command generates a controller and views associated with the specified actions:</p>

<?php if ($this->module->user->hasFlash('success')){ ?>
<div class="success">
	<?php echo $this->module->user->getFlash('success'); ?>
</div>
<?php } ?>
<h3>Results:</h3>
<p>Parameters: <?php echo $form->parameters; ?></p>
<pre><?php echo $logs;?></pre>
