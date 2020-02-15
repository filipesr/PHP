<?php
/**
 * Collection Manager Item Model
 *
 * @version $Id$
 * @package Collection.Manager
 * @subpackage com_collection
 * @author Thorsten Riess
 * @copyright Copyright (C) 2008 T. Riess. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

// this is for the definition of _JC_DB
define('_JC_PATH',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jcollection');
require_once (_JC_PATH.DS.'config.jcollection.php');

jimport( 'joomla.application.component.model' );

/**
 * Collection Item Model
 *
 * @package com_collection
 */
class JCollectionModelItem extends JModel
{
	/**
	 * The current item id
	 * @var int
	 */
	var $_id = null;

	/**
	 * The data (i.e. item row plus corresponsing rating and info field(s)
	 * @var object
	 */
	var $_data = null;

	/**
	 * Constructor that retrieves the ID from the request
	 *
	 * @access	public
	 * @return	void
	 */
	function __construct()
	{
		parent::__construct();

		$this->loadIdFromRequest();
	}

	/**
	 * Method to set the hello identifier
	 *
	 * @access	public
	 * @param	int Hello identifier
	 * @return	void
	 */
	function setId( $id )
	{
		// Set id and wipe data
		$this->_id = $id;
		$this->_data = null;

	}

	function getId()
	{
		if( !$this->_id ) {
			$this->loadIdFromRequest();
		}
		return $this->_id;
	}

	function getCreated_by()
	{
		if( !$this->_id ) {
			$this->loadIdFromRequest();
		}
		if( !$this->_data ) {
			$this->getData();
		}
		if( $this->_data ) {
			return $this->_data->created_by;
		} else {
			return null;
		}
	}

	/**
	 * Method to reload id from the request variable
	 */
	function loadIdFromRequest()
	{
		$id = JRequest::getInt( 'id',  0 );
		$this->setId( $id );
	}

