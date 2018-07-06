<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ShortbrandsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ShortbrandsTable Test Case
 */
class ShortbrandsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ShortbrandsTable
     */
    public $Shortbrands;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.shortbrands',
        'app.brands',
        'app.products'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Shortbrands') ? [] : ['className' => ShortbrandsTable::class];
        $this->Shortbrands = TableRegistry::getTableLocator()->get('Shortbrands', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Shortbrands);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
