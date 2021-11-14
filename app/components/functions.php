<?php
// Форма для обновления фото
function FormLoadFoto($login) {
    return 
    '<style>body {overflow: hidden;} .update_foto {display: block;}</style>
    <div class="update_foto">
        <div class="update_foto_wrapper">
            <form method="POST" name="add_product" enctype="multipart/form-data">
                <input type="file" name="file" required><br>
                <button name="update_foto">Загрузить</button>
                <a href="/profile/'.$login.'">Отмена</a>
            </form>
        </div>
    </div>';
}

// Загрузчик фото (Возвращает ссылку на фотографию)
function LoadFoto($link) {
    $folder = $_SERVER['DOCUMENT_ROOT'].'/public/images/'.$link;    // Папка загрузки
    if (!file_exists($folder)) {                                    // Если нет папки загрузки
        mkdir($_SERVER['DOCUMENT_ROOT'].'/public/images/'.$link);   // Создаётся папка загрузки
    }
    $listFiles = scandir($folder);
    $path = $_FILES['file']['tmp_name'];
    $fileInfo = pathinfo($_FILES['file']['name']);
    return transliteration($fileInfo['filename'], $fileInfo['extension'], $listFiles, $path, $folder);
}
        
// Транслитерация имени загружаемого фото
function transliteration($name, $extension, $listFiles, $path, $folder) {
    $newName = '';
    $arr = ['а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'yo','ж'=>'j','з'=>'z','и'=>'i','й'=>'i','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'sch','ъ'=>'','ы'=>'i','ь'=>'`','э'=>'e','ю'=>'u','я'=>'ya', 'А'=>'A','Б'=>'B','В'=>'V','Г'=>'G','Д'=>'D','Е'=>'E','Ё'=>'YO','Ж'=>'J','З'=>'Z','И'=>'I','Й'=>'I','К'=>'K','Л'=>'L','М'=>'M','Н'=>'N','О'=>'O','П'=>'P','Р'=>'R','С'=>'S','Т'=>'T','У'=>'U','Ф'=>'F','Х'=>'H','Ц'=>'C','Ч'=>'CH','Ш'=>'SH','Щ'=>'SCH','Ъ'=>'','Ы'=>'I','Ь'=>'`','Э'=>'E','Ю'=>'U','Я'=>'YA', 'a' => 'a', 'b' => 'b', 'c' => 'c', 'd' => 'd', 'e' => 'e', 'f' => 'f', 'g' => 'g', 'h' => 'h', 'i' => 'i', 'j' => 'j', 'k' => 'k', 'l' => 'l', 'm' => 'm', 'n' => 'n', 'o' => 'o', 'p' => 'p', 'q' => 'q', 'r' => 'r', 's' => 's', 't' => 't', 'u' => 'u', 'v' => 'v', 'w' => 'w', 'x' => 'x', 'y' => 'y', 'z' => 'z', 'A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F', 'G' => 'G', 'H' => 'H', 'I' => 'I', 'J' => 'J', 'K' => 'K', 'L' => 'L', 'M' => 'M', 'N' => 'N', 'O' => 'O', 'P' => 'P', 'Q' => 'Q', 'R' => 'R', 'S' => 'S', 'T' => 'T', 'U' => 'U', 'V' => 'V', 'W' => 'W', 'X' => 'X', 'Y' => 'Y', 'Z' => 'Z', '-' => '-', '_' => '_', '0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9'];
    $arStr = preg_split('//u', $name);

    foreach($arStr as $letter) {
        if ($letter == '') continue;
        if (!isset($newName)) $newName = $arr[$letter];
        else if (isset($newName)) $newName .= $arr[$letter];
    }
            
    $findFiles = preg_grep("/^".$newName."(.+)?\.".$extension."$/", $listFiles);
                
    $filename = $newName.(count( $findFiles) > 0 ? '_' .(count( $findFiles) + 1) : '').'.'.$extension;
    move_uploaded_file($path, $folder . '/' . $filename);

    return $filename;
}


// Форма для удаления товара
function FormDeleteProduct($login, $product) {
    return '
    <style>body {overflow: hidden;} .delete_product {display: block;}</style>
    <div class="delete_product">
        <div class="delete_product_wrapper">
            <form method="POST">
                <p>Удалить товар?</p>
                <button name="delete_product_yes" value="'.$product.'">Удалить</button>
                <a href="/profile/'.$login.'">Отмена</a>
            </form>
        </div>
    </div>';
}


// Форма для удаления комментария
function FormDeleteComment($login, $comment) {
    return '
    <style>body {overflow: hidden;} .delete_field {display: block;}</style>
    <div class="delete_field">
        <div class="delete_field_wrapper">
            <form method="POST">
                <p>Удалить комментарий?</p>
                <button name="delete_comment_yes" value="'.$comment.'">Удалить</button>
                <a href="/profile/'.$login.'">Отмена</a>
            </form>
        </div>
    </div>';
}