	/**
	 * Method to get an item
	 * @return object with item
	 */
	function &getData()
	{
		// Load the data
		if (empty( $this->_data )) {
			global $option;

			$task = JRequest::getVar('task', null, 'default', 'cmd');

			if( $task == 'edit' )
			{
				$query = $this->_buildQuery();
				$this->_db->setQuery( $query );
				$this->_data = $this->_db->loadObject();
			} else {
				$dispatcher =& JDispatcher::getInstance();
				JPluginHelper::importPlugin( 'jcollection' );

				$user =& JFactory::getUser();
				$aid = (int) $user->get( 'aid', 0 );
				$uid = (int) $user->get( 'id', 0 );
				$gid = (int) $user->get( 'gid', 0 );

				$query = $this->_buildQuery();
				$this->_db->setQuery( $query );
				$this->_data = $this->_db->loadObject();

				if ( ( !$user->authorize( 'com_jcollection', 'edit', 'item', 'all' ) ) && ( !$this->_data->published || !$this->_data->approved ) && $this->_data->created_by != $uid )
				{
					JError::raiseError( 404, JText::_( "Resource Not Found" ) );
					return false;
				}

				if( $this->_data->access > $aid ) {
					JError::raiseError( 403, JText::_( "ALERTNOTAUTH" ) );
					return false;
				}

				$query = $this->_buildInfosQuery();
				$this->_db->setQuery( $query );
				$this->_data->infos = $this->_db->loadObjectList();

				// collect the reviews of each info set
				$revparamsdefs = _JC_PATH.DS.'models'.DS.'rev.xml';
				$cinfos = count( $this->_data->infos );
				for( $i = 0; $i < $cinfos; $i++ ) {
					$info = &$this->_data->infos[$i];
					$query = $this->_buildReviewsQuery( (int)$info->id );
					$this->_db->setQuery( $query );
					$info->revs = $this->_db->loadObjectList();

					$crevs = count( $info->revs );
					for( $j = 0; $j < $crevs; $j++ )
					{
						$rev = &$info->revs[$j];
						$revparamsdata = $rev->params;
						$revparams = new JParameter( $revparamsdata, $revparamsdefs );
						$rev->params = $revparams;
					}
				}

				$params = &JComponentHelper::getParams( $option );

				$cats = array();
				$actcat = $this->_data->catid;
				while($actcat) {
					$query = 'SELECT *, '
					."\n CASE WHEN CHAR_LENGTH(alias) THEN CONCAT_WS(\":\", id, alias) ELSE id END AS slug"
					."\n FROM #__"._JC_DB.'_cat '
					."\n WHERE id=".(int)$actcat;
					$this->_db->setQuery( $query );
					$cat = $this->_db->loadObject();
					if ( ( !$user->authorize( 'com_jcollection', 'edit', 'cat', 'all' ) ) && ( !$cat->published || !$cat->approved ) && ( $cat->created_by != $uid ) )
					{
						JError::raiseError( 404, JText::_( "Resource Not Found" ) );
						return false;
					}
					if( $cat->access > $aid ) {
						JError::raiseError( 403, JText::_( "ALERTNOTAUTH" ) );
						return false;
					}
					$cats[] = $cat;
					$actcat = $cat->parent;
				}
				$cats = array_reverse($cats);
				$this->_data->cats = $cats;
				foreach($cats as $cat) {
					$catparamsdata = $cat->params;
					$catparamsdefs = _JC_PATH.DS.'models'.DS.'category.xml';
					$catparams = new JParameter( $catparamsdata, $catparamsdefs );
					$params->merge( &$catparams );
				}

				$itemparamsdata = $this->_data->params;
				$itemparamsdefs = _JC_PATH.DS.'models'.DS.'item.xml';
				$itemparams = new JParameter( $itemparamsdata, $itemparamsdefs );

				$params->merge( &$itemparams );

				$this->_data->params = $params;

				$ws_model = &JModel::getInstance('webserviceitem','JCollectionModel');
				$services = JCollectionHelper::getWebservices();
				$infotags = array();
				for($j = 1; $j<=10; $j++) {
					$infotags[] = '{INFO'.$j.'}';
				}

				$conf = &JFactory::getConfig();
				$lifetime = $params->get( 'item_cache_time', $conf->getValue( 'config.cachetime' ) ) * 60;
				$cache = &JFactory::getCache( 'com_jcollection_wsitem' );
				$cache->setCaching( 1 );
				$cache->setLifeTime( $lifetime );

				for($i=0;$i<count($this->_data->infos);$i++)
				{
					$info = &$this->_data->infos[$i];

					$infoparamsdata = $info->params;
					$infoparamsdefs = _JC_PATH.DS.'models'.DS.'info.xml';
					$infoparams = new JParameter( $infoparamsdata, $infoparamsdefs );

					$info->params = $infoparams;

					foreach ( $services as $service ) {
						$wsitemname = $service.'item';
						$ws_data = $infoparams->get( $wsitemname );
						$info->$wsitemname = $ws_data;
						if($ws_data) {
							$data = $cache->get( array( $ws_model, 'findId' ), array( $info->id, $ws_data, $service, $info->typeid ) );

							// without cache
							//$data = $ws_model->findId($info->id,$ws_data,$service);
							////$data = $ws_model->getData();
							$xml = $data->xml;
							if($xml) {
								$dataname = $service.'data';
								$info->$dataname = $data;
							}
						}
					}
					$infonames = array();
					for($j = 1; $j<=10; $j++ ) {
						$infonames[] = 'info'.$j;
					}
					$infonames[] = 'title';
					$infonames[] = 'description';
					$infonames[] = 'img';
					$infonames[] = 'url';

					$allservices = implode( ',', $services );
					$defaultoverwrite = $params->get( 'webserviceoverwrite', $allservices );

					foreach($infonames as $infoname ) {
						$overwritename = $infoname.'overwrite';
						$infooverwrite = $infoparams->get( $overwritename, $defaultoverwrite );
						$info->$overwritename = $infooverwrite;
						if( $infooverwrite ) {
							$overwrite = explode(',',$infooverwrite);
							foreach( $overwrite as $o )
							{
								$dataname = $o.'data';
								if( $info->$dataname->$infoname ) {
									$info->$infoname = $info->$dataname->$infoname;
									break;
								}
							}
						}
					}
					// additional fields / disclaimer
					// TODO: order!
					$info->additional_fields_sets = array();
					$info->disclaimer = array();
					$info->offers_sets = array();
					$info->similar_datas_sets = array();
					$info->reviews_sets = array();
					foreach ( $services as $service ) {
						$dataname = $service.'data';
						if(is_array($info->$dataname->additional_field_sets) && count($info->$dataname->additional_fields_sets)) {
							$info->additional_fields_sets = array_merge($info->additional_fields_sets, $info->$dataname->additional_fields_sets);
						}
						if(is_array($info->$dataname->disclaimer) && count($info->$dataname->disclaimer)) {
							$info->disclaimer = array_merge( $info->disclaimer, $info->$dataname->disclaimer);
						}
						if(is_array($info->$dataname->offers_sets) && count($info->$dataname->offers_sets)) {
							$info->offers_sets = array_merge($info->offers_sets, $info->$dataname->offers_sets);
						}
						if(is_array($info->$dataname->similar_datas_sets) && count($info->$dataname->similar_datas_sets)) {
							$info->similar_datas_sets = array_merge($info->similar_datas_sets, $info->$dataname->similar_datas_sets);
						}
						if(is_array($info->$dataname->reviews_sets) && count($info->$dataname->reviews_sets)) {
							$info->reviews_sets = array_merge($info->reviews_sets, $info->$dataname->reviews_sets);
						}
					}

					/*
					 // special treatment of amazon links to include the correct partnerid
					 if( key_exists( 'amazondata', $info ) )
					 {
						$c = substr($info->amazondata->ws_id,0,2);

						$partnerid = $params->get('amazonpartnerid_'.$c);
						$per = (int)$params->get('amazonpartnerid');
						$r = rand(0,100);
						if($r<=$per || !$partnerid) {
						switch($c) {
						case 'us':
						$partnerid = 'com_collection-20';
						break;
						case 'de':
						$partnerid = 'com_collection-21';
						break;
						case 'uk':
						$partnerid = 'com_collectionuk-21';
						break;
						case 'ca':
						$partnerid = 'com_collectionca-20';
						break;
						case 'fr':
						case 'jp':
						default:
						$partnerid = 'ws';
						break;
						}
						}
						if($partnerid) {
						$p = 'tag%3D'.$partnerid;
						if(strstr($info->url,'%26tag%3Dws%26')) {
						$info->url = str_replace('%26tag%3Dws%26','%26'.$p.'%26',$info->url);
						}
						for($j = 0; $j<count($info->similar_datas_sets); $j++) {
						$sitemset = &$info->similar_datas_sets[$j];
						for($k = 0; $k<count($sitemset->similar_datas); $k++) {
						$sitem = &$sitemset->similar_datas[$k];
						if(strstr($sitem->url,'?tag=ws')) {
						$sitem->url = str_replace('?tag=ws','?'.$p,$sitem->url);
						}
						}
						}
						for($j = 0; $j<count($info->offers_sets); $j++) {
						$offerset = &$info->offers_sets[$j];
						for($k = 0; $k<count($offerset->offers); $k++) {
						$offer = &$offerset->offers[$k];
						if(strstr($offer->url,'%26tag%3Dws%26')) {
						$offer->url = str_replace('%26tag%3Dws%26','%26'.$p.'%26',$offer->url);
						}
						}
						}
						}
						}
						*/

					$infovals = array();
					for($j = 1; $j<=10; $j++) {
						$infoname = 'info'.$j;
						$infovals[] = $info->$infoname;
					}
					for($j = 1; $j<=10; $j++) {
						$infoname = 'info'.$j;
						$infohtmlname = $infoname.'html';
						$info->$infoname = str_replace($infotags, $infovals, $info->$infohtmlname);
					}

				}
				$titleoverwrite = $itemparams->get('titleoverwrite');
				$descriptionoverwrite = $itemparams->get('descriptionoverwrite');
				$imgoverwrite = $itemparams->get('imgoverwrite');
				$urloverwrite = $itemparams->get('urloverwrite');
				if( $titleoverwrite && ( $title = @$this->_data->infos[(int)$titleoverwrite-1]->title ) ) {
					$this->_data->name = $title;
				}
				if( $descriptionoverwrite && ( $desc = @$this->_data->infos[(int)$descriptionoverwrite-1]->description ) ) {
					$this->_data->description = $desc;
				}
				if( $imgoverwrite && ( $img = @$this->_data->infos[(int)$imgoverwrite-1]->img ) ) {
					$this->_data->img = $img;
				}
				if( $urloverwrite && ( $url = @$this->_data->infos[(int)$urloverwrite-1]->url ) ) {
					$this->_data->url = $url;
				}
			}
		}
		if (!$this->_data) {
			$user = &JFactory::getUser();
			$uid = $user->get( 'id', 0 );
			$this->_data = new stdClass();
			$this->_data->id = 0;
			$this->_data->catid = JRequest::getInt('catid', 0);
			$this->_data->name = null;
			$this->_data->description = null;
			$this->_data->img = null;
			$this->_data->alias = null;
			$this->_data->date = null;
			$this->_data->created_by = $uid;
			$this->_data->created_by_alias = null;
			$this->_data->modified = null;
			$this->_data->modified_by = null;
			$this->_data->published = null;
			$this->_data->approved = null;
			$this->_data->checked_out = null;
			$this->_data->checked_out_time = null;
			$this->_data->ordering = null;
			$this->_data->params = null;
			$this->_data->hits = null;
			$this->_data->cats = null;

			$this->_data->infos = null;
			$this->_data->lists = null;
			$this->_data->bottomlistsets = array();
			$this->_data->toplistsets = array();
		}
		return $this->_data;
	}

