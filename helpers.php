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
 * @param $data Дополнительные параметры для шаблона
 * @return Часть заданого шаблона
 */

function includeView(string $templateName, $data = null)
{
    $file = $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . $templateName;
    
    if (file_exists($file)) {  
        include $file;
    }

}