<?php
/**
 * Install script for JCollection
 *
 * @package JCollection
 * @subpackage com_jcollection
 * @author Thorsten Riess
 * @copyright Copyright (C) 2009 T. Riess. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */


// no direct access
defined('_JEXEC') or die('Restricted access');

// this is for the definition of _JC_DB
define('_JC_PATH',JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jcollection');
require_once (_JC_PATH.DS.'config.jcollection.php');

/**
 * Parse the existing component XML file and extract the version string
 * @return string|false The version of the installed component
 */
function getVersion()
{
	$version = false;
	$xmlfile = _JC_PATH.DS.'jcollection.xml';
	if ( file_exists( $xmlfile ) )
	{
		$xml = &JFactory::getXMLParser( 'simple' );
		$xml->loadFile( $xmlfile );
		$doc = $xml->document;
		$vel = &$doc->getElementByPath( 'version' );
		if(is_a($vel, 'JSimpleXMLElement')) {
			$version = $vel->data();
		}
	}
	return $version;
}

/**
 * Install the files for JoomFish
 * TODO: update this
 */
function installJoomfishFiles() {
	if (file_exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'config.joomfish.php')) { // joomfish is installed
		@copy( JPATH_ADMINISTRATOR.DS.'components'.DS._JC_COMPNAME.DS.'contentelements'.DS.'jcollection.xml',
		JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.'jcollection.xml');
		@copy( JPATH_ADMINISTRATOR.DS.'components'.DS._JC_COMPNAME.DS.'contentelements'.DS.'translationJC_categoryFilter.php',
		JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.'translationJC_categoryFilter.php');
		@copy( JPATH_ADMINISTRATOR.DS.'components'.DS._JC_COMPNAME.DS.'contentelements'.DS.'jcollection_cat.xml',
		JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.'jcollection_cat.xml');
		@copy( JPATH_ADMINISTRATOR.DS.'components'.DS._JC_COMPNAME.DS.'contentelements'.DS.'jcollection_review.xml',
		JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.'jcollection_review.xml');
		@copy( JPATH_ADMINISTRATOR.DS.'components'.DS._JC_COMPNAME.DS.'contentelements'.DS.'jcollection_list.xml',
		JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.'jcollection_list.xml');
		$c = @copy( JPATH_ADMINISTRATOR.DS.'components'.DS._JC_COMPNAME.DS.'contentelements'.DS.'jcollection_type.xml',
		JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'contentelements'.DS.'jcollection_type.xml');
		if($c) {
			$warning = JText::_('JoomFish files installed');
			JError::raiseNotice(200, 'com_jcollection::installJoomfishFiles: '.$warning);
		} else {
			$warning = JText::_('JoomFish files could not be installed');
			JError::raiseNotice(200, 'com_jcollection::installJoomfishFiles: '.$warning);
		}
		echo "<br />\n";
	} else { // joomfish is not installed
		$warning = JText::_('JoomFish not found');
		JError::raiseNotice(200, 'com_jcollection::installJoomfishFiles: '.$warning);
	}
}

/**
 * Create the folder /images/jcollection
 */
function createImageFolder()
{
	if( !JFolder::exists(JPATH_ROOT.DS.'images'.DS.'jcollection' ) )
	{
		if( !JFolder::create( JPATH_ROOT.DS.'images'.DS.'jcollection' ) ) {
			$warning = JText::_('Could not create image folder');
			JError::raiseNotice(200, 'com_jcollection::createImageFolder: '.$warning);
		}
	}
}

/**
 * Check if webservices can be used
 */
function checkRemote()
{
	$url = "http://www.googel.com";
	$xmlstr = '';
	if(function_exists('curl_init')) {
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$xmlstr = @curl_exec($ch);
		curl_close($ch);
		if($xmlstr) {
			$notice = JText::_('Success loading remote files using cURL - good');
			JError::raiseNotice(200, 'com_jcollection::checkRemote: '.$notice);
		}
	}
	if(!$xmlstr && function_exists('file_get_contents')) {
		$xmlstr = @file_get_contents($url);
		if($xmlstr) {
			$notice = JText::_('Success loading remote files using file_get_contents - good');
			JError::raiseNotice(200, 'com_jcollection::checkRemote: '.$notice);
		}
	}
	if(!$xmlstr) {
		jimport('joomla.filesystem.file');
		$xmlstr = @JFile::read( $url );
		if($xmlstr) {
			$notice = JText::_('Success loading remote files using JFile (fopen) - good');
			JError::raiseNotice(200, 'com_jcollection::checkRemote: '.$notice);
		}
	}
	if(!$xmlstr) {
		$notice = JText::_('Could not access remote files - webservice access will NOT work! Check your PHP configuration/see FAQ.');
		JError::raiseNotice(200, 'com_jcollection::checkRemote: '.$notice);
	}
}

/**
 * Add some standard values to the tables
 */
