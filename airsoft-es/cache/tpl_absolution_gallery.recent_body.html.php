<?php if (!defined('IN_PHPBB')) exit; $this->_tpl_include('gallery/imageblock_body.html'); if (sizeof($this->_tpldata['commentrow'])) {  ?>

	<h4><?php if (! $this->_rootref['COLLAPSE_COMMENTS']) {  if ($this->_rootref['U_G_SEARCH_COMMENTED']) {  ?><a href="<?php echo (isset($this->_rootref['U_G_SEARCH_COMMENTED'])) ? $this->_rootref['U_G_SEARCH_COMMENTED'] : ''; ?>"><?php echo ((isset($this->_rootref['L_RECENT_COMMENTS'])) ? $this->_rootref['L_RECENT_COMMENTS'] : ((isset($user->lang['RECENT_COMMENTS'])) ? $user->lang['RECENT_COMMENTS'] : '{ RECENT_COMMENTS }')); ?></a><?php } else { echo ((isset($this->_rootref['L_RECENT_COMMENTS'])) ? $this->_rootref['L_RECENT_COMMENTS'] : ((isset($user->lang['RECENT_COMMENTS'])) ? $user->lang['RECENT_COMMENTS'] : '{ RECENT_COMMENTS }')); } } else { ?><a href="javascript: dE('recent-comments');"><?php echo ((isset($this->_rootref['L_RECENT_COMMENTS'])) ? $this->_rootref['L_RECENT_COMMENTS'] : ((isset($user->lang['RECENT_COMMENTS'])) ? $user->lang['RECENT_COMMENTS'] : '{ RECENT_COMMENTS }')); ?></a><?php } ?></h4>
	<div id="recent-comments"<?php if ($this->_rootref['COLLAPSE_COMMENTS']) {  ?> style="display: none;"<?php } ?>>
	<?php $_commentrow_count = (isset($this->_tpldata['commentrow'])) ? sizeof($this->_tpldata['commentrow']) : 0;if ($_commentrow_count) {for ($_commentrow_i = 0; $_commentrow_i < $_commentrow_count; ++$_commentrow_i){$_commentrow_val = &$this->_tpldata['commentrow'][$_commentrow_i]; ?>

	<a id="comment_<?php echo $_commentrow_val['COMMENT_ID']; ?>"></a>
	<div class="post <?php if (($_commentrow_val['S_ROW_COUNT'] & 1)  ) {  ?>bg1<?php } else { ?>bg2<?php } ?>">
		<div class="inner">
			<span class="corners-top"><span></span></span>
			<div class="postbody">
				<?php if ($_commentrow_val['U_DELETE'] || $_commentrow_val['U_EDIT'] || $_commentrow_val['U_INFO'] || $_commentrow_val['U_QUOTE']) {  ?>

					<ul class="profile-icons">
						<?php if ($_commentrow_val['U_EDIT']) {  ?><li class="edit-icon"><a href="<?php echo $_commentrow_val['U_EDIT']; ?>" title="<?php echo ((isset($this->_rootref['L_EDIT_COMMENT'])) ? $this->_rootref['L_EDIT_COMMENT'] : ((isset($user->lang['EDIT_COMMENT'])) ? $user->lang['EDIT_COMMENT'] : '{ EDIT_COMMENT }')); ?>"><span><?php echo ((isset($this->_rootref['L_EDIT_COMMENT'])) ? $this->_rootref['L_EDIT_COMMENT'] : ((isset($user->lang['EDIT_COMMENT'])) ? $user->lang['EDIT_COMMENT'] : '{ EDIT_COMMENT }')); ?></span></a></li><?php } if ($_commentrow_val['U_DELETE']) {  ?><li class="delete-icon"><a href="<?php echo $_commentrow_val['U_DELETE']; ?>" title="<?php echo ((isset($this->_rootref['L_DELETE_COMMENT'])) ? $this->_rootref['L_DELETE_COMMENT'] : ((isset($user->lang['DELETE_COMMENT'])) ? $user->lang['DELETE_COMMENT'] : '{ DELETE_COMMENT }')); ?>"><span><?php echo ((isset($this->_rootref['L_DELETE_COMMENT'])) ? $this->_rootref['L_DELETE_COMMENT'] : ((isset($user->lang['DELETE_COMMENT'])) ? $user->lang['DELETE_COMMENT'] : '{ DELETE_COMMENT }')); ?></span></a></li><?php } if ($_commentrow_val['U_INFO']) {  ?><li class="info-icon"><a href="<?php echo $_commentrow_val['U_INFO']; ?>" title="<?php echo ((isset($this->_rootref['L_IP'])) ? $this->_rootref['L_IP'] : ((isset($user->lang['IP'])) ? $user->lang['IP'] : '{ IP }')); ?>" onclick="popup(this.href, 750, 500); return false;"><span><?php echo ((isset($this->_rootref['L_IP'])) ? $this->_rootref['L_IP'] : ((isset($user->lang['IP'])) ? $user->lang['IP'] : '{ IP }')); ?></span></a></li><?php } if ($_commentrow_val['U_QUOTE']) {  ?><li class="quote-icon"><a href="<?php echo $_commentrow_val['U_QUOTE']; ?>" title="<?php echo ((isset($this->_rootref['L_QUOTE_COMMENT'])) ? $this->_rootref['L_QUOTE_COMMENT'] : ((isset($user->lang['QUOTE_COMMENT'])) ? $user->lang['QUOTE_COMMENT'] : '{ QUOTE_COMMENT }')); ?>"><span><?php echo ((isset($this->_rootref['L_QUOTE_COMMENT'])) ? $this->_rootref['L_QUOTE_COMMENT'] : ((isset($user->lang['QUOTE_COMMENT'])) ? $user->lang['QUOTE_COMMENT'] : '{ QUOTE_COMMENT }')); ?></span></a></li><?php } ?>

					</ul>
				<?php } ?>

				<p class="author"><a href="<?php echo $_commentrow_val['U_COMMENT']; ?>"><?php echo (isset($this->_rootref['MINI_POST_IMG'])) ? $this->_rootref['MINI_POST_IMG'] : ''; ?></a>&nbsp;<?php echo ((isset($this->_rootref['L_POST_BY_AUTHOR'])) ? $this->_rootref['L_POST_BY_AUTHOR'] : ((isset($user->lang['POST_BY_AUTHOR'])) ? $user->lang['POST_BY_AUTHOR'] : '{ POST_BY_AUTHOR }')); ?> <strong><?php echo $_commentrow_val['POST_AUTHOR_FULL']; ?></strong> &raquo; <?php echo $_commentrow_val['TIME']; ?> </p>
				<div class="content"><?php echo $_commentrow_val['TEXT']; ?></div>
			</div>
			<dl class="postprofile" id="profile<?php echo $_commentrow_val['COMMENT_ID']; ?>">
				<dd><?php echo ((isset($this->_rootref['L_COMMENT_ON'])) ? $this->_rootref['L_COMMENT_ON'] : ((isset($user->lang['COMMENT_ON'])) ? $user->lang['COMMENT_ON'] : '{ COMMENT_ON }')); ?>:</dd>
				<dd><?php echo $_commentrow_val['UC_IMAGE_NAME']; ?></dd>
				<dt><?php echo $_commentrow_val['UC_THUMBNAIL']; ?></dt>
				<dd>&nbsp;</dd>

				<dd><?php echo ((isset($this->_rootref['L_UPLOADED_BY_USER'])) ? $this->_rootref['L_UPLOADED_BY_USER'] : ((isset($user->lang['UPLOADED_BY_USER'])) ? $user->lang['UPLOADED_BY_USER'] : '{ UPLOADED_BY_USER }')); ?> <?php echo $_commentrow_val['IMAGE_AUTHOR']; ?></dd>
				<dd><?php echo $_commentrow_val['IMAGE_TIME']; ?></dd>
			</dl>
			<span class="corners-bottom"><span></span></span>
		</div>
	</div>
	<?php }} ?>

	</div>
<?php } if (( sizeof($this->_tpldata['recent']) || sizeof($this->_tpldata['random']) || sizeof($this->_tpldata['contest']) || sizeof($this->_tpldata['commentrow']) ) && ! $this->_rootref['S_IN_GALLERY']) {  ?>

<!--
	I request you retain the full copyright notice below including the link to www.flying-bits.org.
	This not only gives respect to the large amount of time given freely by the developer
	but also helps build interest, traffic and use of phpBB Gallery. If you (honestly) cannot retain
	the full copyright I ask you at least leave in place the "Powered by phpBB Gallery" line, with
	"phpBB Gallery" linked to www.flying-bits.org. If you refuse to include even this then support on my
	forums may be affected.

	phpBB Gallery, nickvergessen : 2009
//-->
<div class="copyright">
	Powered by <a href="http://www.flying-bits.org/">phpBB Gallery</a> &copy; 2007, 2009 <a href="http://www.flying-bits.org/">nickvergessen</a>
	<?php if ($this->_rootref['GALLERY_TRANSLATION_INFO']) {  ?><br /><?php echo (isset($this->_rootref['GALLERY_TRANSLATION_INFO'])) ? $this->_rootref['GALLERY_TRANSLATION_INFO'] : ''; } ?>

</div>
<br />
<?php } ?>