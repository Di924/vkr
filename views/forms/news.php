<fieldset>
    <div class="form-group">
        <label for="name">Название новости</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($GLOBALS['edit'] ? $GLOBALS['news']['name'] : '', ENT_QUOTES, 'UTF-8'); ?>" class="form-control" id = "name" >
    </div> 

    <div class="form-group">
        <label for="slug">Название новости на латинице</label>
        <input type="text" name="slug" value="<?php echo htmlspecialchars($GLOBALS['edit'] ? $GLOBALS['news']['slug'] : '', ENT_QUOTES, 'UTF-8'); ?>" class="form-control" id="slug">
    </div> 

    <div class="form-group">
        <label for="content">Содержимое</label><div class="editor">
        <textarea name="content" class="form-control" id="content"><?php echo htmlspecialchars(($GLOBALS['edit']) ? ($GLOBALS['news']['content']?$GLOBALS['news']['content']:'') : '', ENT_QUOTES, 'UTF-8'); ?></textarea></div>
    </div> 

    <div class="form-group">
        <label for="image">Файл <?php echo $GLOBALS['edit'] ? '(выберите чтобы отредактировать)' : '' ?></label>
        <input
            type="file"
            name="image"
            class="form-control"
            accept="image/*"
            id="image"
        />
    </div>

    <div class="form-group text-center">
        <label></label>
        <button type="submit" class="btn btn-warning" >Сохранить<span class="glyphicon glyphicon-send"></span></button>
    </div>       
</fieldset>
<script>
            // Получаем ссылки на элементы полей ввода
    const inputField = document.getElementById('name');
    const slugField = document.getElementById('slug');

            // Добавляем слушатель события на поле ввода
    inputField.addEventListener('input', function() {
            // Получаем значение из поля ввода
    const inputValue = inputField.value;

             // Создаем slug из значения
    const slugValue = createSlug(inputValue);

            // Помещаем slug в другое поле
    slugField.value = slugValue;
            });

// Функция для создания slug из строки
    function createSlug(str) {
        const translit = {
            'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'yo',
            'ж': 'zh', 'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm',
            'н': 'n', 'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u',
            'ф': 'f', 'х': 'h', 'ц': 'c', 'ч': 'ch', 'ш': 'sh', 'щ': 'sсh', 'ъ': '',
            'ы': 'y', 'ь': '', 'э': 'e', 'ю': 'yu', 'я': 'ya'
        };
        str = str.toLowerCase().trim();
        str = str.replace(/./g, function(char) {
            return translit[char] || char;
        });
     // Преобразуем строку в нижний регистр и удаляем пробелы в начале и конце
        str = str.replace(/[^\w\s-]/g, ''); // Удаляем все символы, кроме букв, цифр, пробелов и дефисов
        str = str.replace(/\s+/g, '-'); // Заменяем пробелы на дефисы
        return str;
    }
       
</script>

<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#content' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
