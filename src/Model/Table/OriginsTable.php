<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Origins Model
 *
 * @property \App\Model\Table\ProductsTable|\Cake\ORM\Association\HasMany $Products
 * @property \App\Model\Table\ShortoriginsTable|\Cake\ORM\Association\HasMany $Shortorigins
 *
 * @method \App\Model\Entity\Origin get($primaryKey, $options = [])
 * @method \App\Model\Entity\Origin newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Origin[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Origin|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Origin|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Origin patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Origin[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Origin findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OriginsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('origins');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Products', [
            'foreignKey' => 'origin_id'
        ]);
        $this->hasMany('Shortorigins', [
            'foreignKey' => 'origin_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        return $validator;
    }
}