	function isCheckedOut( $uid = null )
	{
		if ( !$this->_data->id )
		{
			$this->loadIdFromRequest();
			$this->getData();
			if ( $uid ) {
				return ($this->_data->checked_out && $this->_data->checked_out != $uid);
			} else {
				return $this->_data->checked_out;
			}
		} else {
			return false;
		}

	}

	function checkout( $uid = null )
	{
		if ( $this->_id )
		{
			// Make sure we have a user id to checkout the article with
			if ( is_null( $uid ) ) {
				$user =& JFactory::getUser();
				$uid = $user->get( 'id' );
			}
			// Lets get to it and checkout the thing...
			$item = & JTable::getInstance( 'item', 'Table' );
			return $item->checkout( $uid, $this->_id );
		}
		return false;
	}

	/**
	 * Method to store an item including the info fields
	 *
	 * @access public
	 * @param data associative array with the item data, read from request variables if empty
	 * @return boolean true on success
	 */
	function store( &$data )
	{
		$row =& $this->getTable();

		/*
		if( !$data ) {
			$data = JRequest::get( 'post' );

			$desc = JRequest::getVar( 'description', '', 'post', 'string', JREQUEST_ALLOWRAW );
			$desc = str_replace( '<br>', '<br />', $desc );
			$data['description'] = $desc;
		}
		*/

		$user = &JFactory::getUser();

		if( !$user->authorize( 'com_jcollection', 'edit', 'item', 'all' ) )
		{
			if( !( $user->authorize( 'com_jcollection', 'edit', 'item', 'own' ) && ( $data['id'] == 0 || $data['created_by'] == $uid ) ) )
			{
				JError::raiseError( 403, JText::_("ALERTNOTAUTH") );
				return;
			}
		}

		if( !$user->authorize( 'com_jcollection', 'publish' ) )
		{
			if( $data['id'] )
			{
				$data['published'] = 0;
			} else {
				$query = "SELECT published "
				."\n FROM #__"._JC_DB." "
				."\n WHERE id = ".(int)$data['id']
				;
				$this->_db->setQuery( $query );
				$data['published'] = $this->_db->loadResult();
			}
		}

		if( !$user->authorize( 'com_jcollection', 'approve' ) )
		{
			if( $data['id'] )
			{
				$data['approved'] = 0;
			} else {
				$query = "SELECT approved "
				."\n FROM #__"._JC_DB." "
				."\n WHERE id = ".(int)$data['id']
				;
				$this->_db->setQuery( $query );
				$data['approved'] = $this->_db->loadResult();
			}
		}

		$datenow = & JFactory::getDate();
		if( empty( $data['date'] ) ) {
			$data['date'] = $datenow->toMySQL();
		} else {
			$data['modified'] = $datenow->toMySQL();
			$data['modified_by'] = $uid;
		}

		// Bind the form fields to the item table
		if ( !$row->bind( $data ) ) {
			$this->setError( $this->_db->getErrorMsg() );
			return false;
		}

		// Make sure the item record is valid
		if ( !$row->check() ) {
			$this->setError( $row->getError() );
			return false;
		}

		// Store the item to the database
		if ( !$row->store() ) {
			$this->setError( $row->getError() );
			return false;
		}

		// Set the correct id if the item is new
		if( $data['id'] == 0 ) {
			$this->_data->id = $row->id;
			$this->_id = $row->id;
			$data['id'] = $row->id;
		}

		return true;
	}

