<?php

namespace EasyCMS\Tests;

class category extends Base
{
    public const CATEGORY_ID = '090ef1b7-d22e-42e7-9f3e-a4ac353f7628';

    /**
     * 添加文章.
     */
    public function testCreateCategory()
    {
        $result = $this->app->category->create([
            'site_id' => Site::SITE_ID,
            'name' => '测试类目',
            'pid' => 0,
        ]);

        $this->assertEquals($result['data']['pid'], 0);
        $this->assertEquals($result['data']['name'], '测试类目');

        return $result['data']['id'];
    }

    /**
     * @depends testCreatePost
     */
    public function testUpdateCategory($id)
    {
        $result = $this->app->category->update($id, [
            'name' => '修改类目',
        ]);

        $this->assertEquals($result['data']['name'], '修改类目');
    }

    /**
     * Delete post.
     *
     * @depends testCreatePost
     */
    public function testDeleteCategory($id)
    {
        $this->app->category->delete($id);
        $result = $this->app->category->show($id);

        $this->assertEquals($result['status_code'], 404);
    }
}
