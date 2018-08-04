<?php
namespace App\Controller;

use App\Controller\AppController;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\Style\Color;
use Cake\ORM\TableRegistry;
use App\Utility\FieldCheck;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 *
 * @method \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductsController extends AppController
{
  //Liste des entetes de colonne du ficher CSV lors de l'importation
  private $headers = ['code',
            'remplacement_product',
            'title',
            'pcb',
            'prix',
            'uv',
            'poids',
            'volume',
            'dlv',
            'duree_vie',
            'gencod',
            'douanier',
            'dangereux',
            'origin_id',
            'tva',
            'cdref',
            'category_id',
            'subcategory_id',
            'entrepot',
            'supplier',
            'qualification',
            'couche_palette',
            'colis_palette',
            'pieceartk',
            'ifls_remplacement',
            'assortiment',
            'brand_id'];


    private $catalogueHeaders = [
      ['Code',	  'Cde',	'New',	'Durée de',	'DLV',	'Désignation des marchandises',	'Marque',	'Piéces',	'PCB',	'Tarif',	'UV',	'Unités',	'Poids',	'Volume',	'Montant',	'Poids',	'Volume',	'Colis par',	'Colis par', 'Code', 'Q', 'GENCOD'],
      ['Article',	'Colis','', 'vie jours',	'Indicative','', '', 'Article', 'Colis','', '', '', 'Cde', 'Cde', 'Cde', 'Colis',	'Colis', 'couche',	'Palette',	'Douanier', '', ''],
      ['', '', '', 'Indicative',	'au 1er du mois', '', '',	'Kilo']
    ];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Origins', 'Brands']
        ];
        $products = $this->paginate($this->Products);

        $this->set(compact('products'));
    }

    /**
     * View method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $product = $this->Products->get($id, [
            'contain' => ['Origins', 'Brands', 'Shortbrands', 'Shortorigins']
        ]);

        $this->set('product', $product);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $product = $this->Products->newEntity();
        if ($this->request->is('post')) {
            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $origins = $this->Products->Origins->find('list', ['limit' => 200]);
        $brands = $this->Products->Brands->find('list', ['limit' => 200]);
        $shortbrands = $this->Products->Shortbrands->find('list', ['limit' => 200]);
        $shortorigins = $this->Products->Shortorigins->find('list', ['limit' => 200]);
        $this->set(compact('product', 'origins', 'brands', 'shortbrands', 'shortorigins'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $code = null)
    {
        $product = $this->Products->get($id, [
            'contain' => ['Shortbrands', 'Shortorigins']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }

        // Faire la requete qui liste tous les codes articles de la table warnings

          $warnings= TableRegistry::get('warnings');
          $warningList = $warnings->find()->where(['product_code' => $code]);


        $origins = $this->Products->Origins->find('list');
        $brands = $this->Products->Brands->find('list');
        $categories = $this->Products->Categories->find('list');
        $subcategories = $this->Products->Subcategories->find('list');
        $shortbrands = $this->Products->Shortbrands->find('list');
        $shortorigins = $this->Products->Shortorigins->find('list');
        $this->set(compact('product', 'origins', 'brands', 'shortbrands', 'shortorigins', 'warningList', 'categories', 'subcategories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->Products->get($id);
        if ($this->Products->delete($product)) {
            $this->Flash->success(__('The product has been deleted.'));
        } else {
            $this->Flash->error(__('The product could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * updateBase method
     *
     */
    public function updateBase()
    {
        $time_start = microtime(true);
        $csvFilePath = "files/test7.csv";
        $csvNbrRows = count(file($csvFilePath));
        $reader = ReaderFactory::create(Type::CSV); // for CSV files
        $reader->setFieldDelimiter('|');
        $reader->open($csvFilePath);

        $productSearch = TableRegistry::get('products');

        $chunk = 1000; // for example
        //debug($csvNbrRows);
        //debug($chunk);
        $loop = ceil($csvNbrRows / $chunk);
        //debug($loop);
        $fieldCheck = new FieldCheck;

        // AJOUT AVEC CHUNKS
        /*foreach ($reader->getSheetIterator() as $sheet) {

          // Faire boucle de 1000 ligne
          $updateProductList = [];
          $insertProductList = [];

          foreach ($sheet->getRowIterator() as $key => $productRow) {

            if( $key === $chunk){
              Debug($chunk);

              // Si l'array des nouveaux articles n'est pas vide, on insert les produits
              if(!empty($insertProductList)){
                $this->insertProductList($insertProductList);
              }

              // Si l'array des articles à mettre à jour n'est pas vide, on update
              if(!empty($updateProductList)){
                $this->updateProductList($updateProductList);
              }
              $chunk = $chunk + 1000;
              $updateProductList = [];
              $insertProductList = [];
            } else {
              // on ajoute les rows a l'array d'insert ou d'update
              // On renome les keys du array avec les entetes de la table products
              $productRow = $this->renameHeaderArray($productRow);

              // Si le produit est actif on l'ajoute ou on l'update dans la base
              if($fieldCheck->checkActiveProduct($productRow['remplacement_product'])){

                //On recherche si le code article existe dans la table products
                $product = $productSearch->find('all')
                                         ->select(['id'])
                                         ->where(['code' => $productRow['code']]);

                if ( $product->count() === 1 ) { // Nbr de resultat de le réquete
                  //Si il existe on l'ajoute dans la liste des products à update
                  $product_id = $product->first()->toArray(); // On récupere l'id du produit
                  $productRow = array_merge($product_id, $productRow); // On ajoute l'id à l'array du product
                  $updateProductList[$key] = $productRow;
                } else {
                  //Si il n'existe pas on l'ajoute dans la liste des products à insert
                  $insertProductList[$key] = $productRow;
                }

              }

            }

          }

        }*/// FIN avec CHUNKS

        // AJOUT SANS CHUNKS
        foreach ($reader->getSheetIterator() as $sheet) {

          foreach ($sheet->getRowIterator() as $key => $productRow) {

            // On renome les keys du array avec les entetes de la table products
            $productRow = $this->renameHeaderArray($productRow);

              //On recherche si le code article existe dans la table products
              $product = $productSearch->find('all')
                                       ->select(['id'])
                                       ->where(['code' => $productRow['code']]);

              if ( $product->count() === 1 ) { // Nbr de resultat de le réquete
                //Si il existe on l'ajoute dans la liste des products à update
                $product_id = $product->first()->toArray(); // On récupere l'id du produit
                $productRow = array_merge($product_id, $productRow); // On ajoute l'id à l'array du product
                $updateProductList[$key] = $productRow;
              } else {
                //Si il n'existe pas on l'ajoute dans la liste des products à insert
                $insertProductList[$key] = $productRow;
              }

          }

          // Si l'array des nouveaux articles n'est pas vide, on insert les produits
          if(!empty($insertProductList)){
            $this->insertProductList($insertProductList);
          }

          // Si l'array des articles à mettre à jour n'est pas vide, on update
          if(!empty($updateProductList)){
            $this->updateProductList($updateProductList);
          }

          // Fin de la boucle des 1000 lignes

        }// FIN SANS CHUNKS



        $reader->close();

        //TODO DELETE tous les warnings des products inactifs
        //DELETE w FROM `warnings` w INNER JOIN products e ON w.product_code = e.code WHERE active = 0

        $time_end = microtime(true);
        //dividing with 60 will give the execution time in minutes otherwise seconds
        $execution_time = ($time_end - $time_start)/60;
        //execution time of the script
        echo '<p>Total Execution Time: '.$execution_time.' Mins</p>';
        echo "<p>Peak memory:", (memory_get_peak_usage(true) / 1024 / 1024), " MB</p>";

    }

    /**
     * renameHeaderArray method
     * Renomer les key numériques du array des produits avec les entetes de la base de données
     * @param array| $array = Liste des products
     * @return array| retourne le tableau des produits avec les key renomées
     */
    private function renameHeaderArray($array)
    {
      $renamedKeyArray = [];
      foreach($array as $key => $value) {
        $renamedKeyArray[$this->headers[$key]] = $value;
      }
      return $renamedKeyArray;
    }

    /**
     * insertProductList method
     * Insert les nouveaux produits dans la base de données
     * @param array| $array = Liste des products
     * @return true|false retourne true si l'enregistrement c'est bien déroulé
     */
    private function insertProductList($array)
    {
      $product = $this->Products->newEntity();
      $product = $this->Products->patchEntities($product, $array);
      if ($this->Products->saveMany($product)) {
          $this->Flash->success(__('Les ajouts de nouveaux produits ont été effectué avec succès.'));
      } else {
        //Affiche la liste des errors d'insertion si il y en a
        foreach($product as $error) {  Debug($error->errors()); }
      }
    }

    /**
     * updateProductList method
     * update les produits déjà existant dans la base de données
     * @param array| $array = Liste des products à update
     * @return true|false retourne true si l'enregistrement c'est bien déroulé
     */
    private function updateProductList($array)
    {
      // On créé un array qui liste tous les ids des produits à updates
      foreach($array as $key => $value) {
        $liste_ids[] = $value['id'];
      }

      // Requete qui récupère toutes les données des produits à update
      $product_ids = $this->Products->find('all')->where(['id IN' => $liste_ids])->toArray();
      $productsToUpdates = $this->Products->patchEntities($product_ids, $array);
      // On fait une boucle sur les product à update pour les faire 1 par 1
      foreach ($productsToUpdates as $product) {
          if (!$this->Products->save($product)) {
                foreach($product as $error) {
                  $listErrors[] = $error->errors(); // On enregistre les errors dans un array
                }
          }
      }
      // Error ou succés
      if (isset($listErrors)) { // On affiche les erreurs si il y en a
        echo $listErrors;
      } else {
        $this->Flash->success(__('Les mises à jour des produits ont été effectué avec succès.'));
      }

    }

    /**
     * Liste Warnings method
     *
     */
    public function listeWarnings()
    {
      $this->paginate = [
          'contain' => ['Origins', 'Brands']
      ];

      // Faire la requete qui liste tous les codes articles de la table warnings
      $warningsSearch = TableRegistry::get('warnings');
      $warningsQuery = $warningsSearch->find()->select('product_code');

      // Requete des produits en Warnings
      $products = $this->Products->find()
      ->hydrate(false)
      ->join([
          'table' => 'warnings',
          'alias' => 'w',
          'type' => 'LEFT',
          'conditions' => 'w.product_code = products.code',
      ])
      ->select(['Products.id','Products.code','Products.active','w.title','w.value'])
      ->where(['w.product_code IN' => $warningsQuery,'Products.active' => 1]);

      $this->set(compact('products'));
    }

    /**
     * Export method
     *
     * @return \Cake\Http\Response|void
     */
    public function export($type = null)
    {


        $emptyXls = 'files/empty.xlsx';
        $exportFile = 'files/'.time().'.xlsx';
        if (!copy($emptyXls, $exportFile)) {
          echo "failed to copy";
        }

        switch ($type) {
          case 'catalogue':
            // code...
            $finalFile = 'files/catalogue-'.time().'.xlsx';
            rename($exportFile, $finalFile);
            $this->generateCatalogue($finalFile);
            debug('Generate catalogue');
            break;

          default:
            // code...
            debug('Action inconnue');
            break;
        }
        die;


    }

    /**
     * Export method
     *
     * @return \Cake\Http\Response|void
     */
    public function generateCatalogue($file)
    {

      $styleCategorie = (new StyleBuilder())
        ->setFontBold()
        ->setFontSize(22)
        ->setFontColor(Color::ORANGE)
        ->setShouldWrapText(false)
        ->build();

      $stylesubCategorie = (new StyleBuilder())
        ->setFontBold()
        ->setFontSize(16)
        ->setFontColor(Color::BLACK)
        ->setShouldWrapText(false)
        ->build();

      $writer = WriterFactory::create(Type::XLSX); // for XLSX files
      $writer->openToFile($file);

      foreach ($this->catalogueHeaders as $value) {
        $writer->addRow($value);
      }

      $subcategoriesList = TableRegistry::get('subcategories');
      $categoriesList = TableRegistry::get('categories');

      // Ajout des catégories
      $categories = $categoriesList->find('all');
      foreach($categories as $category) {
            //debug($categories);
            $writer->addRow(['']);
            $writer->addRow(['']);
            $writer->addRowWithStyle([$category->title], $styleCategorie);

            // Ajout des sous catégories

            $subcategories = $subcategoriesList->find('all')
                                               ->where(['category_id =' => $category->id]);
            foreach($subcategories as $subcategory) {
                  $writer->addRowWithStyle([$subcategory->title], $stylesubCategorie);
                  // Ajout des articles
                  $products = $this->Products->find('all')
                                             ->where(['Products.active =' => 1, 'Products.subcategory_id =' => $subcategory->id])
                                             ->contain(['origins','categories','subcategories','brands']);
                  foreach($products as $row) {
                    // Formatage de la date dlv
                    if(!empty($row->dlv)){  $row->dlv = date_format($row->dlv, 'd-m-Y'); }

                    // Information exporter pour chaque produit
                    $ligne = [
                      $row->code ,
                      '',
                      '',
                      $row->duree_vie,
                      $row->dlv,
                      $row->title,
                      $row->Brands['title'],
                      $row->pieceartk,
                      $row->pcb,
                      $row->prix,
                      $row->uv,
                      '',
                      '',
                      '',
                      '',
                      $row->poids,
                      $row->volume,
                      '',
                      '',
                      (string)$row->douanier,
                      $row->qualification,
                      $row->gencod];


                      /*
                       $row->remplacement_product, $row->title, $row->pcb , $row->prix,
                    $row->uv, $row->poids, $row->volume, $row->dlv, $row->duree_vie, $row->gencod, (string)$row->douanier,
                    $row->dangereux, $row->Origins['title'], $row->tva, $row->cdref, $row->Categories['code'],
                    $row->Categories['title'], $row->Subcategories['code'], $row->Subcategories['title'],
                    $row->entrepot, $row->supplier, $row->qualification, $row->couche_palette, $row->colis_palette,
                    $row->pieceartk, $row->ifls_remplacement, $row->assortiment, $row->Brands['title']];*/
                    // Ajout de la ligne au fichier Excel
                    $writer->addRow($ligne);

                  }
                  $writer->addRow(['']);
            }
      }
      $writer->close();
    }
}
