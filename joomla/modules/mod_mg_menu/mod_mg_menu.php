<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );



ini_set('arg_separator.output','&amp;');

 $menutype	= $params->get( 'menutype');
 $roll	= $params->get( 'roll');
 $type = 0;
  
 mosShowListMenu($menutype, $roll);
 
function injectCustomHeadTags($html) {
	$buf = ob_get_contents();
	if (!empty($buf) && !headers_sent()) {
		$buf = preg_replace("/<head(| .*?)>(.*?)<\/head>/is", "<head$1>$22".$html."</head>", $buf, 1, $count);
		if ($count == 1) {
			ob_clean();
			echo $buf;
			return true;
		}
	}
	return false;
}


function mosShowListMenu($menutype, $roll) {
  

	global $database, $my, $cur_template, $Itemid;

	global $mosConfig_absolute_path, $mosConfig_live_site, $mosConfig_shownoauth, $mainframe;

  $database = &JFactory::getDBO();

$html = '<script type="text/javascript" src="modules/mod_mg_menu/ieHover.js"></script><link href="modules/mod_mg_menu/mg_menu.css" rel="stylesheet" type="text/css" />';


$doc =& JFactory::getDocument();
$doc->addCustomTag( $html );

//if (!injectCustomHeadTags($html)) {
//	echo $html;
//}

  $class_sfx = null;


	$hilightid = null;



    /* If a user has signed in, get their user type */

	$intUserType = 0;

	if($my->gid){

		switch ($my->usertype)

		{

			case 'Super Administrator':

			$intUserType = 0;

			break;

			case 'Administrator':

			$intUserType = 1;

			break;

			case 'Editor':

			$intUserType = 2;

			break;

			case 'Registered':

			$intUserType = 3;

			break;

			case 'Author':

			$intUserType = 4;

			break;

			case 'Publisher':

			$intUserType = 5;

			break;

			case 'Manager':

			$intUserType = 6;

			break;

		}

	}

	else

	{

		/* user isn't logged in so make their usertype 0 */

		$intUserType = 0;

	}



		if ($mosConfig_shownoauth) {

     $database->setQuery("SELECT m.*, count(p.parent) as cnt" .

	"\nFROM #__menu AS m" .

	"\nLEFT JOIN #__menu AS p ON p.parent = m.id" .

    "\nWHERE m.menutype='$menutype' AND m.published='1'" .

	"\nGROUP BY m.id ORDER BY m.parent, m.ordering ");

      } else {

     $database->setQuery("SELECT m.*, sum(case when p.published=1 then 1 else 0 end) as cnt" .

	"\nFROM #__menu AS m" .

	"\nLEFT JOIN #__menu AS p ON p.parent = m.id" .

    "\nWHERE m.menutype='$menutype' AND m.published='1' AND m.access <= '$my->gid'" .

	"\nGROUP BY m.id ORDER BY m.parent, m.ordering ");

   }



	$rows = $database->loadObjectList( 'id' );

	echo $database->getErrorMsg();

	

		//work out if this should be highlighted

		$sql = "SELECT m.* FROM #__menu AS m"

		. "\nWHERE menutype='". $menutype ."' AND m.published='1'"; 

		$database->setQuery( $sql );

		$subrows = $database->loadObjectList( 'id' );

		$maxrecurse = 5;

		$parentid = $Itemid;



		//this makes sure toplevel stays hilighted when submenu active

		while ($maxrecurse-- > 0) {

			$parentid = getTheParentRow($subrows, $parentid);

			if (isset($parentid) && $parentid >= 0 && $subrows[$parentid]) {

				$hilightid = $parentid;

			} else {

				break;	

			}

		}	



	$indents = array(

	// block prefix / item prefix / item suffix / block suffix

	array( "<ul>", "<li>" , "</li>", "</ul>" ),

	);



    // establish the hierarchy of the menu

	$children = array();



    // first pass - collect children

    foreach ($rows as $v ) {

		$pt = $v->parent;

		$list = @$children[$pt] ? $children[$pt] : array();

		array_push( $list, $v );



        $children[$pt] = $list;



    }



    // second pass - collect 'open' menus

	$open = array( $Itemid );

	$count = 20; // maximum levels - to prevent runaway loop

	$id = $Itemid;

	while (--$count) {

		if (isset($rows[$id]) && $rows[$id]->parent > 0) {

			$id = $rows[$id]->parent;

			$open[] = $id;

		} else {

			break;

		}

	}



	$class_sfx = null;



    mosRecurseListMenu( 0, 0, $children, $open, $indents, $class_sfx, $hilightid , $roll);

}



/**

* Utility function to recursively work through a vertically indented

* hierarchial menu

*/

