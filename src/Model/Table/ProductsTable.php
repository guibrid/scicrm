<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Products Model
 *
 * @property \App\Model\Table\OriginsTable|\Cake\ORM\Association\BelongsTo $Origins
 * @property \App\Model\Table\BrandsTable|\Cake\ORM\Association\BelongsTo $Brands
 * @property \App\Model\Table\WarningsTable|\Cake\ORM\Association\BelongsToMany $Warnings
 * @property \App\Model\Table\ShortbrandsTable|\Cake\ORM\Association\BelongsToMany $Shortbrands
 * @property \App\Model\Table\ShortoriginsTable|\Cake\ORM\Association\BelongsToMany $Shortorigins
 *
 * @method \App\Model\Entity\Product get($primaryKey, $options = [])
 * @method \App\Model\Entity\Product newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Product[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Product|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Product|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Product patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Product[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Product findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductsTable extends Table
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

        $this->setTable('products');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Origins', [
            'foreignKey' => 'origin_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Brands', [
            'foreignKey' => 'brand_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('Warnings', [
            'foreignKey' => 'product_id',
            'targetForeignKey' => 'warning_id',
            'joinTable' => 'products_warnings'
        ]);
        $this->belongsToMany('Shortbrands', [
            'foreignKey' => 'product_id',
            'targetForeignKey' => 'shortbrand_id',
            'joinTable' => 'shortbrands_products'
        ]);
        $this->belongsToMany('Shortorigins', [
            'foreignKey' => 'product_id',
            'targetForeignKey' => 'shortorigin_id',
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
            ->scalar('code')
            ->maxLength('code', 50)
            ->requirePresence('code', 'create')
            ->notEmpty('code');

        $validator
            ->scalar('remplacement_product')
            ->maxLength('remplacement_product', 255)
            ->requirePresence('remplacement_product', 'create')
            ->notEmpty('remplacement_product');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->integer('pcb')
            ->requirePresence('pcb', 'create')
            ->notEmpty('pcb');

        $validator
            ->numeric('prix')
            ->requirePresence('prix', 'create')
            ->notEmpty('prix');

        $validator
            ->scalar('uv')
            ->maxLength('uv', 255)
            ->requirePresence('uv', 'create')
            ->notEmpty('uv');

        $validator
            ->numeric('poids')
            ->requirePresence('poids', 'create')
            ->notEmpty('poids');

        $validator
            ->numeric('volume')
            ->requirePresence('volume', 'create')
            ->notEmpty('volume');

        $validator
            ->date('dlv')
            ->requirePresence('dlv', 'create')
            ->notEmpty('dlv');

        $validator
            ->scalar('duree_vie')
            ->maxLength('duree_vie', 255)
            ->requirePresence('duree_vie', 'create')
            ->notEmpty('duree_vie');

        $validator
            ->scalar('gencod')
            ->maxLength('gencod', 255)
            ->requirePresence('gencod', 'create')
            ->notEmpty('gencod');

        $validator
            ->scalar('douanier')
            ->maxLength('douanier', 255)
            ->requirePresence('douanier', 'create')
            ->notEmpty('douanier');

        $validator
            ->scalar('dangereux')
            ->maxLength('dangereux', 255)
            ->requirePresence('dangereux', 'create')
            ->notEmpty('dangereux');

        $validator
            ->numeric('tva')
            ->requirePresence('tva', 'create')
            ->notEmpty('tva');

        $validator
            ->scalar('cdref')
            ->maxLength('cdref', 255)
            ->requirePresence('cdref', 'create')
            ->notEmpty('cdref');

        $validator
            ->scalar('category_code')
            ->maxLength('category_code', 255)
            ->requirePresence('category_code', 'create')
            ->notEmpty('category_code');

        $validator
            ->scalar('subcategory_code')
            ->maxLength('subcategory_code', 255)
            ->requirePresence('subcategory_code', 'create')
            ->notEmpty('subcategory_code');

        $validator
            ->scalar('entrepot')
            ->maxLength('entrepot', 255)
            ->requirePresence('entrepot', 'create')
            ->notEmpty('entrepot');

        $validator
            ->scalar('supplier')
            ->maxLength('supplier', 255)
            ->requirePresence('supplier', 'create')
            ->notEmpty('supplier');

        $validator
            ->scalar('qualification')
            ->maxLength('qualification', 255)
            ->requirePresence('qualification', 'create')
            ->notEmpty('qualification');

        $validator
            ->integer('couche_palette')
            ->requirePresence('couche_palette', 'create')
            ->notEmpty('couche_palette');

        $validator
            ->integer('colis_palette')
            ->requirePresence('colis_palette', 'create')
            ->notEmpty('colis_palette');

        $validator
            ->scalar('pieceartk')
            ->maxLength('pieceartk', 255)
            ->requirePresence('pieceartk', 'create')
            ->notEmpty('pieceartk');

        $validator
            ->scalar('ifls_remplacement')
            ->maxLength('ifls_remplacement', 255)
            ->requirePresence('ifls_remplacement', 'create')
            ->notEmpty('ifls_remplacement');

        $validator
            ->integer('assortiment')
            ->requirePresence('assortiment', 'create')
            ->notEmpty('assortiment');

        $validator
            ->scalar('temperature')
            ->maxLength('temperature', 255)
            ->requirePresence('temperature', 'create')
            ->notEmpty('temperature');

        $validator
            ->boolean('active')
            ->requirePresence('active', 'create')
            ->notEmpty('active');

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
        $rules->add($rules->existsIn(['brand_id'], 'Brands'));

        return $rules;
    }
}
