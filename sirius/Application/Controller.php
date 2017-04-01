<?php

namespace Sirius\Application;


abstract class Controller extends \MX_Controller
{

    public $language;
    public $actuator = false;

    public function __construct()
    {
        parent::__construct();

        /**
         * Kurulumun yapılıp yapılmadığını kontrol eder.
         * Kurulum yapılmadıysa kurulum ekranına geçer.
         */
        $this->isReady();

        /**
         * Varsayılan dil atama
         */
        $languages = $this->config->item('languages');
        $segment = $this->uri->segment(1);

        if ($languages && $segment) {
            if (array_key_exists($segment, $languages)) {
                $language = $segment;
            }
        }

        if (! empty($language)){
            $this->config->set_item('language', $language);
            $this->language = $language;
        } else {
            $this->language = $this->config->item('language');
        }

        $this->lang->load('application');


        /**
         * Site genel ayarları atama
         */
        $results =  $this->db
            ->where('language', $this->language)
            ->or_where('language', null)
            ->get('options')
            ->result();

        foreach ($results as $result) {
            $this->stack->set("options.{$result->name}", $result->value);
        }


        /**
         * Belirtilen modüle argümanlarını atama
         */
        if (isset($this->module)) {

            if ($this->actuator === true) {
                load_class('Model', 'core');
                $this->module = new ActuatorModel();
            }

            $module = $this->getModule($this->module);

            if ($module) {
                $this->module = $module;

                if (! empty($this->module->arguments->metaTitle)) {
                    $this->stack->set('options.metaTitle', $this->module->arguments->metaTitle);
                }

                if (! empty($this->module->arguments->metaDescription)) {
                    $this->stack->set('options.metaDescription', $this->module->arguments->metaDescription);
                }

                if (! empty($this->module->arguments->metaKeywords)) {
                    $this->stack->set('options.metaKeywords', $this->module->arguments->metaKeywords);
                }

            } else {
                unset($this->module);
            }

        }



    }


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
     * Sayfalama.
     *
     * @param $count
     * @param int $limit
     * @param null $url
     * @return array
     */
    public function paginate($count, $limit = 20, $url = null)
    {
        $this->load->library('pagination');
        $this->pagination->initialize([
            'base_url' => empty($url) ? current_url() : $url,
            'total_rows' => $count,
            'per_page' => $limit
        ]);

        $pagination = $this->pagination->create_links();
        return [
            'limit' => $limit,
            'offset' => $this->pagination->cur_page * $this->pagination->per_page,
            'pagination' => $pagination
        ];
    }


    public function json($data)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    /**
     * View dosyasını layout ile birlikte yükler.
     *
     * @param $file
     * @param $data
     */
    public function render($file, $data = array())
    {
        if (is_array($file)) {
            $file = implode('/', $file);
        }

        $data['view'] = $file;
        $this->load->view('home/master', $data);
    }



    /**
     * Kurulumun yapılıp yapılmadığını kontrol eder.
     * Kurulum yapılmadıysa kurulum ekranına geçer.
     */
    public function isReady()
    {
        if (! $this->db->table_exists('options')) {
            redirect('admin/install');
        }
    }


    /**
     * Modül verilerini çeker.
     *
     * @param $name
     * @return mixed
     */
    public function getModule($name)
    {
        $module = $this->db
            ->from('modules')
            ->where('name', $name)
            ->get()
            ->row();

        if ($module) {
            $arguments = $this->db
                ->from('module_arguments')
                ->where('module', $module->name)
                ->where('language', $this->language)
                ->get()
                ->result();

            $module->arguments = new \stdClass();
            foreach ($arguments as $argument) {
                $module->arguments->{$argument->name} = $argument->value;
            }
        }

        return $module;
    }


    protected function setMeta($record, $options = [])
    {
        $this->stack->set('options.metaTitle', !empty($record->metaTitle) ? $record->metaTitle : $record->title);
        $this->stack->set('options.metaDescription', $record->metaDescription);
        $this->stack->set('options.metaKeywords', $record->metaKeywords);
        $this->stack->set('options.ogTitle', $record->title);

        if (isset($options['type'])) {
            $this->stack->set('options.ogType', $options['type']);
        }

        if (! empty($record->summary)) {
            $this->stack->set('options.ogDescription', $record->summary);
        }

        if (! empty($record->image)) {
            $this->stack->set('options.ogImage', getImage($record->image, isset($options['imagePath']) ? $options['imagePath'] : 'content'));
        }


    }

} 