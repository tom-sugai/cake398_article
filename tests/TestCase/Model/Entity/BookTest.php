<?php
namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\Book;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Entity\Book Test Case
 */
class BookTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Entity\Book
     */
    public $Book;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Book = new Book();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Book);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
    */

    /** This->Book test */
    public function testBookInstance() {
        $this->assertTrue(is_a($this->Book,'App\Model\Entity\Book'));
    }
}
