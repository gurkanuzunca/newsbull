<?php

/**
 * Link yapıcı.
 *
 * @return string
 */
function makeUri()
{
    $arguments = func_get_args();
    $params = array_slice($arguments, -1);
    $params = $params[0];

    $query = null;
    $saveQuery = false;

    if (is_array($params)) {
        array_pop($arguments);

        if (isset($params['query'])) {
            $query = $params['query'];
        }

        if (isset($params['saveQuery']) && $params['saveQuery'] === true) {
            $saveQuery = true;
        }
    }

    if (is_array($arguments)) {
        $arguments = implode('/', $arguments);
    }


    if (is_array($query)) {
        $gets = http_build_query($saveQuery ? array_merge($_GET, $query) : $query);
    } elseif ($saveQuery) {
        $gets = http_build_query($_GET);
    }



    return $arguments . (! empty($gets) ? '?'.$gets : '');
}



function moduleUri()
{
    $arguments = func_get_args();

    if (isset(get_instance()->module)) {
        array_unshift($arguments, 'admin', get_instance()->module);
    }

    return call_user_func_array('makeUri', $arguments);

}

/**
 * Modül yapısına göre link yapıcı.
 *
 * @param array|string $segments Uri parametreleri
 * @param null|array|string $query Querystring parametreleri
 * @param bool|false $saveQuery Önceki querystring'leri korur
 * @return string
 */
function clink($segments, $query = null, $saveQuery = false)
{
    if (! is_array($segments) && strpos($segments, "http") === 0 ) {
        return $segments;
    }

    if (! is_array($segments)) {
        $segments = explode('/', $segments);
    }

    if (get_instance()->config->item('language') != 'tr') {
        array_unshift($segments, get_instance()->language);
    }

    $segments = implode('/', array_map('reservedUri', $segments));

    return makeUri($segments, array('query' => $query, 'saveQuery' => $saveQuery));
}


/**
 * Rezerve edilmiş modül url'lerini dile göre karşılığını verir.
 *
 * @param $uri
 * @return mixed
 */
function reservedUri($uri)
{
    static $uriParam = array();

    if (empty ($uriParam)) {
        $uriList = get_instance()->config->item(get_instance()->language, 'reservedUri');
        $uriParam['keys'] = array();
        $uriParam['values'] = array();

        if ($uriList) {
            $uriParam['keys'] = array_keys($uriList);
            $uriParam['values'] = array_values($uriList);
        }
    }

    return str_replace($uriParam['keys'], $uriParam['values'], $uri);
}


function prepareForSelect($array, $key, $value, $prepend = null)
{
    if (! is_null($prepend)) {
        $result = ! is_array($prepend) ? array('' => $prepend) : $prepend;
    } else {
        $result = array();
    }

    foreach ($array as $item) {
        $result[$item->$key] = $item->$value;
    }

    return $result;
}


/**
 * @param $file
 * @param string $path
 * @param int $width
 * @param null $height
 * @param string $text
 * @return string
 */
function getImage($file, $path = '', $width = 480, $height = null, $text = '?')
{
    $fullpath = 'public/upload/'. (empty($path) ? $path : "$path/") . $file;

    if (is_file($fullpath)) {
        return $fullpath;
    }

    if (empty($height)) {
        $height = $width;
    }

    return 'http://fakeimg.pl/'. $width .'x'. $height .'/?text='. $text;
}


/**
 * Para formatlama kuruşları 2 hane olarak yuvarlar.
 *
 * @param $number
 * @param bool $fractional
 * @return mixed|string
 */
function money($number, $fractional = false)
{
    if ($fractional){
        $number = sprintf('%.2f', $number);
    }
    while (true){
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
        if ($replaced != $number) {
            $number = $replaced;
        } else {
            break;
        }
    }
    return $number;
}



function lang($line, $convert = null)
{
    $slug = (! is_null($convert) ? $convert.'-':'') . makeSlug($line);
    $trans = get_instance()->lang->line($slug);

    if (empty($trans)) {
        $trans = (! is_null($convert) ? strConvert($line, $convert, get_instance()->language) : $line);
        $filepath = APPPATH .'/language/'. get_instance()->language .'/application_lang.php';
        $file = fopen($filepath, FOPEN_WRITE_CREATE);
        $data = '$lang[\''. $slug .'\'] = \''. $trans .'\';'. PHP_EOL;

        flock($file, LOCK_EX);
        fwrite($file, $data);
        flock($file, LOCK_UN);
        fclose($file);

        return $trans;
    }

    return $trans;
}


/**
 * Özel karakterleri dönüştürüp temizler.
 *
 * @param $str
 * @return mixed|string
 */
function makeSlug($str)
{
    get_instance()->load->library('slugify');

    return get_instance()->slugify->make($str);
}


function strConvert($string, $to = null, $lang = 'tr')
{
    switch ($to) {
        case 'upper':
            $string = mb_strtoupper($lang === 'tr' ? str_replace('i', 'İ', $string) : $string, 'UTF-8');
            break;
        case 'lower':
            $string = mb_strtolower($lang === 'tr' ? str_replace('i', 'İ', $string) : $string, 'UTF-8');
            break;
        case 'ucwords':
            $string = ltrim(mb_convert_case($lang === 'tr' ? str_replace(array( ' I', ' ı', ' İ', ' i' ), array( ' I', ' I', ' İ', ' İ' ), ' '.$string) : $string, MB_CASE_TITLE, 'UTF-8'));
            break;
        case 'ucfirst':
            $first = mb_substr($string, 0, 1, 'UTF-8');
            $string = mb_strtoupper($lang === 'tr' ? str_replace('i', 'İ', $first) : $first, 'UTF-8') . mb_substr($string, 1, mb_strlen($string, 'UTF-8') - 1, 'UTF-8');
            break;
    }

    return $string;
}

/**
 * Tarih sınıfı helper.
 *
 * @param string $datetime Tarih formatı Date sınıfına uygun.
 * @return mixed Date
 */
function makeDate($datetime)
{
    return get_instance()->date->set($datetime);
}
