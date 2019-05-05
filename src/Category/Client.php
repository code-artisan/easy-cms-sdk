<?php

namespace EasyCMS\Category;

use EasyCMS\Kernel\BaseClient;

class Client extends BaseClient
{

    /**
     * Get categories by site id.
     *
     * @return mixed
     */
    public function list(int $site_id)
    {
        return $this->httpGet('category', compact('site_id'));
    }

    /**
     * Show category.
     * 
     * @return mixed
     */
    public function show(int $id)
    {
        return $this->httpGet('category/' . $id);
    }

    /**
     * Create category by id.
     *
     * @return mixed
     */
    public function create(array $params)
    {
        return $this->httpPost('category', $params);
    }

    /**
     * Update category by id.
     *
     * @return mixed
     */
    public function update(int $id, array $params)
    {
        return $this->httpPut('category/' . $id, $params);
    }

    /**
     * Delete category by id.
     *
     * @return mixed
     */
    public function delete(int $id)
    {
        return $this->httpDelete('category/' . $id);
    }
}
