<?php

namespace Models;

use Sirius\Application\Model;

abstract class BaseModel extends Model
{
    /**
     * Kayıt bulma
     *
     * @param $value
     * @param string $column
     * @return object
     */
    abstract public function find($value, $column = 'id');

    /**
     * Kayıtları bulma
     *
     * @param array $values
     * @param string $column
     * @return array
     */
    abstract public function findIn(array $values, $column = 'id');

    /**
     * Tüm kayıtları döndürür.
     *
     * @param array $paginate
     * @return array
     */
    abstract public function all($paginate = []);

    /**
     * Toplam kayıt sayısı.
     *
     * @return int
     */
    abstract public function count();

}