<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Single extends Controller
{
    public function commenter()
    {
        return wp_get_current_commenter();
    }
}
