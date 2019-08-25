<?php

namespace App\Composers;

use \WP_Post;
use function \get_post;
use function \get_the_id;
use GrahamCampbell\GitHub\GithubManager;
use League\CommonMark\CommonMarkConverter;
use Illuminate\Support\Collection;
use Roots\Acorn\View\Composer;
use Roots\Acorn\View\Composers\Concerns\Cacheable;
use Roots\Acorn\View\Composers\Concerns\Arrayable;
use App\Model\Post;
use Illuminate\Support\Facades\Cache;

/**
 * plugin singular view composer
 */
class Plugin extends Composer
{
    use Cacheable, Arrayable;

    /**
     * Github account
     * @var string
     */
    public $githubAccountName = 'pixelcollective';

    /**
     * List of views served by this composer.
     * @var array
     */
    protected static $views = [
        'single-plugin',
        'partials.header-plugin',
        'partials.plugin-meta',
        'partials.content-single-plugin',
    ];

    /**
     * Eloquent Plugin
     * @var static Post
     */
    public static $plugin;

    /**
     * Eloquent Post Model
     * @var App\Model\Post
     */
    public static $post;

    /**
     * Constructor.
     *
     * @param \GrahamCampbell\GitHub\GithubManager   $git
     * @param \League\CommonMark\CommonMarkConverter $md
     */
    public function __construct(
        \GrahamCampbell\GitHub\GithubManager $git,
        \League\CommonMark\CommonMarkConverter $md
    ) {
        /**
         * Github API Service
         * @var \GrahamCampbell\GitHub\GithubManager
         */
        $this->git = $git;

        /**
         * Markdown
         * @var object
         */
        $this->md = $md;

        /**
         * Post model
         */
        self::$post  = Post::class;

        /**
         * Plugin Id
         */
        $this->pluginId = get_the_id();

        /**
         * Plugin post.
         */
        $this->pluginInstance = self::$post
                ::type('plugin')
                ->status('publish')
                ->where('id', $this->pluginId)
                ->with('meta')
                ->first();

        /**
         * Plugin meta.
         */
        $this->meta = $this->pluginInstance->meta;
    }

    /**
     * Data to be passed to view before rendering
     *
     * @return array
     */
    protected function with()
    {
        return Cache::rememberForever($this->repoId(), function () {
            return $this->toArray();
        });
    }

    /**
     * View method: $plugin
     */
    public function plugin()
    {
        return $this->meta;
    }

    /**
     * Github ID
     */
    protected function repoId()
    {
        return $this->meta->plugin_githubId;
    }

    /**
     * View method: $git
     *
     * @return array
     */
    public function git() : array
    {
        return $this->git->repo()->show(
            $this->githubAccountName,
            $this->repoId()
        );
    }

    /**
     * View method: $readme
     *
     * @return string
     */
    public function readme()
    {
        return $this->md->convertToHtml($this->repoReadme());
    }

    /**
     * Repository readme.
     *
     * @param  string $name
     * @return string
     */
    protected function repoReadme()
    {
        return $this->git->repo()->readme($this->githubAccountName, $this->repoId());
    }
}
