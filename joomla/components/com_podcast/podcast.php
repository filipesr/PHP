<?php
/*
	Podcast Suite
	(c) 2005 - 2008 Joseph L. LeBlanc
	Released under the GPLv2 License
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class PodcastController extends JController
{
	function display()
	{
	//	JRequest::setVar('format', 'raw', 'get', true);
	//	$document =& JFactory::getDocument();
	//	$document->setType('raw');
		
		parent::display();
	}
}

$document =& JFactory::getDocument();
$document->setType('raw');

$controller = new PodcastController();
$controller->execute(JRequest::getVar('task', null));
$controller->redirect();