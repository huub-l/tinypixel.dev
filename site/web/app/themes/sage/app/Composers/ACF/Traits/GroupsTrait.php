<?php

namespace App\Composers\ACF\Traits;

use \WP_Post;
use \Illuminate\Support\Collection;
use \Illuminate\Support\Facades\Cache;

use function \get_field_objects;

trait GroupsTrait
{
    use CacheTrait;

    /**
     * Custom field values for post from group name
     *
     * @param string $groupName
     * @param string $postId
     * @return \Illuminate\Support\Collection
     */
    public function rawGroup(string $groupName)
    {
        if ($this->customFields) {
            return collect($this->customFields->get("obj"))->get($groupName);
        }
    }

    public function group(string $groupName)
    {
        if ($this->customFields) {
            return $this->fields()->get($groupName);
        }
    }

    public function fields()
    {
        if ($this->customFields) {
            return collect($this->customFields->get('fields'));
        }
    }

    /**
     * Collection of post's custom fields
     *
     * @param \WP_Post $post
     * @return \Illuminate\Support\Collection
     */
    public function withFields()
    {
        if (!function_exists('get_field_objects') || !$this->post) {
            return;
        }

        $this->customFields = $this->collectFieldsFromCache();
    }

    public function collectFieldsFromCache()
    {
        return Cache::remember($this->cache->id, $this->cache->expiry, function () {
            return collect([
                'obj' => $this->collectGroupFields($this->post),
                'fields' => $this->collectFields($this->post),
            ]);
        });
    }

    /**
     * Collects fields
     *
     * @return \Illuminate\Support\Collection
     */
    public function collectGroupFields(WP_Post $post)
    {
        return get_field_objects($post->ID);
    }

    /**
     * Collects group fields
     *
     * @return \Illuminate\Support\Collection
     */
    public function collectFields(WP_Post $post)
    {
        return get_fields($post->ID);
    }
}