function loadDefaults()
{
	$database = & JFactory::getDBO();

	$query = "INSERT INTO #__"._JC_DB."_type (`id`,`name`,`info1label`,`info2label`,`info3label`,`info4label`,`info5label`,`info6label`,`info7label`,`info8label`,`info9label`,`info10label`,`info1html`,`info2html`,`info3html`,`info4html`,`info5html`,`info6html`,`info7html`,`info8html`,`info9html`,`info10html`,`rating1label`,`rating2label`,`rating3label`,`rating4label`,`rating5label`,`ordering`) "
	."\n VALUES ('1','Book','Author','Publisher','Pages','Language','Binding','Released','','','','','{INFO1}','{INFO2}','{INFO3}','{INFO4}','{INFO5}','{INFO6}','{INFO7}','{INFO8}','{INFO9}','{INFO10}','Overall','','','','','1')"
	."\n ,('2','Movie','Director','Actors','Producer','Released','','','','','','','{INFO1}','{INFO2}','{INFO3}','{INFO4}','{INFO5}','{INFO6}','{INFO7}','{INFO8}','{INFO9}','{INFO10}','Overall','','','','','2')"
	."\n ,('3','Music','Artist','Publisher','Released','','','','','','','','{INFO1}','{INFO2}','{INFO3}','{INFO4}','{INFO5}','{INFO6}','{INFO7}','{INFO8}','{INFO9}','{INFO10}','Overall','','','','','3')"
	."\n ,('4','Game','Platform','Publisher','','','','','','','','','{INFO1}','{INFO2}','{INFO3}','{INFO4}','{INFO5}','{INFO6}','{INFO7}','{INFO8}','{INFO9}','{INFO10}','Overall','','','','','4')"
	."\n ,('5','Recipe','Amount','Ingredient','Amount','Ingredient','Amount','Ingredient','Amount','Ingredient','Amount','Ingredient','','{INFO1} {INFO2}','','{INFO3} {INFO4}','','{INFO5} {INFO6}','','{INFO7} {INFO8}','','{INFO9} {INFO10}','Overall','','','','','5')"
	."\n ,('6','Position','Street','City','ZIP','State','Country','Telefone','','','','Map','{INFO1}','{INFO2}','{INFO3}','{INFO4}','{INFO5}','{INFO6}','{INFO7}','{INFO8}','{INFO9}','<img src=\"{INFO10}\" />','','','','','','6')"
	;
	$database->setQuery($query);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}

	$amadis = $database->Quote('Some information/offers/reviews provided by <a href="http://www.amazon.com" target="_blank">Amazon</a>.');
	$ebaydis = $database->Quote('Some information/offers provided by <a href="http://www.ebay.com" target="_blank">eBay</a>.');
	$imdbdis = $database->Quote('Some information taken from <a href="http://www.imdb.com" target="_blank">imdb</a>.');
	$isbndbdis = $database->Quote('Some information provided by <a href="http://www.isbndb.com" target="_blank">ISBNdb</a>');
	$ymdis = $database->Quote('Map provided by <a href="http://www.yahoo.com" target="_blank">Yahoo</a>');
	$ydis = $database->Quote('Some information/offers provided by <a href="http://www.yahoo.com" target="_blank">Yahoo</a>.');
	$zanoxdis = $database->Quote('Some information/offers provided by <a href="http://www.zanox.com" target="_blank">Zanox</a>.');
	$gbdis = $database->Quote('Some information provided by <a href="http://books.google.com" target="_blank">Google books</a>.');
	$gmdis = $database->Quote('Map provided by <a href="http://maps.google.com" target="_blank">Google maps</a>.');
	$lfmdis = $database->Quote('Some information provided by <a href="http://last.fm" target="_blank">last.fm</a>.');

	$query = "INSERT INTO #__"._JC_DB."_webservicetype (`id`,`name`,`webservice`,`typeid`,`disclaimer`,`info1xpath`,`info2xpath`,`info3xpath`,`info4xpath`,`info5xpath`,`info6xpath`,`info7xpath`,`info8xpath`,`info9xpath`,`info10xpath`,`titlexpath`,`descriptionxpath`,`imgxpath`,`urlxpath`,`ordering`)"
	."\n VALUES ('1','Book','amazon',0,".$amadis.",'/ItemLookupResponse/Items/Item/ItemAttributes/Author,/ItemLookupResponse/Items/Item/ItemAttributes/Creator','/ItemLookupResponse/Items/Item/ItemAttributes/Publisher,/ItemLookupResponse/Items/Item/ItemAttributes/Manufacturer','','','','','','','','','/ItemLookupResponse/Items/Item/ItemAttributes/Title','','/ItemLookupResponse/Items/Item/LargeImage/URL,/ItemLookupResponse/Items/Item/MediumImage/URL,/ItemLookupResponse/Items/Item/SmallImage/URL','/ItemLookupResponse/Items/Item/DetailPageURL','1')"
	."\n ,('2','DVD','amazon',0,".$amadis.",'/ItemLookupResponse/Items/Item/ItemAttributes/Director','/ItemLookupResponse/Items/Item/ItemAttributes/Actor','','','','','','','','','/ItemLookupResponse/Items/Item/ItemAttributes/Title','','/ItemLookupResponse/Items/Item/LargeImage/URL,/ItemLookupResponse/Items/Item/MediumImage/URL,/ItemLookupResponse/Items/Item/SmallImage/URL','/ItemLookupResponse/Items/Item/DetailPageURL','2')"
	."\n ,('3','Movie','imdb',0,".$imdbdis.",'/document/directors/director/name','/document/cast/actor/namerole','/document/producers/producer/name','/document/year','','','','','','','/document/title','/document/tagline','/document/photolocal,/document/photo','/document/url','3')"
	."\n ,('4','Book','googlebook',0,".$gbdis.",'/entry/dc:creator','/entry/dc:publisher','','','','','','','','','/entry/title','/entry/dc:description','/entry/link[@rel=\"http://schemas.google.com/books/2008/thumbnail\"]/@href','/entry/link[@rel=\"http://schemas.google.com/books/2008/info\"]/@href','4')"
	."\n ,('5','Item','ebay',0,".$ebaydis.",'','','','','','','','','','','/FindProductsResponse/Product/Title','','/FindProductsResponse/Product/StockPhotoURL','/FindProductsResponse/Product/DetailsURL','5')"
	."\n ,('6','Map','yahoomap',0,".$ymdis.",'','','','','','','','','','','','','','','6')"
	."\n ,('7','Book','ebay',1,".$ebaydis.",'/FindProductsResponse/Product/ItemSpecifics/NameValueList[Name=Author]/Value','','','','/FindProductsResponse/Product/ItemSpecifics/NameValueList[Name=Binding]/Value,/FindProductsResponse/Product/ItemSpecifics/NameValueList[Name=Format]/Value','','','','','','/FindProductsResponse/Product/Title','','/FindProductsResponse/Product/StockPhotoURL','/FindProductsResponse/Product/DetailsURL','7')"
	."\n ,('8','Item','zanox',0,".$zanoxdis.",'','','','','','','','','','','/response/productsResult/productItem/name','/response/productsResult/productItem/description','/response/productsResult/productItem/image/large,/response/productsResult/productItem/image/medium,/response/productsResult/productItem/image/small','/response/productsResult/productItem/url/adspace[1]','8')"
	."\n ,('9','URL','wikipedia',0,'','','','','','','','','','','','','','','/document/url','9')"
	."\n ,('10','Book','isbndb',0,".$isbndbdis.",'/ISBNdb/BookList/BookData/AuthorsText','/ISBNdb/BookList/BookData/PublisherText','','','','','','','','','/ISBNdb/BookList/BookData/Title,/ISBNdb/BookList/BookData/TitleLong','','','','10')"
	."\n ,('11','Map','googlemap',0,".$gmdis.",'','','','','','','','','','/Document/Url','','','','','11')"
	."\n ,('12','Music','yahoomusic',0,".$ydis.",'/Releases/Release/Artist/@name','','/Releases/Release/Artist/@releaseDate','','','','','','','/Releases/Release/@title','','','','','12')"
	."\n ,('13','Catalog','yahoo',0,".$ydis.",'','','','','','','','','','','/Catalogs/Catalog/Specs/ProductName','/Catalogs/Catalog/Specs/Description','/Catalogs/Catalog/Specs/LargeImage/Url,/Catalogs/Catalog/Specs/Image/Url,/Catalogs/Catalog/Specs/Thumbnail/Url','','13')"
	."\n ,('14','Album','lastfm',0,".$lfmdis.",'/lfm/album/artist','','/lfm/album/releasedate','','','','','','','','/lfm/album/name','/lfm/album/wiki/summary','/lfm/album/image[@size=\"extralarge\"],/lfm/album/image[@size=\"large\"],/lfm/album/image[@size=\"medium\"],/lfm/album/image[@size=\"small\"]','/lfm/album/url','14')"
	;
	$database->setQuery($query);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}

	$query = "INSERT INTO #__"._JC_DB."_listcat (`id`,`name`,`alias`,`ordering`) "
	."\n VALUES ('1','Lists','lists','1')"
	."\n ,('2','Tags','tags','2')"
	;
	$database->setQuery($query);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}

}

