<?php if (!defined('IN_PHPBB')) exit; ?><div style="clear: both;"></div>
<div id="nav-wrap-left"></div>
<div id="nav-wrap-right"></div>

<div id="nav">
    <ul>

            <li<?php if ($this->_rootref['SCRIPT_NAME'] == ('index')) {  ?> class="active"<?php } ?>>
                <a href="<?php echo (isset($this->_rootref['U_INDEX'])) ? $this->_rootref['U_INDEX'] : ''; ?>"><img src="<?php echo (isset($this->_rootref['T_THEME_PATH'])) ? $this->_rootref['T_THEME_PATH'] : ''; ?>/images/nav-home.png" width="16" height="16" alt="" /><?php echo ((isset($this->_rootref['L_INDEX'])) ? $this->_rootref['L_INDEX'] : ((isset($user->lang['INDEX'])) ? $user->lang['INDEX'] : '{ INDEX }')); ?></a>
            </li>
            <li class="divider"></li>

        
        <?php if (! $this->_rootref['S_IS_BOT']) {  if ($this->_rootref['S_USER_LOGGED_IN']) {  ?>

            	<li class="float-right logout">
                	<a href="<?php echo (isset($this->_rootref['U_LOGIN_LOGOUT'])) ? $this->_rootref['U_LOGIN_LOGOUT'] : ''; ?>" class="tip" title="<?php echo ((isset($this->_rootref['L_LOGOUT'])) ? $this->_rootref['L_LOGOUT'] : ((isset($user->lang['LOGOUT'])) ? $user->lang['LOGOUT'] : '{ LOGOUT }')); ?>"><img src="<?php echo (isset($this->_rootref['T_THEME_PATH'])) ? $this->_rootref['T_THEME_PATH'] : ''; ?>/images/logout.png" width="16" height="16" alt="" /></a>
                </li>
                <li class="divider float-right"></li>
            <?php } ?>

                     	
        	<li class="float-right<?php if ($this->_rootref['SCRIPT_NAME'] == ('ucp') && $this->_tpldata['DEFINE']['.']['CURRENT_PAGE'] != ('register')) {  ?> active<?php } ?>">
            	<?php if (! $this->_rootref['S_USER_LOGGED_IN']) {  ?>

            		<a href="<?php echo (isset($this->_rootref['U_LOGIN_LOGOUT'])) ? $this->_rootref['U_LOGIN_LOGOUT'] : ''; ?>"><img src="<?php echo (isset($this->_rootref['T_THEME_PATH'])) ? $this->_rootref['T_THEME_PATH'] : ''; ?>/images/key.png" width="16" height="16" alt="" /><?php echo ((isset($this->_rootref['L_LOGIN_LOGOUT'])) ? $this->_rootref['L_LOGIN_LOGOUT'] : ((isset($user->lang['LOGIN_LOGOUT'])) ? $user->lang['LOGIN_LOGOUT'] : '{ LOGIN_LOGOUT }')); ?></a>               
                <?php } else { ?>

                	<a href="<?php echo (isset($this->_rootref['U_PROFILE'])) ? $this->_rootref['U_PROFILE'] : ''; ?>"><img src="<?php echo (isset($this->_rootref['T_THEME_PATH'])) ? $this->_rootref['T_THEME_PATH'] : ''; ?>/images/userdrop.png" width="16" height="16" alt="" /><?php echo (isset($this->_rootref['S_USERNAME'])) ? $this->_rootref['S_USERNAME'] : ''; ?></a>
                    <div style="clear: both;"></div>
                    <ul class="drop">
                        <li><a href="<?php echo (isset($this->_rootref['U_SEARCH_SELF'])) ? $this->_rootref['U_SEARCH_SELF'] : ''; ?>"><?php echo ((isset($this->_rootref['L_SEARCH_SELF'])) ? $this->_rootref['L_SEARCH_SELF'] : ((isset($user->lang['SEARCH_SELF'])) ? $user->lang['SEARCH_SELF'] : '{ SEARCH_SELF }')); ?></a></li>
                        <li><a href="<?php echo (isset($this->_rootref['U_PROFILE'])) ? $this->_rootref['U_PROFILE'] : ''; ?>"><?php echo ((isset($this->_rootref['L_PROFILE'])) ? $this->_rootref['L_PROFILE'] : ((isset($user->lang['PROFILE'])) ? $user->lang['PROFILE'] : '{ PROFILE }')); ?></a></li>
                        <?php if ($this->_rootref['U_MCP']) {  ?><li><a href="<?php echo (isset($this->_rootref['U_MCP'])) ? $this->_rootref['U_MCP'] : ''; ?>"><?php echo ((isset($this->_rootref['L_MCP'])) ? $this->_rootref['L_MCP'] : ((isset($user->lang['MCP'])) ? $user->lang['MCP'] : '{ MCP }')); ?></a></li><?php } if ($this->_rootref['U_ACP']) {  ?><li><a href="<?php echo (isset($this->_rootref['U_ACP'])) ? $this->_rootref['U_ACP'] : ''; ?>"><?php echo ((isset($this->_rootref['L_ACP'])) ? $this->_rootref['L_ACP'] : ((isset($user->lang['ACP'])) ? $user->lang['ACP'] : '{ ACP }')); ?></a></li><?php } ?>

                    </ul>                         
                <?php } ?>

            </li>
            <li class="divider float-right"></li>
            
            <?php if (! $this->_rootref['S_USER_LOGGED_IN'] && $this->_rootref['S_REGISTER_ENABLED'] && ! $this->_rootref['S_SHOW_COPPA']) {  ?>

            	<li class="float-right<?php if ($this->_tpldata['DEFINE']['.']['CURRENT_PAGE'] == ('register')) {  ?> active<?php } ?>">
                	<a href="<?php echo (isset($this->_rootref['U_REGISTER'])) ? $this->_rootref['U_REGISTER'] : ''; ?>"><img src="<?php echo (isset($this->_rootref['T_THEME_PATH'])) ? $this->_rootref['T_THEME_PATH'] : ''; ?>/images/add.png" width="16" height="16" alt="" /><?php echo ((isset($this->_rootref['L_REGISTER'])) ? $this->_rootref['L_REGISTER'] : ((isset($user->lang['REGISTER'])) ? $user->lang['REGISTER'] : '{ REGISTER }')); ?></a>
                </li>
                <li class="divider float-right"></li>
            <?php } if ($this->_rootref['S_DISPLAY_SEARCH']) {  ?>

                <li class="float-right<?php if ($this->_rootref['SCRIPT_NAME'] == ('search')) {  ?> active<?php } ?>">
                    <a href="<?php echo (isset($this->_rootref['U_SEARCH'])) ? $this->_rootref['U_SEARCH'] : ''; ?>"><img src="<?php echo (isset($this->_rootref['T_THEME_PATH'])) ? $this->_rootref['T_THEME_PATH'] : ''; ?>/images/search<?php if ($this->_rootref['S_USER_LOGGED_IN']) {  ?>-drop<?php } ?>.png" width="16" height="16" alt="" /><?php echo ((isset($this->_rootref['L_SEARCH'])) ? $this->_rootref['L_SEARCH'] : ((isset($user->lang['SEARCH'])) ? $user->lang['SEARCH'] : '{ SEARCH }')); ?></a>
                    <?php if ($this->_rootref['S_USER_LOGGED_IN']) {  ?>

                    	<div style="clear: both;"></div>
                    	<ul class="drop">
                            <li><a href="<?php echo (isset($this->_rootref['U_SEARCH'])) ? $this->_rootref['U_SEARCH'] : ''; ?>"><?php echo ((isset($this->_rootref['L_SEARCH_ADV'])) ? $this->_rootref['L_SEARCH_ADV'] : ((isset($user->lang['SEARCH_ADV'])) ? $user->lang['SEARCH_ADV'] : '{ SEARCH_ADV }')); ?></a></li>
                            <li><a href="<?php echo (isset($this->_rootref['U_SEARCH_UNANSWERED'])) ? $this->_rootref['U_SEARCH_UNANSWERED'] : ''; ?>"><?php echo ((isset($this->_rootref['L_SEARCH_UNANSWERED'])) ? $this->_rootref['L_SEARCH_UNANSWERED'] : ((isset($user->lang['SEARCH_UNANSWERED'])) ? $user->lang['SEARCH_UNANSWERED'] : '{ SEARCH_UNANSWERED }')); ?></a></li>
                            <?php if ($this->_rootref['S_LOAD_UNREADS']) {  ?>

                            	<li><a href="<?php echo (isset($this->_rootref['U_SEARCH_UNREAD'])) ? $this->_rootref['U_SEARCH_UNREAD'] : ''; ?>"><?php echo ((isset($this->_rootref['L_SEARCH_UNREAD'])) ? $this->_rootref['L_SEARCH_UNREAD'] : ((isset($user->lang['SEARCH_UNREAD'])) ? $user->lang['SEARCH_UNREAD'] : '{ SEARCH_UNREAD }')); ?></a></li>
                                <li><a href="<?php echo (isset($this->_rootref['U_SEARCH_NEW'])) ? $this->_rootref['U_SEARCH_NEW'] : ''; ?>"><?php echo ((isset($this->_rootref['L_SEARCH_NEW'])) ? $this->_rootref['L_SEARCH_NEW'] : ((isset($user->lang['SEARCH_NEW'])) ? $user->lang['SEARCH_NEW'] : '{ SEARCH_NEW }')); ?></a></li>
                                <li><a href="<?php echo (isset($this->_rootref['U_SEARCH_ACTIVE_TOPICS'])) ? $this->_rootref['U_SEARCH_ACTIVE_TOPICS'] : ''; ?>"><?php echo ((isset($this->_rootref['L_SEARCH_ACTIVE_TOPICS'])) ? $this->_rootref['L_SEARCH_ACTIVE_TOPICS'] : ((isset($user->lang['SEARCH_ACTIVE_TOPICS'])) ? $user->lang['SEARCH_ACTIVE_TOPICS'] : '{ SEARCH_ACTIVE_TOPICS }')); ?></a></li>
                            <?php } ?>

                    	</ul>
                    <?php } ?>                    
                </li>
                <li class="divider float-right"></li>
            <?php } if ($this->_rootref['S_DISPLAY_MEMBERLIST']) {  ?>

                <li class="float-right<?php if ($this->_rootref['SCRIPT_NAME'] == ('memberlist')) {  ?> active<?php } ?>">
                    <a href="<?php echo (isset($this->_rootref['U_MEMBERLIST'])) ? $this->_rootref['U_MEMBERLIST'] : ''; ?>"><img src="<?php echo (isset($this->_rootref['T_THEME_PATH'])) ? $this->_rootref['T_THEME_PATH'] : ''; ?>/images/nav-members.png" width="16" height="16" alt="" /><?php echo ((isset($this->_rootref['L_MEMBERLIST'])) ? $this->_rootref['L_MEMBERLIST'] : ((isset($user->lang['MEMBERLIST'])) ? $user->lang['MEMBERLIST'] : '{ MEMBERLIST }')); ?></a>
                </li>
                <li class="divider float-right"></li>
            <?php } if ($this->_rootref['S_DISPLAY_PM']) {  ?>

                <li class="float-right">
                    <a href="<?php echo (isset($this->_rootref['U_PRIVATEMSGS'])) ? $this->_rootref['U_PRIVATEMSGS'] : ''; ?>"><img src="<?php echo (isset($this->_rootref['T_THEME_PATH'])) ? $this->_rootref['T_THEME_PATH'] : ''; ?>/images/nav-pm<?php if ($this->_rootref['S_USER_UNREAD_PRIVMSG']) {  ?>-new<?php } ?>.png" width="16" height="16" alt="" /><?php echo ((isset($this->_rootref['L_MESSAGES'])) ? $this->_rootref['L_MESSAGES'] : ((isset($user->lang['MESSAGES'])) ? $user->lang['MESSAGES'] : '{ MESSAGES }')); ?></a>
                </li>
                <li class="divider float-right"></li>            
            <?php } } ?>      

    </ul>
</div>