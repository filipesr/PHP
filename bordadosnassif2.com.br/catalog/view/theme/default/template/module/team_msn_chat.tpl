<script type="text/javascript" language="Javascript"><!-- 
    function openChat(account,lang){
       var  link = 'http://settings.messenger.live.com/Conversation/IMMe.aspx?invitee='+account+'&mkt='+lang;

       window.open(link,'','width=380,height=450,toolbar=0,location=0,status=0,menubar=0,scrollbars=0,resizable=0');  
    }  
--></script>
<div class="box">
    <div class="box-heading"><?php echo $heading_title; ?></div>
    <div class="box-content">
        <div >
            <ul
                style="
                padding:0px;
                margin:0px;
                padding-bottom: 12px;
                margin-left:10px;
                list-style:none;
                
                ">
                <?php foreach ($accounts as $account) { ?>
                    <li style="
                        padding: 3px 0px 4px 0px;
                        display: block;">
                        <a
                            style="font-size: 11px;"
                            href="javascript:openChat('<?php echo $account['address']; ?>','<?php echo $account['language']; ?>');">
                            <img 
                                style="
                                 display: block;
                                 border-style: none;
                                 margin-right: 8px;
                                 vertical-align:middle;
                                 float: left;" 
                                 src="http://messenger.services.live.com/users/<?php echo $account['address']; ?>/presenceimage?<?php echo $account['language']; ?>" width="17" height="17" />
                            <?php echo $account['name']; ?>
                        </a>
                    </li>
            <?php } ?>
             </ul>
        </div>
    </div>
</div>
