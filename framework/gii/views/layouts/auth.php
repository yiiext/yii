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
	<link rel="stylesheet" type="text/css" href="<?php echo $this->module->assetsBaseUrl; ?>/css/auth.css" />
	
	<title>Gii module for <?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo">Gii login for <?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div class="container" id="content">
		<?php echo $content; ?>
	</div>

	<div id="footer">
		Gii - The Yii framework code generator<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>