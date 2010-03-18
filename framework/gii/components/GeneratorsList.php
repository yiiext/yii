<?php
class GeneratorsList extends CMenu
{
	public $items=array();
	
	/**
	 * Normalizes the {@link items} property so that the 'active' state is properly identified for every menu item.
	 * @param array the items to be normalized.
	 * @param string the route of the current request.
	 * @param boolean whether there is an active child menu item.
	 * @return array the normalized menu items
	 */
	protected function normalizeItems($items,$route,&$active)
	{
		$generatorsList = array();
		$generators = $this->getController()->getModule()->generators;
		$newItems = array();
		foreach($generators as $key=>$generator){
			$name = (is_array($generator) && isset($generator['title']))?$generator['title']:$key;
			$url = $this->getController()->createUrl('/gii/default/generate', array('g'=>$key));
			$newItems[] = array('label'=>$name, 'url'=>$url, 'active'=>$this->isActive($key));
		}
		return parent::normalizeItems($newItems, $route, $active);
	}
	
	/**
	 * Checks if the $generator is active
	 * @param string $generator
	 * @return boolean whether the generator is active
	 */
	protected function isActive($generator)
	{
		return isset($_GET['g']) && strcmp($_GET['g'],$generator)==0;
	}
}