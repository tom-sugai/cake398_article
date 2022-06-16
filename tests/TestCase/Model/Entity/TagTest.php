<?php
namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\Tag;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Entity\Tag Test Case
 */
class TagTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Entity\Tag
     */
    public $Tag;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Tag = new Tag();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Tag);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
