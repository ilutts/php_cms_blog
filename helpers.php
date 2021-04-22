<?php

/**
 * Поиск значений в массиве (в том числе и многомерном) по ключам переданым в строке
 * @param array $array Обычный или многомерный массив
 * @param string $key Ключ для поиска переданный в виде строки, элементы должны быть разделены точкой
 * @param default Значение которое вернёт функция при неудачном поиске
 * @return значение найденого элемента массива или значение параметра $default
 */

function array_get(array $array, string $key, $default = null)
{
    $keys = explode('.', $key);

    foreach ($keys as $key) {

        if (empty($array[$key])) {
            return $default;
        }

        $array = $array[$key];
    }

    return $array;
}

/**
 * Подключение частей шаблона сайта с возможность передачи в них доп. параметров
 * @param string $templateName Название файла шаблона
 * @param $data Данные для вывода в шаблоне
 * @return Часть заданого шаблона
 */

function includeView(string $templateName, $data = null)
{
    $file = $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . $templateName;

    if (file_exists($file)) {
        include $file;
    }
}

/**
 * Вывод шаблона страницы сайта с данными
 * @param string $fileMain адресс основной части страницы
 * @param array $data Массив данных для вывода в шаблоне
 * @return Страницу сайта
 */

function showTemplate(string $fileMain, array $data)
{
    includeView('templates/header.php', $data['header']);

    includeView($fileMain, $data['main']);

    includeView('templates/footer.php', $data['footer']);
}

/**
 * Функция проверки файлов на соотвествие типу
 * @param string $file Проверяемый файл
 * @param array $types Типы файлов
 * @return bool True - если соответсвует, False - Если нет
 */

function checkTypeFile(string $file, array $types): bool
{
    $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
    $detectedType = finfo_file($fileInfo, $file);

    finfo_close($fileInfo);

    return in_array($detectedType, $types);
}

/**
 * Определяем статус кнопки поганиции для добавление ссылки
 * @param int $page Номер страницы
 * @return string Пустая строка если страница активна
 */

function getStatusPage(int $page): string
{
    if ((!empty($_GET['page']) && (int)$_GET['page'] !== $page) || (empty($_GET['page']) && $page !== 1)) {
        return 'href="' . getQueryUrl('page', $page) . '"';
    }

    return '';
}

/**
 * Получение адреса ссылки
 * @param string $type Тип ссылки, к примеру 'page'
 * @param int $id Номер элемента
 * @return string Ссылка для перехода
 */

function getQueryUrl(string $type, int $id): string
{
    $urlPage = '?' . $type . '=';
    // Получаем строку запроса
    $urlQuery = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);

    if ($urlQuery) {

        if (!empty($_GET[$type])) {
            $arrayQuery = [];

            parse_str($urlQuery, $arrayQuery);

            $arrayQuery[$type] = $id;
            return '?' . http_build_query($arrayQuery);
        }
        $urlPage = '&' . $type . '=';
    }

    return $_SERVER['REQUEST_URI'] . $urlPage . $id;
}
