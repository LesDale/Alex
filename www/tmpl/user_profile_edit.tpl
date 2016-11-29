<div class="header">Профиль пользователя</div>
%message%
<div class="user_avatar">
    <img src="../avatar/%avatar%" alt="%login%">
</div>
<form class="user-info" method="post" action="functions.php" enctype="multipart/form-data">
    <p class="edav">Редактировать аватар</p><br>
    <p><input id="img" name="imgfile" type="file"><br>
    <div>
        <ul id="preview-photo"></ul>
    </div>
    <input id="img" name="load" value="Обновить аватар" type="submit">
    <input id="del_ava" name="delete_avatar" data-val="%avatar%" value="Удалить аватар" type="button"></p>
</form>
<form class="user-email_edit" method="post" action="functions.php" enctype="multipart/form-data">
    <p >Редактировать e-mail</p><br />
    <p><dl class="email_edit">
        <dt>Текущий адрес:</dt>
        <dd>%user_email%</dd>
    </dl></p>
    <div>
        <span>Новый адрес</span>
        <input name="new_email" id="email" maxlength="" type="text">
    </div>
    <input id="emailsub" name="email_submit" value="Изменить адрес" type="submit">
</form>
<form class="user-password_edit" method="post" action="functions.php" enctype="multipart/form-data">
    <p >Редактировать пароль</p><br />
    <div>
        <span>Старый пароль</span>
        <input name="old_password" id="password" class="i-p" maxlength="" type="password">
    </div>
    <div>
        <span>Новый пароль</span>
        <input name="new_password" id="password" class="i-p" maxlength="" type="password">
    </div>
    <div>
        <span>Повторите пароль</span>
        <input name="repeat_password" id="password" class="i-p" maxlength="" type="password">
    </div>
    <input id="passsub" name="password_submit" value="Изменить пароль" type="submit">
</form>

<script type="text/javascript">
    var previewWidth = 150, // ширина превью
            previewHeight = 150, // высота превью
            maxFileSize = 2 * 1024 * 1024, // (байт) Максимальный размер файла (2мб)
            selectedFiles = {},// объект, в котором будут храниться выбранные файлы
            queue = [],
            image = new Image(),
            imgLoadHandler,
            isProcessing = false,
            errorMsg, // сообщение об ошибке при валидации файла
            previewPhotoContainer = document.querySelector('#preview-photo'); // контейнер, в котором будут отображаться превью

    // Когда пользователь выбрал файлы, обрабатываем их
    $('input[type=file][id=img]').on('change', function() {
        var newFiles = $(this)[0].files; // массив с выбранными файлами

        for (var i = 0; i < newFiles.length; i++) {

            var file = newFiles[i];

            // В качестве "ключей" в объекте selectedFiles используем названия файлов
            // чтобы пользователь не мог добавлять один и тот же файл
            // Если файл с текущим названием уже существует в массиве, переходим к следующему файлу
            if (selectedFiles[file.name] != undefined) continue;

            // Валидация файлов (проверяем формат и размер)
            if ( errorMsg = validateFile(file) ) {
                alert(errorMsg);
                return;
            }

            // Добавляем файл в объект selectedFiles
            selectedFiles[file.name] = file;
            queue.push(file);

        }

        $(this).val('');
        processQueue(); // запускаем процесс создания миниатюр
    });

    // Валидация выбранного файла (формат, размер)
    var validateFile = function(file)
    {
        if ( !file.type.match(/image\/(jpeg|jpg|png|gif)/) ) {
            return 'Фотография должна быть в формате jpg, png или gif';
        }

        if ( file.size > maxFileSize ) {
            return 'Размер фотографии не должен превышать 2 Мб';
        }
    };

    var listen = function(element, event, fn) {
        return element.addEventListener(event, fn, false);
    };

    // Создание миниатюры
    var processQueue = function()
    {
        // Миниатюры будут создаваться поочередно
        // чтобы в один момент времени не происходило создание нескольких миниатюр
        // проверяем запущен ли процесс
        if (isProcessing) { return; }

        // Если файлы в очереди закончились, завершаем процесс
        if (queue.length == 0) {
            isProcessing = false;
            return;
        }

        isProcessing = true;

        var file = queue.pop(); // Берем один файл из очереди

        var li = document.createElement('LI');
        var span = document.createElement('SPAN');
        var spanDel = document.createElement('SPAN');
        var canvas = document.createElement('CANVAS');
        var ctx = canvas.getContext('2d');

        span.setAttribute('class', 'img');
        spanDel.setAttribute('class', 'delete');
        spanDel.innerHTML = 'Удалить';

        li.appendChild(span);
        li.appendChild(spanDel);
        li.setAttribute('data-id', file.name);

        image.removeEventListener('load', imgLoadHandler, false);

        // создаем миниатюру
        imgLoadHandler = function() {
            ctx.drawImage(image, 0, 0, previewWidth, previewHeight);
            URL.revokeObjectURL(image.src);
            span.appendChild(canvas);
            isProcessing = false;
            setTimeout(processQueue, 200); // запускаем процесс создания миниатюры для следующего изображения
        };

        // Выводим миниатюру в контейнере previewPhotoContainer
        previewPhotoContainer.appendChild(li);
        listen(image, 'load', imgLoadHandler);
        image.src = URL.createObjectURL(file);

        // Сохраняем содержимое оригинального файла в base64 в отдельном поле формы
        // чтобы при отправке формы файл был передан на сервер
        var fr = new FileReader();
        fr.readAsDataURL(file);
        fr.onload = (function (file) {
            return function (e) {
                $('#preview-photo').append(
                        '<input type="hidden" name="photos[]" value="' + e.target.result + '" data-id="' + file.name+ '">'
                );
            }
        }) (file);
    };

    // Удаление фотографии
    $(document).on('click', '#preview-photo li span.delete', function() {
        var fileId = $(this).parents('li').attr('data-id');

        if (selectedFiles[fileId] != undefined) delete selectedFiles[fileId]; // Удаляем файл из объекта selectedFiles
        $(this).parents('li').remove(); // Удаляем превью
        $('input[name^=photo][data-id="' + fileId + '"]').remove(); // Удаляем поле с содержимым файла
    });
//-------------------------------------------------------
    $("#del_ava").bind("click", function () {
        var an=$("#del_ava").data("val");
        $.get("/data.php?view=delete_avatar", {an}, function () {
            window.location.href = "/?view=user_profile_edit";
        })});
</script>