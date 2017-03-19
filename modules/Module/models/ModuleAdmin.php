<?php

use Models\AdminModel;

class ModuleAdmin extends AdminModel
{

    protected $table = 'modules';

    public function name($name)
    {
        $record = $this->db
            ->from($this->table)
            ->where('name', $name)
            ->get()
            ->row();

        if ($record) {
            $record->arguments = $this->arguments($record);
        }
        return $record;
    }


    public function find($id)
    {
        $record = $this->db
            ->from($this->table)
            ->where('id', $id)
            ->get()
            ->row();

        if ($record) {
            $record->arguments = $this->arguments($record);
        }
        return $record;
    }


    public function all($paginate = [])
    {
        $this->setFilter();
        $this->setPaginate($paginate);

        $records = $this->db
            ->select("{$this->table}.*, (SELECT COUNT(id) FROM module_arguments WHERE module_arguments.module = {$this->table}.name AND module_arguments.language = '{$this->language}') arguments", false)
            ->from($this->table)
            ->order_by('order', 'asc')
            ->order_by('id', 'asc')
            ->get()
            ->result();

        foreach ($records as $record) {
            if (! file_exists('modules/'. ucfirst($record->name)) || empty($record->controller)) {
                $record->controller = false;
            }
        }

        return $records;
    }


    public function count()
    {
        $this->setFilter();

        return $this->db
            ->from($this->table)
            ->count_all_results();
    }



    public function update($record, $data = array())
    {
        $affected = 0;

        foreach ($record->arguments as $argument) {
            if ($this->input->post($argument->name) !== false) {
                $this->db
                    ->where('id', $argument->id)
                    ->update('module_arguments', array(
                        'value' => $this->input->post($argument->name)
                    ));
                if ($this->db->affected_rows() > 0) {
                    $affected++;
                }
            }
        }

        return $affected;
    }



    public function arguments($record)
    {
        $results = $this->db
            ->from('module_arguments')
            ->where('module', $record->name)
            ->where('language', $this->language)
            ->get()
            ->result();

        foreach ($results as $result) {
            $result->arguments = json_decode($result->arguments, true);
        }

        return $results;
    }

    public function delete($data)
    {
        return parent::callDelete($this->table, $data);
    }

    public function order($ids)
    {
        return parent::callOrder($this->table, $ids);
    }


} 