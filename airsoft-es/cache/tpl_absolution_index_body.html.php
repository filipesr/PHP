<?php if (!defined('IN_PHPBB')) exit; $this->_tpl_include('overall_header.html'); $this->_tpl_include('forumlist_body.html'); ?>


<br />

<div class="indexlinks">
    <?php if ($this->_rootref['U_TEAM']) {  ?><a href="<?php echo (isset($this->_rootref['U_TEAM'])) ? $this->_rootref['U_TEAM'] : ''; ?>"><?php echo ((isset($this->_rootref['L_THE_TEAM'])) ? $this->_rootref['L_THE_TEAM'] : ((isset($user->lang['THE_TEAM'])) ? $user->lang['THE_TEAM'] : '{ THE_TEAM }')); ?></a> | <?php } if (! $this->_rootref['S_IS_BOT']) {  ?><a href="<?php echo (isset($this->_rootref['U_DELETE_COOKIES'])) ? $this->_rootref['U_DELETE_COOKIES'] : ''; ?>"><?php echo ((isset($this->_rootref['L_DELETE_COOKIES'])) ? $this->_rootref['L_DELETE_COOKIES'] : ((isset($user->lang['DELETE_COOKIES'])) ? $user->lang['DELETE_COOKIES'] : '{ DELETE_COOKIES }')); ?></a><?php } ?> | 
    <a href="<?php echo (isset($this->_rootref['U_FAQ'])) ? $this->_rootref['U_FAQ'] : ''; ?>"><?php echo ((isset($this->_rootref['L_FAQ'])) ? $this->_rootref['L_FAQ'] : ((isset($user->lang['FAQ'])) ? $user->lang['FAQ'] : '{ FAQ }')); ?></a>
    <?php if (! $this->_rootref['S_IS_BOT'] && $this->_rootref['U_MARK_FORUMS'] && $this->_rootref['SCRIPT_NAME'] == ('index')) {  ?> | <a href="<?php echo (isset($this->_rootref['U_MARK_FORUMS'])) ? $this->_rootref['U_MARK_FORUMS'] : ''; ?>" accesskey="m"><?php echo ((isset($this->_rootref['L_MARK_FORUMS_READ'])) ? $this->_rootref['L_MARK_FORUMS_READ'] : ((isset($user->lang['MARK_FORUMS_READ'])) ? $user->lang['MARK_FORUMS_READ'] : '{ MARK_FORUMS_READ }')); ?></a><?php } ?>

    <br /><?php echo (isset($this->_rootref['CURRENT_TIME'])) ? $this->_rootref['CURRENT_TIME'] : ''; ?>

</div>

<br />

