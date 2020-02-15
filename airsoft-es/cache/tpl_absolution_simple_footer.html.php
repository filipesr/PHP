<?php if (!defined('IN_PHPBB')) exit; ?></div>

	<div class="copyright" style="color: #FFFFFF;">Powered by <a href="http://www.phpbb.com/">phpBB</a>&reg; Forum Software &copy; phpBB Group
    <br />&copy; Absolution Style by <a href="http://www.christianbullock.com">Christian Bullock</a>
		<?php if ($this->_rootref['TRANSLATION_INFO']) {  ?><br /><?php echo (isset($this->_rootref['TRANSLATION_INFO'])) ? $this->_rootref['TRANSLATION_INFO'] : ''; } if ($this->_rootref['DEBUG_OUTPUT']) {  ?><br /><?php echo (isset($this->_rootref['DEBUG_OUTPUT'])) ? $this->_rootref['DEBUG_OUTPUT'] : ''; } ?>

	</div>
</div>

</body>
</html>