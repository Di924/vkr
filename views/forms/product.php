<?php
$db = getDbInstance();
$select = array('id', 'name');
$category_id = $GLOBALS['edit'] ? $GLOBALS['products']['category_id'] : filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
if ($category_id) {
    $category = $db->where('id', $category_id)->getOne('categories');
    if ($category) {
        $db->where('mark_id', $category['mark_id']);
    }
}
$rows = $db->arraybuilder()->get('categories');
if (!$category_id) {
    $marks = $db->arraybuilder()->get('marks');
    // map names marks to categories names
    $rows = array_map(function ($row) use ($marks) {
        $mark = array_filter($marks, function ($mark) use ($row) {
            return $mark['id'] === $row['mark_id'];
        });
        $row['name'] = $row['name'] . ' (' . array_values($mark)[0]['name'] . ')';
        return $row;
    }, $rows);
}
?>
<fieldset>
    <div class="form-group">
        <label for="name">Название</label>
        <input type="text" name="name" value="<?= htmlspecialchars($GLOBALS['edit'] ? $GLOBALS['products']['name'] : '', ENT_QUOTES, 'UTF-8'); ?>" class="form-control" id="name">
    </div>
    <div class="form-group">
        <label for="slug">Категория</label>

        <select name="category_id" class="form-control" id="category">
            <?php foreach ($rows as $row) : ?>
                <option value="<?= $row['id'] ?>" <?= ($GLOBALS['edit'] && $GLOBALS['products']['category_id'] === $row['id']) ? 'selected' : '' ?>><?= $row['name'] ?></option>
            <? endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="slug">Slug</label>
        <input type="text" name="slug" value="<?= htmlspecialchars($GLOBALS['edit'] ? $GLOBALS['products']['slug'] : '', ENT_QUOTES, 'UTF-8'); ?>" class="form-control" id="slug">
    </div>

    <div class="form-group">
        <label for="sort">Сортировка</label>
        <input oninput="cutIfMoreThan(this, 11);" type="number" value="<?= htmlspecialchars($GLOBALS['edit'] ? $GLOBALS['products']['sort'] : '', ENT_QUOTES, 'UTF-8'); ?>" class="form-control" id="sort">
    </div>

    <div class="form-group">
        <label for="mass_netto">Масса нетто</label>
        <input type="text" value="<?= htmlspecialchars($GLOBALS['edit'] ? $GLOBALS['products']['mass_netto'] : '', ENT_QUOTES, 'UTF-8'); ?>" class="form-control" id="mass_netto">
    </div>

    <div class="form-group">
        <label for="srok_godnosti">Срок годности</label>
        <input type="text" value="<?= htmlspecialchars($GLOBALS['edit'] ? $GLOBALS['products']['srok_godnosti'] : '', ENT_QUOTES, 'UTF-8'); ?>" class="form-control" id="srok_godnosti">
    </div>

    <div class="form-group">
        <label for="slug">Количество в упаковке</label>
        <input type="number" value="<?= htmlspecialchars($GLOBALS['edit'] ? $GLOBALS['products']['count_product_in_ypakovka'] : '', ENT_QUOTES, 'UTF-8'); ?>" class="form-control" id="count_product_in_ypakovka">
    </div>

    <div class="form-group">
        <label for="slug">Штрихкод</label>
        <input type="text" oninput="cutIfMoreThan(this, 50);" value="<?= htmlspecialchars($GLOBALS['edit'] ? $GLOBALS['products']['shtrihcode_product'] : '', ENT_QUOTES, 'UTF-8'); ?>" class="form-control" id="shtrihcode_product">
    </div>

    <div class="form-group">
        <label for="mass_dolya_shira">Массовая доля жира</label>
        <textarea name="mass_dolya_shira" oninput="cutIfMoreThan(this, 10);" class="form-control" id="mass_dolya_shira"><?= htmlspecialchars(($GLOBALS['edit']) ? $GLOBALS['products']['mass_dolya_shira'] : '', ENT_QUOTES, 'UTF-8') ?></textarea>
    </div>
    <div class="form-group">
        <label for="image">Image</label>
        <input name="image" class="form-control" id="image" value="<?= htmlspecialchars(($GLOBALS['edit']) ? $GLOBALS['products']['image'] : '', ENT_QUOTES, 'UTF-8'); ?>"></input>
    </div>

    <div class="form-group">
        <label for="description">Описание</label>
        <textarea name="description" class="form-control" id="description" rows="6"><?php echo htmlspecialchars(($GLOBALS['edit']) ? $GLOBALS['products']['description'] : '', ENT_QUOTES, 'UTF-8'); ?></textarea>
    </div>

    <div class="form-group text-center">
        <label></label>
        <button type="submit" class="btn btn-warning">Save <span class="glyphicon glyphicon-send"></span></button>
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
            'а': 'a',
            'б': 'b',
            'в': 'v',
            'г': 'g',
            'д': 'd',
            'е': 'e',
            'ё': 'yo',
            'ж': 'zh',
            'з': 'z',
            'и': 'i',
            'й': 'j',
            'к': 'k',
            'л': 'l',
            'м': 'm',
            'н': 'n',
            'о': 'o',
            'п': 'p',
            'р': 'r',
            'с': 's',
            'т': 't',
            'у': 'u',
            'ф': 'f',
            'х': 'h',
            'ц': 'c',
            'ч': 'ch',
            'ш': 'sh',
            'щ': 'sсh',
            'ъ': '',
            'ы': 'y',
            'ь': '',
            'э': 'e',
            'ю': 'yu',
            'я': 'ya'
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

    function cutIfMoreThan(elem, max) {
        let str = elem.value;
        if (str.length > max) {
            elem.value = str.substring(0, max);
        }
    }
</script>

<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#mass_dolya_shira' ) )
        .catch( error => {
            console.error( error );
        } );
        
    ClassicEditor
    .create( document.querySelector( '#description' ) )
    .catch( error => {
        console.error( error );
    } );
</script>