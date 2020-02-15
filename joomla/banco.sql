-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tempo de Geração: Jun 10, 2009 as 11:36 AM
-- Versão do Servidor: 5.0.45
-- Versão do PHP: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Banco de Dados: `orlaonli_dbwork`
-- 

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_banner`
-- 

CREATE TABLE `jos_banner` (
  `bid` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL default '0',
  `type` varchar(30) NOT NULL default 'banner',
  `name` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `imptotal` int(11) NOT NULL default '0',
  `impmade` int(11) NOT NULL default '0',
  `clicks` int(11) NOT NULL default '0',
  `imageurl` varchar(100) NOT NULL default '',
  `clickurl` varchar(200) NOT NULL default '',
  `date` datetime default NULL,
  `showBanner` tinyint(1) NOT NULL default '0',
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `editor` varchar(50) default NULL,
  `custombannercode` text,
  `catid` int(10) unsigned NOT NULL default '0',
  `description` text NOT NULL,
  `sticky` tinyint(1) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  `tags` text NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY  (`bid`),
  KEY `viewbanner` (`showBanner`),
  KEY `idx_banner_catid` (`catid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Extraindo dados da tabela `jos_banner`
-- 

INSERT INTO `jos_banner` (`bid`, `cid`, `type`, `name`, `alias`, `imptotal`, `impmade`, `clicks`, `imageurl`, `clickurl`, `date`, `showBanner`, `checked_out`, `checked_out_time`, `editor`, `custombannercode`, `catid`, `description`, `sticky`, `ordering`, `publish_up`, `publish_down`, `tags`, `params`) VALUES 
(1, 1, '', 'SigSystem', 'sigsystem', 0, 210, 0, '', 'http://www.sigsystem.com.br', '2009-06-08 18:26:43', 1, 0, '0000-00-00 00:00:00', '', '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="414" height="64" title="SigSystem">\r\n  <param name="movie" value="http://localhost/joomla/images/banners/banner_SigCar.swf" />\r\n  <param name="quality" value="high" />\r\n  <embed src="http://localhost/joomla/images/banners/banner_SigCar.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="414" height="64"></embed>\r\n</object>', 8, '', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 'width=0\nheight=0');

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_bannerclient`
-- 

CREATE TABLE `jos_bannerclient` (
  `cid` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `contact` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `extrainfo` text NOT NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` time default NULL,
  `editor` varchar(50) default NULL,
  PRIMARY KEY  (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Extraindo dados da tabela `jos_bannerclient`
-- 

INSERT INTO `jos_bannerclient` (`cid`, `name`, `contact`, `email`, `extrainfo`, `checked_out`, `checked_out_time`, `editor`) VALUES 
(1, 'Filipe', 'Filipe', 'fsr.trabalho@gmail.com', '', 0, '00:00:00', '');

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_bannertrack`
-- 

CREATE TABLE `jos_bannertrack` (
  `track_date` date NOT NULL,
  `track_type` int(10) unsigned NOT NULL,
  `banner_id` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Extraindo dados da tabela `jos_bannertrack`
-- 


-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_categories`
-- 

CREATE TABLE `jos_categories` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `image` varchar(255) NOT NULL default '',
  `section` varchar(50) NOT NULL default '',
  `image_position` varchar(30) NOT NULL default '',
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `editor` varchar(50) default NULL,
  `ordering` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `cat_idx` (`section`,`published`,`access`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- 
-- Extraindo dados da tabela `jos_categories`
-- 

INSERT INTO `jos_categories` (`id`, `parent_id`, `title`, `name`, `alias`, `image`, `section`, `image_position`, `description`, `published`, `checked_out`, `checked_out_time`, `editor`, `ordering`, `access`, `count`, `params`) VALUES 
(3, 0, 'Brasil', '', 'brasil', '', '1', 'left', '', 1, 0, '0000-00-00 00:00:00', NULL, 2, 0, 0, ''),
(2, 0, 'Turismo', '', 'turismo', '', '1', 'left', '', 1, 0, '0000-00-00 00:00:00', NULL, 1, 0, 0, ''),
(4, 0, 'Cotidiano', '', 'cotidiano', '', '1', 'left', '', 1, 0, '0000-00-00 00:00:00', NULL, 3, 0, 0, ''),
(5, 0, 'Economia', '', 'economia', '', '1', 'left', '', 1, 0, '0000-00-00 00:00:00', NULL, 4, 0, 0, ''),
(6, 0, 'Educação', '', 'educacao', '', '1', 'left', '', 1, 0, '0000-00-00 00:00:00', NULL, 5, 0, 0, ''),
(7, 0, 'Esportes', '', 'esportes', '', '1', 'left', '', 1, 0, '0000-00-00 00:00:00', NULL, 6, 0, 0, ''),
(8, 0, 'Filipe', '', 'filipe', '', 'com_banner', 'left', '', 1, 0, '0000-00-00 00:00:00', NULL, 1, 0, 0, '');

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_components`
-- 

CREATE TABLE `jos_components` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `menuid` int(11) unsigned NOT NULL default '0',
  `parent` int(11) unsigned NOT NULL default '0',
  `admin_menu_link` varchar(255) NOT NULL default '',
  `admin_menu_alt` varchar(255) NOT NULL default '',
  `option` varchar(50) NOT NULL default '',
  `ordering` int(11) NOT NULL default '0',
  `admin_menu_img` varchar(255) NOT NULL default '',
  `iscore` tinyint(4) NOT NULL default '0',
  `params` text NOT NULL,
  `enabled` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `parent_option` (`parent`,`option`(32))
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

-- 
-- Extraindo dados da tabela `jos_components`
-- 

INSERT INTO `jos_components` (`id`, `name`, `link`, `menuid`, `parent`, `admin_menu_link`, `admin_menu_alt`, `option`, `ordering`, `admin_menu_img`, `iscore`, `params`, `enabled`) VALUES 
(1, 'Banners', '', 0, 0, '', 'Banner Management', 'com_banners', 0, 'js/ThemeOffice/component.png', 0, 'track_impressions=0\ntrack_clicks=0\ntag_prefix=\n\n', 1),
(2, 'Banners', '', 0, 1, 'option=com_banners', 'Active Banners', 'com_banners', 1, 'js/ThemeOffice/edit.png', 0, '', 1),
(3, 'Clients', '', 0, 1, 'option=com_banners&c=client', 'Manage Clients', 'com_banners', 2, 'js/ThemeOffice/categories.png', 0, '', 1),
(4, 'Web Links', 'option=com_weblinks', 0, 0, '', 'Manage Weblinks', 'com_weblinks', 0, 'js/ThemeOffice/component.png', 0, 'show_comp_description=1\ncomp_description=\nshow_link_hits=1\nshow_link_description=1\nshow_other_cats=1\nshow_headings=1\nshow_page_title=1\nlink_target=0\nlink_icons=\n\n', 1),
(5, 'Links', '', 0, 4, 'option=com_weblinks', 'View existing weblinks', 'com_weblinks', 1, 'js/ThemeOffice/edit.png', 0, '', 1),
(6, 'Categories', '', 0, 4, 'option=com_categories&section=com_weblinks', 'Manage weblink categories', '', 2, 'js/ThemeOffice/categories.png', 0, '', 1),
(7, 'Contacts', 'option=com_contact', 0, 0, '', 'Edit contact details', 'com_contact', 0, 'js/ThemeOffice/component.png', 1, 'contact_icons=0\nicon_address=\nicon_email=\nicon_telephone=\nicon_fax=\nicon_misc=\nshow_headings=1\nshow_position=1\nshow_email=0\nshow_telephone=1\nshow_mobile=1\nshow_fax=1\nbannedEmail=\nbannedSubject=\nbannedText=\nsession=1\ncustomReply=0\n\n', 1),
(8, 'Contacts', '', 0, 7, 'option=com_contact', 'Edit contact details', 'com_contact', 0, 'js/ThemeOffice/edit.png', 1, '', 1),
(9, 'Categories', '', 0, 7, 'option=com_categories&section=com_contact_details', 'Manage contact categories', '', 2, 'js/ThemeOffice/categories.png', 1, 'contact_icons=0\nicon_address=\nicon_email=\nicon_telephone=\nicon_fax=\nicon_misc=\nshow_headings=1\nshow_position=1\nshow_email=0\nshow_telephone=1\nshow_mobile=1\nshow_fax=1\nbannedEmail=\nbannedSubject=\nbannedText=\nsession=1\ncustomReply=0\n\n', 1),
(10, 'Polls', 'option=com_poll', 0, 0, 'option=com_poll', 'Manage Polls', 'com_poll', 0, 'js/ThemeOffice/component.png', 0, '', 1),
(11, 'News Feeds', 'option=com_newsfeeds', 0, 0, '', 'News Feeds Management', 'com_newsfeeds', 0, 'js/ThemeOffice/component.png', 0, '', 1),
(12, 'Feeds', '', 0, 11, 'option=com_newsfeeds', 'Manage News Feeds', 'com_newsfeeds', 1, 'js/ThemeOffice/edit.png', 0, 'show_headings=1\nshow_name=1\nshow_articles=1\nshow_link=1\nshow_cat_description=1\nshow_cat_items=1\nshow_feed_image=1\nshow_feed_description=1\nshow_item_description=1\nfeed_word_count=0\n\n', 1),
(13, 'Categories', '', 0, 11, 'option=com_categories&section=com_newsfeeds', 'Manage Categories', '', 2, 'js/ThemeOffice/categories.png', 0, '', 1),
(14, 'User', 'option=com_user', 0, 0, '', '', 'com_user', 0, '', 1, '', 1),
(15, 'Search', 'option=com_search', 0, 0, 'option=com_search', 'Search Statistics', 'com_search', 0, 'js/ThemeOffice/component.png', 1, 'enabled=0\n\n', 1),
(16, 'Categories', '', 0, 1, 'option=com_categories&section=com_banner', 'Categories', '', 3, '', 1, '', 1),
(17, 'Wrapper', 'option=com_wrapper', 0, 0, '', 'Wrapper', 'com_wrapper', 0, '', 1, '', 1),
(18, 'Mail To', '', 0, 0, '', '', 'com_mailto', 0, '', 1, '', 1),
(19, 'Media Manager', '', 0, 0, 'option=com_media', 'Media Manager', 'com_media', 0, '', 1, 'upload_extensions=bmp,csv,doc,epg,gif,ico,jpg,odg,odp,ods,odt,pdf,png,ppt,swf,txt,xcf,xls,BMP,CSV,DOC,EPG,GIF,ICO,JPG,ODG,ODP,ODS,ODT,PDF,PNG,PPT,SWF,TXT,XCF,XLS\nupload_maxsize=10000000\nfile_path=images\nimage_path=images/stories\nrestrict_uploads=1\nallowed_media_usergroup=3\ncheck_mime=1\nimage_extensions=bmp,gif,jpg,png\nignore_extensions=\nupload_mime=image/jpeg,image/gif,image/png,image/bmp,application/x-shockwave-flash,application/msword,application/excel,application/pdf,application/powerpoint,text/plain,application/x-zip\nupload_mime_illegal=text/html\nenable_flash=0\n\n', 1),
(20, 'Articles', 'option=com_content', 0, 0, '', '', 'com_content', 0, '', 1, 'show_noauth=0\nshow_title=1\nlink_titles=0\nshow_intro=1\nshow_section=0\nlink_section=0\nshow_category=0\nlink_category=0\nshow_author=0\nshow_create_date=1\nshow_modify_date=1\nshow_item_navigation=1\nshow_readmore=1\nshow_vote=1\nshow_icons=1\nshow_pdf_icon=1\nshow_print_icon=1\nshow_email_icon=0\nshow_hits=1\nfeed_summary=0\nfilter_tags=\nfilter_attritbutes=\n\n', 1),
(21, 'Configuration Manager', '', 0, 0, '', 'Configuration', 'com_config', 0, '', 1, '', 1),
(22, 'Installation Manager', '', 0, 0, '', 'Installer', 'com_installer', 0, '', 1, '', 1),
(23, 'Language Manager', '', 0, 0, '', 'Languages', 'com_languages', 0, '', 1, 'site=pt-BR\nadministrator=pt-BR\n\n', 1),
(24, 'Mass mail', '', 0, 0, '', 'Mass Mail', 'com_massmail', 0, '', 1, 'mailSubjectPrefix=\nmailBodySuffix=\n\n', 1),
(25, 'Menu Editor', '', 0, 0, '', 'Menu Editor', 'com_menus', 0, '', 1, '', 1),
(27, 'Messaging', '', 0, 0, '', 'Messages', 'com_messages', 0, '', 1, '', 1),
(28, 'Modules Manager', '', 0, 0, '', 'Modules', 'com_modules', 0, '', 1, '', 1),
(29, 'Plugin Manager', '', 0, 0, '', 'Plugins', 'com_plugins', 0, '', 1, '', 1),
(30, 'Template Manager', '', 0, 0, '', 'Templates', 'com_templates', 0, '', 1, '', 1),
(31, 'User Manager', '', 0, 0, '', 'Users', 'com_users', 0, '', 1, 'allowUserRegistration=0\nnew_usertype=Registered\nuseractivation=1\nfrontend_userparams=1\n\n', 1),
(32, 'Cache Manager', '', 0, 0, '', 'Cache', 'com_cache', 0, '', 1, '', 1),
(33, 'Control Panel', '', 0, 0, '', 'Control Panel', 'com_cpanel', 0, '', 1, '', 1),
(34, 'Phoca Gallery', 'option=com_phocagallery', 0, 0, 'option=com_phocagallery', 'Phoca Gallery', 'com_phocagallery', 0, 'components/com_phocagallery/assets/images/icon-16-menu.png', 0, 'font_color=#b36b00\nbackground_color=#fcfcfc\nbackground_color_hover=#f5f5f5\nimage_background_color=#f5f5f5\nimage_background_shadow=shadow1\nborder_color=#e8e8e8\nborder_color_hover=#b36b00\nmargin_box=5\npadding_box=5\ndisplay_name=1\ndisplay_icon_detail=1\ndisplay_icon_download=1\ndisplay_icon_folder=0\nfont_size_name=12\nchar_length_name=15\ncategory_box_space=0\ndisplay_categories_sub=0\ndisplay_subcat_page=0\ndisplay_icon_random_image=0\ndisplay_back_button=1\ndisplay_categories_back_button=1\ndisplay_categories_cv=0\ndisplay_subcat_page_cv=0\ndisplay_icon_random_image_cv=0\ndisplay_back_button_cv=1\ndisplay_categories_back_button_cv=1\ncategories_columns_cv=1\ndisplay_image_categories_cv=1\nimage_categories_size_cv=4\ncategories_columns=1\ndisplay_image_categories=1\nimage_categories_size=4\ndisplay_subcategories=1\ndisplay_empty_categories=0\nhide_categories=\ndisplay_access_category=1\ndetail_window=0\ndetail_window_background_color=#ffffff\nmodal_box_overlay_color=#000000\nmodal_box_overlay_opacity=0.3\nmodal_box_border_color=#6b6b6b\nmodal_box_border_width=2\nsb_slideshow_delay=5\nsb_lang=pt\ndisplay_description_detail=0\ndisplay_title_description=0\nfont_size_desc=11\nfont_color_desc=#333333\ndescription_detail_height=16\ndescription_lightbox_font_size=12\ndescription_lightbox_font_color=#ffffff\ndescription_lightbox_bg_color=#000000\nslideshow_delay=5000\nslideshow_pause=0\nslideshow_random=0\ndetail_buttons=1\nphocagallery_width=\ndisplay_phoca_info=7\ndefault_pagination=20\npagination=5;10;15;20;50\ncategory_ordering=1\nimage_ordering=1\nenable_piclens=0\nstart_piclens=0\npiclens_image=1\nswitch_image=0\nswitch_width=640\nswitch_height=480\nenable_overlib=0\nol_bg_color=#666666\nol_fg_color=#f6f6f6\nol_tf_color=#000000\nol_cf_color=#ffffff\noverlib_overlay_opacity=0.7\ncreate_watermark=1\nwatermark_position_x=center\nwatermark_position_y=middle\ndisplay_icon_vm=0\nenable_user_cp=1\nmax_create_cat_char=1000\ndisplay_rating=1\ndisplay_comment=0\ncomment_width=500\nmax_comment_char=1000\ndisplay_category_statistics=0\ndisplay_main_cat_stat=1\ndisplay_lastadded_cat_stat=1\ncount_lastadded_cat_stat=3\ndisplay_mostviewed_cat_stat=1\ncount_mostviewed_cat_stat=3\ndisplay_camera_info=0\nexif_information=FILE.FileName;FILE.FileDateTime;FILE.FileSize;FILE.MimeType;COMPUTED.Height;COMPUTED.Width;COMPUTED.IsColor;COMPUTED.ApertureFNumber;IFD0.Make;IFD0.Model;IFD0.Orientation;IFD0.XResolution;IFD0.YResolution;IFD0.ResolutionUnit;IFD0.Software;IFD0.DateTime;IFD0.Exif_IFD_Pointer;IFD0.GPS_IFD_Pointer;EXIF.ExposureTime;EXIF.FNumber;EXIF.ExposureProgram;EXIF.ISOSpeedRatings;EXIF.ExifVersion;EXIF.DateTimeOriginal;EXIF.DateTimeDigitized;EXIF.ShutterSpeedValue;EXIF.ApertureValue;EXIF.ExposureBiasValue;EXIF.MaxApertureValue;EXIF.MeteringMode;EXIF.LightSource;EXIF.Flash;EXIF.FocalLength;EXIF.SubSecTimeOriginal;EXIF.SubSecTimeDigitized;EXIF.ColorSpace;EXIF.ExifImageWidth;EXIF.ExifImageLength;EXIF.SensingMethod;EXIF.CustomRendered;EXIF.ExposureMode;EXIF.WhiteBalance;EXIF.DigitalZoomRatio;EXIF.FocalLengthIn35mmFilm;EXIF.SceneCaptureType;EXIF.GainControl;EXIF.Contrast;EXIF.Saturation;EXIF.Sharpness;EXIF.SubjectDistanceRange;GPS.GPSLatitudeRef;GPS.GPSLatitude;GPS.GPSLongitudeRef;GPS.GPSLongitude;GPS.GPSAltitudeRef;GPS.GPSAltitude;GPS.GPSTimeStamp;GPS.GPSStatus;GPS.GPSMapDatum;GPS.GPSDateStamp\ngoogle_maps_api_key=\ndisplay_categories_geotagging=0\ncategories_lng=\ncategories_lat=\ncategories_zoom=2\ncategories_map_width=500\ncategories_map_height=500\ndisplay_icon_geotagging=0\ndisplay_category_geotagging=0\ncategory_map_width=500\ncategory_map_height=400\ndisplay_title_upload=1\ndisplay_description_upload=1\nmax_upload_char=1000\nupload_maxsize=3000000\ncat_folder_maxsize=20000000\nenable_java=0\njava_resize_width=-1\njava_resize_height=-1\njava_box_width=480\njava_box_height=480\npagination_thumbnail_creation=0\nclean_thumbnails=0\nenable_thumb_creation=1\ncrop_thumbnail=5\njpeg_quality=85\nicon_format=gif\nlarge_image_width=640\nlarge_image_height=480\nmedium_image_width=100\nmedium_image_height=100\nsmall_image_width=50\nsmall_image_height=50\nfront_modal_box_width=680\nfront_modal_box_height=560\nadmin_modal_box_width=680\nadmin_modal_box_height=520\n\n', 1),
(35, 'Control Panel', '', 0, 34, 'option=com_phocagallery', 'Control Panel', 'com_phocagallery', 0, 'components/com_phocagallery/assets/images/icon-16-control-panel.png', 0, '', 1),
(36, 'Images', '', 0, 34, 'option=com_phocagallery&view=phocagallerys', 'Images', 'com_phocagallery', 1, 'components/com_phocagallery/assets/images/icon-16-menu-gal.png', 0, '', 1),
(37, 'Categories', '', 0, 34, 'option=com_phocagallery&view=phocagallerycs', 'Categories', 'com_phocagallery', 2, 'components/com_phocagallery/assets/images/icon-16-menu-cat.png', 0, '', 1),
(38, 'Themes', '', 0, 34, 'option=com_phocagallery&view=phocagalleryt', 'Themes', 'com_phocagallery', 3, 'components/com_phocagallery/assets/images/icon-16-menu-theme.png', 0, '', 1),
(39, 'Rating', '', 0, 34, 'option=com_phocagallery&view=phocagalleryra', 'Rating', 'com_phocagallery', 4, 'components/com_phocagallery/assets/images/icon-16-menu-vote.png', 0, '', 1),
(40, 'Comments', '', 0, 34, 'option=com_phocagallery&view=phocagallerycos', 'Comments', 'com_phocagallery', 5, 'components/com_phocagallery/assets/images/icon-16-menu-comment.png', 0, '', 1),
(41, 'Info', '', 0, 34, 'option=com_phocagallery&view=phocagalleryin', 'Info', 'com_phocagallery', 6, 'components/com_phocagallery/assets/images/icon-16-menu-info.png', 0, '', 1),
(42, 'Podcast Suite', 'option=com_podcast', 0, 0, 'option=com_podcast', 'Podcast Suite', 'com_podcast', 0, 'js/ThemeOffice/component.png', 0, '', 1),
(43, 'Manage Clips', '', 0, 42, 'option=com_podcast&view=files', 'Manage Clips', 'com_podcast', 0, 'js/ThemeOffice/component.png', 0, '', 1),
(44, 'Information', '', 0, 42, 'option=com_podcast&view=info', 'Information', 'com_podcast', 1, 'js/ThemeOffice/component.png', 0, '', 1);

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_contact_details`
-- 

CREATE TABLE `jos_contact_details` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `con_position` varchar(255) default NULL,
  `address` text,
  `suburb` varchar(100) default NULL,
  `state` varchar(100) default NULL,
  `country` varchar(100) default NULL,
  `postcode` varchar(100) default NULL,
  `telephone` varchar(255) default NULL,
  `fax` varchar(255) default NULL,
  `misc` mediumtext,
  `image` varchar(255) default NULL,
  `imagepos` varchar(20) default NULL,
  `email_to` varchar(255) default NULL,
  `default_con` tinyint(1) unsigned NOT NULL default '0',
  `published` tinyint(1) unsigned NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  `user_id` int(11) NOT NULL default '0',
  `catid` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `mobile` varchar(255) NOT NULL default '',
  `webpage` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Extraindo dados da tabela `jos_contact_details`
-- 


-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_content`
-- 

CREATE TABLE `jos_content` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `title_alias` varchar(255) NOT NULL default '',
  `introtext` mediumtext NOT NULL,
  `fulltext` mediumtext NOT NULL,
  `state` tinyint(3) NOT NULL default '0',
  `sectionid` int(11) unsigned NOT NULL default '0',
  `mask` int(11) unsigned NOT NULL default '0',
  `catid` int(11) unsigned NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) unsigned NOT NULL default '0',
  `created_by_alias` varchar(255) NOT NULL default '',
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) unsigned NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  `images` text NOT NULL,
  `urls` text NOT NULL,
  `attribs` text NOT NULL,
  `version` int(11) unsigned NOT NULL default '1',
  `parentid` int(11) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `access` int(11) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '0',
  `metadata` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_section` (`sectionid`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Extraindo dados da tabela `jos_content`
-- 

INSERT INTO `jos_content` (`id`, `title`, `alias`, `title_alias`, `introtext`, `fulltext`, `state`, `sectionid`, `mask`, `catid`, `created`, `created_by`, `created_by_alias`, `modified`, `modified_by`, `checked_out`, `checked_out_time`, `publish_up`, `publish_down`, `images`, `urls`, `attribs`, `version`, `parentid`, `ordering`, `metakey`, `metadesc`, `access`, `hits`, `metadata`) VALUES 
(1, 'Ouro Preto lembra os 85 anos da  Semana Santa modernista', 'ouropretolembraos85anosdasemanasantamodernista', '', '<!--[if gte mso 9]><xml>  <w:WordDocument>   <w:View>Normal</w:View>   <w:Zoom>0</w:Zoom>   <w:HyphenationZone>21</w:HyphenationZone>   <w:PunctuationKerning/>   <w:ValidateAgainstSchemas/>   <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid>   <w:IgnoreMixedContent>false</w:IgnoreMixedContent>   <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText>   <w:Compatibility>    <w:BreakWrappedTables/>    <w:SnapToGridInCell/>    <w:WrapTextWithPunct/>    <w:UseAsianBreakRules/>    <w:DontGrowAutofit/>   </w:Compatibility>   <w:BrowserLevel>MicrosoftInternetExplorer4</w:BrowserLevel>  </w:WordDocument> </xml><![endif]--><!--[if gte mso 9]><xml>  <w:LatentStyles DefLockedState="false" LatentStyleCount="156">  </w:LatentStyles> </xml><![endif]--><!--[if !mso]><object  classid="clsid:38481807-CA0E-42D2-BF39-B33AF135CC4D" id=ieooui></object> <style> st1\\:*{behavior:url(#ieooui) } </style> <![endif]--> <!--  /* Font Definitions */  @font-face 	{font-family:Tahoma; 	panose-1:2 11 6 4 3 5 4 4 2 4; 	mso-font-charset:0; 	mso-generic-font-family:swiss; 	mso-font-pitch:variable; 	mso-font-signature:1627421319 -2147483648 8 0 66047 0;}  /* Style Definitions */  p.MsoNormal, li.MsoNormal, div.MsoNormal 	{mso-style-parent:""; 	margin:0cm; 	margin-bottom:.0001pt; 	mso-pagination:widow-orphan; 	font-size:12.0pt; 	font-family:"Times New Roman"; 	mso-fareast-font-family:"Times New Roman";} a:link, span.MsoHyperlink 	{color:blue; 	text-decoration:underline; 	text-underline:single;} a:visited, span.MsoHyperlinkFollowed 	{color:purple; 	text-decoration:underline; 	text-underline:single;} @page Section1 	{size:612.0pt 792.0pt; 	margin:70.85pt 3.0cm 70.85pt 3.0cm; 	mso-header-margin:36.0pt; 	mso-footer-margin:36.0pt; 	mso-paper-source:0;} div.Section1 	{page:Section1;} --> <!--[if gte mso 10]> <style>  /* Style Definitions */  table.MsoNormalTable 	{mso-style-name:"Table Normal"; 	mso-tstyle-rowband-size:0; 	mso-tstyle-colband-size:0; 	mso-style-noshow:yes; 	mso-style-parent:""; 	mso-padding-alt:0cm 5.4pt 0cm 5.4pt; 	mso-para-margin:0cm; 	mso-para-margin-bottom:.0001pt; 	mso-pagination:widow-orphan; 	font-size:10.0pt; 	font-family:"Times New Roman"; 	mso-ansi-language:#0400; 	mso-fareast-language:#0400; 	mso-bidi-language:#0400;} </style> <![endif]-->  <p style="text-align: justify; line-height: 115%" class="MsoNormal"><em><span style="font-family: Tahoma">Em abril de 1924, Mário, Oswald, Tarsila e Cendrars descobriram em Ouro Preto as raízes da cultura brasileira e novos rumos para o modernismo. Angelo Oswaldo fala sobre a célebre viagem dos modernistas às cidades históricas de Minas, há exatos 85 anos.</span></em></p>  <p style="text-align: justify; line-height: 115%" class="MsoNormal"><span style="font-family: Tahoma"> </span></p>  <p style="text-align: justify; line-height: 115%" class="MsoNormal"><span style="font-family: Tahoma">O jornalista, escritor e prefeito de Ouro Preto, Angelo Oswaldo, lembra os 85 anos da viagem dos modernistas de São Paulo a Ouro Preto, exatamente quando se celebrava a Semana Santa, em abril de 1924. “Foi a Semana Santa da Arte Moderna”, explica o prefeito e intelectual, ao evocar o impacto que a descoberta do acervo cultural de Minas Gerais pelos modernistas provocou nos rumos da renovação artística em pleno curso nos anos 20. Em 1922, a Semana de Arte Moderna, na cidade de São Paulo, havia marcado a grande ruptura, mas a Semana Santa mineira de 1924 foi o mergulho profundo dos modernistas nas fontes da história do Brasil. “Eles encontraram temas brasileiros para as formas arrojadas que vinham da Europa e sugeriam a recriação local, a antropofagia proclamada por Oswald de Andrade”.</span></p>  <p style="text-align: justify; line-height: 115%" class="MsoNormal"><span style="font-family: Tahoma"> </span></p>  <p style="text-align: justify; line-height: 115%" class="MsoNormal"><span style="font-family: Tahoma">Os poetas Mário de Andrade e Oswald de Andrade, a pintora Tarsila Amaral e o poeta suíço-francês Blaise Cendrars visitaram Ouro Preto e diversas outras cidades históricas, buscando as raízes da arte brasileira. Conquistaram, nessa viagem cheia de emoção, novas dimensões para as propostas com que revolucionavam a cultura do País. O barroco abrasileirado e a genialidade do Aleijadinho deram uma guinada na obra dos principais modernistas.</span></p>  <p style="text-align: justify; line-height: 115%" class="MsoNormal"><span style="font-family: Tahoma"> </span></p>  <p style="text-align: justify; line-height: 115%" class="MsoNormal"><span style="font-family: Tahoma">Angelo Oswaldo reconstitui o roteiro de Minas seguido pelos modernistas e analisa as ricas conseqüências da célebre excursão para a cultura brasileira. Dela resultaram, segundo ele, a Poesia Pau-Brasil, de Oswald, as cenas da estrada de ferro pintadas por Tarsila e o poema “Noturno de Belo Horizonte”, de Mário. “Macunaíma” e a Antropofagia decorrem do contato direto com as fontes genuínas que abasteceram a um novo entendimento da modernidade cultural do Brasil. A “kodack excursionista” flagrou uma nova imagem do Brasil e deu aos modernos a identidade pela qual ansiavam. </span></p>  <p style="text-align: justify; line-height: 115%" class="MsoNormal"><span style="font-family: Tahoma"> </span></p>  <p style="text-align: justify; line-height: 115%" class="MsoNormal"><span style="font-family: Tahoma">O poeta suíço-francês Blaise Cendrars, convidado dos paulistas, sintetizou esses rumos ao aconselhar aos modernistas que tomassem o trem para Minas e não mais navios para o Havre, porto que leva a Paris. Segundo Angelo Oswaldo, “conhecer Ouro Preto será sempre, na verdade, uma redescoberta do Brasil e da nossa identidade cultural”.</span></p>  <p style="text-align: justify; line-height: 115%" class="MsoNormal"><span style="font-family: Tahoma"> </span></p>  <p style="text-align: justify; line-height: 115%" class="MsoNormal"><span style="font-family: Tahoma"> </span></p>  <p style="text-align: justify; line-height: 115%" class="MsoNormal"><em><span style="font-family: Tahoma">Informações para imprensa:</span></em></p>  <p style="text-align: justify; line-height: 115%" class="MsoNormal"><em><span style="font-family: Tahoma">Converso Comunicação – <a href="mailto:conversocomunicacao@gmail.com">conversocomunicacao@gmail.com</a></span></em></p>  <p style="text-align: justify; line-height: 115%" class="MsoNormal"><em><span style="font-family: Tahoma">(31) 3551-0618 ou 9347-1422</span></em></p>  <em><span style="font-size: 12pt; font-family: Tahoma">Falar com Lícia Ribeiro ou Aline Monteiro</span></em>', '', 1, 1, 0, 2, '2009-06-07 02:31:49', 62, '', '0000-00-00 00:00:00', 0, 0, '0000-00-00 00:00:00', '2009-06-07 02:31:49', '0000-00-00 00:00:00', '', '', 'show_title=\nlink_titles=\nshow_intro=\nshow_section=\nlink_section=\nshow_category=\nlink_category=\nshow_vote=\nshow_author=\nshow_create_date=\nshow_modify_date=\nshow_pdf_icon=\nshow_print_icon=\nshow_email_icon=\nlanguage=\nkeyref=\nreadmore=', 1, 0, 3, '', '', 0, 18, 'robots=\nauthor='),
(2, 'Balneário Camboriú e Misiones efetivam parceria', 'balneario-camboriu-e-misiones-efetivam-parceria', '', '<!--[if gte mso 9]><xml>  <w:WordDocument>   <w:View>Normal</w:View>   <w:Zoom>0</w:Zoom>   <w:HyphenationZone>21</w:HyphenationZone>   <w:PunctuationKerning/>   <w:ValidateAgainstSchemas/>   <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid>   <w:IgnoreMixedContent>false</w:IgnoreMixedContent>   <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText>   <w:Compatibility>    <w:BreakWrappedTables/>    <w:SnapToGridInCell/>    <w:WrapTextWithPunct/>    <w:UseAsianBreakRules/>    <w:DontGrowAutofit/>   </w:Compatibility>   <w:BrowserLevel>MicrosoftInternetExplorer4</w:BrowserLevel>  </w:WordDocument> </xml><![endif]--><!--[if gte mso 9]><xml>  <w:LatentStyles DefLockedState="false" LatentStyleCount="156">  </w:LatentStyles> </xml><![endif]--><!--[if !mso]><object  classid="clsid:38481807-CA0E-42D2-BF39-B33AF135CC4D" id=ieooui></object> <style> st1\\:*{behavior:url(#ieooui) } </style> <![endif]--> <!--  /* Font Definitions */  @font-face 	{font-family:"Trebuchet MS"; 	panose-1:2 11 6 3 2 2 2 2 2 4; 	mso-font-charset:0; 	mso-generic-font-family:swiss; 	mso-font-pitch:variable; 	mso-font-signature:647 0 0 0 159 0;}  /* Style Definitions */  p.MsoNormal, li.MsoNormal, div.MsoNormal 	{mso-style-parent:""; 	margin:0cm; 	margin-bottom:.0001pt; 	mso-pagination:widow-orphan; 	font-size:12.0pt; 	font-family:"Times New Roman"; 	mso-fareast-font-family:"Times New Roman";} a:link, span.MsoHyperlink 	{color:blue; 	text-decoration:underline; 	text-underline:single;} a:visited, span.MsoHyperlinkFollowed 	{color:purple; 	text-decoration:underline; 	text-underline:single;} p 	{mso-margin-top-alt:auto; 	margin-right:0cm; 	mso-margin-bottom-alt:auto; 	margin-left:0cm; 	mso-pagination:widow-orphan; 	font-size:12.0pt; 	font-family:"Times New Roman"; 	mso-fareast-font-family:"Times New Roman";} @page Section1 	{size:612.0pt 792.0pt; 	margin:70.85pt 3.0cm 70.85pt 3.0cm; 	mso-header-margin:36.0pt; 	mso-footer-margin:36.0pt; 	mso-paper-source:0;} div.Section1 	{page:Section1;} --> <!--[if gte mso 10]> <style>  /* Style Definitions */  table.MsoNormalTable 	{mso-style-name:"Table Normal"; 	mso-tstyle-rowband-size:0; 	mso-tstyle-colband-size:0; 	mso-style-noshow:yes; 	mso-style-parent:""; 	mso-padding-alt:0cm 5.4pt 0cm 5.4pt; 	mso-para-margin:0cm; 	mso-para-margin-bottom:.0001pt; 	mso-pagination:widow-orphan; 	font-size:10.0pt; 	font-family:"Times New Roman"; 	mso-ansi-language:#0400; 	mso-fareast-language:#0400; 	mso-bidi-language:#0400;} </style> <![endif]-->  <p style="text-align: justify" class="MsoNormal"><span style="font-size: 10pt; font-family: ''Trebuchet MS''">Está chegando a Balneário Camboriú, neste final de semana, o caminhão conhecido na província argentina de Misiones como “<em>Embajador</em>”. O veículo integra a parceria entre a Prefeitura de Balneário Camboriú e o Ministério de Ecologia, Recursos Naturais, Renováveis e Turismo daquela província, firmada através de um acordo entre o Governo de Misiones <span> </span>e o prefeito Edson Renato Dias (Piriquito), que visitou aquele país ainda em dezembro, como prefeito-eleito da cidade. Com o caminhão, chegam 14 jornalistas argentinos, para conhecer e divulgar o acordo, além de promover Balneário Camboriú em suas reportagens.</span></p>  <p style="text-align: justify" class="MsoNormal"><span style="font-size: 10pt; font-family: ''Trebuchet MS''">A parceria consiste na divulgação mútua entre Balneário e Misiones, na qual o estado argentino fará exposição no interior do veículo, entre os dias 18 de janeiro (domingo) e 7 de fevereiro na Barra Sul,<span>  </span>dos seus recantos turísticos, folclore, mapa de localização e, entre outros atrativos, as Cataratas do Iguaçu pelo lado argentino. </span></p>  <p style="text-align: justify" class="MsoNormal"><span style="font-size: 10pt; font-family: ''Trebuchet MS''">Em contrapartida, a Prefeitura de Balneário Camboriú, através da Secretaria de Turismo e Desenvolvimento Econômico (Sectur), estará instalando gratuitamente, em toda a província de Misiones que é composta por 74 municípios, cerca de 250 outdoors. A arte dos painéis estará sob responsabilidade da Sectur. Balneário também receberá apoio da mídia argentina, em jornais, revistas, rádios, televisões e internet.</span></p>  <p style="text-align: justify" class="MsoNormal"><span style="font-size: 10pt; font-family: ''Trebuchet MS''">É a primeira vez que Balneário firma oficialmente parceria com Misiones. Segundo explica o diretor geral da Delegação de Turismo Área Internacional de Iguazú, Eduardo Allou, em reunião nesta sexta-feira na Sectur, o acordo é importante, para que a Argentina saiba que o turismo de nossa cidade continua intacto, após as enchentes de novembro do ano passado. “Nós recebemos informação de que a cidade estava alagada, infestada por ratos e que mais de 250<span>  </span>municípios catarinenses tinham sido atingidos pelas cheias. Precisávamos reverter essa situação”, conta o diretor, que já morou no Brasil e que tem carinho especial por Balneário desde 1974, quando conheceu a praia. “A visita de Piriquito a Misiones e a Assuncion foi muito importante, para mudar esta realidade. Se isso não ocorresse, o turismo deste município catarinense estaria muito prejudicado”, avalia Allou.</span></p>  <p style="text-align: justify" class="MsoNormal"><span style="font-size: 10pt; font-family: ''Trebuchet MS''">Os 14 jornalistas argentinos, que chegam com o “<em>Embajador</em>”, estarão visitando rotas e equipamentos turísticos locais, para produção de reportagens. Eles estarão fazendo um intercâmbio e recebendo jornalistas brasileiros. Para isso, estará sendo realizada uma coletiva no domingo, dia 18, às 10 horas, em frente ao caminhão. O diretor de Turismo argentino, Allou, estará explicando a parceria aos profissionais dos dois países e a Sectur estará recepcionando a comitiva argentina.</span></p>  <p style="text-align: justify" class="MsoNormal"><span style="font-size: 10pt; font-family: ''Trebuchet MS''"> </span></p>  <p style="text-align: justify" class="MsoNormal"><strong><span style="font-size: 10pt; font-family: ''Trebuchet MS''">O que é o <em>“Embajador</em>”?</span></strong></p>  <p style="text-align: justify" class="MsoNormal"><span style="font-size: 10pt; font-family: ''Trebuchet MS''">Caminhão todo equipado com materiais de divulgação de Misiones. Contém uma sala de cinema com 12 cadeiras e máquinas de acesso eletrônico às informações econômicas, culturais e turísticas das cidades misioneiras. Essa idéia estará sendo aproveitada em Balneário Camboriú, que já estuda a montagem de dois caminhões parecidos, para divulgar nossa praia em outras cidades e até no exterior. </span></p>  <p style="text-align: justify" class="MsoNormal"><span style="font-size: 10pt; font-family: ''Trebuchet MS''"> </span></p>  <p style="text-align: justify" class="MsoNormal"><strong><span style="font-size: 10pt; font-family: ''Trebuchet MS''">SERVIÇO</span></strong></p>  <p style="text-align: justify" class="MsoNormal"><span style="font-size: 10pt; font-family: ''Trebuchet MS''"> </span></p>  <p style="text-align: justify" class="MsoNormal"><strong><span style="font-size: 10pt; font-family: ''Trebuchet MS''">Coletiva à imprensa brasileira e argentina</span></strong></p>  <p style="text-align: justify" class="MsoNormal"><strong><span style="font-size: 10pt; font-family: ''Trebuchet MS''">Local: </span></strong><span style="font-size: 10pt; font-family: ''Trebuchet MS''">Barra Sul – ao lado do caminhão “<em>Embajador</em>”<strong></strong></span></p>  <p style="text-align: justify" class="MsoNormal"><strong><span style="font-size: 10pt; font-family: ''Trebuchet MS''">Horário: </span></strong><span style="font-size: 10pt; font-family: ''Trebuchet MS''">10 horas<strong></strong></span></p>  <p style="text-align: justify" class="MsoNormal"><strong><span style="font-size: 10pt; font-family: ''Trebuchet MS''">Haverá: </span></strong><span style="font-size: 10pt; font-family: ''Trebuchet MS''">Sorteio<strong> </strong>de brindes aos jornalistas presentes, como viagens, diárias em hotéis de Misiones, kits de erva-mate com bomba, cuia e erva (produto forte daquela província), alimentação e passeios no país vizinho. <strong></strong></span></p>  <p style="text-align: justify" class="MsoNormal"><span style="font-size: 10pt; font-family: ''Trebuchet MS''">----------------------------- </span></p>  <p><span style="font-size: 10pt">,Silvia C. Bomm - Ass. Comunicação<br /> Secretaria de Turismo e Desenvolvimento Econômico<br /> Prefeitura de Balneário Camboriú <br /> (47) 3367-8122 <br /> e-mail:<span>  </span><a href="mailto:comunicacao@secturbc.com.br">comunicacao@secturbc.com.br</a> <br /> <a href="http://www.camboriu.sc.gov.br/">www.camboriu.sc.gov.br</a> <br /> <a href="http://www.secturbc.com.br/">www.secturbc.com.br</a> </span></p>', '', 1, 1, 0, 2, '2009-06-08 18:07:59', 62, '', '0000-00-00 00:00:00', 0, 0, '0000-00-00 00:00:00', '2009-06-08 18:07:59', '0000-00-00 00:00:00', '', '', 'show_title=\nlink_titles=\nshow_intro=\nshow_section=\nlink_section=\nshow_category=\nlink_category=\nshow_vote=\nshow_author=\nshow_create_date=\nshow_modify_date=\nshow_pdf_icon=\nshow_print_icon=\nshow_email_icon=\nlanguage=\nkeyref=\nreadmore=', 1, 0, 2, '', '', 0, 5, 'robots=\nauthor='),
(3, 'Coelhinho na Praia encerrou com sucesso', 'coelhinho-na-praia-encerrou-com-sucesso', '', '<!--[if gte mso 9]><xml>  <w:WordDocument>   <w:View>Normal</w:View>   <w:Zoom>0</w:Zoom>   <w:HyphenationZone>21</w:HyphenationZone>   <w:PunctuationKerning/>   <w:ValidateAgainstSchemas/>   <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid>   <w:IgnoreMixedContent>false</w:IgnoreMixedContent>   <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText>   <w:Compatibility>    <w:BreakWrappedTables/>    <w:SnapToGridInCell/>    <w:WrapTextWithPunct/>    <w:UseAsianBreakRules/>    <w:DontGrowAutofit/>   </w:Compatibility>   <w:BrowserLevel>MicrosoftInternetExplorer4</w:BrowserLevel>  </w:WordDocument> </xml><![endif]--><!--[if gte mso 9]><xml>  <w:LatentStyles DefLockedState="false" LatentStyleCount="156">  </w:LatentStyles> </xml><![endif]--> <!--  /* Style Definitions */  p.MsoNormal, li.MsoNormal, div.MsoNormal 	{mso-style-parent:""; 	margin:0cm; 	margin-bottom:.0001pt; 	mso-pagination:widow-orphan; 	font-size:12.0pt; 	font-family:"Times New Roman"; 	mso-fareast-font-family:"Times New Roman";} a:link, span.MsoHyperlink 	{color:blue; 	text-decoration:underline; 	text-underline:single;} a:visited, span.MsoHyperlinkFollowed 	{color:purple; 	text-decoration:underline; 	text-underline:single;} @page Section1 	{size:612.0pt 792.0pt; 	margin:70.85pt 3.0cm 70.85pt 3.0cm; 	mso-header-margin:36.0pt; 	mso-footer-margin:36.0pt; 	mso-paper-source:0;} div.Section1 	{page:Section1;} --> <!--[if gte mso 10]> <style>  /* Style Definitions */  table.MsoNormalTable 	{mso-style-name:"Table Normal"; 	mso-tstyle-rowband-size:0; 	mso-tstyle-colband-size:0; 	mso-style-noshow:yes; 	mso-style-parent:""; 	mso-padding-alt:0cm 5.4pt 0cm 5.4pt; 	mso-para-margin:0cm; 	mso-para-margin-bottom:.0001pt; 	mso-pagination:widow-orphan; 	font-size:10.0pt; 	font-family:"Times New Roman"; 	mso-ansi-language:#0400; 	mso-fareast-language:#0400; 	mso-bidi-language:#0400;} </style> <![endif]-->  <p style="text-align: justify" class="MsoNormal">A Secretaria de Turismo e Desenvolvimento Econômico de Balneário Camboriú comemora o sucesso do projeto Coelhinho na Praia, realizado na Barra Sul, entre os dias 3 e 12 de abril, das 10 às 22h. Foram dez dias de grande visitação à casa do coelhinho, que manteve neste período várias atrações às crianças, como desenhos, pinturas em rostinho, brincadeiras com a família Coelho e ainda coelhinhos de verdade, que chamaram a atenção até dos adultos.</p>  <p style="text-align: justify" class="MsoNormal">&nbsp;</p>  <p style="text-align: justify" class="MsoNormal">O Coelhinho na Praia teve uma visitação surpreendente nestes dias de funcionamento. Chegou a atender <span>150 pessoas por hora</span>, atingindo a marca de dez <span>mil visitantes</span> no período. Foram feitas pinturas em aproximadamente dois mil rostinhos e distribuídos cerca de 30 mil unidades de bombons e balas. Famílias inteiras foram ver os coelhinhos que habitaram na Barra Sul até o dia de Páscoa. Ainda foram pintados pelas crianças centenas de desenhos, vários deles foram deixados no varal de talentos da casinha. </p>  <p style="text-align: justify" class="MsoNormal">&nbsp;</p>  <p style="text-align: justify" class="MsoNormal">O encerramento do projeto, no último sábado e domingo, contou com a apresentação cultural de grandes grupos de canto, dança, interpretação e recreação infantil, através do apoio da Fundação Cultural do município. No sábado, o coral show Criança Feliz, de Criciúma encantou a todos com grandes musicais. Foram apresentadas 22 canções, entre elas uma seleção de Elvis Presley, outra do filme Grease e grandes interpretações em ópera, MPB, e música internacional com um espetáculo de alto nível pelos cantores do grupo, na faixa etária entre 12 e 22 anos.</p>  <p style="text-align: justify" class="MsoNormal">&nbsp;</p>  <p style="text-align: justify" class="MsoNormal">No domingo foi a vez do Grupo de Dança Recriate, de Camboriú, e do Projeto Lançai a Rede, de Balneário Camboriú, fechar o evento Coelhinho na Praia com coreografias, peça teatral e canções para os baixinhos. O Recriarte trouxe ao palco cinco as coreografias: Caixinha de Música (balé clássico), Baião Sapateado (sapateado), Sebastiana (jazz), Raízes(jazz) e Escravos de Jó(jazz). O Grupo ainda encenou a peça A Coelha e o Tigre, que trouxe risos e diversão entre a garotada. Já o projeto Lançai a Rede animou a noite com os coelhos Zezé e Dih, a boneca Emília, o palhaço Bolinha, a Chapeuzinho Vermelho, a Abelha e o palhaço pipoquinha. As crianças cantaram e dançaram junto com o grupo.</p>  <p style="text-align: justify" class="MsoNormal">&nbsp;</p>  <p style="text-align: justify" class="MsoNormal">A primeira edição do Coelhinho na Praia, promovido pela Prefeitura de Balneário Camboriú através da Secretaria de Turismo, contou com a parceria da Secretaria de Inclusão Social (Centro de Treinamento Comunitário - CTC, Marcenaria Municipal e Clube de Mães); da Secretaria de Obras (Paisagismo); da Fundação Cultural de Balneário Camboriú; dos recursos da Cosip – Contribuição sobre Iluminação Pública; e ainda com a parceria da Polícia Militar, Secretaria Municipal de Segurança, Vigilância Sanitária entre outros órgãos que auxiliaram o projeto.</p>  <p style="text-align: justify" class="MsoNormal">&nbsp;</p>  <p class="MsoNormal">&nbsp;</p>  <p class="MsoNormal">Silvia C. Bomm - Ass. Comunicação<br /> Secretaria de Turismo e Desenvolvimento Econômico<br /> Prefeitura de Balneário Camboriú<br /> (47) 3367-8122<br /> e-mail:  <a href="mailto:comunicacao@secturbc.com.br">comunicacao@secturbc.com.br</a><br /> <a href="http://www.camboriu.sc.gov.br/">www.camboriu.sc.gov.br</a><br /> <a href="http://www.secturbc.com.br/">www.secturbc.com.br</a></p>', '', 1, 1, 0, 2, '2009-06-08 18:12:22', 62, '', '0000-00-00 00:00:00', 0, 0, '0000-00-00 00:00:00', '2009-06-08 18:12:22', '0000-00-00 00:00:00', '', '', 'show_title=\nlink_titles=\nshow_intro=\nshow_section=\nlink_section=\nshow_category=\nlink_category=\nshow_vote=\nshow_author=\nshow_create_date=\nshow_modify_date=\nshow_pdf_icon=\nshow_print_icon=\nshow_email_icon=\nlanguage=\nkeyref=\nreadmore=', 1, 0, 1, '', '', 0, 0, 'robots=\nauthor=');

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_content_frontpage`
-- 

CREATE TABLE `jos_content_frontpage` (
  `content_id` int(11) NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY  (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Extraindo dados da tabela `jos_content_frontpage`
-- 


-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_content_rating`
-- 

CREATE TABLE `jos_content_rating` (
  `content_id` int(11) NOT NULL default '0',
  `rating_sum` int(11) unsigned NOT NULL default '0',
  `rating_count` int(11) unsigned NOT NULL default '0',
  `lastip` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Extraindo dados da tabela `jos_content_rating`
-- 

INSERT INTO `jos_content_rating` (`content_id`, `rating_sum`, `rating_count`, `lastip`) VALUES 
(1, 5, 1, '127.0.0.1'),
(2, 5, 1, '127.0.0.1');

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_core_acl_aro`
-- 

CREATE TABLE `jos_core_acl_aro` (
  `id` int(11) NOT NULL auto_increment,
  `section_value` varchar(240) NOT NULL default '0',
  `value` varchar(240) NOT NULL default '',
  `order_value` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `jos_section_value_value_aro` (`section_value`(100),`value`(100)),
  KEY `jos_gacl_hidden_aro` (`hidden`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- 
-- Extraindo dados da tabela `jos_core_acl_aro`
-- 

INSERT INTO `jos_core_acl_aro` (`id`, `section_value`, `value`, `order_value`, `name`, `hidden`) VALUES 
(10, 'users', '62', 0, 'Filipe SR', 0),
(11, 'users', '63', 0, 'Hilquias', 0);

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_core_acl_aro_groups`
-- 

CREATE TABLE `jos_core_acl_aro_groups` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `lft` int(11) NOT NULL default '0',
  `rgt` int(11) NOT NULL default '0',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `jos_gacl_parent_id_aro_groups` (`parent_id`),
  KEY `jos_gacl_lft_rgt_aro_groups` (`lft`,`rgt`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

-- 
-- Extraindo dados da tabela `jos_core_acl_aro_groups`
-- 

INSERT INTO `jos_core_acl_aro_groups` (`id`, `parent_id`, `name`, `lft`, `rgt`, `value`) VALUES 
(17, 0, 'ROOT', 1, 22, 'ROOT'),
(28, 17, 'USERS', 2, 21, 'USERS'),
(29, 28, 'Public Frontend', 3, 12, 'Public Frontend'),
(18, 29, 'Registered', 4, 11, 'Registered'),
(19, 18, 'Author', 5, 10, 'Author'),
(20, 19, 'Editor', 6, 9, 'Editor'),
(21, 20, 'Publisher', 7, 8, 'Publisher'),
(30, 28, 'Public Backend', 13, 20, 'Public Backend'),
(23, 30, 'Manager', 14, 19, 'Manager'),
(24, 23, 'Administrator', 15, 18, 'Administrator'),
(25, 24, 'Super Administrator', 16, 17, 'Super Administrator');

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_core_acl_aro_map`
-- 

CREATE TABLE `jos_core_acl_aro_map` (
  `acl_id` int(11) NOT NULL default '0',
  `section_value` varchar(230) NOT NULL default '0',
  `value` varchar(100) NOT NULL,
  PRIMARY KEY  (`acl_id`,`section_value`,`value`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Extraindo dados da tabela `jos_core_acl_aro_map`
-- 


-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_core_acl_aro_sections`
-- 

CREATE TABLE `jos_core_acl_aro_sections` (
  `id` int(11) NOT NULL auto_increment,
  `value` varchar(230) NOT NULL default '',
  `order_value` int(11) NOT NULL default '0',
  `name` varchar(230) NOT NULL default '',
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `jos_gacl_value_aro_sections` (`value`),
  KEY `jos_gacl_hidden_aro_sections` (`hidden`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- 
-- Extraindo dados da tabela `jos_core_acl_aro_sections`
-- 

INSERT INTO `jos_core_acl_aro_sections` (`id`, `value`, `order_value`, `name`, `hidden`) VALUES 
(10, 'users', 1, 'Users', 0);

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_core_acl_groups_aro_map`
-- 

CREATE TABLE `jos_core_acl_groups_aro_map` (
  `group_id` int(11) NOT NULL default '0',
  `section_value` varchar(240) NOT NULL default '',
  `aro_id` int(11) NOT NULL default '0',
  UNIQUE KEY `group_id_aro_id_groups_aro_map` (`group_id`,`section_value`,`aro_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Extraindo dados da tabela `jos_core_acl_groups_aro_map`
-- 

INSERT INTO `jos_core_acl_groups_aro_map` (`group_id`, `section_value`, `aro_id`) VALUES 
(21, '', 11),
(25, '', 10);

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_core_log_items`
-- 

CREATE TABLE `jos_core_log_items` (
  `time_stamp` date NOT NULL default '0000-00-00',
  `item_table` varchar(50) NOT NULL default '',
  `item_id` int(11) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Extraindo dados da tabela `jos_core_log_items`
-- 


-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_core_log_searches`
-- 

CREATE TABLE `jos_core_log_searches` (
  `search_term` varchar(128) NOT NULL default '',
  `hits` int(11) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Extraindo dados da tabela `jos_core_log_searches`
-- 


-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_groups`
-- 

CREATE TABLE `jos_groups` (
  `id` tinyint(3) unsigned NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Extraindo dados da tabela `jos_groups`
-- 

INSERT INTO `jos_groups` (`id`, `name`) VALUES 
(0, 'Public'),
(1, 'Registered'),
(2, 'Special');

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_menu`
-- 

CREATE TABLE `jos_menu` (
  `id` int(11) NOT NULL auto_increment,
  `menutype` varchar(75) default NULL,
  `name` varchar(255) default NULL,
  `alias` varchar(255) NOT NULL default '',
  `link` text,
  `type` varchar(50) NOT NULL default '',
  `published` tinyint(1) NOT NULL default '0',
  `parent` int(11) unsigned NOT NULL default '0',
  `componentid` int(11) unsigned NOT NULL default '0',
  `sublevel` int(11) default '0',
  `ordering` int(11) default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `pollid` int(11) NOT NULL default '0',
  `browserNav` tinyint(4) default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `utaccess` tinyint(3) unsigned NOT NULL default '0',
  `params` text NOT NULL,
  `lft` int(11) unsigned NOT NULL default '0',
  `rgt` int(11) unsigned NOT NULL default '0',
  `home` int(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `componentid` (`componentid`,`menutype`,`published`,`access`),
  KEY `menutype` (`menutype`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- 
-- Extraindo dados da tabela `jos_menu`
-- 

INSERT INTO `jos_menu` (`id`, `menutype`, `name`, `alias`, `link`, `type`, `published`, `parent`, `componentid`, `sublevel`, `ordering`, `checked_out`, `checked_out_time`, `pollid`, `browserNav`, `access`, `utaccess`, `params`, `lft`, `rgt`, `home`) VALUES 
(1, 'mainmenu', 'Home', 'home', 'index.php?option=com_content&view=frontpage', 'component', 1, 0, 20, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, 0, 3, 'num_leading_articles=1\nnum_intro_articles=4\nnum_columns=2\nnum_links=4\norderby_pri=\norderby_sec=front\nshow_pagination=2\nshow_pagination_results=1\nshow_feed_link=1\nshow_noauth=\nshow_title=\nlink_titles=\nshow_intro=\nshow_section=\nlink_section=\nshow_category=\nlink_category=\nshow_author=\nshow_create_date=\nshow_modify_date=\nshow_item_navigation=\nshow_readmore=\nshow_vote=\nshow_icons=\nshow_pdf_icon=\nshow_print_icon=\nshow_email_icon=\nshow_hits=\nfeed_summary=\npage_title=\nshow_page_title=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\n\n', 0, 0, 1),
(2, 'mainmenu', 'Notícias', 'noticias', 'index.php?option=com_content&view=section&id=1', 'component', 1, 0, 20, 0, 2, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 'show_description=0\nshow_description_image=0\nshow_categories=1\nshow_empty_categories=0\nshow_cat_num_articles=1\nshow_category_description=1\norderby=\norderby_sec=rdate\nshow_feed_link=1\nshow_noauth=\nshow_title=\nlink_titles=\nshow_intro=\nshow_section=\nlink_section=\nshow_category=\nlink_category=\nshow_author=\nshow_create_date=\nshow_modify_date=\nshow_item_navigation=\nshow_readmore=\nshow_vote=\nshow_icons=\nshow_pdf_icon=\nshow_print_icon=\nshow_email_icon=\nshow_hits=\nfeed_summary=\npage_title=\nshow_page_title=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\n\n', 0, 0, 0),
(3, 'mainmenu', 'Destinos', 'destinos', 'index.php?option=com_content&view=frontpage', 'component', 1, 0, 20, 0, 3, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 'num_leading_articles=1\nnum_intro_articles=4\nnum_columns=2\nnum_links=4\norderby_pri=\norderby_sec=front\nmulti_column_order=1\nshow_pagination=2\nshow_pagination_results=1\nshow_feed_link=1\nshow_noauth=\nshow_title=\nlink_titles=\nshow_intro=\nshow_section=\nlink_section=\nshow_category=\nlink_category=\nshow_author=\nshow_create_date=\nshow_modify_date=\nshow_item_navigation=\nshow_readmore=\nshow_vote=\nshow_icons=\nshow_pdf_icon=\nshow_print_icon=\nshow_email_icon=\nshow_hits=\nfeed_summary=\npage_title=\nshow_page_title=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\n\n', 0, 0, 0),
(4, 'mainmenu', 'Serviços', 'servicos', 'index.php?option=com_content&view=frontpage', 'component', 1, 0, 20, 0, 4, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 'num_leading_articles=1\nnum_intro_articles=4\nnum_columns=2\nnum_links=4\norderby_pri=\norderby_sec=front\nmulti_column_order=1\nshow_pagination=2\nshow_pagination_results=1\nshow_feed_link=1\nshow_noauth=\nshow_title=\nlink_titles=\nshow_intro=\nshow_section=\nlink_section=\nshow_category=\nlink_category=\nshow_author=\nshow_create_date=\nshow_modify_date=\nshow_item_navigation=\nshow_readmore=\nshow_vote=\nshow_icons=\nshow_pdf_icon=\nshow_print_icon=\nshow_email_icon=\nshow_hits=\nfeed_summary=\npage_title=\nshow_page_title=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\n\n', 0, 0, 0),
(5, 'mainmenu', 'Galeria de fotos', 'galeria-de-fotos', 'index.php?option=com_phocagallery&view=categories', 'component', 1, 0, 34, 0, 5, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 'image=-1\nimage_align=right\nshow_pagination=1\nshow_pagination_limit=1\nshow_feed_link=1\ndisplay_cat_name_title=1\nfont_color=\nbackground_color=\nbackground_color_hover=\nimage_background_color=\nimage_background_shadow=\nborder_color=\nborder_color_hover=\nmargin_box=\npadding_box=\ndisplay_name=\ndisplay_icon_detail=\ndisplay_icon_download=\ndisplay_icon_folder=\nfont_size_name=\nchar_length_name=\ncategory_box_space=\ndisplay_categories_sub=\ndisplay_subcat_page=\ndisplay_icon_random_image=\ndisplay_back_button=\ndisplay_categories_back_button=\ndisplay_categories_cv=\ndisplay_subcat_page_cv=\ndisplay_icon_random_image_cv=\ndisplay_back_button_cv=\ndisplay_categories_back_button_cv=\ncategories_columns_cv=\ndisplay_image_categories_cv=\nimage_categories_size_cv=\ncategories_columns=\ndisplay_image_categories=\nimage_categories_size=\ndisplay_subcategories=\ndisplay_empty_categories=\nhide_categories=\ndisplay_access_category=\ndetail_window=\ndetail_window_background_color=\nmodal_box_overlay_color=\nmodal_box_overlay_opacity=\nmodal_box_border_color=\nmodal_box_border_width=\nsb_slideshow_delay=\nsb_lang=\ndisplay_description_detail=\ndisplay_title_description=\nfont_size_desc=\nfont_color_desc=\ndescription_detail_height=\ndescription_lightbox_font_size=\ndescription_lightbox_font_color=\ndescription_lightbox_bg_color=\nslideshow_delay=\nslideshow_pause=\nslideshow_random=\ndetail_buttons=\nphocagallery_width=\ndisplay_phoca_info=\ndefault_pagination=\npagination=\ncategory_ordering=\nimage_ordering=\nenable_piclens=\nstart_piclens=\npiclens_image=\nswitch_image=\nswitch_width=\nswitch_height=\nenable_overlib=\nol_bg_color=\nol_fg_color=\nol_tf_color=\nol_cf_color=\noverlib_overlay_opacity=\ncreate_watermark=\nwatermark_position_x=\nwatermark_position_y=\ndisplay_icon_vm=\nenable_user_cp=\nmax_create_cat_char=\ndisplay_rating=\ndisplay_comment=\ncomment_width=\nmax_comment_char=\ndisplay_category_statistics=\ndisplay_main_cat_stat=\ndisplay_lastadded_cat_stat=\ncount_lastadded_cat_stat=\ndisplay_mostviewed_cat_stat=\ncount_mostviewed_cat_stat=\ndisplay_camera_info=\nexif_information=\ngoogle_maps_api_key=\ndisplay_categories_geotagging=\ncategories_lng=\ncategories_lat=\ncategories_zoom=\ncategories_map_width=\ncategories_map_height=\ndisplay_icon_geotagging=\ndisplay_category_geotagging=\ncategory_map_width=\ncategory_map_height=\ndisplay_title_upload=\ndisplay_description_upload=\nmax_upload_char=\nupload_maxsize=\ncat_folder_maxsize=\nenable_java=\njava_resize_width=\njava_resize_height=\njava_box_width=\njava_box_height=\npagination_thumbnail_creation=\nclean_thumbnails=\nenable_thumb_creation=\ncrop_thumbnail=\njpeg_quality=\nicon_format=\nlarge_image_width=\nlarge_image_height=\nmedium_image_width=\nmedium_image_height=\nsmall_image_width=\nsmall_image_height=\nfront_modal_box_width=\nfront_modal_box_height=\nadmin_modal_box_width=\nadmin_modal_box_height=\npage_title=\nshow_page_title=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\n\n', 0, 0, 0),
(6, 'notmenu', 'Enviar Artigo', 'enviar-artigo', 'index.php?option=com_content&view=article&layout=form', 'component', 1, 0, 20, 0, 1, 0, '0000-00-00 00:00:00', 0, 0, 1, 0, 'show_noauth=\nshow_title=\nlink_titles=\nshow_intro=\nshow_section=\nlink_section=\nshow_category=\nlink_category=\nshow_author=\nshow_create_date=\nshow_modify_date=\nshow_item_navigation=\nshow_readmore=\nshow_vote=\nshow_icons=\nshow_pdf_icon=\nshow_print_icon=\nshow_email_icon=\nshow_hits=\nfeed_summary=\npage_title=\nshow_page_title=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\n\n', 0, 0, 0),
(7, 'notmenu', 'Artigos Arquivados', 'artigosarquivados', 'index.php?option=com_content&view=archive', 'component', 1, 0, 20, 0, 2, 0, '0000-00-00 00:00:00', 0, 0, 1, 0, 'orderby=rdate\nshow_noauth=\nshow_title=\nlink_titles=\nshow_intro=\nshow_section=\nlink_section=\nshow_category=\nlink_category=\nshow_author=\nshow_create_date=\nshow_modify_date=\nshow_item_navigation=\nshow_readmore=\nshow_vote=\nshow_icons=\nshow_pdf_icon=\nshow_print_icon=\nshow_email_icon=\nshow_hits=\nfeed_summary=\npage_title=\nshow_page_title=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\n\n', 0, 0, 0),
(8, 'notmenu', 'Galeria de fotos', 'galeria-de-fotos', 'index.php?option=com_phocagallery&view=user', 'component', 1, 0, 34, 0, 3, 0, '0000-00-00 00:00:00', 0, 0, 1, 0, 'display_cat_name_title=1\ndisplay_cat_name_breadcrumbs=0\nfont_color=\nbackground_color=\nbackground_color_hover=\nimage_background_color=\nimage_background_shadow=\nborder_color=\nborder_color_hover=\nmargin_box=\npadding_box=\ndisplay_name=\ndisplay_icon_detail=\ndisplay_icon_download=\ndisplay_icon_folder=\nfont_size_name=\nchar_length_name=\ncategory_box_space=\ndisplay_categories_sub=\ndisplay_subcat_page=\ndisplay_icon_random_image=\ndisplay_back_button=\ndisplay_categories_back_button=\ndisplay_categories_cv=\ndisplay_subcat_page_cv=\ndisplay_icon_random_image_cv=\ndisplay_back_button_cv=\ndisplay_categories_back_button_cv=\ncategories_columns_cv=\ndisplay_image_categories_cv=\nimage_categories_size_cv=\ncategories_columns=\ndisplay_image_categories=\nimage_categories_size=\ndisplay_subcategories=\ndisplay_empty_categories=\nhide_categories=\ndisplay_access_category=\ndetail_window=\ndetail_window_background_color=\nmodal_box_overlay_color=\nmodal_box_overlay_opacity=\nmodal_box_border_color=\nmodal_box_border_width=\nsb_slideshow_delay=\nsb_lang=\ndisplay_description_detail=\ndisplay_title_description=\nfont_size_desc=\nfont_color_desc=\ndescription_detail_height=\ndescription_lightbox_font_size=\ndescription_lightbox_font_color=\ndescription_lightbox_bg_color=\nslideshow_delay=\nslideshow_pause=\nslideshow_random=\ndetail_buttons=\nphocagallery_width=\ndisplay_phoca_info=\ndefault_pagination=\npagination=\ncategory_ordering=\nimage_ordering=\nenable_piclens=\nstart_piclens=\npiclens_image=\nswitch_image=\nswitch_width=\nswitch_height=\nenable_overlib=\nol_bg_color=\nol_fg_color=\nol_tf_color=\nol_cf_color=\noverlib_overlay_opacity=\ncreate_watermark=\nwatermark_position_x=\nwatermark_position_y=\ndisplay_icon_vm=\nenable_user_cp=\nmax_create_cat_char=\ndisplay_rating=\ndisplay_comment=\ncomment_width=\nmax_comment_char=\ndisplay_category_statistics=\ndisplay_main_cat_stat=\ndisplay_lastadded_cat_stat=\ncount_lastadded_cat_stat=\ndisplay_mostviewed_cat_stat=\ncount_mostviewed_cat_stat=\ndisplay_camera_info=\nexif_information=\ngoogle_maps_api_key=\ndisplay_categories_geotagging=\ncategories_lng=\ncategories_lat=\ncategories_zoom=\ncategories_map_width=\ncategories_map_height=\ndisplay_icon_geotagging=\ndisplay_category_geotagging=\ncategory_map_width=\ncategory_map_height=\ndisplay_title_upload=\ndisplay_description_upload=\nmax_upload_char=\nupload_maxsize=\ncat_folder_maxsize=\nenable_java=\njava_resize_width=\njava_resize_height=\njava_box_width=\njava_box_height=\npagination_thumbnail_creation=\nclean_thumbnails=\nenable_thumb_creation=\ncrop_thumbnail=\njpeg_quality=\nicon_format=\nlarge_image_width=\nlarge_image_height=\nmedium_image_width=\nmedium_image_height=\nsmall_image_width=\nsmall_image_height=\nfront_modal_box_width=\nfront_modal_box_height=\nadmin_modal_box_width=\nadmin_modal_box_height=\npage_title=\nshow_page_title=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\n\n', 0, 0, 0);

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_menu_types`
-- 

CREATE TABLE `jos_menu_types` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `menutype` varchar(75) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `menutype` (`menutype`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- 
-- Extraindo dados da tabela `jos_menu_types`
-- 

INSERT INTO `jos_menu_types` (`id`, `menutype`, `title`, `description`) VALUES 
(1, 'mainmenu', 'Main Menu', 'Menu principal'),
(4, 'notmenu', 'Menu de Noticias', '');

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_messages`
-- 

CREATE TABLE `jos_messages` (
  `message_id` int(10) unsigned NOT NULL auto_increment,
  `user_id_from` int(10) unsigned NOT NULL default '0',
  `user_id_to` int(10) unsigned NOT NULL default '0',
  `folder_id` int(10) unsigned NOT NULL default '0',
  `date_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `state` int(11) NOT NULL default '0',
  `priority` int(1) unsigned NOT NULL default '0',
  `subject` text NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY  (`message_id`),
  KEY `useridto_state` (`user_id_to`,`state`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Extraindo dados da tabela `jos_messages`
-- 


-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_messages_cfg`
-- 

CREATE TABLE `jos_messages_cfg` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `cfg_name` varchar(100) NOT NULL default '',
  `cfg_value` varchar(255) NOT NULL default '',
  UNIQUE KEY `idx_user_var_name` (`user_id`,`cfg_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Extraindo dados da tabela `jos_messages_cfg`
-- 


-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_migration_backlinks`
-- 

CREATE TABLE `jos_migration_backlinks` (
  `itemid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `url` text NOT NULL,
  `sefurl` text NOT NULL,
  `newurl` text NOT NULL,
  PRIMARY KEY  (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Extraindo dados da tabela `jos_migration_backlinks`
-- 


-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_modules`
-- 

CREATE TABLE `jos_modules` (
  `id` int(11) NOT NULL auto_increment,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `ordering` int(11) NOT NULL default '0',
  `position` varchar(50) default NULL,
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  `module` varchar(50) default NULL,
  `numnews` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `showtitle` tinyint(3) unsigned NOT NULL default '1',
  `params` text NOT NULL,
  `iscore` tinyint(4) NOT NULL default '0',
  `client_id` tinyint(4) NOT NULL default '0',
  `control` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `published` (`published`,`access`),
  KEY `newsfeeds` (`module`,`published`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

-- 
-- Extraindo dados da tabela `jos_modules`
-- 

INSERT INTO `jos_modules` (`id`, `title`, `content`, `ordering`, `position`, `checked_out`, `checked_out_time`, `published`, `module`, `numnews`, `access`, `showtitle`, `params`, `iscore`, `client_id`, `control`) VALUES 
(2, 'Login', '', 1, 'login', 0, '0000-00-00 00:00:00', 1, 'mod_login', 0, 0, 1, '', 1, 1, ''),
(3, 'Popular', '', 3, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_popular', 0, 2, 1, '', 0, 1, ''),
(4, 'Recent added Articles', '', 4, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_latest', 0, 2, 1, 'ordering=c_dsc\nuser_id=0\ncache=0\n\n', 0, 1, ''),
(5, 'Menu Stats', '', 5, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_stats', 0, 2, 1, '', 0, 1, ''),
(6, 'Unread Messages', '', 1, 'header', 0, '0000-00-00 00:00:00', 1, 'mod_unread', 0, 2, 1, '', 1, 1, ''),
(7, 'Online Users', '', 2, 'header', 0, '0000-00-00 00:00:00', 1, 'mod_online', 0, 2, 1, '', 1, 1, ''),
(8, 'Toolbar', '', 1, 'toolbar', 0, '0000-00-00 00:00:00', 1, 'mod_toolbar', 0, 2, 1, '', 1, 1, ''),
(9, 'Quick Icons', '', 1, 'icon', 0, '0000-00-00 00:00:00', 1, 'mod_quickicon', 0, 2, 1, '', 1, 1, ''),
(10, 'Logged in Users', '', 2, 'cpanel', 0, '0000-00-00 00:00:00', 1, 'mod_logged', 0, 2, 1, '', 0, 1, ''),
(11, 'Footer', '', 0, 'footer', 0, '0000-00-00 00:00:00', 1, 'mod_footer', 0, 0, 1, '', 1, 1, ''),
(12, 'Admin Menu', '', 1, 'menu', 0, '0000-00-00 00:00:00', 1, 'mod_menu', 0, 2, 1, '', 0, 1, ''),
(13, 'Admin SubMenu', '', 1, 'submenu', 0, '0000-00-00 00:00:00', 1, 'mod_submenu', 0, 2, 1, '', 0, 1, ''),
(14, 'User Status', '', 1, 'status', 0, '0000-00-00 00:00:00', 1, 'mod_status', 0, 2, 1, '', 0, 1, ''),
(15, 'Title', '', 1, 'title', 0, '0000-00-00 00:00:00', 1, 'mod_title', 0, 2, 1, '', 0, 1, ''),
(17, 'Ultimas Notícias', '', 0, 'footer', 0, '0000-00-00 00:00:00', 1, 'mod_globalnews', 0, 0, 0, 'global=s\nlayout=scroller\ncols=1\nmargin=2px\ncat_order=1\ncat_limit=\nempty=0\nfilter=0\ncurcat=0\ncatids=\nsecids=\ncatexc=\nsecexc=\nshow_cat=1\ncat_title=1\ncat_img_align=0\ncat_img_width=\ncat_img_height=\ncat_img_margin=3px\ncat_img_border=0\ncount=10\nordering=c_dsc\nuser_id=0\nshow_front=1\ncurrent=1\nmore=1\nwidth=auto\nborder=1px solid #EFEFEF\nheader_color=#EFEFEF\nheader_padding=5px\nheight=100px\ncolor=#FFFFFF\npadding=5px\ndelay=3000\nnext=0\nhtml=GN_image GN_title GN_break GN_date GN_break GN_text GN_readmore\nlimittext=150\ntext=0\ndate_format=\ndate=created\nitem_img_align=left\nitem_img_width=\nitem_img_height=\nitem_img_margin=3px\nitem_img_border=0\nauthor=username\ncb_link=0\ncomments_table=#__comment\narticle_column=contentid\ncache=0\ncache_time=900\nmoduleclass_sfx=\n\n', 0, 0, ''),
(27, 'UserLogin', '', 0, 'right', 0, '0000-00-00 00:00:00', 1, 'mod_login', 0, 0, 0, 'cache=0\nmoduleclass_sfx=\npretext=\nposttext=\nlogin=1\nlogout=2\ngreeting=1\nname=0\nusesecure=0\n\n', 0, 0, ''),
(28, 'Mais Lidos', '', 2, 'footer', 0, '0000-00-00 00:00:00', 1, 'mod_mostread', 0, 1, 1, 'moduleclass_sfx=\nshow_front=1\ncount=5\ncatid=\nsecid=\ncache=1\ncache_time=900\n\n', 0, 0, ''),
(29, 'mod_notmenu', '', 0, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 1, 0, 'menutype=notmenu\nmenu_style=list\nstartLevel=0\nendLevel=0\nshowAllChildren=0\nwindow_open=\nshow_whitespace=0\ncache=1\ntag_id=\nclass_sfx=\nmoduleclass_sfx=\nmaxdepth=10\nmenu_images=0\nmenu_images_align=0\nmenu_images_link=0\nexpand_menu=0\nactivate_parent=0\nfull_active_id=0\nindent_image=0\nindent_image1=\nindent_image2=\nindent_image3=\nindent_image4=\nindent_image5=\nindent_image6=\nspacer=\nend_spacer=\n\n', 0, 0, ''),
(22, 'Top Menu', '', 0, 'user3', 0, '0000-00-00 00:00:00', 1, 'mod_mainmenu', 0, 0, 0, 'menutype=mainmenu\nmenu_style=list_flat\nstartLevel=0\nendLevel=0\nshowAllChildren=0\nwindow_open=\nshow_whitespace=0\ncache=1\ntag_id=\nclass_sfx=-nav\nmoduleclass_sfx=\nmaxdepth=10\nmenu_images=0\nmenu_images_align=0\nmenu_images_link=0\nexpand_menu=0\nactivate_parent=0\nfull_active_id=0\nindent_image=0\nindent_image1=-1\nindent_image2=-1\nindent_image3=-1\nindent_image4=-1\nindent_image5=-1\nindent_image6=-1\nspacer=\nend_spacer=\n\n', 0, 0, ''),
(23, 'Pesquisa', '', 0, 'user4', 0, '0000-00-00 00:00:00', 1, 'mod_search', 0, 0, 0, 'moduleclass_sfx=\nwidth=20\ntext=pesquisar\nbutton=\nbutton_pos=right\nimagebutton=\nbutton_text=\ncache=1\ncache_time=900\n\n', 0, 0, ''),
(24, 'Estatística', '', 2, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_stats', 0, 0, 1, 'serverinfo=0\nsiteinfo=1\ncounter=1\nincrease=0\nmoduleclass_sfx=\ncache=0\ncache_time=900\n\n', 0, 0, ''),
(25, 'Breadcrumbs', '', 0, 'breadcrumb', 0, '0000-00-00 00:00:00', 1, 'mod_breadcrumbs', 0, 0, 1, 'showHome=1\nhomeText=Home\nshowLast=1\nseparator=\nmoduleclass_sfx=\ncache=0\n\n', 0, 0, ''),
(26, 'Banner Topo', '', 0, 'top', 0, '0000-00-00 00:00:00', 1, 'mod_banners', 0, 0, 1, 'target=1\ncount=1\ncid=0\ncatid=0\ntag_search=0\nordering=0\nheader_text=\nfooter_text=\nmoduleclass_sfx=\ncache=1\ncache_time=900\n\n', 0, 0, '');

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_modules_menu`
-- 

CREATE TABLE `jos_modules_menu` (
  `moduleid` int(11) NOT NULL default '0',
  `menuid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`moduleid`,`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Extraindo dados da tabela `jos_modules_menu`
-- 

INSERT INTO `jos_modules_menu` (`moduleid`, `menuid`) VALUES 
(17, 1),
(17, 5),
(22, 0),
(23, 0),
(24, 1),
(25, 0),
(26, 0),
(27, 0),
(28, 1),
(29, 0);

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_newsfeeds`
-- 

CREATE TABLE `jos_newsfeeds` (
  `catid` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `alias` varchar(255) NOT NULL default '',
  `link` text NOT NULL,
  `filename` varchar(200) default NULL,
  `published` tinyint(1) NOT NULL default '0',
  `numarticles` int(11) unsigned NOT NULL default '1',
  `cache_time` int(11) unsigned NOT NULL default '3600',
  `checked_out` tinyint(3) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `rtl` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `published` (`published`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Extraindo dados da tabela `jos_newsfeeds`
-- 


-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_phocagallery`
-- 

CREATE TABLE `jos_phocagallery` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `sid` int(11) NOT NULL default '0',
  `title` varchar(250) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `filename` varchar(250) NOT NULL default '',
  `description` text NOT NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `hits` int(11) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  `extlink1` text NOT NULL,
  `extlink2` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `catid` (`catid`,`published`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Extraindo dados da tabela `jos_phocagallery`
-- 

INSERT INTO `jos_phocagallery` (`id`, `catid`, `sid`, `title`, `alias`, `filename`, `description`, `date`, `hits`, `published`, `checked_out`, `checked_out_time`, `ordering`, `params`, `extlink1`, `extlink2`) VALUES 
(1, 1, 0, 'NRD 001 a', 'nrd-001-a', 'nrd001a.jpg', '', '2009-05-20 00:00:00', 13, 1, 0, '0000-00-00 00:00:00', 1, 'zoom=2;', '', '');

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_phocagallery_categories`
-- 

CREATE TABLE `jos_phocagallery_categories` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `image` varchar(255) NOT NULL default '',
  `section` varchar(50) NOT NULL default '',
  `image_position` varchar(30) NOT NULL default '',
  `description` text NOT NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `editor` varchar(50) default NULL,
  `ordering` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `hits` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `cat_idx` (`section`,`published`,`access`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Extraindo dados da tabela `jos_phocagallery_categories`
-- 

INSERT INTO `jos_phocagallery_categories` (`id`, `parent_id`, `title`, `name`, `alias`, `image`, `section`, `image_position`, `description`, `date`, `published`, `checked_out`, `checked_out_time`, `editor`, `ordering`, `access`, `count`, `hits`, `params`) VALUES 
(1, 0, 'BNT 2009', '', 'bnt-2009', '', '', 'left', '<div class="caption" align="center"><h1><font face="verdana,geneva">Evento BNT 2009</font></h1></div>', '2009-05-20 00:00:00', 1, 0, '0000-00-00 00:00:00', NULL, 1, 0, 0, 16, 'accessuserid=-1,;uploaduserid=-1,;deleteuserid=-1,;zoom=2;'),
(2, 0, 'Teste', '', 'teste', '', '', 'left', 'teste teste', '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', NULL, 2, 0, 0, 4, 'accessuserid=-1;uploaduserid=63;deleteuserid=63;userfolder=hilquias-teste-66d9;');

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_phocagallery_comments`
-- 

CREATE TABLE `jos_phocagallery_comments` (
  `id` int(11) NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `userid` int(11) NOT NULL default '0',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `title` varchar(255) NOT NULL default '',
  `comment` text NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Extraindo dados da tabela `jos_phocagallery_comments`
-- 


-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_phocagallery_user_category`
-- 

CREATE TABLE `jos_phocagallery_user_category` (
  `id` int(11) NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `userid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `catid` (`catid`,`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Extraindo dados da tabela `jos_phocagallery_user_category`
-- 

INSERT INTO `jos_phocagallery_user_category` (`id`, `catid`, `userid`) VALUES 
(1, 2, 63);

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_phocagallery_votes`
-- 

CREATE TABLE `jos_phocagallery_votes` (
  `id` int(11) NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `userid` int(11) NOT NULL default '0',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `rating` tinyint(1) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Extraindo dados da tabela `jos_phocagallery_votes`
-- 

INSERT INTO `jos_phocagallery_votes` (`id`, `catid`, `userid`, `date`, `rating`, `published`, `checked_out`, `checked_out_time`, `ordering`, `params`) VALUES 
(1, 1, 63, '2009-06-08 20:13:44', 5, 1, 0, '0000-00-00 00:00:00', 1, ''),
(2, 2, 63, '2009-06-08 23:43:21', 5, 1, 0, '0000-00-00 00:00:00', 1, '');

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_phocagallery_votes_statistics`
-- 

CREATE TABLE `jos_phocagallery_votes_statistics` (
  `id` int(11) NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `count` tinyint(11) NOT NULL default '0',
  `average` float(8,6) NOT NULL default '0.000000',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Extraindo dados da tabela `jos_phocagallery_votes_statistics`
-- 

INSERT INTO `jos_phocagallery_votes_statistics` (`id`, `catid`, `count`, `average`) VALUES 
(1, 1, 1, 5.000000),
(2, 2, 1, 5.000000);

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_plugins`
-- 

CREATE TABLE `jos_plugins` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `element` varchar(100) NOT NULL default '',
  `folder` varchar(100) NOT NULL default '',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `published` tinyint(3) NOT NULL default '0',
  `iscore` tinyint(3) NOT NULL default '0',
  `client_id` tinyint(3) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_folder` (`published`,`client_id`,`access`,`folder`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

-- 
-- Extraindo dados da tabela `jos_plugins`
-- 

INSERT INTO `jos_plugins` (`id`, `name`, `element`, `folder`, `access`, `ordering`, `published`, `iscore`, `client_id`, `checked_out`, `checked_out_time`, `params`) VALUES 
(1, 'Authentication - Joomla', 'joomla', 'authentication', 0, 1, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(2, 'Authentication - LDAP', 'ldap', 'authentication', 0, 2, 0, 1, 0, 0, '0000-00-00 00:00:00', 'host=\nport=389\nuse_ldapV3=0\nnegotiate_tls=0\nno_referrals=0\nauth_method=bind\nbase_dn=\nsearch_string=\nusers_dn=\nusername=\npassword=\nldap_fullname=fullName\nldap_email=mail\nldap_uid=uid\n\n'),
(3, 'Authentication - GMail', 'gmail', 'authentication', 0, 4, 0, 0, 0, 0, '0000-00-00 00:00:00', ''),
(4, 'Authentication - OpenID', 'openid', 'authentication', 0, 3, 0, 0, 0, 0, '0000-00-00 00:00:00', ''),
(5, 'User - Joomla!', 'joomla', 'user', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', 'autoregister=1\n\n'),
(6, 'Search - Content', 'content', 'search', 0, 1, 1, 1, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\nsearch_content=1\nsearch_uncategorised=1\nsearch_archived=1\n\n'),
(7, 'Search - Contacts', 'contacts', 'search', 0, 3, 1, 1, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(8, 'Search - Categories', 'categories', 'search', 0, 4, 1, 0, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(9, 'Search - Sections', 'sections', 'search', 0, 5, 1, 0, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(10, 'Search - Newsfeeds', 'newsfeeds', 'search', 0, 6, 1, 0, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(11, 'Search - Weblinks', 'weblinks', 'search', 0, 2, 1, 1, 0, 0, '0000-00-00 00:00:00', 'search_limit=50\n\n'),
(12, 'Content - Pagebreak', 'pagebreak', 'content', 0, 10000, 1, 1, 0, 0, '0000-00-00 00:00:00', 'enabled=1\ntitle=1\nmultipage_toc=1\nshowall=1\n\n'),
(13, 'Content - Rating', 'vote', 'content', 0, 4, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(14, 'Content - Email Cloaking', 'emailcloak', 'content', 0, 5, 1, 0, 0, 0, '0000-00-00 00:00:00', 'mode=1\n\n'),
(15, 'Content - Code Hightlighter (GeSHi)', 'geshi', 'content', 0, 5, 0, 0, 0, 0, '0000-00-00 00:00:00', ''),
(16, 'Content - Load Module', 'loadmodule', 'content', 0, 6, 1, 0, 0, 0, '0000-00-00 00:00:00', 'enabled=1\nstyle=0\n\n'),
(17, 'Content - Page Navigation', 'pagenavigation', 'content', 0, 2, 1, 1, 0, 0, '0000-00-00 00:00:00', 'position=1\n\n'),
(18, 'Editor - No Editor', 'none', 'editors', 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(19, 'Editor - TinyMCE 2.0', 'tinymce', 'editors', 0, 0, 1, 1, 0, 0, '0000-00-00 00:00:00', 'theme=advanced\ncleanup=1\ncleanup_startup=0\nautosave=0\ncompressed=0\nrelative_urls=1\ntext_direction=ltr\nlang_mode=0\nlang_code=en\ninvalid_elements=applet\ncontent_css=1\ncontent_css_custom=\nnewlines=0\ntoolbar=top\nhr=1\nsmilies=1\ntable=1\nstyle=1\nlayer=1\nxhtmlxtras=0\ntemplate=0\ndirectionality=1\nfullscreen=1\nhtml_height=550\nhtml_width=750\npreview=1\ninsertdate=1\nformat_date=%Y-%m-%d\ninserttime=1\nformat_time=%H:%M:%S\n\n'),
(20, 'Editor - XStandard Lite 2.0', 'xstandard', 'editors', 0, 0, 0, 1, 0, 0, '0000-00-00 00:00:00', ''),
(21, 'Editor Button - Image', 'image', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(22, 'Editor Button - Pagebreak', 'pagebreak', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(23, 'Editor Button - Readmore', 'readmore', 'editors-xtd', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(24, 'XML-RPC - Joomla', 'joomla', 'xmlrpc', 0, 7, 0, 1, 0, 0, '0000-00-00 00:00:00', ''),
(25, 'XML-RPC - Blogger API', 'blogger', 'xmlrpc', 0, 7, 0, 1, 0, 0, '0000-00-00 00:00:00', 'catid=1\nsectionid=0\n\n'),
(27, 'System - SEF', 'sef', 'system', 0, 1, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(28, 'System - Debug', 'debug', 'system', 0, 2, 1, 0, 0, 0, '0000-00-00 00:00:00', 'queries=1\nmemory=1\nlangauge=1\n\n'),
(29, 'System - Legacy', 'legacy', 'system', 0, 3, 0, 1, 0, 0, '0000-00-00 00:00:00', 'route=0\n\n'),
(30, 'System - Cache', 'cache', 'system', 0, 4, 0, 1, 0, 0, '0000-00-00 00:00:00', 'browsercache=0\ncachetime=15\n\n'),
(31, 'System - Log', 'log', 'system', 0, 5, 0, 1, 0, 0, '0000-00-00 00:00:00', ''),
(32, 'System - Remember Me', 'remember', 'system', 0, 6, 1, 1, 0, 0, '0000-00-00 00:00:00', ''),
(33, 'System - Backlink', 'backlink', 'system', 0, 7, 0, 1, 0, 0, '0000-00-00 00:00:00', ''),
(34, 'Content - Podcast', 'podcast', 'content', 0, 0, 1, 0, 0, 0, '0000-00-00 00:00:00', ''),
(35, 'Ulti Polaroid', 'ultipolaroid', 'system', 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 'tag=polaroid\n');

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_podcast`
-- 

CREATE TABLE `jos_podcast` (
  `podcast_id` int(11) NOT NULL auto_increment,
  `filename` varchar(255) NOT NULL,
  `itAuthor` varchar(255) NOT NULL default '',
  `itBlock` tinyint(1) NOT NULL default '0',
  `itCategory` varchar(255) NOT NULL default '',
  `itDuration` varchar(10) NOT NULL default '',
  `itExplicit` tinyint(1) NOT NULL default '0',
  `itKeywords` varchar(255) NOT NULL default '',
  `itSubtitle` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`podcast_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Extraindo dados da tabela `jos_podcast`
-- 


-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_polls`
-- 

CREATE TABLE `jos_polls` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `voters` int(9) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  `access` int(11) NOT NULL default '0',
  `lag` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Extraindo dados da tabela `jos_polls`
-- 


-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_poll_data`
-- 

CREATE TABLE `jos_poll_data` (
  `id` int(11) NOT NULL auto_increment,
  `pollid` int(11) NOT NULL default '0',
  `text` text NOT NULL,
  `hits` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `pollid` (`pollid`,`text`(1))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Extraindo dados da tabela `jos_poll_data`
-- 


-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_poll_date`
-- 

CREATE TABLE `jos_poll_date` (
  `id` bigint(20) NOT NULL auto_increment,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `vote_id` int(11) NOT NULL default '0',
  `poll_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `poll_id` (`poll_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Extraindo dados da tabela `jos_poll_date`
-- 


-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_poll_menu`
-- 

CREATE TABLE `jos_poll_menu` (
  `pollid` int(11) NOT NULL default '0',
  `menuid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pollid`,`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Extraindo dados da tabela `jos_poll_menu`
-- 


-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_sections`
-- 

CREATE TABLE `jos_sections` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `image` text NOT NULL,
  `scope` varchar(50) NOT NULL default '',
  `image_position` varchar(30) NOT NULL default '',
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_scope` (`scope`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Extraindo dados da tabela `jos_sections`
-- 

INSERT INTO `jos_sections` (`id`, `title`, `name`, `alias`, `image`, `scope`, `image_position`, `description`, `published`, `checked_out`, `checked_out_time`, `ordering`, `access`, `count`, `params`) VALUES 
(1, 'Notícias', '', 'noticia', '', 'content', 'left', '', 1, 0, '0000-00-00 00:00:00', 1, 0, 6, '');

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_session`
-- 

CREATE TABLE `jos_session` (
  `username` varchar(150) default '',
  `time` varchar(14) default '',
  `session_id` varchar(200) NOT NULL default '0',
  `guest` tinyint(4) default '1',
  `userid` int(11) default '0',
  `usertype` varchar(50) default '',
  `gid` tinyint(3) unsigned NOT NULL default '0',
  `client_id` tinyint(3) unsigned NOT NULL default '0',
  `data` longtext,
  PRIMARY KEY  (`session_id`(64)),
  KEY `whosonline` (`guest`,`usertype`),
  KEY `userid` (`userid`),
  KEY `time` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Extraindo dados da tabela `jos_session`
-- 

INSERT INTO `jos_session` (`username`, `time`, `session_id`, `guest`, `userid`, `usertype`, `gid`, `client_id`, `data`) VALUES 
('', '1244570578', 'ph5fqtvn1l2rdmf5bj7fqd3ij6', 1, 0, '', 0, 0, '__default|a:8:{s:15:"session.counter";i:1;s:19:"session.timer.start";i:1244570578;s:18:"session.timer.last";i:1244570578;s:17:"session.timer.now";i:1244570578;s:22:"session.client.browser";s:55:"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)";s:8:"registry";O:9:"JRegistry":3:{s:17:"_defaultNameSpace";s:7:"session";s:9:"_registry";a:1:{s:7:"session";a:1:{s:4:"data";O:8:"stdClass":0:{}}}s:7:"_errors";a:0:{}}s:4:"user";O:5:"JUser":19:{s:2:"id";i:0;s:4:"name";N;s:8:"username";N;s:5:"email";N;s:8:"password";N;s:14:"password_clear";s:0:"";s:8:"usertype";N;s:5:"block";N;s:9:"sendEmail";i:0;s:3:"gid";i:0;s:12:"registerDate";N;s:13:"lastvisitDate";N;s:10:"activation";N;s:6:"params";N;s:3:"aid";i:0;s:5:"guest";i:1;s:7:"_params";O:10:"JParameter":7:{s:4:"_raw";s:0:"";s:4:"_xml";N;s:9:"_elements";a:0:{}s:12:"_elementPath";a:1:{i:0;s:58:"D:\\wamp\\www\\joomla\\libraries\\joomla\\html\\parameter\\element";}s:17:"_defaultNameSpace";s:8:"_default";s:9:"_registry";a:1:{s:8:"_default";a:1:{s:4:"data";O:8:"stdClass":0:{}}}s:7:"_errors";a:0:{}}s:9:"_errorMsg";N;s:7:"_errors";a:0:{}}s:13:"session.token";s:32:"c1a7fc8bd8f4e414ee2fd714cd4d9f58";}');

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_stats_agents`
-- 

CREATE TABLE `jos_stats_agents` (
  `agent` varchar(255) NOT NULL default '',
  `type` tinyint(1) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Extraindo dados da tabela `jos_stats_agents`
-- 


-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_templates_menu`
-- 

CREATE TABLE `jos_templates_menu` (
  `template` varchar(255) NOT NULL default '',
  `menuid` int(11) NOT NULL default '0',
  `client_id` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`menuid`,`client_id`,`template`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Extraindo dados da tabela `jos_templates_menu`
-- 

INSERT INTO `jos_templates_menu` (`template`, `menuid`, `client_id`) VALUES 
('orlaonline', 0, 0),
('khepri', 0, 1);

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_users`
-- 

CREATE TABLE `jos_users` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `username` varchar(150) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `password` varchar(100) NOT NULL default '',
  `usertype` varchar(25) NOT NULL default '',
  `block` tinyint(4) NOT NULL default '0',
  `sendEmail` tinyint(4) default '0',
  `gid` tinyint(3) unsigned NOT NULL default '1',
  `registerDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `activation` varchar(100) NOT NULL default '',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `usertype` (`usertype`),
  KEY `idx_name` (`name`),
  KEY `gid_block` (`gid`,`block`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=64 ;

-- 
-- Extraindo dados da tabela `jos_users`
-- 

INSERT INTO `jos_users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `gid`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES 
(62, 'Filipe SR', 'filipe', 'fsr.trabalho@gmail.com', 'c2b6d249ef507d85f716e6019672282e:Kwn3Jaf0naPRZnHhsODKS4VMGDw7gdf0', 'Super Administrator', 0, 1, 25, '2009-06-06 23:07:23', '2009-06-08 23:32:10', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(63, 'Hilquias', 'hilquias', 'executivo@orlaonline.com.br', '25e298a752e132dd72cd5d16cad22612:mQ3Bjg2Qikn1lAEWy5eslrc13m5CpXkg', 'Publisher', 0, 0, 21, '2009-06-08 17:29:57', '2009-06-08 23:53:47', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=-3\n\n');

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `jos_weblinks`
-- 

CREATE TABLE `jos_weblinks` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `sid` int(11) NOT NULL default '0',
  `title` varchar(250) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `url` varchar(250) NOT NULL default '',
  `description` text NOT NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `hits` int(11) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `archived` tinyint(1) NOT NULL default '0',
  `approved` tinyint(1) NOT NULL default '1',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `catid` (`catid`,`published`,`archived`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Extraindo dados da tabela `jos_weblinks`
-- 