function update_0_9_0_to_0_9_1()
{
	$database = & JFactory::getDBO();

	if($database->hasUTF()) {
		$utf = "DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
		$vc255 = "VARCHAR(255)";
	} else {
		$utf = ""; // default charset empty if database does not support utf-8
		$vc255 = "TEXT"; // varchar(255) is replaced by text if database does not support utf-8 (for fields that allow special characters)
	}

	$query = "INSERT INTO #__"._JC_DB."_type (`name`,`info1label`,`info2label`,`info3label`,`info4label`,`info5label`,`info6label`,`info7label`,`info8label`,`info9label`,`info10label`,`info1html`,`info2html`,`info3html`,`info4html`,`info5html`,`info6html`,`info7html`,`info8html`,`info9html`,`info10html`,`ordering`) "
	."\n VALUES ('Recipe','Amount','Ingredient','Amount','Ingredient','Amount','Ingredient','Amount','Ingredient','Amount','Ingredient','','{INFO1} {INFO2}','','{INFO3} {INFO4}','','{INFO5} {INFO6}','','{INFO7} {INFO8}','','{INFO9} {INFO10}','5')"
	."\n ,('Position','Street','City','ZIP','State','Country','Telefone','','','','Map','{INFO1}','{INFO2}','{INFO3}','{INFO4}','{INFO5}','{INFO6}','{INFO7}','{INFO8}','{INFO9}','<img src=\"{INFO10}\" />','6')"
	;
	$database->setQuery($query);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}


	$lfmdis = $database->Quote('Some information provided by <a href="http://last.fm" target="_blank">last.fm</a>.');
	$query = "INSERT INTO #__"._JC_DB."_webservicetype (`name`,`webservice`,`typeid`,`disclaimer`,`info1xpath`,`info2xpath`,`info3xpath`,`info4xpath`,`info5xpath`,`info6xpath`,`info7xpath`,`info8xpath`,`info9xpath`,`info10xpath`,`titlexpath`,`descriptionxpath`,`imgxpath`,`urlxpath`,`ordering`)"
	."\n VALUES ('Album','lastfm',0,".$lfmdis.",'/lfm/album/artist','','/lfm/album/releasedate','','','','','','','','/lfm/album/name','/lfm/album/wiki/summary','/lfm/album/image[@size=\"extralarge\"],/lfm/album/image[@size=\"large\"],/lfm/album/image[@size=\"medium\"],/lfm/album/image[@size=\"small\"]','/lfm/album/url','14')"
	;
	$database->setQuery($query);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}

	$query = "DROP TABLE IF EXISTS #__"._JC_DB."_ratingtype;";
	$database->setQuery($query);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}

	$query1 = "DROP TABLE IF EXISTS #__"._JC_DB."_rating;";
	$query2 = "CREATE TABLE #__"._JC_DB."_rating ("
	."\n `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,"
	."\n `infoid` INT(11) UNSIGNED NOT NULL DEFAULT '0',"
	."\n `ratingsum1` INT(11) NOT NULL DEFAULT '0',"
	."\n `ratingcount1` INT(11) NOT NULL DEFAULT '0',"
	."\n `lastip1` $vc255 NOT NULL DEFAULT '',"
	."\n `ratingsum2` INT(11) NOT NULL DEFAULT '0',"
	."\n `ratingcount2` INT(11) NOT NULL DEFAULT '0',"
	."\n `lastip2` $vc255 NOT NULL DEFAULT '',"
	."\n `ratingsum3` INT(11) NOT NULL DEFAULT '0',"
	."\n `ratingcount3` INT(11) NOT NULL DEFAULT '0',"
	."\n `lastip3` $vc255 NOT NULL DEFAULT '',"
	."\n `ratingsum4` INT(11) NOT NULL DEFAULT '0',"
	."\n `ratingcount4` INT(11) NOT NULL DEFAULT '0',"
	."\n `lastip4` $vc255 NOT NULL DEFAULT '',"
	."\n `ratingsum5` INT(11) NOT NULL DEFAULT '0',"
	."\n `ratingcount5` INT(11) NOT NULL DEFAULT '0',"
	."\n `lastip5` $vc255 NOT NULL DEFAULT '',"
	."\n PRIMARY KEY  (`id`),"
	."\n FOREIGN KEY (`infoid`) REFERENCES `#__"._JC_DB."_info`(`id`)"
	."\n ) TYPE=MyISAM $utf;";
	// MyISAM does not support foreign keys, so the "FOREIGN KEY" statement is for information purposes only - and foreign indices are impossible
	$database->setQuery($query1);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}
	$database->setQuery($query2);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}

	$query = "ALTER TABLE #__"._JC_DB."_type "
	."\n ADD `rating1label` $vc255 NOT NULL DEFAULT '',"
	."\n ADD `rating2label` $vc255 NOT NULL DEFAULT '',"
	."\n ADD `rating3label` $vc255 NOT NULL DEFAULT '',"
	."\n ADD `rating4label` $vc255 NOT NULL DEFAULT '',"
	."\n ADD `rating5label` $vc255 NOT NULL DEFAULT ''"
	;
	$database->setQuery($query);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}

	$query = "UPDATE #__"._JC_DB."_type "
	."\n SET rating1label = 'Overall' "
	;
	$database->setQuery($query);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}

	$query = "ALTER TABLE #__"._JC_DB."_webserviceitem "
	."\n ADD `expires` INT(11) NOT NULL DEFAULT '0'"
	;
	$database->setQuery($query);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}

}

