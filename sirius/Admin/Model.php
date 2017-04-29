<?php

namespace Sirius\Admin;

abstract class Model extends \CI_Model
{

    /**
     * Filtreleme koşullarını ekler
     *
     * @param null|string $table
     */
    protected function setFilter($table = null)
    {
        if ($table !== null) {
            $table = $table.'.';
        }

        if (isset($this->search)) {
            if (strlen($this->input->get('search')) > 0) {
                $where = array();

                foreach ($this->search as $column) {
                    if (strpos($column, '.') === false) {
                        $column = $table . $column;
                    }
                    $where[] = "$column LIKE '%" . $this->input->get('search') ."%'";
                }

                $this->db->where('('. implode(' OR ', $where) .')');
            }
        }

        if (isset($this->filter) && is_array($this->filter)) {
            foreach ($this->filter as $filter) {
                if (strlen($this->input->get($filter)) > 0) {
                    $value = $this->input->get($filter);

                    if ($value == 'true') {
                        $value = 1;
                    } elseif ($value == 'false') {
                        $value = 0;
                    }

                    if (strpos($filter, '.') === false) {
                        $filter = $table . $filter;
                    }

                    $this->db->where($filter, $value);
                }
            }
        }
    }


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
     * Post değerlerine göre slug oluşturur.
     *
     * @param string $slugInput
     * @param string $defaultInput
     * @return string
     */
    protected function makeSlug($slugInput = 'slug', $defaultInput = 'title')
    {
        return makeSlug($this->input->post($slugInput) ? $this->input->post($slugInput) : $this->input->post($defaultInput));
    }


    /**
     * Slug daha önceden kullanılmışsa id son eki eklenerek slug güncellenir.
     *
     * @param $table
     * @param $record
     * @param string $column
     * @return bool
     */
    protected function checkSlug($table, $record, $column = 'slug')
    {
        $count = $this->db
            ->from($table)
            ->where('language', $this->language)
            ->where($column, $record->slug)
            ->count_all_results();

        if ($count > 1) {
            $slug = $record->slug .'-'.$record->id;

            $this->db->where('id', $record->id)->update($table, array(
                $column => $slug
            ));

            if ($this->db->affected_rows() > 0) {
                $record->slug = $slug;
                return true;
            }
        }

        return false;
    }


    protected function makeLastOrder($table, $condition = array(), $column = 'order')
    {
        if ($condition) {
            $this->db->where($condition);
        }

        $order = 1;
        $lastOrder = $this->db
            ->from($table)
            ->where('language', $this->language)
            ->order_by($column, 'desc')
            ->limit(1)
            ->get()
            ->row();

        if ($lastOrder) {
            $order = $lastOrder->$column + 1;
        }

        return $order;
    }



    protected function setMeta(&$data, $language = false)
    {
        $metas = array(
            'metaTitle' => $this->input->post('metaTitle'),
            'metaDescription' => $this->input->post('metaDescription'),
            'metaKeywords' => $this->input->post('metaKeywords')
        );

        if ($language === true) {
            $metas['language'] = $this->language;
        }

        $data = array_merge($data, $metas);
    }


    protected function setMetaAndLang(&$data)
    {
        $data = $this->setMeta($data, true);
    }


    /**
     * Kayıt silme.
     *
     * @param string $table Tablo adı.
     * @param array|object $data Id'ler yada silinecek kayıt
     * @param bool|false $returnRecords İşlem başarılı olduğunda kayıtları döndür.
     * @return array|bool
     */
    protected function callDelete($table, $data, $returnRecords = false)
    {
        if (! is_array($data) && ! is_object($data)) {
            return false;
        }

        if (is_object($data)) {
            $data = array($data->id);
        }

        $records = array();

        if ($returnRecords === true) {
            $records = $this->db
                ->from($table)
                ->where_in('id', $data)
                ->get()
                ->result();
        }

        $success = $this->db
            ->where_in('id', $data)
            ->delete($table);

        if ($returnRecords === true && $success) {
            return $records;
        }

        return $success;
    }


    /**
     * Sıralama işlemleri.
     *
     * @param string $table
     * @param array $ids
     * @return bool|int
     */
    protected function callOrder($table, $ids)
    {
        if (! is_array($ids)) {
            return false;
        }

        $records = $this->db
            ->from($table)
            ->where_in('id', $ids)
            ->order_by('order', 'asc')
            ->get()
            ->result();

        $firstOrder = 1;
        $affected = 0;

        foreach ($records as $record) {
            if ($firstOrder === 0) {
                $firstOrder = $record->order;
            }

            $order = array_search($record->id, $ids) + $firstOrder;

            if ($record->order != $order) {
                $this->db
                    ->where('id', $record->id)
                    ->update($table, array('order' => $order));

                if ($this->db->affected_rows() > 0) {
                    $affected++;
                }
            }

        }

        return $affected;
    }


} 