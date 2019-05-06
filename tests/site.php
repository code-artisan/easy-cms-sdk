<?php

namespace EasyCMS\Tests;

class site extends Base
{
    public const SITE_ID = 'a8aaaf27-5493-4750-8a6b-47a5aa2808d1';

    /**
     * @depends testUpdateSite
     */
    public function testShowSite()
    {
        $result = $this->app->site->show(self::SITE_ID);

        $this->assertEquals($result['data']['title'], '测试站点');
    }

    /**
     * Update site.
     */
    public function testUpdateSite()
    {
        $result = $this->app->site->update(self::SITE_ID, [
            'title' => '测试修改站点',
        ]);

        $this->assertEquals($result['data']['title'], '测试修改站点');
    }
}
