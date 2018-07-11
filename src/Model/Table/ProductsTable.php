<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use ArrayObject;
use App\Utility\FieldCheck;
use Cake\Datasource\EntityInterface;

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

      $fieldCheck = new FieldCheck;

      foreach($data as $key => $row) {
        switch ($key) {

          case 'code': // alphanumeric, no empty
            $fieldCheck->isalphaNum($key, $row, $data['code']); // Check si alphnumerique
            $fieldCheck->isVide($key, $row, $data['code']); // Check si empty
            //On ne met pas le code à null car il est insere dans la table warning
            break;

          case 'remplacement_product': // alphanumeric, empty
            if (!$fieldCheck->isalphaNum($key, $row, $data['code'])) {  // Check si alphnumerique
              $data['remplacement_product'] = null; //On met la value à null si la fonction renvoie false
            };
            break;

          case 'pcb': // entier,  no empty
            if (!$fieldCheck->isInteger($key, $row, $data['code']) || !$fieldCheck->isVide($key, $row, $data['code'])) {
              // Check si entier ou vide
              $data['pcb'] = null; //On met la value à null si la fonction renvoie false
            };
            break;

          case 'prix': // double ou vide
            $data['prix'] = str_replace(",", ".", $data['prix']); // On remplace la virgule par un point
            if (!$fieldCheck->isDouble($key, $data['prix'] , $data['code'])) {  // Check si c'est un double
              $data['prix'] = null; //On met la value à null si la fonction renvoie false
            };
            break;

          case 'uv': // U ou K, no empty
          $data['uv'] = strtoupper($data['uv']);
          if (!$fieldCheck->matchString($key, $data['uv'], $data['code'], ['U','K']) || !$fieldCheck->isVide($key, $data['uv'], $data['code'])) {
            // Check si correspond aux options ou vide
            $data['uv'] = null; //On met la value à null si la fonction renvoie false
          };
          break;

          case 'poids': // double, no empty
            $data['poids'] = str_replace(",", ".", $data['poids']); // On remplace la virgule par un point
            if (!$fieldCheck->isDouble($key, $data['poids'] , $data['code']) || !$fieldCheck->isVide($key, $data['poids'], $data['code'])) {  // Check si c'est un double ou vide
              $data['poids'] = null; //On met la value à null si la fonction renvoie false
            };
            break;

          case 'volume': // double, no empty
            $data['volume'] = str_replace(",", ".", $data['volume']); // On remplace la virgule par un point
            if (!$fieldCheck->isDouble($key, $data['volume'] , $data['code']) || !$fieldCheck->isVide($key, $data['volume'], $data['code'])) {  // Check si c'est un double ou vide
              $data['volume'] = null; //On met la value à null si la fonction renvoie false
            };
            break;

          case 'dlv': // date ou vide
            if (!$fieldCheck->isValidDate($key, $data['dlv'], $data['code']) ) { //Check si le format et le date sont valides
              $data['dlv'] = null; //On met la value à null si la fonction renvoi false
            } else if(!empty($data['dlv'])) {
              // On met la date au format YYY/mm/dd pour insert dans la base
              $data['dlv'] = date_create_from_format('d/m/Y', $data['dlv']);
              $data['dlv'] = date_format($data['dlv'], 'Y-m-d');
            }

            break;

          case 'duree_vie': // entier ou vide
            if (!$fieldCheck->isInteger($key, $row, $data['code'])) {
              // Check si entier ou vide
              $data['duree_vie'] = null; //On met la value à null si la fonction renvoie false
            };
            break;

          case 'gencod': // entier,  no empty
            if (!$fieldCheck->isInteger($key, $row, $data['code']) || !$fieldCheck->isVide($key, $row, $data['code'])) {
              // Check si entier ou vide
              $data['gencod'] = null; //On met la value à null si la fonction renvoie false
            };
            break;

          case 'douanier': // entier,  no empty
            if (!$fieldCheck->isInteger($key, $row, $data['code']) || !$fieldCheck->isVide($key, $row, $data['code'])) {
              // Check si entier ou vide
              $data['douanier'] = null; //On met la value à null si la fonction renvoie false
            };
            break;

          case 'dangereux': // alphanumeric, empty
            if (!$fieldCheck->isalphaNum($key, $row, $data['code'])) {  // Check si alphnumerique
              $data['dangereux'] = null; //On met la value à null si la fonction renvoie false
            };
            break;

          case 'origin_id': // entier ou vide
              // Recherche de l'id dans les tables origins et shortorigins
              $data['origin_id'] = $fieldCheck->searchOrigin($key, $row, $data['code']);
            break;

          case 'tva': // double, no empty
            $data['tva'] = str_replace(",", ".", $data['tva']); // On remplace la virgule par un point
            if (!$fieldCheck->isDouble($key, $data['tva'] , $data['code']) || !$fieldCheck->isVide($key, $data['tva'], $data['code'])) {  // Check si c'est un double ou vide
              $data['tva'] = null; //On met la value à null si la fonction renvoie false
            };
            break;

          case 'cdref': // entier,  no empty
          if (!$fieldCheck->isInteger($key, $row, $data['code']) || !$fieldCheck->isVide($key, $row, $data['code'])) {
            // Check si entier ou vide
            $data['cdref'] = null; //On met la value à null si la fonction renvoie false
          };
          break;

          case 'category_code': // entier, no empty
            if (!$fieldCheck->isInteger($key, $row, $data['code']) || !$fieldCheck->isVide($key, $row, $data['code'])) {
              // Check si entier ou vide
              $data['category_code'] = null; //On met la value à null si la fonction renvoie false
            };
            break;

          case 'subcategory_code': // entier, no empty
            if (!$fieldCheck->isInteger($key, $row, $data['code']) || !$fieldCheck->isVide($key, $row, $data['code'])) {
              // Check si entier ou vide
              $data['subcategory_code'] = null; //On met la value à null si la fonction renvoie false
            };
            break;

          case 'entrepot': // entier, no empty
            if (!$fieldCheck->isInteger($key, $row, $data['code']) || !$fieldCheck->isVide($key, $row, $data['code'])) {
              // Check si entier ou vide
              $data['entrepot'] = null; //On met la value à null si la fonction renvoie false
            };
            break;

          case 'qualification': // P M ou A , no empty
            $data['qualification'] = strtoupper($data['qualification']);
            if (!$fieldCheck->matchString($key, $data['qualification'], $data['code'], ['P','M','A']) || !$fieldCheck->isVide($key, $data['qualification'], $data['code'])) {
              // Check si correspond aux options ou vide
              $data['qualification'] = null; //On met la value à null si la fonction renvoie false
            };
            break;

          case 'couche_palette': // entier ou vide
            if (!$fieldCheck->isInteger($key, $row, $data['code'])) {
              // Check si entier ou vide
              $data['couche_palette'] = null; //On met la value à null si la fonction renvoie false
            };
            break;

          case 'colis_palette': // entier ou vide
            if (!$fieldCheck->isInteger($key, $row, $data['code'])) {
              // Check si entier ou vide
              $data['colis_palette'] = null; //On met la value à null si la fonction renvoie false
            };
            break;

          case 'pieceartk': // entier ou vide ( si uv K no empty) (si uv U vide)
            //TODO Logique
            //debug($data['uv']);
            //die;
            /*if (!$this->isInteger($key, $row, $data['code'])) {
              // Check si entier ou vide
              $data['colis_palette'] = null; //On met la value à null si la fonction renvoie false
            };*/
            break;

          case 'ifls_remplacement': // alphanumeric, empty
            if (!$fieldCheck->isalphaNum($key, $row, $data['code'])) {  // Check si alphnumerique
              $data['ifls_remplacement'] = null; //On met la value à null si la fonction renvoie false
            };
            break;


          case 'assortiment': // entier, no empty
            if (!$fieldCheck->isInteger($key, $row, $data['code']) || !$fieldCheck->isVide($key, $row, $data['code'])) {
              // Check si entier ou vide
              $data['assortiment'] = null; //On met la value à null si la fonction renvoie false
            };
            break;

          case 'brand_id': // (entier ou vide) si code famille = XXXX mettre famille "VIN" | si vide ou "sans marque ou "sans" alert
          //TODO GERER LES LIBELLE DES ORIGINES
          //Verifier dans la table orgines que la valeur existe
            //Si elle existe  $data['origin_id'] = origin.id trouver dans la base

            //Sinon vérifier dans la table shortorgins que la valeur existe
             //Si elle existe et que shortorgins.origin_id est renseigneé alors $data['origin_id'] = shortorgins.origin_id

          //Si elle n'existe nul par l'ajouter dans shortorigins sans lui associer de origin_id, créer un alert origin iconnue
            break;
      }
      };

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
            ->allowEmpty('code');

        $validator
            ->allowEmpty('remplacement_product');

        $validator
            ->allowEmpty('title');

        $validator
            ->allowEmpty('pcb');

        $validator
            ->allowEmpty('prix');

        $validator
            ->allowEmpty('uv');

        $validator
            ->allowEmpty('poids');

        $validator
            ->allowEmpty('volume');

        $validator
            ->allowEmpty('dlv');

        $validator
            ->allowEmpty('duree_vie');

        $validator
            ->allowEmpty('gencod');

        $validator
            ->allowEmpty('douanier');

        $validator
            ->allowEmpty('dangereux');

        $validator
            ->allowEmpty('tva');

        $validator
            ->allowEmpty('cdref');

        $validator
            ->allowEmpty('category_code');

        $validator
            ->allowEmpty('subcategory_code');

        $validator
            ->allowEmpty('entrepot');

        $validator
            ->allowEmpty('supplier');

        $validator
            ->allowEmpty('qualification');

        $validator
            ->allowEmpty('couche_palette');

        $validator
            ->allowEmpty('colis_palette');

        $validator
            ->allowEmpty('pieceartk');

        $validator
            ->allowEmpty('ifls_remplacement');

        $validator
            ->allowEmpty('assortiment');

        $validator
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
