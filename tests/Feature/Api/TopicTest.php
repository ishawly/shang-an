<?php

namespace Tests\Feature\Api;

use App\Models\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\Traits\MockApiUser;
use Tests\TestCase;

class TopicTest extends TestCase
{
    use MockApiUser, WithFaker;

    private $url = '/api/topics';

    protected function setUp(): void
    {
        parent::setUp();

        $this->setAuthenticationHeader();
    }

    public function test_get_topic_list()
    {
        $response = $this->getJson($this->url);

        $response->assertStatus(200)->assertJson(['code' => 0]);
        $response->assertJsonStructure([
            'code',
            'message',
            'data' => [
                'data',
                'meta' => [
                    'total',
                ],
            ]
        ]);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->whereType('data.data', 'array')
                ->whereType('data.meta.total', 'integer')
                ->has('data.data.0', fn ($json) =>
                $json->whereType('id', 'integer')
                    ->whereType('topic_name', 'string')
                    ->etc()
            )->etc()
        );
    }

    public function test_store_a_topic()
    {
        $topicName = $this->faker->text(80);
        $remarks = $this->faker->text(500);

        $response = $this->postJson($this->url, [
            'topic_name' => $topicName,
            'remarks' => $remarks,
        ]);

        $response->assertSuccessful();
        $response->assertJsonPath('data.topic_name', $topicName);
        $response->assertJsonPath('data.remarks', $remarks);
    }

    public function test_show_topic()
    {
        $user = $this->getAnApiUser();
        $topic = Topic::firstWhere([
            'created_by' => $user->id,
        ]);

        $response = $this->getJson($this->url . '/' . $topic->id);
        $response->assertOk();
        $response->assertJson([
            'data' => [
                'topic_name' => $topic->topic_name,
                'remarks' => $topic->remarks,
                'created_by' => $user->id,
            ]
        ]);
    }

    public function test_update_topic()
    {
        $user = $this->getAnApiUser();
        $topic = Topic::firstWhere([
            'created_by' => $user->id,
        ]);

        $postData = [
            'topic_name' => $this->faker->text(80),
            'remarks' => $this->faker->text(500),
        ];
        $response = $this->patchJson($this->url . '/' . $topic->id, $postData);
        $response->assertOk();
        $response->assertJson(['data' => $postData]);
    }

    public function test_delete_topic()
    {
        $user = $this->getAnApiUser();
        $topic = Topic::firstWhere([
            'created_by' => $user->id,
        ]);

        $response = $this->delete($this->url . '/' . $topic->id);
        $response->assertNoContent();
    }
}