function update_0_9_1_to_0_9_2()
{
	$database = & JFactory::getDBO();

	if($database->hasUTF()) {
		$utf = "DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
		$vc255 = "VARCHAR(255)";
	} else {
		$utf = ""; // default charset empty if database does not support utf-8
		$vc255 = "TEXT"; // varchar(255) is replaced by text if database does not support utf-8 (for fields that allow special characters)
	}

	$query = "DROP TABLE IF EXISTS #__"._JC_DB."_reviewrating;";
	$database->setQuery($query);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}

	$query1 = "DROP TABLE IF EXISTS #__"._JC_DB."_reviewrating;";
	$query2 = "CREATE TABLE #__"._JC_DB."_reviewrating ("
	."\n `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,"
	."\n `reviewid` INT(11) UNSIGNED NOT NULL DEFAULT '0',"
	."\n `rating1` INT(3) NOT NULL DEFAULT '-1',"
	."\n `rating2` INT(3) NOT NULL DEFAULT '-1',"
	."\n `rating3` INT(3) NOT NULL DEFAULT '-1',"
	."\n `rating4` INT(3) NOT NULL DEFAULT '-1',"
	."\n `rating5` INT(11) NOT NULL DEFAULT '-1',"
	."\n `useful_yes` INT(11) NOT NULL DEFAULT '0',"
	."\n `useful_no` INT(11) NOT NULL DEFAULT '0',"
	."\n `lastip` $vc255 NOT NULL DEFAULT '',"
	."\n PRIMARY KEY (`id`),"
	."\n FOREIGN KEY (`reviewid`) REFERENCES `#__"._JC_DB."_review`(`id`)"
	."\n ) TYPE=MyISAM $utf;";
	// MyISAM does not support foreign keys, so the "FOREIGN KEY" statement is for information purposes only - and foreign indices are impossible
	$database->setQuery($query1);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}
	$database->setQuery($query2);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}

	$query = "UPDATE #__"._JC_DB."_review "
	."\n SET description = review "
	;
	$database->setQuery($query);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}

	$query = "ALTER TABLE #__"._JC_DB."_review "
	."\n DROP `review` "
	;
	$database->setQuery($query);
	$database->query();
	if ($database->getErrorNum()) {
		JError::raiseError( 500, $database->stderr());
	}

}

/**
 * Install com_jcollection
 */
