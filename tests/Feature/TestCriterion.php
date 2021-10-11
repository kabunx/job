<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\InputBag;
use Tests\TestCase;

class TestCriterion extends TestCase
{

    /**
     * @return InputBag
     */
    public function testInputBag(): InputBag
    {
        $bag = new InputBag();
        $bag->set('name', '[&]你好');
        $bag->set('resume.name', '[|]张三');
        $bag->set('sorts', 'id,created_at:desc');
        $this->assertInstanceOf(InputBag::class, $bag);
        return $bag;
    }

    /**
     * @depends testInputBag
     */
    public function testUser(InputBag $query)
    {
        $user = new User();
        $user->filter($query)->get();
    }
}
