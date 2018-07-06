<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductsWarningsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductsWarningsTable Test Case
 */
class ProductsWarningsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductsWarningsTable
     */
    public $ProductsWarnings;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.products_warnings',
        'app.products',
        'app.warnings'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ProductsWarnings') ? [] : ['className' => ProductsWarningsTable::class];
        $this->ProductsWarnings = TableRegistry::getTableLocator()->get('ProductsWarnings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProductsWarnings);

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
