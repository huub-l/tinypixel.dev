<?php

namespace App\Composers\ACF;

use App\Composers\ACF\Traits\{
    PostTrait,
    CacheTrait,
    GroupsTrait,
};

use Roots\Acorn\View\Composer;

class FieldComposer extends Composer
{
    use Traits\PostTrait;
    use Traits\GroupsTrait;

    /**
     * Construct
     */
    public function useGroups()
    {
        $this
            ->setupPost()
            ->usingCache()
            ->withFields();
    }
}
