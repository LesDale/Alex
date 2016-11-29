<li class="usermessage_item" id="%message_id%">
    <div class="r_%read_flag%" id="notread">
    </div>
    <div>
        <input class="check" data-value="%message_id%" type="checkbox">
    </div>
    <div id="from_to_message">%name%</div>
    <div id="usermess_item">
        <a href="%link_message%">%subject%</a>
    </div>
    <div id="usmess_date">
        %date%
    </div>
    <div style="clear:both"></div>
</li>
<script type="text/javascript">
    $(document).ready(function() {
        $("div.r_1").html("<img src=\"../images/belarus.png\" alt=\"непрочитанное\" title=\"\" height=\"20\">");
        $("div.r_0").html("<img src=\"../images/bosnia_and_herzegovina.png\" alt=\"прочитанное\" title=\"\" height=\"20\">");
            });
</script>