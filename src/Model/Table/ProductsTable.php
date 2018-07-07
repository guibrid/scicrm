<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use ArrayObject;

/**
 * Products Model
 *
 * @property \App\Model\Table\OriginsTable|\Cake\ORM\Association\BelongsTo $Origins
 * @property \App\Model\Table\BrandsTable|\Cake\ORM\Association\BelongsTo $Brands
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
            //'joinType' => 'INNER'
        ]);
        $this->belongsTo('Brands', [
            'foreignKey' => 'brand_id',
            //'joinType' => 'INNER'

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

    // Dans une classe table ou behavior
    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        //On format la valeur TVA pour la mettre au format numeric et double
        $data['tva'] = str_replace(",", ".", $data['tva']);
        if (is_numeric(($data['tva']))) {
          $data['tva'] = (float)$data['tva'];
          //debug( $data['tva'].'-'.gettype($data['tva']));
          //die;
        }

    }



    public function isvalidDouble($value, array $context)
    {
      if (is_double($value)) {
        return true;
      } else {
        // Ajouter dans la table warning, un enregistrement avec le product_code, le title, la value, urgence
        //debug($context);
        //die;
      }

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
            ->add('tva', 'validDouble', [
                  'rule' => 'isvalidDouble',
                  'message' => 'TVA is not a valid double',
                  'provider' => 'table']);

        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('code')
            ->maxLength('code', 50)
            ->allowEmpty('code');

        $validator
            ->scalar('remplacement_product')
            ->maxLength('remplacement_product', 255)
            ->allowEmpty('remplacement_product');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->allowEmpty('title');

        $validator
            ->integer('pcb')
            ->allowEmpty('pcb');

        $validator
            ->numeric('prix')
            ->allowEmpty('prix');

        $validator
            ->scalar('uv')
            ->maxLength('uv', 255)
            ->allowEmpty('uv');

        $validator
            ->numeric('poids')
            ->allowEmpty('poids');

        $validator
            ->numeric('volume')
            ->allowEmpty('volume');

        $validator
            ->scalar('dlv')
            ->maxLength('dlv', 255)
            ->allowEmpty('dlv');

        $validator
            ->scalar('duree_vie')
            ->maxLength('duree_vie', 255)
            ->allowEmpty('duree_vie');

        $validator
            ->scalar('gencod')
            ->maxLength('gencod', 255)
            ->allowEmpty('gencod');

        $validator
            ->scalar('douanier')
            ->maxLength('douanier', 255)
            ->allowEmpty('douanier');

        $validator
            ->scalar('dangereux')
            ->maxLength('dangereux', 255)
            ->allowEmpty('dangereux');

        $validator
            ->scalar('tva')
            ->maxLength('tva', 255)
            ->allowEmpty('tva');

        $validator
            ->scalar('cdref')
            ->maxLength('cdref', 255)
            ->allowEmpty('cdref');

        $validator
            ->scalar('category_code')
            ->maxLength('category_code', 255)
            ->allowEmpty('category_code');

        $validator
            ->scalar('subcategory_code')
            ->maxLength('subcategory_code', 255)
            ->allowEmpty('subcategory_code');

        $validator
            ->scalar('entrepot')
            ->maxLength('entrepot', 255)
            ->allowEmpty('entrepot');

        $validator
            ->scalar('supplier')
            ->maxLength('supplier', 255)
            ->allowEmpty('supplier');

        $validator
            ->scalar('qualification')
            ->maxLength('qualification', 255)
            ->allowEmpty('qualification');

        $validator
            ->integer('couche_palette')
            ->allowEmpty('couche_palette');

        $validator
            ->integer('colis_palette')
            ->allowEmpty('colis_palette');

        $validator
            ->scalar('pieceartk')
            ->maxLength('pieceartk', 255)
            ->allowEmpty('pieceartk');

        $validator
            ->scalar('ifls_remplacement')
            ->maxLength('ifls_remplacement', 255)
            ->allowEmpty('ifls_remplacement');

        $validator
            ->integer('assortiment')
            ->allowEmpty('assortiment');

        $validator
            ->boolean('active')
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
