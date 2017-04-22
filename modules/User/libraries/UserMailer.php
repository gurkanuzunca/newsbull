<?php

use Sirius\Common\Mailer;

class UserMailer extends Mailer
{

    /**
     * Yeni kullanıcı mail doğrulama.
     *
     * @param string $to Alıcı email
     * @param mixed $data View da render edilecek değişkenler
     * @param string $subject
     */
    public function sendEmailVerify($to, $data = array(), $subject = 'E-mail Adresinizi Doğrulayın')
    {
        $this->mailer->to($to);
        $this->mailer->subject($subject);
        $this->mailer->message($this->render('user/mailer/email-verify', $data));
        $this->mailer->send();
    }

    /**
     * Parolamı unuttum maili
     *
     * @param string $to Alıcı email
     * @param mixed $data View da render edilecek değişkenler
     * @param string $subject
     */
    public function sendForgotPassword($to, $data = array(), $subject = 'Parolamı Unuttum')
    {
        $this->mailer->to($to);
        $this->mailer->subject($subject);
        $this->mailer->message($this->ci->load->view('user/mailer/forgot-password', $data, true));
        $this->mailer->send();
    }

    /**
     * Yeni kullanıcı hoşgeldin.
     *
     * @param string $to Alıcı email
     * @param mixed $data View da render edilecek değişkenler
     * @param string $subject
     */
    public function sendWelcome($to, $data = array(), $subject = 'Hesabınız Doğrulandı')
    {
        $this->mailer->to($to);
        $this->mailer->subject($subject);
        $this->mailer->message($this->ci->load->view('user/mailer/welcome', $data, true));
        $this->mailer->send();
    }


}