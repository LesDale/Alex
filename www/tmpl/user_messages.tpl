<div class="header">Личные сообщения</div>
<div class="user_message_links">
    <ul id="usermess_menu">
        <li id="usercab_links">
            <a href="%address%?view=compose_message">Написать</a>
        </li>
        <li id="in_link" class="">
            <a href="javascript:void(0)">Входящие</a>
        </li>
        <li id="out_link" class="">
            <a href="javascript:void(0)">Отправленнные</a>
        </li>
    </ul>
</div>
<div class="user_messages">
    <div class="user_message_else">
        <span id="delete">Удалить</span>
    </div>
    <ul id="messages"></ul>
</div>
<script type="text/javascript">
    var view="in";
    $(document).ready(function() {
        $("#in_link").bind("click", function () {
            view="in";
            $("#in_link").attr("class", "active");
            $("#out_link").attr("class", "");
                    $.get("/data.php?view=user_in_messages", {}, function (in_messages) {
                        $("#messages").empty().html(in_messages);
                    })});
        $("#out_link").bind("click", function() {
            view="out";
            $("#out_link").attr("class", "active");
            $("#in_link").attr("class", "");
            $.get("/data.php?view=user_out_messages", {}, function (out_messages) {
                $("#messages").empty().html(out_messages);
        })});
        $("#in_link").click();

        $("#delete").click(function(){
            var ids = [];
            $(".check:checked").each( function(i, el){
                var id = $(el).data("value");
                ids.push(id);
            });
            if(view=="in"){
                $.get("/data.php?view=delete_received_messages", {messageids:ids}, function(){
                    window.location.href = "/?view=user_messages";
                });
            }
            else{
                $.get("/data.php?view=delete_send_messages", {messageids:ids}, function(){
                    window.location.href = "/?view=user_messages";
                });
            }
        });
    });
</script>