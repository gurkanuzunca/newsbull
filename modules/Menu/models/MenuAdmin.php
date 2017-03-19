<?php

use Models\AdminModel;

class MenuAdmin extends AdminModel
{
    /**
     * Değişken modelde tanımlanacak.
     * @var string
     */
    protected $table = 'menus';

    public function find($id)
    {
        return $this->db
            ->from($this->table)
            ->where('id', $id)
            ->where('language', $this->language)
            ->get()
            ->row();
    }


    public function all($paginate = [])
    {
        $this->setFilter();
        $this->setPaginate($paginate);

        return $this->db
            ->select("{$this->table}.*, (SELECT COUNT(id) FROM {$this->table} child WHERE child.parentId = {$this->table}.id) childs", false)
            ->from($this->table)
            ->where('parentId IS NULL')
            ->where('language', $this->language)
            ->order_by('order', 'asc')
            ->order_by('id', 'asc')
            ->get()
            ->result();
    }


    public function count()
    {
        $this->setFilter();

        return $this->db
            ->from($this->table)
            ->where('parentId IS NULL')
            ->where('language', $this->language)
            ->count_all_results();
    }


    public function childAll($parent, $paginate = [])
    {
        $this->setFilter();
        $this->setPaginate($paginate);

        return $this->db
            ->select("{$this->table}.*, (SELECT COUNT(id) FROM {$this->table} child WHERE child.parentId = {$this->table}.id) childs", false)
            ->from($this->table)
            ->where('parentId', $parent->id)
            ->where('language', $this->language)
            ->order_by('order', 'asc')
            ->order_by('id', 'asc')
            ->get()
            ->result();
    }


    public function childCount($parent)
    {
        $this->setFilter();

        return $this->db
            ->from($this->table)
            ->where('parentId', $parent->id)
            ->where('language', $this->language)
            ->count_all_results();
    }


    public function module($name) {
        return $this->db
            ->from('modules')
            ->where('name', $name)
            ->get()
            ->row();
    }


    public function moduleAll()
    {
        return $this->db
            ->from('modules')
            ->where('type', 'public')
            ->order_by('id', 'asc')
            ->get()
            ->result();
    }


    public function moduleLinks($module)
    {
        $return = array();
        $pattern = $module->menuPattern = unserialize($module->menuPattern);

        if (isset($pattern['where'])) {
            $this->db->where($pattern['where']);
        }

        if (isset($pattern['language']) && $pattern['language'] === true) {
            $this->db->where('language', $this->language);
        }

        if (isset($pattern['moduleLink'])) {
            $return[] = (object) array(
                'id' => '',
                'module' => $module->name,
                'title' => $module->title,
                'hint' => $module->title,
                'link' => '@'.$module->name,
            );
        }

        if (isset($pattern['link']) && isset($pattern['title']) && isset($pattern['hint'])) {
            $results = $this->db
                ->from($pattern['table'])
                ->order_by('id', 'asc')
                ->get()
                ->result();

            foreach ($results as $result) {
                $link = array();
                foreach ($pattern['link'] as $column){
                    $link[] = $result->$column;
                }

                $return[] = (object) array(
                    'id' => $result->id,
                    'module' => $module->name,
                    'title' => $result->{$pattern['title']},
                    'hint' => $result->{$pattern['hint']},
                    'link' => '@'.$module->name .'/'. implode('/', $link),
                );
            }
        }

        return $return;
    }


    public function moduleLinkRecord($name, $id)
    {
        $module = $this->module($name);

        if ($module) {
            if ($id !== 'false') {
                $module->record = $this->db
                    ->from($module->table)
                    ->where('id', $id)
                    ->get()
                    ->row();
            }
        }

        return $module;
    }


    public function insert($parent, $data)
    {
        $order = $this->makeLastOrder($this->table, array('parentId' => $parent->id));
        $this->db->insert($this->table, array(
            'parentId' => $parent->id,
            'title' => $data['title'],
            'hint' => $data['hint'],
            'link' => $data['link'],
            'order' => $order,
            'language' => $this->language,
        ));

        $insertId = $this->db->insert_id();

        if ($insertId > 0) {
            return $this->find($insertId);
        }

        return false;
    }


    public function update($record, $data = array())
    {
        $this->db
            ->where('id', $record->id)
            ->update($this->table, array(
                'title' => $this->input->post('title'),
                'hint' => $this->input->post('hint'),
                'link' => $this->input->post('link'),
                'htmlID' => $this->input->post('htmlID'),
                'htmlClass' => $this->input->post('htmlClass'),
                'target' => $this->input->post('target'),
            ));

        if ($this->db->affected_rows() > 0) {
            return $this->find($record->id);
        }

        return false;
    }


    public function delete($data)
    {
        return parent::callDelete($this->table, $data);
    }


    public function parents($id)
    {
        static $result = array();

        $record = $this->db->where('id', $id)->get($this->table)->row();

        if ($record) {
            array_unshift($result, array('title' => $record->title, 'url' => moduleUri('childs', $record->id)));

            if ($record->parentId > 0) {
                $this->parents($record->parentId, false);
            }
        }

        return $result;
    }


    public function order($ids)
    {
        return parent::callOrder($this->table, $ids);
    }


    public function groupInsert($data = array())
    {
        $this->db->insert($this->table, array(
            'name' => $this->input->post('name'),
            'title' => $this->input->post('title'),
            'language' => $this->language,
        ));

        $insertId = $this->db->insert_id();

        if ($insertId > 0) {
            return $this->find($insertId);
        }

        return false;
    }


    public function groupUpdate($record, $data = array())
    {
        $this->db
            ->where('id', $record->id)
            ->update($this->table, array(
                'name' => $this->input->post('name'),
                'title' => $this->input->post('title')
            ));

        if ($this->db->affected_rows() > 0) {
            return $this->find($record->id);
        }

        return false;
    }


    public function groupDelete($data)
    {
        return parent::callDelete($this->table, $data);
    }
} 