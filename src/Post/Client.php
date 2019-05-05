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
    public function show(int $id)
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
     * @param int $id
     */
    public function publish($id)
    {
        return $this->httpPost('post/publish/' . $id);
    }

    /**
     * Unpublish post by id.
     * @param int $id
     */
    public function unpublish($id)
    {
        return $this->httpPost('post/unpublish/' . $id);
    }

    /**
     * Update post by site and category.
     *
     * @return mixed
     */
    public function update(int $id, array $params)
    {
        return $this->httpPut('post/' . $id, $params);
    }

    /**
     * Update post by site and category.
     *
     * @return mixed
     */
    public function delete(int $id)
    {
        return $this->httpDelete('post/' . $id);
    }
}