<div class="catglow">
    <div class="cathead-m">
        <div class="cathead-r">
            <div class="cathead-l">
            	<?php echo ((isset($this->_rootref['L_INFORMATION'])) ? $this->_rootref['L_INFORMATION'] : ((isset($user->lang['INFORMATION'])) ? $user->lang['INFORMATION'] : '{ INFORMATION }')); ?>

            </div>
        </div>
    </div>
    <div class="collapsethis">
    	<?php if (! $this->_rootref['S_USER_LOGGED_IN'] && ! $this->_rootref['S_IS_BOT']) {  ?>

            <div class="statspanel" style="background-image: url('<?php echo (isset($this->_rootref['T_THEME_PATH'])) ? $this->_rootref['T_THEME_PATH'] : ''; ?>/images/lock.png');">
                <form method="post" action="<?php echo (isset($this->_rootref['S_LOGIN_ACTION'])) ? $this->_rootref['S_LOGIN_ACTION'] : ''; ?>">
                    <fieldset class="quick-login">
                        <label for="username"><?php echo ((isset($this->_rootref['L_USERNAME'])) ? $this->_rootref['L_USERNAME'] : ((isset($user->lang['USERNAME'])) ? $user->lang['USERNAME'] : '{ USERNAME }')); ?>:</label>&nbsp;<input type="text" name="username" id="username" size="10" class="inputbox" title="<?php echo ((isset($this->_rootref['L_USERNAME'])) ? $this->_rootref['L_USERNAME'] : ((isset($user->lang['USERNAME'])) ? $user->lang['USERNAME'] : '{ USERNAME }')); ?>" />
                        <label for="password"><?php echo ((isset($this->_rootref['L_PASSWORD'])) ? $this->_rootref['L_PASSWORD'] : ((isset($user->lang['PASSWORD'])) ? $user->lang['PASSWORD'] : '{ PASSWORD }')); ?>:</label>&nbsp;<input type="password" name="password" id="password" size="10" class="inputbox" title="<?php echo ((isset($this->_rootref['L_PASSWORD'])) ? $this->_rootref['L_PASSWORD'] : ((isset($user->lang['PASSWORD'])) ? $user->lang['PASSWORD'] : '{ PASSWORD }')); ?>" />
                        <?php if ($this->_rootref['S_AUTOLOGIN_ENABLED']) {  ?>

                            <input type="checkbox" name="autologin" id="autologin" class="tip" title="<?php echo ((isset($this->_rootref['L_LOG_ME_IN'])) ? $this->_rootref['L_LOG_ME_IN'] : ((isset($user->lang['LOG_ME_IN'])) ? $user->lang['LOG_ME_IN'] : '{ LOG_ME_IN }')); ?>" /> &nbsp;
                        <?php } ?>

                        <input type="submit" name="login" value="<?php echo ((isset($this->_rootref['L_LOGIN'])) ? $this->_rootref['L_LOGIN'] : ((isset($user->lang['LOGIN'])) ? $user->lang['LOGIN'] : '{ LOGIN }')); ?>" class="button2" />
                        <?php echo (isset($this->_rootref['S_LOGIN_REDIRECT'])) ? $this->_rootref['S_LOGIN_REDIRECT'] : ''; ?>

                    </fieldset>
                </form>
            </div>
        <?php } if ($this->_rootref['S_DISPLAY_ONLINE_LIST']) {  ?>

        	<div class="statspanel" style="background-image: url('<?php echo (isset($this->_rootref['T_THEME_PATH'])) ? $this->_rootref['T_THEME_PATH'] : ''; ?>/images/who-is-online.png');">
                <?php echo (isset($this->_rootref['TOTAL_USERS_ONLINE'])) ? $this->_rootref['TOTAL_USERS_ONLINE'] : ''; ?> <!--(<?php echo ((isset($this->_rootref['L_ONLINE_EXPLAIN'])) ? $this->_rootref['L_ONLINE_EXPLAIN'] : ((isset($user->lang['ONLINE_EXPLAIN'])) ? $user->lang['ONLINE_EXPLAIN'] : '{ ONLINE_EXPLAIN }')); ?>)--><?php if ($this->_rootref['S_USER_LOGGED_IN'] && $this->_rootref['U_VIEWONLINE']) {  ?> - <a href="<?php echo (isset($this->_rootref['U_VIEWONLINE'])) ? $this->_rootref['U_VIEWONLINE'] : ''; ?>"><?php echo ((isset($this->_rootref['L_WHO_IS_ONLINE'])) ? $this->_rootref['L_WHO_IS_ONLINE'] : ((isset($user->lang['WHO_IS_ONLINE'])) ? $user->lang['WHO_IS_ONLINE'] : '{ WHO_IS_ONLINE }')); ?>?</a><?php } ?>

                <!--<br /><?php echo (isset($this->_rootref['RECORD_USERS'])) ? $this->_rootref['RECORD_USERS'] : ''; ?>-->
                <br /><br /><?php echo (isset($this->_rootref['LOGGED_IN_USER_LIST'])) ? $this->_rootref['LOGGED_IN_USER_LIST'] : ''; ?><br />
                <?php if ($this->_rootref['LEGEND']) {  ?><br /><strong><?php echo ((isset($this->_rootref['L_LEGEND'])) ? $this->_rootref['L_LEGEND'] : ((isset($user->lang['LEGEND'])) ? $user->lang['LEGEND'] : '{ LEGEND }')); ?>: <?php echo (isset($this->_rootref['LEGEND'])) ? $this->_rootref['LEGEND'] : ''; ?></strong><?php } ?>   
                <br />    
            </div>
        <?php } if ($this->_rootref['NEWEST_USER']) {  ?>

        	<div class="statspanel" style="background-image: url('<?php echo (isset($this->_rootref['T_THEME_PATH'])) ? $this->_rootref['T_THEME_PATH'] : ''; ?>/images/statistics.png');">
            	<?php echo (isset($this->_rootref['TOTAL_POSTS'])) ? $this->_rootref['TOTAL_POSTS'] : ''; ?> &bull; <?php echo (isset($this->_rootref['TOTAL_TOPICS'])) ? $this->_rootref['TOTAL_TOPICS'] : ''; ?> &bull; <?php echo (isset($this->_rootref['TOTAL_USERS'])) ? $this->_rootref['TOTAL_USERS'] : ''; ?> &bull; <?php echo (isset($this->_rootref['NEWEST_USER'])) ? $this->_rootref['NEWEST_USER'] : ''; ?>

            </div>
        <?php } if ($this->_rootref['S_DISPLAY_BIRTHDAY_LIST'] && $this->_rootref['BIRTHDAY_LIST']) {  ?>

        	<div class="statspanel" style="background-image: url('<?php echo (isset($this->_rootref['T_THEME_PATH'])) ? $this->_rootref['T_THEME_PATH'] : ''; ?>/images/birthdays.png');">
            	<?php if ($this->_rootref['BIRTHDAY_LIST']) {  echo ((isset($this->_rootref['L_CONGRATULATIONS'])) ? $this->_rootref['L_CONGRATULATIONS'] : ((isset($user->lang['CONGRATULATIONS'])) ? $user->lang['CONGRATULATIONS'] : '{ CONGRATULATIONS }')); ?>: <strong><?php echo (isset($this->_rootref['BIRTHDAY_LIST'])) ? $this->_rootref['BIRTHDAY_LIST'] : ''; ?></strong><?php } else { echo ((isset($this->_rootref['L_NO_BIRTHDAYS'])) ? $this->_rootref['L_NO_BIRTHDAYS'] : ((isset($user->lang['NO_BIRTHDAYS'])) ? $user->lang['NO_BIRTHDAYS'] : '{ NO_BIRTHDAYS }')); } ?>

            </div>
        <?php } ?>

    </div>
</div>




<?php $this->_tpl_include('overall_footer.html'); ?>