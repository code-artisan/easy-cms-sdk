<?php

namespace EasyCMS\Site;

use EasyCMS\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * Get current site.
     *
     * @return mixed
     */
    public function show(string $id)
    {
        return $this->httpGet('site/'.$id);
    }

    /**
     * Update current site.
     *
     * @return mixed
     */
    public function update(string $id, array $params = [])
    {
        return $this->httpPut('site/'.$id, $params);
    }
}
