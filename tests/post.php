<?php

namespace EasyCMS\Tests;

class post extends Base
{
    /**
     * 添加文章.
     */
    public function testCreatePost()
    {
        $result = $this->app->post->create([
            'site_id' => Site::SITE_ID,
            'category_id' => Category::CATEGORY_ID,
            'title' => '测试文章',
            'body' => '这是一篇测试文章',
        ]);

        $this->assertEquals($result['data']['title'], '测试文章');
        $this->assertEquals($result['data']['site_id'], Site::SITE_ID);
        $this->assertEquals($result['data']['category_id'], Category::CATEGORY_ID);
        $this->assertEquals($result['data']['body'], '这是一篇测试文章');

        return $result['data']['id'];
    }

    /**
     * @depends testCreatePost
     */
    public function testUpdatePost($id)
    {
        $result = $this->app->post->update($id, [
            'body' => '我是修改之后的文章内容',
            'title' => '测试修改站点',
        ]);

        $this->assertEquals($result['data']['title'], '测试修改站点');
        $this->assertEquals($result['data']['body'], '我是修改之后的文章内容');
    }

    /**
     * @depends testCreatePost
     */
    public function testShowPost($id)
    {
        $result = $this->app->post->show($id);

        $this->assertEquals($result['data']['title'], '测试修改站点');
    }

    /**
     * @depends testCreatePost
     */
    public function testPublishPost($id)
    {
        $result = $this->app->post->publish($id);

        $this->assertEquals($result['message'], '发布成功');
    }

    /**
     * @depends testCreatePost
     */
    public function testUnpublishPost($id)
    {
        $result = $this->app->post->unpublish($id);

        $this->assertEquals($result['message'], '撤销发布成功');
    }

    /**
     * Delete post.
     *
     * @depends testCreatePost
     */
    public function testDeletePost($id)
    {
        $this->app->post->delete($id);
        $result = $this->app->post->show($id);

        $this->assertEquals($result['status_code'], 404);
    }
}
