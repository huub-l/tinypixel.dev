<?php

namespace App\Composers;

use App\Composers\Concerns\Services;
use TinyPixel\FieldsComposer\FieldsComposer;

/**
 * Plugin single template
 */
class Plugin extends FieldsComposer
{
    use Services;

    /**
     * Github account
     * @var string
     */
    public static $account = 'pixelcollective';

    /**
     * List of views served by this composer.
     * @var array
     */
    protected static $views = [
        'partials.header-plugin',
        'partials.content-single-plugin',
        'partials.plugin-meta',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @param  array $data
     * @param  \Illuminate\View\View $view
     * @return array
     */
    public function with($data, $view)
    {
        $this->useServices([
            'github',
            'commonmark',
            'cache',
        ]);

        $this->repoId = $this->fields('plugin')->githubId;

        return $this->forever($this->repoId, function () {
            return [
                'plugin' => $this->fields('plugin'),
                'git'    => $this->repo($this->repoId),
                'readme' => $this->readme($this->repoId),
            ];
        });
    }

    /**
     * Repository.
     *
     * @param  string $repoId
     * @return array
     */
    public function repo($repoId) : array
    {
        return $this->github->repo()->show(self::$account, $repoId);
    }

    /**
     * Readme.
     *
     * @param  string $repoId
     * @return string
     */
    public function readme($repoId) : string
    {
        return $this->commonmark->convertToHtml(
            $this->github->repo()->readme(self::$account, $repoId)
        );
    }
}
