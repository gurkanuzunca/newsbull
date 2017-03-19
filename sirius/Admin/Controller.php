<?php

namespace Sirius\Admin;


abstract class Controller extends Manager
{
    /**
     * Form Validate.
     *
     * @param array $rules
     * @return bool
     */
    public function validate($rules = array())
    {
        foreach ($rules as $name => $rule) {
            $this->form_validation->set_rules($name, $rule[1], $rule[0]);
        }

        if ($this->form_validation->run() === false) {
            $this->alert->set('error', $this->form_validation->error_array());

            return false;
        }

        return true;
    }

    /**
     * Yönlendirme işlemleri.
     *
     * @param $params
     * @param null $record
     */
    public function makeRedirect($params, $record = null)
    {
        if ($this->input->post('redirect')) {
            $params = explode('/', $this->input->post('redirect'));
        } else {
            $params = ! is_array($params) ? array($params) : $params;
        }



        if ($record !== null) {
            foreach ($params as &$param) {
                if ($param[0] === '@') {
                    $column = str_replace('@', '', $param);
                    isset($record->$column) && $param = $record->$column;
                }
            }
        }

        redirect(call_user_func_array('moduleUri', $params));
    }

    /**
     * Sayfalama.
     *
     * @param $count
     * @param int $limit
     * @param null $url
     * @param bool|false $forOrder
     * @return array
     */
    public function paginate($count, $limit = 20, $url = null, $forOrder = false)
    {
        $this->load->library('pagination');
        $this->pagination->initialize([
            'base_url' => empty($url) ? current_url() : $url,
            'total_rows' => $count,
            'per_page' => $forOrder === true ? ($limit - 1) : $limit
        ]);

        $pagination = $this->pagination->create_links();
        return [
            'limit' => $limit,
            'offset' => $this->pagination->cur_page * $this->pagination->per_page,
            'pagination' => $pagination
        ];
    }

    /**
     * Sıralama baz alarak sayfalama.
     *
     * @param $count
     * @param int $limit
     * @param null $url
     * @return array
     */
    public function paginateForOrder($count, $limit = 20, $url = null)
    {
        return $this->paginate($count, $limit, $url, true);
    }

    /**
     * View dosyasını layout ile birlikte yükler.
     * @param array|string $file
     * @param bool $actuator
     */
    public function render($file, $actuator = false)
    {
        if (is_array($file)) {
            $file = implode('/', $file);
        }

        $this->load->view('layout', array(
            'view' => $actuator === true ? 'actuator/'. $file : $this->module .'/admin/'. $file,
            'data' => $this->viewData
        ));
    }

