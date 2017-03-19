<?php

class Stack
{
    private $items = [];

    /**
     * Toplu yığın atama
     *
     * @param array $array
     */
    public function load(array $array)
    {
        $this->items = array_merge($this->items, $array);
    }

    /**
     * Key'i verilen kaydı döndürür.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key = null, $default = null)
    {
        return $this->getArrayValue($this->items, $key, $default);
    }


    /**
     * Key'e değer atar.
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function set($key, $value)
    {
        return $this->setArrayValue($this->items, $key, $value);
    }

    public function extend($key, $value)
    {
        return $this->setArrayValue($this->items, $key, $value, true);
    }

    /**
     * Tüm yığını döndürür.
     *
     * @return mixed
     */
    public function all()
    {
        return $this->get();
    }


    /**
     * Belirtilen keyin varlığını kontrol eder.
     *
     * @param string $key
     * @return mixed
     */
    public function has($key)
    {
        return $this->getArrayValue($this->items, $key, false);
    }


    /**
     * Dizi içerisindeki değeri döndürür.
     * Dot Notation deniliyor "key.key.key" olayına.
     *
     * @param array $array
     * @param string $key Diziden çekilmek istenen key veya path (key.key.key).
     * @param null $default Bulunamaması durumunda varsayılan değer.
     * @return mixed
     */
    private function getArrayValue(array $array, $key, $default = null)
    {
        if (is_null($key)) {
            return $array;
        }

        if (isset($array[$key])) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $part) {
            if (isset($array[$part])) {
                $array = $array[$part];
            } else {
                return $default;
            }
        }

        return $array;
    }


    /**
     * Dizi içerisine değer atar.
     * Dot Notation deniliyor "key.key.key" olayına.
     *
     * @param array $array
     * @param string $key Diziye eklenmek istenen key veya path (key.key.key).
     * @param mixed $value Keye eklenmek istenen değer.
     * @param bool $extend Keye değerin ek olarak ekleneceğini belirtir. Key değeri array değilse dönüştürülür.
     * @return array
     */
    private function setArrayValue(array &$array, $key, $value, $extend = false)
    {
        if (is_null($key)) {
            return $array = $value;
        }

        foreach (explode('.', $key) as $part) {
            if (! isset($array[$part])) {
                $array[$part] = array();
            }

            $array =& $array[$part];
        }

        if ($extend === true) {
            if (! is_array($array)) {
                $array = [$array];
            }

            $array[] = $value;
        } else {
            $array = $value;
        }


        return $array;
    }

}