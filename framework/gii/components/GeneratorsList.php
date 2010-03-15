<?php
/**
 * MainMenu is a widget displaying main menu items.
 *
 * The menu items are displayed as an HTML list. One of the items
 * may be set as active, which could add an "active" CSS class to the rendered item.
 *
 * To use this widget, specify the "items" property with an array of
 * the menu items to be displayed. Each item should be an array with
 * the following elements:
 * - visible: boolean, whether this item is visible;
 * - label: string, label of this menu item. Make sure you HTML-encode it if needed;
 * - url: string|array, the URL that this item leads to. Use a string to
 *   represent a static URL, while an array for constructing a dynamic one.
 * - pattern: array, optional. This is used to determine if the item is active.
 *   The first element refers to the route of the request, while the rest
 *   name-value pairs representing the GET parameters to be matched with.
 *   When the route does not contain the action part, it is treated
 *   as a controller ID and will match all actions of the controller.
 *   If pattern is not given, the url array will be used instead.
 */
class GeneratorsList extends CWidget
{
	public $items=array();

	public function run(){
		$generatorsList = array();
		$generators = $this->getController()->getModule()->generators;
		$items = array();
		foreach($generators as $key=>$generator){
			$name = (is_array($generator) && isset($generator['title']))?$generator['title']:$key;
			$url = $this->getController()->createUrl('/gii/default/generate', array('g'=>$key));
			$items[] = array('label'=>$name, 'url'=>$url, 'active'=>$this->isActive($key));
		}
		
		$this->render('leftMenu', array('items'=>$items));
	}

	/**
	 * Checks if the actual key is the same as the selected controller
	 * @param string $key
	 * @return boolean
	 */
	protected function isActive($key)
	{
		return isset($_GET['g']) && strcmp($_GET['g'],$key)==0;
	}
}