    public function json($data)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }


    /**
     * Tüm kayıtları sayfalama yaparak listeler.
     *
     * @param array $methods
     * @param bool|false $ignoreDefaults Varsayılan metodları kullanma
     */
    protected function callRecords($methods = array(), $ignoreDefaults = false)
    {
        if ($ignoreDefaults !== true) {
            $methods = array_merge(array(
                'count' => [$this->appmodel, 'count'],
                'all' => [$this->appmodel, 'all'],
                'recordsRequest' => 'recordsRequest',
            ), $methods);
        }

        $records = array();
        $paginate = null;
        $recordCount = $this->callMethod($methods['count']);

        if ($recordCount > 0) {
            $paginate = $this->paginateForOrder($recordCount);
            $records = $this->callMethod($methods['all'], [$paginate]);
        }

        $this->callMethod($methods['recordsRequest']);
        $this->utils->breadcrumb('Kayıtlar');

        $this->viewData['records'] = $records;
        $this->viewData['paginate'] = $paginate;
    }




    /**
     * Yeni kayıt ekleme
     *
     * @param array $methods
     * @param bool|false $ignoreDefaults Varsayılan metodları kullanma
     */
    protected function callInsert($methods = array(), $ignoreDefaults = false)
    {
        if ($ignoreDefaults !== true) {
            $methods = array_merge(array(
                'insert' => [$this->appmodel, 'insert'],
                'validation' => 'validation',
                'validationAfter' => 'validationAfter',
                'insertBefore' => 'insertBefore',
                'insertAfter' => 'insertAfter',
                'insertRequest' => 'insertRequest',
                'redirect' => ['update', '@id']
            ), $methods);
        }

        if ($this->input->post()) {
            $this->callMethod($methods['validation'], ['insert']);

            if (! $this->alert->has('error')) {
                $this->callMethod($methods['validationAfter'], ['insert']);
            }

            if (! $this->alert->has('error')) {
                $this->callMethod($methods['insertBefore']);

                $success = $this->callMethod($methods['insert'], [$this->modelData]);

                if ($success) {
                    $this->callMethod($methods['insertAfter']);
                    $this->alert->set('success', 'Kayıt eklendi.');

                    $this->makeRedirect($methods['redirect'], $success);
                }
            }
        }

        $this->callMethod($methods['insertRequest']);
        $this->utils->breadcrumb('Yeni kayıt');
    }


    /**
     * Kayıt güncelleme
     *
     * @param array $methods
     * @param bool|false $ignoreDefaults Varsayılan metodları kullanma
     */
    protected function callUpdate($methods = array(), $ignoreDefaults = false)
    {
        if ($ignoreDefaults !== true) {
            $methods = array_merge(array(
                'update' => [$this->appmodel, 'update'],
                'find' => [$this->appmodel, 'find'],
                'validation' => 'validation',
                'validationAfter' => 'validationAfter',
                'updateBefore' => 'updateBefore',
                'updateAfter' => 'updateAfter',
                'updateRequest' => 'updateRequest',
                'redirect' => ['update', '@id']
            ), $methods);
        }

        if (! $record = $this->callMethod($methods['find'], $this->uri->segment(4))) {
            show_404();
        }

        if ($this->input->post()) {
            $this->callMethod($methods['validation'], ['update', $record]);

            if (! $this->alert->has('error')) {
                $this->callMethod($methods['validationAfter'], ['update', $record]);
            }

            if (! $this->alert->has('error')) {
                $this->callMethod($methods['updateBefore'], [$record]);
                $success = $this->callMethod($methods['update'], [$record, $this->modelData]);

                if ($success) {
                    $this->callMethod($methods['updateAfter'], [$record]);
                    $this->alert->set('success', 'Kayıt düzenlendi.');

                    $this->makeRedirect($methods['redirect'], $success);
                }

                $this->alert->set('warning', 'Kayıt düzenlenmedi.');
            }
        }

        $this->callMethod($methods['updateRequest'], [$record]);
        $this->utils->breadcrumb('Kayıt Düzenle');

        $this->viewData['record'] = $record;
    }

    /**
     * Kayıt(lar) silme
     *
     * @param array $methods
     * @param bool|false $ignoreDefaults Varsayılan metodları kullanma
     */
    protected function callDelete($methods = array(), $ignoreDefaults = false)
    {
        if ($ignoreDefaults !== true) {
            $methods = array_merge(array(
                'delete' => [$this->appmodel, 'delete'],
                'find' => [$this->appmodel, 'find'],
            ), $methods);
        }

        /**
         * Ajax sorgusu  ise toplu silme uygulanır
         */
        if ($this->input->is_ajax_request()) {
            $ids = $this->input->post('ids');

            if (count($ids) == 0) {
                $this->alert->set('error', 'Lütfen kayıt seçiniz.');
                echo $this->input->server('HTTP_REFERER');
            }

            $success = $this->callMethod($methods['delete'], [$ids]);

            if ($success) {
                $this->alert->set('success', "Kayıtlar başarıyla silindi.");
                echo $this->input->server('HTTP_REFERER');
            }

            die();
        }

        /**
         * Normal sorgu ise tekli silme uygulanır
         */
        if (! $record = $this->callMethod($methods['find'], $this->uri->segment(4))) {
            show_404();
        }

        $success = $this->callMethod($methods['delete'], [$record]);

        if ($success) {
            $this->alert->set('success', "Kayıt kaldırıldı. (#{$record->id})");
            redirect($this->input->server('HTTP_REFERER'));
        }

        $this->alert->set('error', 'Kayıt kaldırılamadı.');
        redirect($this->input->server('HTTP_REFERER'));

    }

    /**
     * Sıralama işlemi yapar
     *
     * @param array $methods
     * @param bool|false $ignoreDefaults Varsayılan metodları kullanma
     */
    protected function callOrder($methods = array(), $ignoreDefaults = false)
    {
        if ($ignoreDefaults !== true) {
            $methods = array_merge(array(
                'order' => [$this->appmodel, 'order']
            ), $methods);
        }

        $ids = explode(',', $this->input->post('ids'));

        if (count($ids) == 0){
            $this->alert->set('error', 'Lütfen kayıt seçiniz.');
        }

        $success = $this->callMethod($methods['order'], [$ids]);

        if ($success){
            $this->alert->set('success', "Kayıtlar başarıyla sıralandı.");
        }
    }

} 