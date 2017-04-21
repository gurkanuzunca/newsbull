<?php

namespace Controllers;

use Sirius\Application\Controller;

abstract class BaseController extends Controller
{

    /**
     * Login olun kullanıcı bilgilerini döndürür.
     *
     * @return mixed
     */
    public function getUser()
    {
        return $this->auth->user();
    }

}