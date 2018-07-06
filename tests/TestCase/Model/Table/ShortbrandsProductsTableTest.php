<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ShortbrandsProductsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ShortbrandsProductsTable Test Case
 */
class ShortbrandsProductsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ShortbrandsProductsTable
     */
    public $ShortbrandsProducts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.shortbrands_products',
        'app.shortbrands',
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
        $config = TableRegistry::getTableLocator()->exists('ShortbrandsProducts') ? [] : ['className' => ShortbrandsProductsTable::class];
        $this->ShortbrandsProducts = TableRegistry::getTableLocator()->get('ShortbrandsProducts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ShortbrandsProducts);

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
