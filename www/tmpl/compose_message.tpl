<div class="message_compose">%message_compose%</div>
<div class="header">Отправить личное сообщение</div>
<form name="myform" action="functions.php" method="post">
    <table>
        <tr>
            <td>Кому:</td>
            <td>
                <input type="text" name="to" value="" />
            </td>
        </tr>
        <tr>
            <td>Тема:</td>
            <td>
                <input type="text" name="subject" value=""/>
            </td>
        </tr>
        <tr>
            <td>Сообщение:</td>
            <td>
                <textarea name="message" cols="100" rows="20"></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <div id="auth">
                    <input type="submit" name="send" value="Отправить"/>
                </div>
            </td>
        </tr>
    </table>
</form>
    <p id="ussearch">Найти пользователя:</p>

    <div id="sashasearch">
        <input type="submit" name="user_search" value="Найти"/>
    </div>
<div id="sashasearchinput">
    <input type="text" name="search_user" value="" />
</div>
<div id="messages"></div>

<script type="text/javascript">
    $(document).ready(function() {
        var login="";
        $("div#sashasearch").bind("click", function () {
            login = $("input:last").val();
            $.get("/data.php?view=user_search", {fuck:login}, function (out_messages) {
                $("#messages").empty().html(out_messages);
            });
        });
    });
</script>