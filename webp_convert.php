<?

/*

	в .htaccess дописать если редирект файлов возможен
	RewriteCond %{REQUEST_URI} ^(.+)\.(jpe?g|png)$ [NC]
	RewriteRule ^(.+)\.(jpe?g|png)$ /webp_convert.php?file=$1.$2 [R=301,L]

	если не возможен, и дописать в шаблонах окончание файлам .webp
	RewriteCond %{REQUEST_URI} ^(.+)\.(jpe?g|png)\.webp$ [NC]
	RewriteRule ^(.+)\.(jpe?g|png)\.webp$ /webp_convert.php?file=$1.$2 [R=301,L]


	НАСТРОЙКА
*/

define("CONVERT_JPEG", true); // включаем конвертацию JPEG
define("CONVERT_PNG", true); // включаем конвертацию PNG


if (

    strpos($_SERVER["HTTP_ACCEPT"], "image/webp") !== false                            // Браузер поддерживает формат WEBP
    && file_exists($_SERVER["DOCUMENT_ROOT"] . "/cache/" . $_GET["file"] . ".webp")    // WEBP ФАЙЛ есть в кеше

) {

    $file = $_SERVER["DOCUMENT_ROOT"] . "/cache/" . $_GET["file"] . ".webp";
    $type = "image/webp";

} elseif (

    strpos($_SERVER["HTTP_ACCEPT"], "image/webp") !== false                            // Браузер поддерживает формат WEBP
    && !file_exists($_SERVER["DOCUMENT_ROOT"] . "/cache/" . $_GET["file"] . ".webp")    // WEBP ФАЙЛА нет в кеше
    && webp_convert($_GET["file"]) === true                                            // На хостинге есть поддержка WEBP для конвертации

) {

    $file = $_SERVER["DOCUMENT_ROOT"] . "/cache/" . $_GET["file"] . ".webp";
    $type = "image/webp";

} else {                                                                                // Все остальные случаи выводим оригинал файла

    $file = $_SERVER["DOCUMENT_ROOT"] . "/" . $_GET["file"];
    $type = mime_content_type($file);

}

// Собственно вывод файла
header('Content-Type: ' . $type);
header('Content-Length: ' . filesize($file));
readfile($file);
exit();

####################################
####################################
####################################


function webp_convert($file)
{

    if (function_exists("imagewebp")) {

        // путь до файла
        $path = explode("/", $file);
        unset($path[count($path) - 1]);

        // Определяем тип файла
        $mime_type = mime_content_type($_SERVER["DOCUMENT_ROOT"] . '/' . $file);

        // Загружаем файл
        $im = false;

        if ($mime_type == "image/png" && CONVERT_PNG === true)
            $im = imagecreatefrompng($_SERVER["DOCUMENT_ROOT"] . '/' . $file);

        if ($mime_type == "image/jpeg" && CONVERT_JPEG === true)
            $im = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"] . '/' . $file);
        header('DEBUG: ' . $_SERVER["DOCUMENT_ROOT"] . '/' . $file);

        if ($im) {

            // Создаем папки если их нет
            $cache_dir = $_SERVER["DOCUMENT_ROOT"] . '/cache/';
            foreach ($path as $dir) {

                if (!is_dir($cache_dir . $dir . '/')) {

                    mkdir($cache_dir . $dir, 0777);

                }

                $cache_dir .= $dir . '/';

            }

            // Сохраняем файл
            $file_cache = $_SERVER["DOCUMENT_ROOT"] . '/cache/' . $file . '.webp';
            $save = imagewebp($im, $file_cache, 80);
            if (filesize($file_cache) % 2 == 1) {
                file_put_contents($file_cache, "\0", FILE_APPEND);
            }
            if ($save && filesize($file_cache) > 0) {

                return true; // все удачно

            } else {
                // echo "WEBP файл не создан или битый";
                // die();
                return false;
            } // WEBP файл не создан или битый

        } else {
            // echo "Изображение не загрузили";
            // die();
            return false;
        } // Изображение не загрузили

    } else {
        return false;
    } // Нет поддержки функции imagewebp
}