function mosRecurseListMenu( $id, $level, &$children, $open, &$indents, $class_sfx, $highlight,$roll ) {

	global $Itemid;

	global $HTTP_SERVER_VARS, $mosConfig_live_site;



	if (@$children[$id]) {

		$n = min( $level, count( $indents )-1 );

		

	

			if ($level==0) echo '<ul id="nav">';

			else

        echo $indents[$n][0];



		foreach ($children[$id] as $row) {



		

		        switch ($row->type) {

          		case 'separator':

          		// do nothing

          		$row->link = "seperator";



          		break;

          

          		case 'url':

          		if ( eregi( 'index.php\?', $row->link ) ) {

        				if ( !eregi( 'Itemid=', $row->link ) ) {

        					$row->link .= '&Itemid='. $row->id;

        				}

        			}

          		break;

          

          		default:

          			$row->link .= "&Itemid=$row->id";

          

          		break;

          	}

            if ($n=="0") {
            $li=  "<li class=\"off\">";
            } else {
            $li =  "\n".$indents[$n][1] ;
            }
            $current_itemid = trim( JRequest::getVar('Itemid') );

            if ($row->link != "seperator" &&

								$current_itemid == $row->id || 

            		$row->id == $highlight || 

                (JRoute::_( substr($_SERVER['PHP_SELF'],0,-9) . $row->link)) == $_SERVER['REQUEST_URI'] ||

                (JRoute::_( substr($_SERVER['PHP_SELF'],0,-9) . $row->link)) == $HTTP_SERVER_VARS['REQUEST_URI']) {

							$li = "<li class=\"on\">";

						}

	          echo $li;

								

            echo mosGetLink( $row, $roll, $level, $class_sfx );

						mosRecurseListMenu( $row->id, $level+1, $children, $open, $indents, $class_sfx, "", $roll  );

            echo $indents[$n][2];



        }

		echo "\n".$indents[$n][3];



	}

}



function getTheParentRow($rows, $id) {

		if (isset($rows[$id]) && $rows[$id]) {

			if($rows[$id]->parent > 0) {

				return $rows[$id]->parent;

			}	

		}

		return -1;

	}



/**

* Utility function for writing a menu link

*/

function mosGetLink( $mitem, $roll, $level, $class_sfx='' ) {

	global $Itemid, $mosConfig_live_site;
  
	$txt = '';

	

	$menuclass = '';

	

	$mitem->link = str_replace( '&', '&amp;', $mitem->link );



	if (strcasecmp(substr($mitem->link,0,4),"http")) {

		$mitem->link = JRoute::_($mitem->link);

	}



    switch ($mitem->browserNav) {

		// cases are slightly different

		case 1:

		// open in a new window

    if ($mitem->cnt > 0) {

		   if ($level == 0) {

                $txt = "<a class=\"top\" target=\"_window\"  href=\"$mitem->link\">";
                $txt .= show_image($mitem, $roll);
                $txt .= "</a>";

		   } else {

                $txt = "<a class=\"sub\" target=\"_window\"  href=\"$mitem->link\">";
                $txt .= show_image($mitem, $roll);
                $txt .= "</a>";

		   }

		} else {

		   	        $txt = "<a href=\"$mitem->link\" target=\"_window\" >";
                $txt .= show_image($mitem, $roll);
                $txt .= "</a>";

		}

		break;



		case 2:

		// open in a popup window

    if ($mitem->cnt > 0) {

				if ($level == 0) {

                $txt = "<a href=\"#\" class=\"top\" onClick=\"javascript: window.open('$mitem->link', '', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=780,height=550');\" class=\"$menuclass\">$mitem->name</a>\n";

		   } else {

                $txt = "<a href=\"#\" class=\"daddy\" onClick=\"javascript: window.open('$mitem->link', '', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=780,height=550');\" class=\"$menuclass\">$mitem->name</a>\n";

		   }

		} else {

		    $txt = "<a href=\"#\" onClick=\"javascript: window.open('$mitem->link', '', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=780,height=550');\" class=\"$menuclass\">$mitem->name</a>\n";

		}



		break;



		case 3:

		// don't link it

    if ($mitem->cnt > 0) {

		   if ($level == 0) {

                $txt = "<a class=\"top\">";
                $txt .= show_image($mitem, $roll);
                $txt .= "</a>";

		   } else {

                $txt = "<a class=\"sub\">";
                $txt .= show_image($mitem, $roll);
                $txt .= "</a>";

		   }

		} else {

		   	$txt = "<a>";
                $txt .= show_image($mitem, $roll);
                $txt .= "</a>";

		}



		break;



		default:	// formerly case 2

		// open in parent window

		if (isset($mitem->cnt) && $mitem->cnt > 0) {

		    if ($level == 0) {

                $txt = "<a class=\"top\" href=\"$mitem->link\">";
                $txt .= show_image($mitem, $roll);
                $txt .= "</a>";

		   } else {

                $txt = "<a class=\"sub\" href=\"$mitem->link\">";
                $txt .= show_image($mitem, $roll);
                $txt .= "</a>";
		   }

		} else {
	
	//	if ( $params->get( 'menu_images' ) ) {		
      $txt = "<a href=\"$mitem->link\">";
      $txt .= show_image($mitem, $roll);
		  $txt .= '</a>';
      }

        break;

	} 

    return $txt;

}


function show_image($mitem, $roll){
global $Itemid;

		jimport( 'joomla.application.component.helper' );
		$menu_params = new stdClass();
			

      $menu_params = JComponentHelper::getParams( 'mod_mg_menu' );

			$menu_image = $menu_params->def( 'menu_image', -1 );

			if ( ( $menu_image != '-1' ) && $menu_image && (strlen($menu_image)>0)) {

				$ima = explode(".", $menu_image);		

				$image = '<img src="images/stories/'.(($_REQUEST['Itemid'] == ($mitem->id)) ? $ima[0] . $roll . "." . $ima[1] : $menu_image) . '" border="0" alt="'. $mitem->name . '" onmouseover="javascript:this.src=\'images/stories/' . $ima[0] . $roll . "." . $ima[1] . '\'" onmouseout="javascript:this.src=\'/images/stories/' . (($_REQUEST['Itemid'] == ($mitem->id)) ? $ima[0] . $roll . "." . $ima[1]  : $menu_image) . '\'" />';

				$txt.=$image;

        }else{
		    $txt .= $mitem->name;
		   }
		   return $txt;
}
?>
