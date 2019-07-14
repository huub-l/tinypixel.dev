<?php

namespace App\Composers\ACF\Traits;

trait PostTrait
{
    /**
     * Setup post
     */
    public function setupPost()
    {
        $this->post = \get_post(\get_the_ID());

        return $this;
    }
}
