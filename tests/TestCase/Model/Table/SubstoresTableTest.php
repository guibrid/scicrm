<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SubstoresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SubstoresTable Test Case
 */
class SubstoresTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SubstoresTable
     */
    public $Substores;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.substores',
        'app.stores',
        'app.categories'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Substores') ? [] : ['className' => SubstoresTable::class];
        $this->Substores = TableRegistry::getTableLocator()->get('Substores', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Substores);

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
