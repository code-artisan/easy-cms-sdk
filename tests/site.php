<?php

namespace EasyCMS\Tests;

class TestSite extends Base
{
    public const SITE_ID = 1;

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
