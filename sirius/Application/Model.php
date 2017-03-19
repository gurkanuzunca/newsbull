<?php

namespace Sirius\Application;


abstract class Model extends \CI_Model
{
    /**
     * Sayfalama koşullarını ekler
     *
     * @param array $paginate
     */
    protected function setPaginate($paginate)
    {
        if (! empty($paginate['limit'])) {
            $this->db->limit($paginate['limit'], empty($paginate['offset']) ? 0 : $paginate['offset']);
        }
    }


    /**
     * Verilen kolon değerlerini göndürür.
     *
     * @param array $records
     * @param string $column
     * @return array
     */
    protected function getColumnData(array $records, $column)
    {
        $results = array();

        foreach ($records as $record) {
            $results[] = $record->$column;
        }

        return $results;
    }


    /**
     * Id değerlerini göndürür.
     *
     * @param array $records
     * @return array
     */
    protected function getIds(array $records)
    {
        return $this->getColumnData($records, 'id');
    }


    /**
     * Kayıtları verilen kolon değerine göre index'li array olarak göndürür.
     *
     * @param array $records
     * @param array $column
     */
    protected function setNamed(array &$records, $column)
    {
        $results = array();

        foreach ($records as $record) {
            $results[$record->$column] = $record;
        }

        $records = $results;
    }


    /**
     * Birebir ilişki tanımlamalarını yapar.
     * İlişki kurulacak kayıtlar daha önceden çekilmiş olmalıdır.
     * Sadece alanları eşleştirir sorgu işlemi yapmaz.
     *
     * @param string $variable Hangi değişken adı ile yazılacağı. Records kayıtlarına $variable değişleni ile yazılır. $item->$variable.
     * @param array $records İlişkili kaydın tanımlanacağı kayıtlar.
     * @param string $foreignKey Records kayıtlarındaki ilişkilenecek kolon adı.
     * @param array $relatedRecords Records kayıtlarına ilişkilenecek kayıtlar.
     * @param string $localKey İlişkilenecek kayıtlardaki kolon ismi. $record->$foreignKey = $relatedRecord->$localKey
     * @return void
     */
    protected function setRelation($variable, array &$records, $foreignKey, array $relatedRecords, $localKey)
    {
        $this->setNamed($relatedRecords, $localKey);

        foreach ($records as $record) {
            if (isset($relatedRecords[$record->$foreignKey])) {
                $record->$variable = $relatedRecords[$record->$foreignKey];
            }
        }
    }


    /**
     * Birebir ilişki tanımlamalarını yapar.
     * İlişki kurulacak kayıtlar daha önceden çekilmiş olmalıdır.
     * Sadece alanları eşleştirir sorgu işlemi yapmaz.
     *
     * @param string $variable Hangi değişken adı ile yazılacağı. Records kayıtlarına $variable değişleni ile yazılır. $item->$variable.
     * @param array $records İlişkili kaydın tanımlanacağı kayıtlar.
     * @param string $foreignKey Records kayıtlarındaki ilişkilenecek kolon adı.
     * @param array $relatedRecords Records kayıtlarına ilişkilenecek kayıtlar.
     * @param string $localKey İlişkilenecek kayıtlardaki kolon ismi. $record->$foreignKey = $relatedRecord->$localKey
     * @return void
     */
    protected function setRelationOne($variable, array &$records, $foreignKey, array $relatedRecords, $localKey)
    {
        $this->setRelation($variable, $records, $foreignKey, $relatedRecords, $localKey);
    }
} 