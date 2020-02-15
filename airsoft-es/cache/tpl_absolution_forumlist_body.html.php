<?php if (!defined('IN_PHPBB')) exit; ?><div class="forumlist">
<?php $_forumrow_count = (isset($this->_tpldata['forumrow'])) ? sizeof($this->_tpldata['forumrow']) : 0;if ($_forumrow_count) {for ($_forumrow_i = 0; $_forumrow_i < $_forumrow_count; ++$_forumrow_i){$_forumrow_val = &$this->_tpldata['forumrow'][$_forumrow_i]; if (( $_forumrow_val['S_IS_CAT'] && ! $_forumrow_val['S_FIRST_ROW'] ) || $_forumrow_val['S_NO_CAT']) {  ?>

    				</table>
            	</div>
            </div>
            <br /><br />
	<?php } if ($_forumrow_val['S_IS_CAT'] || $_forumrow_val['S_FIRST_ROW'] || $_forumrow_val['S_NO_CAT']) {  ?>

    <div class="catglow">
        <div class="cathead-m">
            <div class="cathead-r">
                <div class="cathead-l">
                    <?php if ($_forumrow_val['S_IS_CAT']) {  ?><a href="<?php echo $_forumrow_val['U_VIEWFORUM']; ?>"><?php echo $_forumrow_val['FORUM_NAME']; ?></a><?php } else { echo ((isset($this->_rootref['L_FORUM'])) ? $this->_rootref['L_FORUM'] : ((isset($user->lang['FORUM'])) ? $user->lang['FORUM'] : '{ FORUM }')); } ?>

                </div>
            </div>
        </div>
        
        <?php if ($this->_tpldata['DEFINE']['.']['COLLAPSIBLE_CATEGORIES']) {  if ($this->_rootref['SCRIPT_NAME'] == ('index')) {  ?><div class="trigger active"></div><?php } } ?>

        <div class="collapsethis">
        	<table class="cat" cellpadding="0" cellspacing="0" width="100%">
	<?php } if (! $_forumrow_val['S_IS_CAT']) {  ?>

    	<tr>
        	<td class="forumicon"><?php echo $_forumrow_val['FORUM_FOLDER_IMG']; ?></td>
            <td class="forumdetails<?php if ($_forumrow_val['S_IS_LINK']) {  ?> forumlink<?php } ?>">
            	<?php if ($_forumrow_val['FORUM_IMAGE']) {  ?><span class="forumimage"><?php echo $_forumrow_val['FORUM_IMAGE']; ?></span><?php } ?>

            	                   <a href="<?php echo $_forumrow_val['U_VIEWFORUM']; ?>" class="forumtitle"><?php echo $_forumrow_val['FORUM_NAME']; ?></a> <?php if ($this->_rootref['S_ENABLE_FEEDS'] && $_forumrow_val['S_FEED_ENABLED']) {  ?> <a class="feed-icon-forum" title="<?php echo ((isset($this->_rootref['L_FEED'])) ? $this->_rootref['L_FEED'] : ((isset($user->lang['FEED'])) ? $user->lang['FEED'] : '{ FEED }')); ?> - <?php echo $_forumrow_val['FORUM_NAME']; ?>" href="<?php echo (isset($this->_rootref['U_FEED'])) ? $this->_rootref['U_FEED'] : ''; ?>?f=<?php echo $_forumrow_val['FORUM_ID']; ?>"><img src="<?php echo (isset($this->_rootref['T_THEME_PATH'])) ? $this->_rootref['T_THEME_PATH'] : ''; ?>/images/feed.gif" alt="<?php echo ((isset($this->_rootref['L_FEED'])) ? $this->_rootref['L_FEED'] : ((isset($user->lang['FEED'])) ? $user->lang['FEED'] : '{ FEED }')); ?> - <?php echo $_forumrow_val['FORUM_NAME']; ?>" /></a> <?php } ?>

    <br />
				<span class="forum-descriptions"><?php echo $_forumrow_val['FORUM_DESC']; ?></span>
                <?php if ($_forumrow_val['SUBFORUMS'] && $_forumrow_val['S_LIST_SUBFORUMS']) {  ?>

                    <span class="subforums">
                    	<img src="<?php echo (isset($this->_rootref['T_THEME_PATH'])) ? $this->_rootref['T_THEME_PATH'] : ''; ?>/images/tree.gif" width="19" height="12" alt="" />
                    	<strong><?php echo $_forumrow_val['L_SUBFORUM_STR']; ?></strong> <?php echo $_forumrow_val['SUBFORUMS']; ?>

                    </span>
                <?php } if ($_forumrow_val['MODERATORS']) {  ?>

                    <span class="forummods">
                    	<?php if ($_forumrow_val['SUBFORUMS']) {  ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?><img src="<?php echo (isset($this->_rootref['T_THEME_PATH'])) ? $this->_rootref['T_THEME_PATH'] : ''; ?>/images/tree.gif" width="19" height="12" alt="" />
                    	<strong><?php echo $_forumrow_val['L_MODERATOR_STR']; ?>:</strong> <?php echo $_forumrow_val['MODERATORS']; ?>

                    </span>
                <?php } ?>                          
            </td>
            <?php if ($_forumrow_val['CLICKS']) {  ?>

            <td colspan="3" class="forumclicks">
            	<?php echo ((isset($this->_rootref['L_REDIRECTS'])) ? $this->_rootref['L_REDIRECTS'] : ((isset($user->lang['REDIRECTS'])) ? $user->lang['REDIRECTS'] : '{ REDIRECTS }')); ?>: <?php echo $_forumrow_val['CLICKS']; ?>

            </td>
            <?php } else if (! $_forumrow_val['S_IS_LINK']) {  ?>

                <td class="forumlastpost">
                    <?php if ($_forumrow_val['U_UNAPPROVED_TOPICS']) {  ?><a href="<?php echo $_forumrow_val['U_UNAPPROVED_TOPICS']; ?>"><?php echo (isset($this->_rootref['UNAPPROVED_IMG'])) ? $this->_rootref['UNAPPROVED_IMG'] : ''; ?></a><?php } if ($_forumrow_val['LAST_POST_TIME']) {  ?>

                        <?php echo ((isset($this->_rootref['L_LAST_POST'])) ? $this->_rootref['L_LAST_POST'] : ((isset($user->lang['LAST_POST'])) ? $user->lang['LAST_POST'] : '{ LAST_POST }')); ?> <?php echo ((isset($this->_rootref['L_POST_BY_AUTHOR'])) ? $this->_rootref['L_POST_BY_AUTHOR'] : ((isset($user->lang['POST_BY_AUTHOR'])) ? $user->lang['POST_BY_AUTHOR'] : '{ POST_BY_AUTHOR }')); ?> <?php echo $_forumrow_val['LAST_POSTER_FULL']; ?>

                        <?php if (! $this->_rootref['S_IS_BOT']) {  ?>

                            <a href="<?php echo $_forumrow_val['U_LAST_POST']; ?>"><?php echo (isset($this->_rootref['LAST_POST_IMG'])) ? $this->_rootref['LAST_POST_IMG'] : ''; ?></a>
                        <?php } ?><br /><span class="fade"><?php echo $_forumrow_val['LAST_POST_TIME']; ?></span>
                    <?php } else { ?>

                        <span class="fade"><?php echo ((isset($this->_rootref['L_NO_POSTS'])) ? $this->_rootref['L_NO_POSTS'] : ((isset($user->lang['NO_POSTS'])) ? $user->lang['NO_POSTS'] : '{ NO_POSTS }')); ?></span><br />&nbsp;
                    <?php } ?>            
                </td>
                <td class="forumtopics"><div class="statbubble"><span><?php echo $_forumrow_val['TOPICS']; ?></span><br /><?php echo ((isset($this->_rootref['L_TOPICS'])) ? $this->_rootref['L_TOPICS'] : ((isset($user->lang['TOPICS'])) ? $user->lang['TOPICS'] : '{ TOPICS }')); ?></div></td>
                <td class="forumposts"><div class="statbubble"><span><?php echo $_forumrow_val['POSTS']; ?></span><br /><?php echo ((isset($this->_rootref['L_POSTS'])) ? $this->_rootref['L_POSTS'] : ((isset($user->lang['POSTS'])) ? $user->lang['POSTS'] : '{ POSTS }')); ?></div></td>
            <?php } ?>

        </tr>
	<?php } if ($_forumrow_val['S_LAST_ROW']) {  ?>  					
					</table>
           		</div>
            </div>
	<?php } }} else { ?>

	<div class="panel">
		<div class="inner"><span class="corners-top"><span></span></span>
		<strong><?php echo ((isset($this->_rootref['L_NO_FORUMS'])) ? $this->_rootref['L_NO_FORUMS'] : ((isset($user->lang['NO_FORUMS'])) ? $user->lang['NO_FORUMS'] : '{ NO_FORUMS }')); ?></strong>
		<span class="corners-bottom"><span></span></span></div>
	</div>
<?php } ?>

</div>

<?php if ($this->_tpldata['DEFINE']['.']['COLLAPSIBLE_CATEGORIES']) {  ?>

    <script type="text/javascript">
    // <![CDATA[
                $(".forumlist").collapse({show: function(){
                        this.animate({
                            opacity: 'toggle',
                            height: 'toggle'
                        }, 300);
                    },
                    hide : function() {
                        this.animate({
                            opacity: 'toggle',
                            height: 'toggle'
                        }, 300);
                    }
                });
    // ]]>
    </script>
<?php } ?>