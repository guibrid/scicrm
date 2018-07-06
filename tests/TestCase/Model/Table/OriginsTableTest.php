<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OriginsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OriginsTable Test Case
 */
class OriginsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OriginsTable
     */
    public $Origins;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.origins',
        'app.products',
        'app.shortorigins'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Origins') ? [] : ['className' => OriginsTable::class];
        $this->Origins = TableRegistry::getTableLocator()->get('Origins', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Origins);

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
}
