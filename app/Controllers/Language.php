<?php

namespace App\Controllers;
// Use BaseController
use App\Controllers\BaseController;

class Language extends BaseController
{
    public function index()
    {
        $locale = $this->request->getLocale();
        session()->remove('lang');
        session()->set('lang', $locale);
        return redirect()->back();
    }
}
