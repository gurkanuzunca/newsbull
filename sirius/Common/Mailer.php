<?php

namespace Sirius\Common;

abstract class Mailer
{
    /**
     * CodeIgniter object.
     *
     * @var \CI_Controller
     */
    protected $ci;

    /**
     * Mailer
     *
     * @var \CI_Email
     */
    protected $mailer;

    /**
     * @var string
     */
    protected $smtpHost;

    /**
     * @var string
     */
    protected $smtpPort;

    /**
     * @var string
     */
    protected $smtpUser;

    /**
     * @var string
     */
    protected $smtpPass;

    /**
     * @var string
     */
    protected $smtpFromEmail;


    public function __construct()
    {
        $this->ci =& get_instance();

        $this->smtpHost = $this->ci->stack->get('options.smtpHost');
        $this->smtpPort = $this->ci->stack->get('options.smtpPort');
        $this->smtpUser = $this->ci->stack->get('options.smtpUser');
        $this->smtpPass = $this->ci->stack->get('options.smtpPass');
        $this->smtpFromEmail = $this->ci->stack->get('options.smtpFromEmail');

        if (empty($this->smtpHost) || empty($this->smtpPort) || empty($this->smtpUser) || empty($this->smtpPass)) {
            throw new \Exception(sprintf('Smtp bilgileri hatalı. Host: %s, Port: %s, User: %s, Pass: %s', $this->smtpHost, $this->smtpPort, $this->smtpUser, $this->smtpPass));
        }

        if (empty($this->smtpFromEmail)) {
            $this->smtpFromEmail = $this->smtpUser;
        }

        $this->ci->load->library('email');
        $this->ci->email->initialize(array(
            'smtp_host' => $this->smtpHost,
            'smtp_port' => $this->smtpPort,
            'smtp_user' => $this->smtpUser,
            'smtp_pass' => $this->smtpPass
        ));

        $this->mailer = $this->ci->email;

        $this->mailer->from($this->smtpFromEmail);
    }

    /**
     * View dosyasını layout ile birlikte render edip string döndürür.
     *
     * @param $file
     * @param $data
     * @return string
     */
    public function render($file, $data = array())
    {
        if (is_array($file)) {
            $file = implode('/', $file);
        }

        $data['view'] = $file;
        return $this->ci->load->view('home/mailer-master', $data, true);
    }



}