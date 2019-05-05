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
    public function show(int $id)
    {
        return $this->httpGet('site/' . $id);
    }

    /**
     * Update current site.
     *
     * @return mixed
     */
    public function update(int $id, array $params = [])
    {
        return $this->httpPut('site/' . $id, $params);
    }
}
