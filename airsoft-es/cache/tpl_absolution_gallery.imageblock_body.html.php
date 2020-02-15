<?php if (!defined('IN_PHPBB')) exit; $_imageblock_count = (isset($this->_tpldata['imageblock'])) ? sizeof($this->_tpldata['imageblock']) : 0;if ($_imageblock_count) {for ($_imageblock_i = 0; $_imageblock_i < $_imageblock_count; ++$_imageblock_i){$_imageblock_val = &$this->_tpldata['imageblock'][$_imageblock_i]; ?>

<div class="forumbg">
	<div class="inner">
		<span class="corners-top"><span></span></span>
		<ul class="topiclist">
			<li class="header">
				<dl class="icon">
					<dt><?php if ($_imageblock_val['U_BLOCK']) {  ?><a href="<?php echo $_imageblock_val['U_BLOCK']; ?>"><?php echo $_imageblock_val['BLOCK_NAME']; ?></a><?php } else { echo $_imageblock_val['BLOCK_NAME']; } ?></dt>
				</dl>
			</li>
		</ul>
		<ul class="topiclist topics">
			<li class="bg2">
				<table width="100%" cellpadding="2" cellspacing="10" border="0" class="forumline">
					<?php $_imagerow_count = (isset($_imageblock_val['imagerow'])) ? sizeof($_imageblock_val['imagerow']) : 0;if ($_imagerow_count) {for ($_imagerow_i = 0; $_imagerow_i < $_imagerow_count; ++$_imagerow_i){$_imagerow_val = &$_imageblock_val['imagerow'][$_imagerow_i]; ?>

					<tr>
						<?php $_image_count = (isset($_imagerow_val['image'])) ? sizeof($_imagerow_val['image']) : 0;if ($_image_count) {for ($_image_i = 0; $_image_i < $_image_count; ++$_image_i){$_image_val = &$_imagerow_val['image'][$_image_i]; ?>

						<td class="bg2" valign="top" style="width: <?php echo $_imageblock_val['S_COL_WIDTH']; ?>;">
							<table width="100%" cellpadding="2" cellspacing="5" border="0" class="forumline">
								<tr>
									<td align="center" style="height: <?php echo (isset($this->_rootref['S_THUMBNAIL_SIZE'])) ? $this->_rootref['S_THUMBNAIL_SIZE'] : ''; ?>px;" class="bg1<?php if ($_image_val['S_UNAPPROVED']) {  ?> g_unapproved<?php } if ($_image_val['S_LOCKED']) {  ?> g_locked<?php } if ($_image_val['S_REPORTED']) {  ?> g_reported<?php } ?>">
										<span class="genmed"><?php echo $_image_val['UC_THUMBNAIL']; ?></span>
									</td>
								</tr>
								<tr>
									<td class="bg2" valign="top">
										<div class="gensmall" style="overflow: hidden;">
											<?php if ($_image_val['CONTEST_RANK']) {  echo ((isset($this->_rootref['L_CONTEST_RESULT'])) ? $this->_rootref['L_CONTEST_RESULT'] : ((isset($user->lang['CONTEST_RESULT'])) ? $user->lang['CONTEST_RESULT'] : '{ CONTEST_RESULT }')); ?>: <strong><?php echo $_image_val['CONTEST_RANK']; ?></strong><br /><?php } if ($_image_val['UC_IMAGE_NAME']) {  echo ((isset($this->_rootref['L_IMAGE_NAME'])) ? $this->_rootref['L_IMAGE_NAME'] : ((isset($user->lang['IMAGE_NAME'])) ? $user->lang['IMAGE_NAME'] : '{ IMAGE_NAME }')); ?>: <?php echo $_image_val['UC_IMAGE_NAME']; ?><br /><?php } if ($_image_val['U_ALBUM']) {  echo ((isset($this->_rootref['L_ALBUM_NAME'])) ? $this->_rootref['L_ALBUM_NAME'] : ((isset($user->lang['ALBUM_NAME'])) ? $user->lang['ALBUM_NAME'] : '{ ALBUM_NAME }')); ?>: <a href="<?php echo $_image_val['U_ALBUM']; ?>" style="font-weight: bold;" title="<?php echo $_image_val['ALBUM_NAME_FULL']; ?>"><?php echo $_image_val['ALBUM_NAME']; ?></a><br /><?php } if ($_image_val['POSTER']) {  echo ((isset($this->_rootref['L_UPLOADED_BY_USER'])) ? $this->_rootref['L_UPLOADED_BY_USER'] : ((isset($user->lang['UPLOADED_BY_USER'])) ? $user->lang['UPLOADED_BY_USER'] : '{ UPLOADED_BY_USER }')); ?>: <?php echo $_image_val['POSTER']; ?><br /><?php } if ($_image_val['TIME']) {  echo ((isset($this->_rootref['L_UPLOADED_ON_DATE'])) ? $this->_rootref['L_UPLOADED_ON_DATE'] : ((isset($user->lang['UPLOADED_ON_DATE'])) ? $user->lang['UPLOADED_ON_DATE'] : '{ UPLOADED_ON_DATE }')); ?>: <?php echo $_image_val['TIME']; ?><br /><?php } if ($_image_val['VIEW'] > (-1)) {  echo ((isset($this->_rootref['L_GALLERY_VIEWS'])) ? $this->_rootref['L_GALLERY_VIEWS'] : ((isset($user->lang['GALLERY_VIEWS'])) ? $user->lang['GALLERY_VIEWS'] : '{ GALLERY_VIEWS }')); ?>: <?php echo $_image_val['VIEW']; ?><br /><?php } if ($_image_val['S_RATINGS']) {  echo ((isset($this->_rootref['L_RATING'])) ? $this->_rootref['L_RATING'] : ((isset($user->lang['RATING'])) ? $user->lang['RATING'] : '{ RATING }')); ?>: <a href="<?php echo $_image_val['U_RATINGS']; ?>"><?php echo $_image_val['S_RATINGS']; ?></a><br /><?php } if ($_image_val['S_COMMENTS']) {  echo $_image_val['L_COMMENTS']; ?>: <a href="<?php echo $_image_val['U_COMMENTS']; ?>"><?php echo $_image_val['S_COMMENTS']; ?></a><br /><?php } if ($_image_val['S_IP']) {  echo ((isset($this->_rootref['L_IP'])) ? $this->_rootref['L_IP'] : ((isset($user->lang['IP'])) ? $user->lang['IP'] : '{ IP }')); ?>: <?php echo $_image_val['S_IP']; ?> &#187; <a href="<?php echo $_image_val['U_WHOIS']; ?>" onclick="popup(this.href, 750, 500); return false;"><?php echo ((isset($this->_rootref['L_WHOIS'])) ? $this->_rootref['L_WHOIS'] : ((isset($user->lang['WHOIS'])) ? $user->lang['WHOIS'] : '{ WHOIS }')); ?></a><br /><?php } if ($_image_val['U_REPORT'] || $_image_val['U_STATUS'] || $_image_val['U_MOVE'] || $_image_val['U_EDIT'] || $_image_val['U_DELETE']) {  ?>

											<a href="javascript: dE('moderate_imageblock_<?php echo $_imageblock_val['S_ROW_COUNT']; ?>_imagerow_<?php echo $_image_val['IMAGE_ID']; ?>');"><?php echo ((isset($this->_rootref['L_MODERATE'])) ? $this->_rootref['L_MODERATE'] : ((isset($user->lang['MODERATE'])) ? $user->lang['MODERATE'] : '{ MODERATE }')); ?></a>
											<div id="moderate_imageblock_<?php echo $_imageblock_val['S_ROW_COUNT']; ?>_imagerow_<?php echo $_image_val['IMAGE_ID']; ?>" style="display: none;">
												<?php if ($_image_val['U_REPORT']) {  ?>&#187; <a href="<?php echo $_image_val['U_REPORT']; ?>" class="reported-images-number"><?php echo ((isset($this->_rootref['L_READ_REPORT'])) ? $this->_rootref['L_READ_REPORT'] : ((isset($user->lang['READ_REPORT'])) ? $user->lang['READ_REPORT'] : '{ READ_REPORT }')); ?></a><br /><?php } if ($_image_val['U_STATUS']) {  ?>&#187; <a href="<?php echo $_image_val['U_STATUS']; ?>"><?php echo $_image_val['L_STATUS']; ?></a><br /><?php } if ($_image_val['U_MOVE']) {  ?>&#187; <a href="<?php echo $_image_val['U_MOVE']; ?>"><?php echo ((isset($this->_rootref['L_MOVE'])) ? $this->_rootref['L_MOVE'] : ((isset($user->lang['MOVE'])) ? $user->lang['MOVE'] : '{ MOVE }')); ?></a><br /><?php } if ($_image_val['U_EDIT']) {  ?>&#187; <a href="<?php echo $_image_val['U_EDIT']; ?>"><?php echo ((isset($this->_rootref['L_EDIT_IMAGE'])) ? $this->_rootref['L_EDIT_IMAGE'] : ((isset($user->lang['EDIT_IMAGE'])) ? $user->lang['EDIT_IMAGE'] : '{ EDIT_IMAGE }')); ?></a><br /><?php } if ($_image_val['U_DELETE']) {  ?>&#187; <a href="<?php echo $_image_val['U_DELETE']; ?>"><?php echo ((isset($this->_rootref['L_DELETE_IMAGE'])) ? $this->_rootref['L_DELETE_IMAGE'] : ((isset($user->lang['DELETE_IMAGE'])) ? $user->lang['DELETE_IMAGE'] : '{ DELETE_IMAGE }')); ?></a><br /><?php } ?>

											</div>
											<?php } ?>

										</div>
									</td>
								</tr>
							</table>
						</td>
						<?php }} $_no_image_count = (isset($_imagerow_val['no_image'])) ? sizeof($_imagerow_val['no_image']) : 0;if ($_no_image_count) {for ($_no_image_i = 0; $_no_image_i < $_no_image_count; ++$_no_image_i){$_no_image_val = &$_imagerow_val['no_image'][$_no_image_i]; ?> 
							<td class="bg2" valign="top" style="width: <?php echo $_imageblock_val['S_COL_WIDTH']; ?>;">
								<table width="100%" cellpadding="2" cellspacing="10" border="0" class="forumline"><tr>
								<td style="height: <?php echo (isset($this->_rootref['S_THUMBNAIL_SIZE'])) ? $this->_rootref['S_THUMBNAIL_SIZE'] : ''; ?>px;" class="bg1"></td>
								</tr></table>
							</td> 
						<?php }} ?>

					</tr>
					<?php }} ?>

				</table>
			</li>
		</ul>
		<span class="corners-bottom"><span></span></span>
	</div>
</div>
<?php }} ?>