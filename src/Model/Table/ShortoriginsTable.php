<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Shortorigins Model
 *
 * @property \App\Model\Table\OriginsTable|\Cake\ORM\Association\BelongsTo $Origins
 * @property \App\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsToMany $Products
 *
 * @method \App\Model\Entity\Shortorigin get($primaryKey, $options = [])
 * @method \App\Model\Entity\Shortorigin newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Shortorigin[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Shortorigin|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Shortorigin|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Shortorigin patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Shortorigin[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Shortorigin findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ShortoriginsTable extends Table
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

        $this->setTable('shortorigins');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Origins', [
            'foreignKey' => 'origin_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('Products', [
            'foreignKey' => 'shortorigin_id',
            'targetForeignKey' => 'product_id',
            'joinTable' => 'shortorigins_products'
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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['origin_id'], 'Origins'));

        return $rules;
    }
}
