<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TestPostController extends TestCase
{

    use DatabaseMigrations;
    use DatabaseTransactions;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testSearchBlankKeyword() {
        $aCategory = factory(App\Category::class)->create();
        $aLocation = factory(App\Location::class)->create();

        $expectedPost = factory(App\Post::class)->create([
            'title' => 'harambe',
            'category_id' => $aCategory->id,
            'location_id' => $aLocation->id
           ]);

        $acutalPost = $this->call('GET', 'posts/search')->original->getData()['posts']->first();

        $this->assertEquals($expectedPost->id, $acutalPost->id);
        $this->assertEquals($expectedPost->title, $acutalPost->title);
    }

    public function testSearchValidKeyword() {
        $aCategory = factory(App\Category::class)->create();
        $aLocation = factory(App\Location::class)->create();

        $expectedHarambePost = factory(App\Post::class)->create(
            ['title' => 'harambe',
            'category_id' => $aCategory->id,
            'location_id' => $aLocation->id]);
        
        $expectedIphonePost = factory(App\Post::class)->create(
            ['title' => 'iphone',
            'category_id' => $aCategory->id,
            'location_id' => $aLocation->id]);

        $acutalPost = $this->call('GET', 'posts/search?keyword=iphone')->original->getData()['posts']->first();

        $this->assertEquals(1, sizeOf($acutalPost));
        $this->assertEquals($expectedIphonePost->id, $acutalPost->id);
    }

    public function testSearchValidKeywordWithInvalidLocationFilter() {
        $aCategory = factory(App\Category::class)->create();
        $aLocation = factory(App\Location::class)->create();

        $expectedHarambePost = factory(App\Post::class)->create(
            ['title' => 'harambe',
            'category_id' => $aCategory->id,
            'location_id' => $aLocation->id]);
        
        $expectedIphonePost = factory(App\Post::class)->create(
            ['title' => 'iphone',
            'category_id' => $aCategory->id,
            'location_id' => $aLocation->id]);

        $acutalPost = $this->call('GET', 'posts/search?keyword=iphone&locationId=invalidId')
                        ->original->getData()['posts']->first();

        $this->assertEquals(0, sizeOf($acutalPost));
    }

    public function testSearchValidKeywordWithValidLocationFilter() {
        $aCategory = factory(App\Category::class)->create();
        $aLocation = factory(App\Location::class)->create();

        $expectedHarambePost = factory(App\Post::class)->create(
            ['title' => 'harambe',
            'category_id' => $aCategory->id,
            'location_id' => $aLocation->id]);
        
        $expectedIphonePost = factory(App\Post::class)->create(
            ['title' => 'iphone',
            'category_id' => $aCategory->id,
            'location_id' => $aLocation->id]);

        $acutalPost = $this->call('GET', 'posts/search?keyword=iphone&locationId=' . $aLocation->id)
                        ->original->getData()['posts']->first();

        $this->assertEquals(1, sizeOf($acutalPost));
        $this->assertEquals($expectedIphonePost->id, $acutalPost->id);
    }

    public function testSearchValidKeywordWithInvalidCategoryFilter() {
        $aCategory = factory(App\Category::class)->create();
        $aLocation = factory(App\Location::class)->create();

        $expectedHarambePost = factory(App\Post::class)->create(
            ['title' => 'harambe',
            'category_id' => $aCategory->id,
            'location_id' => $aLocation->id]);
        
        $expectedIphonePost = factory(App\Post::class)->create(
            ['title' => 'iphone',
            'category_id' => $aCategory->id,
            'location_id' => $aLocation->id]);

        $acutalPost = $this->call('GET', 'posts/search?keyword=iphone&categoryId=invalidId')
                        ->original->getData()['posts']->first();

        $this->assertEquals(0, sizeOf($acutalPost));
    }

    public function testSearchValidKeywordWithCategoryAndLocationFilter() {
        $aCategory = factory(App\Category::class)->create();
        $aLocation = factory(App\Location::class)->create();

        $expectedHarambePost = factory(App\Post::class)->create(
            ['title' => 'harambe',
            'category_id' => $aCategory->id,
            'location_id' => $aLocation->id]);
        
        $expectedIphonePost = factory(App\Post::class)->create(
            ['title' => 'iphone',
            'category_id' => $aCategory->id,
            'location_id' => $aLocation->id]);

        $acutalPost = $this->call('GET', 'posts/search?keyword=iphone&categoryId=' . $aCategory->id)
                        ->original->getData()['posts']->first();

        $this->assertEquals(1, sizeOf($acutalPost));
        $this->assertEquals($expectedIphonePost->id, $acutalPost->id);
    }
}
