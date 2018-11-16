<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use App\Utility\ValidatorCheck;

/**
 * Products Model
 *
 * @property \App\Model\Table\OriginsTable|\Cake\ORM\Association\BelongsTo $Origins
 * @property \App\Model\Table\CategoriesTable|\Cake\ORM\Association\BelongsTo $Categories
 * @property \App\Model\Table\SubcategoriesTable|\Cake\ORM\Association\BelongsTo $Subcategories
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
            'foreignKey' => 'origin_id'
        ]);
        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id'
        ]);
        $this->belongsTo('Subcategories', [
            'foreignKey' => 'subcategory_id'
        ]);
        $this->belongsTo('Brands', [
            'foreignKey' => 'brand_id'
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
        $this->hasMany('Photos');
    }

    // Dans une classe table ou behavior
    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
      $validatorCheck = new ValidatorCheck;
  

      $validatorCheck->validate($data); // Validation personnalisé des données
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
        //$rules->add($rules->existsIn(['origin_id'], 'Origins'));
        //$rules->add($rules->existsIn(['category_id'], 'Categories'));
        //$rules->add($rules->existsIn(['subcategory_id'], 'Subcategories'));
        //$rules->add($rules->existsIn(['brand_id'], 'Brands'));

        return $rules;
    }
}
