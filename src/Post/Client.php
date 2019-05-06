<?php

namespace EasyCMS\Post;

use EasyCMS\Kernel\BaseClient;

class Client extends BaseClient
{

    /**
     * Get posts by site and category.
     *
     * @return mixed
     */
    public function paginator(array $params)
    {
        return $this->httpGet('post', $params);
    }

    /**
     * Get posts by id.
     *
     * @return mixed
     */
    public function show(string $id)
    {
        return $this->httpGet('post/' . $id);
    }

    /**
     * Create post by site and category.
     *
     * @return mixed
     */
    public function create(array $params)
    {
        return $this->httpPost('post', $params);
    }

    /**
     * Publish post by id.
     * @param string $id
     */
    public function publish(string $id)
    {
        return $this->httpPost('post/publish/' . $id);
    }

    /**
     * Unpublish post by id.
     * @param string $id
     */
    public function unpublish(string $id)
    {
        return $this->httpPost('post/unpublish/' . $id);
    }

    /**
     * Update post by site and category.
     *
     * @return mixed
     */
    public function update(string $id, array $params)
    {
        return $this->httpPut('post/' . $id, $params);
    }

    /**
     * Update post by site and category.
     *
     * @return mixed
     */
    public function delete(string $id)
    {
        return $this->httpDelete('post/' . $id);
    }
}
