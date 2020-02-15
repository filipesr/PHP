<?php if (!defined('IN_PHPBB')) exit; ?></div>
    
</div><!-- /contentpadding -->



</div><!-- /wrap -->

<div style="clear: both;"></div>

<div class="footer" style='width: <?php echo (isset($this->_tpldata['DEFINE']['.']['ABSOLUTION_BOARD_WIDTH'])) ? $this->_tpldata['DEFINE']['.']['ABSOLUTION_BOARD_WIDTH'] : ''; ?>;'>
	<!-- Please do not remove the following credit line. This style is free, and attribution such as this helps to keep it in development. Thanks -->
         &copy; Absolution design by Christian Bullock. Powered by phpBB. Traduzido por Suporte phpBB
  <!-- Please do not remove the above credit line. This style is free, and attribution such as this helps to keep it in development. Thanks -->
    <br> Forum administrado por <a href="http://www.hostcia.net" target="_blank">Hosting & CIA</a>  <?php if ($this->_rootref['DEBUG_OUTPUT']) {  ?><br /><?php echo (isset($this->_rootref['DEBUG_OUTPUT'])) ? $this->_rootref['DEBUG_OUTPUT'] : ''; } if ($this->_rootref['U_ACP']) {  ?><br /><strong><a href="<?php echo (isset($this->_rootref['U_ACP'])) ? $this->_rootref['U_ACP'] : ''; ?>"><?php echo ((isset($this->_rootref['L_ACP'])) ? $this->_rootref['L_ACP'] : ((isset($user->lang['ACP'])) ? $user->lang['ACP'] : '{ ACP }')); ?></a></strong><?php } ?>

</div>


</div><!-- /noise -->

    <script type='text/javascript'>
    // <![CDATA[
       $(function() {
          $('.tip').tipsy({fade: true, gravity: 's'});
       });
    // ]]>
    </script>
<div>
	<a id="bottom" name="bottom" accesskey="z"></a>
	<?php if (! $this->_rootref['S_IS_BOT']) {  echo (isset($this->_rootref['RUN_CRON_TASK'])) ? $this->_rootref['RUN_CRON_TASK'] : ''; } ?>

</div>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-786044-14']);
  _gaq.push(['_setDomainName', 'airsoft-es.com.br']);
  _gaq.push(['_setAllowLinker', true]);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>