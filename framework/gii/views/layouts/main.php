<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo $this->module->assetsBaseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->module->assetsBaseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo $this->module->assetsBaseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo $this->module->assetsBaseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->module->assetsBaseUrl; ?>/css/form.css" />

	<title>Gii module for <?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo">Gii module for <?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('gii.components.MainMenu',array(
			'items'=>array(
				array('label'=>'Gii', 'url'=>array('/gii')),
				array('label'=>'Login', 'url'=>array('/gii/default/login'), 'visible'=>$this->module->user->isGuest),
				array('label'=>'Logout ('.$this->module->user->name.')', 'url'=>array('/gii/default/logout'), 'visible'=>!$this->module->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->

	<div class="container" id="content">
	<?php if(!$this->module->user->isGuest){ ?>
		<div id="leftmenu" class="span-4">
			<?php $this->widget('gii.components.GeneratorsList')?>
		</div>
		<div class="span-20 last" >
			<?php echo $content; ?>
		</div>
	<?php }else{ ?>
		<div class="span-24 last inner" >
			<?php echo $content; ?>
		</div>
	<?php } ?>
	</div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>