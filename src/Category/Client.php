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
    public function list(string $site_id, $pid = '0')
    {
        return $this->httpGet('category', compact('site_id', 'pid'));
    }

    public function tree(string $site_id, $pid = '0')
    {
        return $this->httpGet('category/tree', compact('site_id', 'pid'));
    }

    /**
     * Show category.
     *
     * @return mixed
     */
    public function show(string $id)
    {
        return $this->httpGet('category/'.$id);
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
    public function update(string $id, array $params)
    {
        return $this->httpPut('category/'.$id, $params);
    }

    /**
     * Delete category by id.
     *
     * @return mixed
     */
    public function delete(string $id)
    {
        return $this->httpDelete('category/'.$id);
    }
}