	/**
	 * Method to delete item(s) (including ratings and info fields
	 *
	 * @access public
	 * @param cids array with item ids to be deleted. If empty, use the current _id
	 * @return boolean True on success
	 */
	function delete( $cids=null )
	{
		if(is_integer($cids)) {
			$cids = array($cids);
		} else if(!$cids && $this->_id) {
			$cids = array($this->_id);
		}

		if (count( $cids ))
		{
			$row =& $this->getTable();
			foreach($cids as $cid) {
				if (!$row->delete( $cid )) {
					$this->setError( $row->getError() );
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Method to publish item(s) (_not_ including info fields!)
	 *
	 * @access public
	 * @param cids array with item ids to be published. If empty, use the current _id
	 * @param publish 0 - unpublish, 1 - publish
	 * @return boolean True on success
	 */
	function publish( $cids=null, $publish = 1 )
	{
		if(is_integer($cids)) {
			$cids = array($cids);
		} else if(!$cids && $this->_id) {
			$cids = array($this->_id);
		}

		if (count( $cids ))
		{
			$user =& JFactory::getUser();
			$row =& $this->getTable();
			foreach($cids as $cid) {
				if (!$row->publish( $cid, $publish, $user->id )) {
					$this->setError( $row->getError() );
					return false;
				}
			}
		}
		return true;
	}

	function _buildQuery()
	{
		$where = $this->_buildWhere();
		$url = JURI::root() . 'images/jcollection/';
		$query = " SELECT *, "
		."\n CASE WHEN CHAR_LENGTH(alias) THEN CONCAT_WS(\":\", id, alias) ELSE id END AS slug, "
		."\n CASE WHEN ( ( LENGTH(img)>0 ) AND ( SUBSTRING( img, 1, 7 ) <> 'http://' ) AND ( SUBSTRING( img, 1, 8 ) <> 'https://' ) ) THEN CONCAT( \"".$url."\", img ) ELSE img END AS image "
		."\n FROM #__"._JC_DB
		.$where;

		return $query;
	}

	function _buildWhere()
	{
		//$user =& JFactory::getUser();
		//$aid = (int) $user->get( 'aid', 0);
		//$uid = (int) $user->get( 'id', 0 );
		$where = array();
		$where[] = '( id = '.intval( $this->_id ).' )';
		//if( !$user->authorize( 'com_jcollection', 'edit', 'item', 'all' ) )
		//{
		//	$where[] = '( ( published = 1 AND approved = 1 ) OR ( created_by = '.$uid.' ) )';
		//}
		// not neccessary - the access level will be checked in getData
		//$where[] = '( access <= '.$aid.' )';

		return ( count( $where ) ? ' WHERE '.implode( ' AND ', $where ) : '' );
	}

	function _buildInfosQuery()
	{
		$where = $this->_buildInfosWhere();
		$order = $this->_buildInfosOrder();
		$query = ' SELECT i.*,'
		."\n t.info1label,t.info2label,t.info3label,t.info4label,"
		."\n t.info5label,t.info6label,t.info7label,t.info8label,t.info9label,"
		."\n t.info10label,"
		."\n t.info1html,t.info2html,t.info3html,t.info4html,t.info5html,t.info6html,"
		."\n t.info7html,t.info8html,t.info9html,t.info10html,"
		."\n t.rating1label,t.rating2label,t.rating3label,t.rating4label,t.rating5label,"
		."\n CASE WHEN r.ratingcount1>0 THEN ROUND( r.ratingsum1/r.ratingcount1 ) ELSE 0 END AS rating1,"
		."\n CASE WHEN r.ratingcount2>0 THEN ROUND( r.ratingsum2/r.ratingcount2 ) ELSE 0 END AS rating2, "
		."\n CASE WHEN r.ratingcount3>0 THEN ROUND( r.ratingsum3/r.ratingcount3 ) ELSE 0 END AS rating3, "
		."\n CASE WHEN r.ratingcount4>0 THEN ROUND( r.ratingsum4/r.ratingcount4 ) ELSE 0 END AS rating4, "
		."\n CASE WHEN r.ratingcount5>0 THEN ROUND( r.ratingsum5/r.ratingcount5 ) ELSE 0 END AS rating5, "
		."\n r.ratingcount1, r.ratingcount2, r.ratingcount3, r.ratingcount4, r.ratingcount5"
		."\n FROM #__"._JC_DB."_info AS i "
		."\n LEFT JOIN #__"._JC_DB."_type AS t ON t.id=i.typeid "
		."\n LEFT JOIN #__"._JC_DB."_rating AS r ON r.infoid=i.id "
		.$where
		.$order;
		return $query;
	}

	function _buildInfosWhere()
	{
		$where = array();
		$where[] = '( i.itemid = '.intval($this->_id).' )';
		return ( count( $where ) ? ' WHERE '.implode( ' AND ', $where ) : '' );
	}

	function _buildInfosOrder()
	{
		$order = ' ORDER BY i.ordering ASC';
		return $order;
	}

	function _buildReviewsQuery( $infoid )
	{
		$where = $this->_buildReviewsWhere( $infoid );
		$order = $this->_buildReviewsOrder();
		$query = "SELECT e.*, "
		."\n t.rating1label,t.rating2label,t.rating3label,t.rating4label,t.rating5label, "
		."\n r.rating1, r.rating2, r.rating3, r.rating4, r.rating5, "
		."\n r.useful_yes, r.useful_no, m.id AS itemid "
		."\n FROM #__"._JC_DB."_review AS e "
		."\n LEFT JOIN #__"._JC_DB."_info AS i ON i.id=e.infoid "
		."\n LEFT JOIN #__"._JC_DB." AS m ON m.id=i.itemid "
		."\n LEFT JOIN #__"._JC_DB."_type AS t ON t.id=i.typeid "
		."\n LEFT JOIN #__"._JC_DB."_reviewrating AS r ON r.reviewid=e.id "
		.$where
		.$order;

		return $query;
	}

	function _buildReviewsWhere( $infoid )
	{
		$user =& JFactory::getUser();
		$aid = (int) $user->get( 'aid', 0 );
		$uid = (int) $user->get( 'id', 0 );
		$where = array();
		$where[] = '( e.infoid = '.(int)$infoid.' )';
		if( !$user->authorize( 'com_jcollection', 'edit', 'rev', 'all' ) )
		{
			$where[] = '( ( e.published = 1 AND e.approved = 1 ) OR ( e.created_by = '.$uid.' ) )';
		}
		$where[] = '( e.access <= '.$aid.' )';

		return ( count( $where ) ? ' WHERE '.implode( ' AND ', $where ) : '' );
	}

	function _buildReviewsOrder()
	{
		$order = ' ORDER BY e.ordering ASC';
		return $order;
	}

}
?>
