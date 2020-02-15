<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// this is for the definition of _JC_DB
define('_JC_PATH',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jcollection');
require_once (_JC_PATH.DS.'config.jcollection.php');

jimport( 'joomla.plugin.plugin' );

/**
 * JCollection Rating plugin
 */
class plgJCollectionListcat extends JPlugin
{
	/**
	 * Constructor
	 *
	 * For php4 compatibility we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @access	protected
	 * @param	object	$subject The object to observe
	 * @param 	array   $config  An array that holds the plugin configuration
	 * @since	1.0
	 */
	function plgJCollectionListcat( &$subject, $config )
	{
		parent::__construct( $subject, $config );

		// Do some extra initialisation in this constructor if required
	}

	/**
	 * Do something onAfterInitialise
	 */
	function onAfterInitialise()
	{
		// Perform some action
	}

	/**
	 * Return the html source for the lists (before)
	 * @param $item object
	 * @param $params object
	 * @return string The html source
	 */

	function onBeforeDisplayItem( &$item, &$params )
	{
		$id = $item->id;
		$html = '';

		$listcats = $this->params->get( 'toplistcats', '' );
		if( $listcats && $params->get( 'show_toplists', 0 ) )
		{
			$html .= $this->_getListcats( $listcats, $id );
		}

		return $html;
	}

	/**
	 * Return the html source for the lists (after)
	 * @param $item object
	 * @param $params object
	 * @return string The html source
	 */
	function onAfterDisplayItem( &$item, &$params )
	{
		$id = $item->id;
		$html = '';

		$listcats = $this->params->get( 'bottomlistcats', '' );
		if( $listcats && $params->get( 'show_bottomlists', 0 ) )
		{
			$html .= $this->_getListcats( $listcats, $id );
		}

		return $html;
	}

	function _getListcats( $listcats, $id )
	{
		$html = '';
		if( $listcats )
		{
			$db = &JFactory::getDBO();
			$listcats = explode( ',', $listcats );
			JArrayHelper::toInteger( $listcats );
			$listcats = array_unique( $listcats );

			if( count( $listcats ) ) {
				if( $listcats[0] == -1 ) {
					$query = 'SELECT DISTINCT i.catid '
					."\n FROM #__"._JC_DB."_item2list AS l "
					."\n LEFT JOIN #__"._JC_DB."_list AS i ON i.id=l.listid "
					."\n WHERE l.itemid = ".intval( $id )
					."\n ORDER BY l.ordering"
					;
					$db->setQuery( $query );
					$listcats = $db->loadResultArray();
				}
			}

			if( count( $listcats ) )
			{
				foreach($listcats as $listcat)
				{
					$query = $this->_buildListsQuery( $listcat, $id );
					$db->setQuery( $query );
					$lists = $db->loadObjectList();

					$clists = count( $lists );
					if( $clists )
					{
						$html .= "<br />\n";
						$html .= "<b>".$lists[0]->catname."</b>: ";
						for( $i = 0; $i < $clists; $i++ )
						{
							$list = &$lists[$i];
							$listlink = JRoute::_( 'index.php?option=com_jcollection&view=list&listid='.$list->slug );
							$html .= '<a href="'.$listlink.'">'.htmlspecialchars( $list->name ).'</a>';
							if( $i < $clists-1 ) {
								$html .= '&nbsp;/&nbsp;';
							}
						}
					}
				}
			}
		}
		return $html;
	}

	function _buildListsQuery( $listcatid = -1, $itemid = 0 )
	{
		$where = $this->_buildListsWhere( $listcatid, $itemid );
		$order = $this->_buildListsOrder();

		$query = 'SELECT l.listid,l.itemid,i.*,c.name AS catname, '
		."\n CASE WHEN CHAR_LENGTH(i.alias) THEN CONCAT_WS(\":\", i.id, i.alias) ELSE i.id END AS slug, "
		."\n CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(\":\", c.id, c.alias) ELSE c.id END AS catslug "
		."\n FROM #__"._JC_DB.'_item2list AS l '
		."\n LEFT JOIN #__"._JC_DB."_list AS i ON i.id=l.listid "
		."\n LEFT JOIN #__"._JC_DB."_listcat AS c ON c.id=i.catid "
		.$where
		.$order;
		return $query;
	}

	function _buildListsWhere( $listcatid, $itemid )
	{
		$user =& JFactory::getUser();
		$aid = (int) $user->get( 'aid', 0 );
		$uid = (int) $user->get( 'id', 0 );
		$where = array();
		$where[] = '( l.itemid = '.intval($itemid).' )';
		if( (int)$listcat != -1 ) {
			$where[] = '( i.catid = '.$listcatid.' )';
		}
		if( !$user->authorize( 'com_jcollection', 'edit', 'cat', 'all' ) )
		{
			$where[] = '( ( c.published = 1 AND c.approved = 1 ) OR ( c.created_by = '.$uid.' ) )';
		}
		$where[] = '( c.access <= '.$aid.' )';
		if( !$user->authorize( 'com_jcollection', 'edit', 'item', 'all' ) )
		{
			$where[] = '( ( i.published = 1 AND i.approved = 1 ) OR ( i.created_by = '.$uid.' ) )';
		}
		$where[] = '( i.access <= '.$aid.' )';

		return ( count( $where ) ? ' WHERE '.implode( ' AND ', $where ) : '' );
	}

	function _buildListsOrder()
	{
		$order = 'ORDER BY l.ordering ASC';
		return $order;
	}

}

?>
