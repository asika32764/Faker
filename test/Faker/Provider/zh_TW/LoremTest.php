<?php

namespace Faker\Test\Provider\zh_TW;

use Faker\Generator;
use Faker\Provider\zh_TW\Lorem;
use PHPUnit\Framework\TestCase;

class LoremTest extends TestCase
{
    /**
     * @var Generator
     */
    private $faker;

    /**
     * @var  array
     */
    private $wordList;

    public function setUp()
    {
        $faker = new Generator();
        $faker->addProvider($lorem = new Lorem($faker));
        $this->faker = $faker;

        $reflection = new \ReflectionClass($lorem);
        $property = $reflection->getProperty('wordList');
        $property->setAccessible(true);

        $this->wordList = $property->getValue($lorem);
    }

    public function testWord()
    {
        $word = $this->faker->word;

        self::assertContains($word, $this->wordList);
    }

    public function testWords()
    {
        $words = array_unique($this->faker->words);
        sort($words);

        $expected = array_unique(array_intersect($this->wordList, $words));
        sort($expected);

        self::assertEquals(array_values($words), array_values($expected));
    }

    public function testText()
    {
        self::assertEquals(1, mb_strlen($this->faker->text(1)));
        self::assertEquals(2, mb_strlen($this->faker->text(2)));
        self::assertEquals(3, mb_strlen($this->faker->text(3)));
        self::assertEquals(4, mb_strlen($this->faker->text(4)));
        self::assertEquals(5, mb_strlen($this->faker->text(5)));

        self::assertStringEndsWith('。', $this->faker->text(10));

        self::assertStringEndsWith('。', $this->faker->text(20));
        self::assertContains('，', $this->faker->text(20));
    }
}
