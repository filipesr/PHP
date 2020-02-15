<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.event.plugin');

class plgSystemUltiPolaroid extends JPlugin
{
  function plgSystemUltiPolaroid(&$subject, $config)
  {
	parent::__construct($subject,$config);
  }
  
  function onAfterDispatch()
  {
        global $mainframe;
	if ($mainframe->isAdmin()) {
         return;
        }

       JHTML::script('polaroid.js','plugins/system/javascript/',false);
  }   
  
  function onAfterRender()
  {
    // just startup
    global $mainframe;
    global $mybaseurl;

    if ($mainframe->isAdmin()) {
      return;
    }

    $plugin =& JPluginHelper::getPlugin('system', 'Ulti Polaroid');
    $tag=$this->params->get('tag');	
    $regex='#{'.$tag.'(.*?)}\s?(.*?)\s?{/'.$tag.'}#';
    $matches = array();

    //Get all the matching verses
    $buffer = JResponse::getBody();
    $ct= preg_match_all( $regex, $buffer, $matches ); 

    
    //For each match repleace the regx with a link to the verse.
    for($i=0;$i<$ct;$i++)
    {
      $imagelink=$matches[2][$i];
      $parameters = $matches[1][$i];
      // alt
      ereg("alt=\s?\"\s?([^\"]*)\s?\"",$parameters ,$altparam );
      $altvalue = $altparam[1];
      
      // title
      ereg("title=\s?\"\s?([^\"]*)\s?\"",$parameters ,$titleparam );
      $titlevalue = $titleparam[1];      
      
      // width
      ereg(" width=\s?\"\s?([^\"]*)\s?\"",$parameters ,$widthparam );
      $widthvalue = $widthparam[1];            

      // height
      ereg("height=\s?\"\s?([^\"]*)\s?\"",$parameters ,$heightparam );
      $heightvalue = $heightparam[1];            
      
      // rotation
      ereg("rotation=\s?\"\s?([^\"]*)\s?\"",$parameters ,$rotationparam );
      $rotationvalue = $rotationparam[1];      

      // bordercolor
      ereg("bordercolor=\s?\"\s?([^\"]*)\s?\"",$parameters ,$bordercolorparam );
      $bordercolorvalue = $bordercolorparam[1];  

      // borderwidth
      ereg("borderwidth=\s?\"\s?([^\"]*)\s?\"",$parameters ,$borderwidthparam );
      $borderwidthvalue = $borderwidthparam[1];        
      
      // shadowcolor
      ereg("shadowcolor=\s?\"\s?([^\"]*)\s?\"",$parameters ,$shadowcolorparam );
      $shadowcolorvalue = $shadowcolorparam[1];        

      // shadowopacity
      ereg("shadowopacity=\s?\"\s?([^\"]*)\s?\"",$parameters ,$shadowopacityparam );
      $shadowopacityvalue = $shadowopacityparam[1];          

      $link="<img src=\"".JURI::base()."/images/".$imagelink."\" class=\"polaroidimage\" 
                  onload=\"makePolaroid(this,'".$rotationvalue."','".$bordercolorvalue."','".$borderwidthvalue."','".$shadowcolorvalue."','".$shadowopacityvalue."')\"";
//      if($altvalue!="") {
        $link .= " alt=\"".$altvalue."\"";
//      }
      if($titlevalue!="") {
        $link .= " title=\"".$titlevalue."\"";
      }        
      if($widthvalue!="") {
        $link .= " width=\"".$widthvalue."\"";
      }      
      if($heightvalue!="") {
        $link .= " height=\"".$heightvalue."\"";
      }                            
      $link .= " />";
      $buffer=str_replace($matches[0][$i], $link, $buffer);
    }
    JResponse::setBody($buffer);
    return true;	  
  }
}

?>