function com_install() {

	// Get the database object
	$database = & JFactory::getDBO();

	$version = getVersion();
	if($version) {
		$notice = 'Previous version: '.$version;
		JError::raiseNotice(200, 'com_jcollection::com_install: '.$notice);
	}

	// Run the mySQL queries
	$tables = $database->getTableList();
	if( !in_array( $database->getPrefix()._JC_DB, $tables ) )
	{ // Fresh install

		/* check if database supports utf-8. If yes, use it as default charset. */
		if($database->hasUTF()) {
			$utf = "DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
			$vc255 = "VARCHAR(255)";
		} else {
			$utf = ""; // default charset empty if database does not support utf-8
			$vc255 = "TEXT"; // varchar(255) is replaced by text if database does not support utf-8 (for fields that allow special characters)
		}

		// Standard fields to be inserted in each database table
		$standardfields = "\n `description` TEXT NOT NULL DEFAULT '',"
		."\n `img` VARCHAR(255) NOT NULL DEFAULT '',"
		."\n `alias` VARCHAR(255) NOT NULL DEFAULT ''," // for SEF
		."\n `date` DATETIME NOT NULL,"
		."\n `created_by` INT(11) UNSIGNED NOT NULL DEFAULT '0',"
		."\n `created_by_alias` $vc255 NOT NULL DEFAULT '',"
		."\n `modified` DATETIME NOT NULL,"
		."\n `modified_by` INT(11) UNSIGNED NOT NULL DEFAULT '0',"
		."\n `published` INT(3) NOT NULL DEFAULT '0',"
		."\n `approved` INT(3) NOT NULL DEFAULT '0',"
		."\n `access` INT(11) NOT NULL DEFAULT '0',"
		."\n `checked_out` INT(11) UNSIGNED NOT NULL DEFAULT '0',"
		."\n `checked_out_time` DATETIME NOT NULL,"
		."\n `ordering` INT NOT NULL DEFAULT '0',"
		."\n `params` TEXT NOT NULL DEFAULT '',";

		$standardkeys = "\n FOREIGN KEY (`created_by`) REFERENCES `#__users`(`id`),"
		."\n FOREIGN KEY (`modified_by`) REFERENCES `#__users`(`id`),"
		."\n FOREIGN KEY (`checked_out`) REFERENCES `#__users`(`id`),"
		."\n INDEX (`created_by`),"
		."\n INDEX (`date`),"
		."\n INDEX (`ordering`)";

		// Add tables if first time install

		/*
			Table collection_cat (for categories)
			*/
		$query1 = "DROP TABLE IF EXISTS #__"._JC_DB."_cat;";
		$query2 = "CREATE TABLE `#__"._JC_DB."_cat` ("
		."\n `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,"
		."\n `name` $vc255 NOT NULL DEFAULT '',"
		."\n `parent` INT(11) UNSIGNED NOT NULL DEFAULT '0',"
		.$standardfields
		."\n PRIMARY KEY  (`id`),"
		."\n INDEX (`name`),"
		."\n INDEX (`parent`),"
		.$standardkeys
		."\n ) TYPE=MyISAM AUTO_INCREMENT=1 $utf;";
		// MyISAM does not support foreign keys, so the "FOREIGN KEY" statement is for information purposes only
		$database->setQuery($query1);
		$database->query();
		if ($database->getErrorNum()) {
			JError::raiseError( 500, $database->stderr());
		}
		$database->setQuery($query2);
		$database->query();
		if ($database->getErrorNum()) {
			JError::raiseError( 500, $database->stderr());
		}

		/*
			Table collection (for items)
			*/
		$query1 = "DROP TABLE IF EXISTS #__"._JC_DB.";";
		$query2 = "CREATE TABLE #__"._JC_DB." ("
		."\n `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,"
		."\n `catid` INT(11) NOT NULL DEFAULT '0',"
		."\n `name` $vc255 NOT NULL DEFAULT '',"
		.$standardfields
		."\n `hits` INT(11) UNSIGNED NOT NULL DEFAULT '0',"
		."\n PRIMARY KEY  (`id`),"
		."\n INDEX (`catid`),"
		."\n INDEX (`name`),"
		."\n INDEX (`hits`),"
		."\n FOREIGN KEY (`catid`) REFERENCES `#__"._JC_DB."_cat`(`id`),"
		.$standardkeys
		."\n ) TYPE=MyISAM AUTO_INCREMENT=1 $utf;";
		// MyISAM does not support foreign keys, so the "FOREIGN KEY" statement is for information purposes only
		$database->setQuery($query1);
		$database->query();
		if ($database->getErrorNum()) {
			JError::raiseError( 500, $database->stderr());
		}
		$database->setQuery($query2);
		$database->query();
		if ($database->getErrorNum()) {
			JError::raiseError( 500, $database->stderr());
		}

		/*
			Table collection_rating (for item rating)
		 */
		$query1 = "DROP TABLE IF EXISTS #__"._JC_DB."_rating;";
		$query2 = "CREATE TABLE #__"._JC_DB."_rating ("
		."\n `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,"
		."\n `infoid` INT(11) UNSIGNED NOT NULL DEFAULT '0',"
		."\n `ratingsum1` INT(11) NOT NULL DEFAULT '0',"
		."\n `ratingcount1` INT(11) NOT NULL DEFAULT '0',"
		."\n `lastip1` $vc255 NOT NULL DEFAULT '',"
		."\n `ratingsum2` INT(11) NOT NULL DEFAULT '0',"
		."\n `ratingcount2` INT(11) NOT NULL DEFAULT '0',"
		."\n `lastip2` $vc255 NOT NULL DEFAULT '',"
		."\n `ratingsum3` INT(11) NOT NULL DEFAULT '0',"
		."\n `ratingcount3` INT(11) NOT NULL DEFAULT '0',"
		."\n `lastip3` $vc255 NOT NULL DEFAULT '',"
		."\n `ratingsum4` INT(11) NOT NULL DEFAULT '0',"
		."\n `ratingcount4` INT(11) NOT NULL DEFAULT '0',"
		."\n `lastip4` $vc255 NOT NULL DEFAULT '',"
		."\n `ratingsum5` INT(11) NOT NULL DEFAULT '0',"
		."\n `ratingcount5` INT(11) NOT NULL DEFAULT '0',"
		."\n `lastip5` $vc255 NOT NULL DEFAULT '',"
		."\n PRIMARY KEY (`id`),"
		."\n FOREIGN KEY (`infoid`) REFERENCES `#__"._JC_DB."_info`(`id`)"
		."\n ) TYPE=MyISAM $utf;";
		// MyISAM does not support foreign keys, so the "FOREIGN KEY" statement is for information purposes only - and foreign indices are impossible
		$database->setQuery($query1);
		$database->query();
		if ($database->getErrorNum()) {
			JError::raiseError( 500, $database->stderr());
		}
		$database->setQuery($query2);
		$database->query();
		if ($database->getErrorNum()) {
			JError::raiseError( 500, $database->stderr());
		}

		/*
			Table collection_type (for types)
			*/
		$query1 = "DROP TABLE IF EXISTS #__"._JC_DB."_type;";
		$query2 = "CREATE TABLE `#__"._JC_DB."_type` ("
		."\n `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,"
		."\n `name` $vc255 NOT NULL DEFAULT '',"
		."\n `description` TEXT NOT NULL DEFAULT '',"
		."\n `img` $vc255 NOT NULL DEFAULT '',"
		."\n `info1label` $vc255 NOT NULL DEFAULT '',"
		."\n `info2label` $vc255 NOT NULL DEFAULT '',"
		."\n `info3label` $vc255 NOT NULL DEFAULT '',"
		."\n `info4label` $vc255 NOT NULL DEFAULT '',"
		."\n `info5label` $vc255 NOT NULL DEFAULT '',"
		."\n `info6label` $vc255 NOT NULL DEFAULT '',"
		."\n `info7label` $vc255 NOT NULL DEFAULT '',"
		."\n `info8label` $vc255 NOT NULL DEFAULT '',"
		."\n `info9label` $vc255 NOT NULL DEFAULT '',"
		."\n `info10label` $vc255 NOT NULL DEFAULT '',"
		."\n `info1html` $vc255 NOT NULL DEFAULT '',"
		."\n `info2html` $vc255 NOT NULL DEFAULT '',"
		."\n `info3html` $vc255 NOT NULL DEFAULT '',"
		."\n `info4html` $vc255 NOT NULL DEFAULT '',"
		."\n `info5html` $vc255 NOT NULL DEFAULT '',"
		."\n `info6html` $vc255 NOT NULL DEFAULT '',"
		."\n `info7html` $vc255 NOT NULL DEFAULT '',"
		."\n `info8html` $vc255 NOT NULL DEFAULT '',"
		."\n `info9html` $vc255 NOT NULL DEFAULT '',"
		."\n `info10html` $vc255 NOT NULL DEFAULT '',"
		."\n `rating1label` $vc255 NOT NULL DEFAULT '',"
		."\n `rating2label` $vc255 NOT NULL DEFAULT '',"
		."\n `rating3label` $vc255 NOT NULL DEFAULT '',"
		."\n `rating4label` $vc255 NOT NULL DEFAULT '',"
		."\n `rating5label` $vc255 NOT NULL DEFAULT '',"
		."\n `checked_out` INT(11) NOT NULL DEFAULT '0',"
		."\n `checked_out_time` DATETIME NOT NULL,"
		."\n `ordering` INT NOT NULL DEFAULT '0',"
		."\n `params` TEXT NOT NULL DEFAULT '',"
		."\n PRIMARY KEY (`id`),"
		."\n INDEX (`name`),"
		."\n FOREIGN KEY (`checked_out`) REFERENCES `#__users`(`id`),"
		."\n INDEX (`ordering`)"
		."\n ) TYPE=MyISAM AUTO_INCREMENT=1 $utf;";
		$database->setQuery($query1);
		$database->query();
		if ($database->getErrorNum()) {
			JError::raiseError( 500, $database->stderr());
		}
		$database->setQuery($query2);
		$database->query();
		if ($database->getErrorNum()) {
			JError::raiseError( 500, $database->stderr());
		}

		/*
			Table collection_info (for item information)
			*/
		$query1 = "DROP TABLE IF EXISTS #__"._JC_DB."_info;";
		$query2 = "CREATE TABLE `#__"._JC_DB."_info` ("
		."\n `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,"
		."\n `itemid` INT(11) UNSIGNED NOT NULL DEFAULT '0',"
		."\n `typeid` INT(11) UNSIGNED NOT NULL DEFAULT '0',"
		."\n `name` $vc255 NOT NULL DEFAULT '',"
		."\n `title` TEXT NOT NULL DEFAULT '',"
		."\n `info1` TEXT NOT NULL DEFAULT '',"
		."\n `info2` TEXT NOT NULL DEFAULT '',"
		."\n `info3` TEXT NOT NULL DEFAULT '',"
		."\n `info4` TEXT NOT NULL DEFAULT '',"
		."\n `info5` TEXT NOT NULL DEFAULT '',"
		."\n `info6` TEXT NOT NULL DEFAULT '',"
		."\n `info7` TEXT NOT NULL DEFAULT '',"
		."\n `info8` TEXT NOT NULL DEFAULT '',"
		."\n `info9` TEXT NOT NULL DEFAULT '',"
		."\n `info10` TEXT NOT NULL DEFAULT '',"
		."\n `url` TEXT NOT NULL DEFAULT '',"
		.$standardfields
		."\n PRIMARY KEY (`id`),"
		."\n FOREIGN KEY (`itemid`) REFERENCES `#__"._JC_DB."`(`id`),"
		."\n FOREIGN KEY (`typeid`) REFERENCES `#__"._JC_DB."_type`(`id`),"
		."\n INDEX (`name`),"
		.$standardkeys
		."\n ) TYPE=MyISAM AUTO_INCREMENT=1 $utf;";
		// MyISAM does not support foreign keys, so the "FOREIGN KEY" statement is for information purposes only
		$database->setQuery($query1);
		$database->query();
		if ($database->getErrorNum()) {
			JError::raiseError( 500, $database->stderr());
		}
		$database->setQuery($query2);
		$database->query();
		if ($database->getErrorNum()) {
			JError::raiseError( 500, $database->stderr());
		}

		$query1 = "DROP TABLE IF EXISTS #__"._JC_DB."_review;";
		$query2 = "CREATE TABLE `#__"._JC_DB."_review` ("
		."\n `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,"
		."\n `infoid` INT(11) UNSIGNED NOT NULL DEFAULT '0',"
		."\n `name` $vc255 NOT NULL NOT NULL DEFAULT '',"
		.$standardfields
		."\n PRIMARY KEY  (`id`),"
		."\n INDEX (`infoid`),"
		."\n INDEX (`name`),"
		."\n FOREIGN KEY (`infoid`) REFERENCES `#__"._JC_DB."_info`(`id`),"
		.$standardkeys
		."\n ) TYPE=MyISAM AUTO_INCREMENT=1 $utf;";
		$database->setQuery($query1);
		$database->query();
		if ($database->getErrorNum()) {
			JError::raiseError( 500, $database->stderr());
		}
		$database->setQuery($query2);
		$database->query();
		if ($database->getErrorNum()) {
			JError::raiseError( 500, $database->stderr());
		}

		/*
			Table collection_reviewrating (for review rating)
		 */
		$query1 = "DROP TABLE IF EXISTS #__"._JC_DB."_reviewrating;";
		$query2 = "CREATE TABLE #__"._JC_DB."_reviewrating ("
		."\n `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,"
		."\n `reviewid` INT(11) UNSIGNED NOT NULL DEFAULT '0',"
		."\n `rating1` INT(3) NOT NULL DEFAULT '0',"
		."\n `rating2` INT(3) NOT NULL DEFAULT '0',"
		."\n `rating3` INT(3) NOT NULL DEFAULT '0',"
		."\n `rating4` INT(3) NOT NULL DEFAULT '0',"
		."\n `rating5` INT(3) NOT NULL DEFAULT '0',"
		."\n `useful_yes` INT(11) NOT NULL DEFAULT '0',"
		."\n `useful_no` INT(11) NOT NULL DEFAULT '0',"
		."\n `lastip` $vc255 NOT NULL DEFAULT '',"
		."\n PRIMARY KEY (`id`),"
		."\n FOREIGN KEY (`reviewid`) REFERENCES `#__"._JC_DB."_review`(`id`)"
		."\n ) TYPE=MyISAM $utf;";
		// MyISAM does not support foreign keys, so the "FOREIGN KEY" statement is for information purposes only - and foreign indices are impossible
		$database->setQuery($query1);
		$database->query();
		if ($database->getErrorNum()) {
			JError::raiseError( 500, $database->stderr());
		}
		$database->setQuery($query2);
		$database->query();
		if ($database->getErrorNum()) {
			JError::raiseError( 500, $database->stderr());
		}


		$query1 = "DROP TABLE IF EXISTS #__"._JC_DB."_webservicetype;";
		$query2 = "CREATE TABLE `#__"._JC_DB."_webservicetype` ("
		."\n `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,"
		."\n `name` $vc255 NOT NULL NOT NULL DEFAULT '',"
		."\n `webservice` $vc255 NOT NULL DEFAULT '',"
		."\n `typeid` $vc255 NOT NULL DEFAULT '',"
		."\n `disclaimer` TEXT NOT NULL DEFAULT '',"
		."\n `info1xpath` TEXT NOT NULL DEFAULT '',"
		."\n `info2xpath` TEXT NOT NULL DEFAULT '',"
		."\n `info3xpath` TEXT NOT NULL DEFAULT '',"
		."\n `info4xpath` TEXT NOT NULL DEFAULT '',"
		."\n `info5xpath` TEXT NOT NULL DEFAULT '',"
		."\n `info6xpath` TEXT NOT NULL DEFAULT '',"
		."\n `info7xpath` TEXT NOT NULL DEFAULT '',"
		."\n `info8xpath` TEXT NOT NULL DEFAULT '',"
		."\n `info9xpath` TEXT NOT NULL DEFAULT '',"
		."\n `info10xpath` TEXT NOT NULL DEFAULT '',"
		."\n `titlexpath` TEXT NOT NULL DEFAULT '',"
		."\n `descriptionxpath` TEXT NOT NULL DEFAULT '',"
		."\n `imgxpath` TEXT NOT NULL DEFAULT '',"
		."\n `urlxpath` TEXT NOT NULL DEFAULT '',"
		."\n `checked_out` INT(11) UNSIGNED NOT NULL DEFAULT '0',"
		."\n `checked_out_time` DATETIME NOT NULL,"
		."\n `ordering` INT NOT NULL DEFAULT '0',"
		."\n `params` TEXT NOT NULL DEFAULT '',"
		."\n PRIMARY KEY (`id`),"
		."\n FOREIGN KEY (`checked_out`) REFERENCES `#__users`(`id`),"
		."\n FOREIGN KEY (`typeid`) REFERENCES `#__"._JC_DB."_type`(`id`),"
		."\n INDEX (`ordering`),"
		."\n INDEX (`name`),"
		."\n INDEX (`webservice`)"
		."\n ) TYPE=MyISAM AUTO_INCREMENT=1 $utf;";
		// MyISAM does not support foreign keys, so the "FOREIGN KEY" statement is for information purposes only
		$database->setQuery($query1);
		$database->query();
		if ($database->getErrorNum()) {
			JError::raiseError( 500, $database->stderr());
		}
		$database->setQuery($query2);
		$database->query();
		if ($database->getErrorNum()) {
			JError::raiseError( 500, $database->stderr());
		}

		$query1 = "DROP TABLE IF EXISTS #__"._JC_DB."_webserviceitem;";
		$query2 = "CREATE TABLE `#__"._JC_DB."_webserviceitem` ("
		."\n `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,"
		."\n `ws_id` $vc255 NOT NULL DEFAULT '',"
		."\n `infoid` INT(11) UNSIGNED NOT NULL DEFAULT '0',"
		."\n `webservice` $vc255 NOT NULL DEFAULT '',"
		."\n `type` INT(11) UNSIGNED NOT NULL NOT NULL DEFAULT '0',"
		."\n `xml` MEDIUMTEXT NOT NULL DEFAULT '',"
		."\n `updated` DATETIME NOT NULL,"
		."\n `expires` INT(11) NOT NULL DEFAULT '0',"
		."\n `checked_out` INT(11) UNSIGNED NOT NULL DEFAULT '0',"
		."\n `checked_out_time` DATETIME NOT NULL,"
		."\n `params` TEXT NOT NULL DEFAULT '',"
		."\n PRIMARY KEY (`id`),"
		."\n FOREIGN KEY (`checked_out`) REFERENCES `#__users`(`id`),"
		."\n FOREIGN KEY (`infoid`) REFERENCES `#__"._JC_DB."_info`(`id`),"
		."\n FOREIGN KEY (`type`) REFERENCES `#__"._JC_DB."_webservicetype`(`id`),"
		."\n INDEX (`webservice`),"
		."\n INDEX (`infoid`),"
		."\n INDEX (`ws_id`)"
		."\n ) TYPE=MyISAM AUTO_INCREMENT=1 $utf;";
		// MyISAM does not support foreign keys, so the "FOREIGN KEY" statement is for information purposes only
		$database->setQuery($query1);
		$database->query();
		if ($database->getErrorNum()) {
			JError::raiseError( 500, $database->stderr());
		}
		$database->setQuery($query2);
		$database->query();
		if ($database->getErrorNum()) {
			JError::raiseError( 500, $database->stderr());
		}

		/*
			Table collection_listcat
			*/
		$query1 = "DROP TABLE IF EXISTS #__"._JC_DB."_listcat;";
		$query2 = "CREATE TABLE `#__"._JC_DB."_listcat` ("
		."\n `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,"
		."\n `name` $vc255 NOT NULL DEFAULT '',"
		.$standardfields
		."\n PRIMARY KEY (`id`),"
		."\n INDEX (`name`),"
		.$standardkeys
		."\n ) TYPE=MyISAM AUTO_INCREMENT=1 $utf;";
		// MyISAM does not support foreign keys, so the "FOREIGN KEY" statement is for information purposes only
		$database->setQuery($query1);
		$database->query();
		if ($database->getErrorNum()) {
			JError::raiseError( 500, $database->stderr());
		}
		$database->setQuery($query2);
		$database->query();
		if ($database->getErrorNum()) {
			JError::raiseError( 500, $database->stderr());
		}

		/*
			Table collection_tag (for lists and tags)
			*/
		$query1 = "DROP TABLE IF EXISTS #__"._JC_DB."_list;";
		$query2 = "CREATE TABLE `#__"._JC_DB."_list` ("
		."\n `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,"
		."\n `name` $vc255 NOT NULL DEFAULT '',"
		."\n `catid` INT(11) UNSIGNED NOT NULL DEFAULT '0',"
		.$standardfields
		."\n PRIMARY KEY (`id`),"
		."\n INDEX (`name`),"
		."\n FOREIGN KEY (`catid`) REFERENCES `#__"._JC_DB."_listcat`(`id`),"
		.$standardkeys
		."\n ) TYPE=MyISAM AUTO_INCREMENT=1 $utf;";
		// MyISAM does not support foreign keys, so the "FOREIGN KEY" statement is for information purposes only
		$database->setQuery($query1);
		$database->query();
		if ($database->getErrorNum()) {
			JError::raiseError( 500, $database->stderr());
		}
		$database->setQuery($query2);
		$database->query();
		if ($database->getErrorNum()) {
			JError::raiseError( 500, $database->stderr());
		}

		/*
			Table collection_item2list
			*/
		$query1 = "DROP TABLE IF EXISTS #__"._JC_DB."_item2list;";
		$query2 = "CREATE TABLE `#__"._JC_DB."_item2list` ("
		."\n `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,"
		."\n `itemid` INT(11) UNSIGNED NOT NULL DEFAULT '0',"
		."\n `listid` INT(11) UNSIGNED NOT NULL DEFAULT '0',"
		."\n `ordering` INT NOT NULL DEFAULT '0',"
		."\n PRIMARY KEY (`id`),"
		."\n FOREIGN KEY (`itemid`) REFERENCES `#__"._JC_DB."`(`id`),"
		."\n FOREIGN KEY (`listid`) REFERENCES `#__"._JC_DB."_list`(`id`),"
		."\n INDEX (`ordering`)"
		."\n ) TYPE=MyISAM AUTO_INCREMENT=1 $utf;";
		// MyISAM does not support foreign keys, so the "FOREIGN KEY" statement is for information purposes only
		$database->setQuery($query1);
		$database->query();
		if ($database->getErrorNum()) {
			JError::raiseError( 500, $database->stderr());
		}
		$database->setQuery($query2);
		$database->query();
		if ($database->getErrorNum()) {
			JError::raiseError( 500, $database->stderr());
		}

		loadDefaults();

		echo "<br />";
		echo JText::_( 'Database created' );
		echo "<br />\n";
	}
	else
	{
		// there is an old version - try to update!
		if( $version )
		{
			$v = explode( '.', $version );
			if( $v[0] == 0 && $v[1] == 9 )
			{
				if( $v[2] < 1 ) {
					update_0_9_0_to_0_9_1();
				}
				if( $v[2] < 2 ) {
					update_0_9_1_to_0_9_2();
				}
			}
		}
	}

	// install the JoomFish translation files
	installJoomfishFiles();

	// create the /image/jcollection folder
	createImageFolder();

	// check if webservices can be used
	checkRemote();
}
?>
