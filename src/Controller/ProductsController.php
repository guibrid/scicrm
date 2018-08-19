<?php
namespace App\Controller;

use App\Controller\AppController;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;
use Cake\ORM\TableRegistry;
use App\Utility\FieldCheck;
use App\Utility\CatalogueHelpers;

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
        $csvFilePath = "files/xxx.csv";
        $csvNbrRows = count(file($csvFilePath));
        $reader = ReaderFactory::create(Type::CSV); // for CSV files
        $reader->setFieldDelimiter('|');
        $reader->open($csvFilePath);

        // Avnt de faire l'importation on réinitialise les champs new et active à 0
        $productSearch = TableRegistry::get('products');
        $productSearch->updateAll(['new' => 0, "active" => 0],'');

        $fieldCheck = new FieldCheck;

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
                // C'est un isert donc le produit est nouveau. On definit le champs new à 1
                $productRow['new'] = '1';
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
        debug($listErrors);
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
            //$this->generateSommaire($finalFile);
            if($this->generateCatalogue($finalFile)) {
              debug('Generate catalogue');
              debug('- Col A : Convertir en Nombre');
              debug('- Col L : Formule = B * I');
              debug('- Col M : Formule = B * P');
              debug('- Col N : Formule = B * Q');
              debug('- Col O : Formule = SI(L9<>"Au cours"|(J9*N9)|"")');
            } else {
                debug('Error');
              }

            break;

          case 'commande':
            // code...
            $finalFile = 'files/bonCommande-'.time().'.xlsx';
            rename($exportFile, $finalFile);
            //$this->generateSommaire($finalFile);
            $this->generateBonCommande($finalFile);
            break;

          default:

            break;
        }
        die;


    }

    /**
     * generateSommaire method
     * Genere array des subcategories classé par store et subcategorie.Title
     * @return array| Return le tableau du sommaire classé
     */
    public function generateSommaire()
    {
      $sommaire = array();
          $subcategoriesList = TableRegistry::get('subcategories');
          $subcategories = $subcategoriesList->find('all')
                                             ->contain(['Categories'])
                                             ->order(['Categories.store_id' => 'ASC', 'subcategories.title' => 'ASC']);;
          foreach($subcategories as $key =>$subcategory) {
            $sommaire[] = [$subcategory['title']];
          }
      return $sommaire;
    }

    /**
     * generateCatalogue method
     * A partir des articles dans la table products, générer le fichier excel Catalogue
     * @param string| $file = Path du fichier Excel
     * @return true| Return true quand le fichier est généré
     */
    public function generateBonCommande($file)
    {
      $writer = WriterFactory::create(Type::XLSX); // for XLSX files
      $writer->openToFile($file);
      $products = $this->Products->find('all')->contain(['Origins']);
      //debug($products);

      foreach ($products as $row) {
        //debug();
        $origine = $row->origin['title'];
        //die;
        // Formatage de la date dlv
        if(!empty($row->dlv)){  $row->dlv = date_format($row->dlv, 'd-m-Y'); }
        $ligne = [
          $row->code , $row->remplacement_product, $row->title, $row->pcb, $row->prix,$row->uv,$row->poids, $row->volume,
          $row->dlv, $row->duree_vie, $row->gencod,(string)$row->douanier,'',$row->dangereux,$origine];
        //debug($ligne);
        //die;
          $writer->addRow($ligne);
      }
      $writer->close();

      return true;
    }

    /**
     * generateCatalogue method
     * A partir des articles dans la table products, générer le fichier excel Catalogue
     * @param string| $file = Path du fichier Excel
     * @return true| Return true quand le fichier est généré
     */
    public function generateCatalogue($file)
    {
      $catalogueHelpers= new CatalogueHelpers;
      $writer = WriterFactory::create(Type::XLSX); // for XLSX files
      $writer->openToFile($file);

      // Populate le sommaire
      $sheet = $writer->getCurrentSheet();
      $sheet->setName('Sommaire');
      $writer->addRows($this->generateSommaire());

      // Créé la nouvelle sheet pour le sommaire
      $newSheet = $writer->addNewSheetAndMakeItCurrent();
      $sheet = $writer->getCurrentSheet();
      $sheet->setName('Catalogue');

      foreach ($catalogueHelpers->catalogueHeaders as $value) {
        //Ajoute la date du premier jour du mois pour la colonnes DLV indicative
        foreach ($value as &$str) {
          $str = str_replace('au #1erduMois#', 'au '.date("01/m/Y"), $str);
        }
        $writer->addRow($value);
      }

      $subcategoriesList = TableRegistry::get('subcategories');
      $categoriesList = TableRegistry::get('categories');
      $storesList = TableRegistry::get('stores');

      // Ajouter la boucle des stores
      $stores = $storesList->find('all');
      foreach($stores as $store) {
            $writer->addRowWithStyle(
                  ['','','','','','',$store->title],
                  $catalogueHelpers->getTitleStyle(22, 'FFC000'));
            // Ajout des catégories
            $categories = $categoriesList->find('all')
                                         ->where(['store_id =' => $store->id]);
            foreach($categories as $category) {
                  // Ajout des sous catégories
                  $subcategories = $subcategoriesList->find('all')
                                                     ->where(['category_id =' => $category->id]);
                  foreach($subcategories as $subcategory) {

                        // Ajout des articles
                        $products = $this->Products->find('all')
                                                   ->where(['Products.active =' => 1, 'Products.subcategory_id =' => $subcategory->id])
                                                   ->contain(['origins','categories','subcategories','brands']);
                        // On verifie si il y a des produits dans la sousCategorie pour afficher le titre
                        if($products->count()>0) {
                          $writer->addRowWithStyle(
                              ['','','','','','',$subcategory->title], $catalogueHelpers->getTitleStyle(16, '000000'));
                        }

                        $listQualiM = []; // Initialisation des articles avec le code qualification M
                        $listQualiP = []; // Initialisation des articles avec le code qualification P
                        $listQualiA = []; // Initialisation des articles avec le code qualification A
                        foreach($products as $row) {

                          // Formatage de la date dlv
                          if(!empty($row->dlv)){  $row->dlv = date_format($row->dlv, 'd-m-Y'); }
                          // Formatage du Tarif
                          if(empty($row->prix)){  $row->prix = 'Au cours'; }
                          // Formatage colonne New
                          if($row->new == 1){  $row->new = 'New'; } else { $row->new = ''; }
                          // Formatage colonne Maarque pour les vins
                          if($row->Brands['title'] == 'VIN'){  $row->Brands['title'] = '-'; }

                          // Information exporter pour chaque produit
                          $ligne = [
                            $row->code , '', '', $row->new, $row->duree_vie, $row->dlv,
                            $row->title, $row->Brands['title'], $row->pieceartk,
                            $row->pcb, $row->prix, $row->uv, '', '', '', '',
                            $row->poids, $row->volume, (int)$row->couche_palette,
                            (int)$row->colis_palette, (string)$row->douanier,
                            $row->qualification, $row->gencod];

                            switch ($row->qualification) {
                              case 'P':
                                $listQualiP[] = $ligne;
                                break;

                              case 'M':
                                $listQualiM[] = $ligne;
                                break;

                              default:
                                $listQualiA[] = $ligne;
                                break;
                            }

                        }

                        // Tri par marque pour les MDD
                        $listQualiM = $catalogueHelpers->sortMDDMarques($listQualiM);
                        // Orginiser les tableaux 1er prix, MDD, Marques nationale
                        $listeProducts = array_merge($catalogueHelpers->getProductsToDisplay($listQualiM, 'M'),
                                                     $catalogueHelpers->getProductsToDisplay($listQualiA));
                        $listeProducts = array_merge($catalogueHelpers->getProductsToDisplay($listQualiP),$listeProducts);

                        //foreach qui va ajouter les lignes marques et produits au fichier Excel
                        foreach ($listeProducts as $key => $value) {
                          //Get le style en fonction de la marque
                          $style = $catalogueHelpers->renderStyle($value['Marque']);

                          //if(empty($value['Marque'])){ $value['Marque'] = 'Autres marques';} // Si la marque n'existe pas on cree autres marques
                          if($value['Marque'] !== 'VIN'){ // On créé la ligne Marque uf pour la marque VIN
                            $writer->addRowWithStyle(['','','','','','',$value['Marque']], $style['Marque']);
                          }
                          //On boucle sur les ligne produit associé à la marque
                          foreach ($value['Produits'] as $key => $article) {
                            $writer->addRowWithStyle($article, $style['Product']);
                          }
                        }

                  } //Foreach souscategorie end

            } //Foreach Categorie end

      } //Foreach Store end
      $writer->close();

      return true;
    }

    /**
     * updateSansMarques method
     * Mettre a jour via une table de correspondance CSV les articles sans marques ['Code produit', 'Libelle']
     * @return true| Return true quand l'update est terminé
     */
    public function updateSansMarques()
    {
      $time_start = microtime(true);
      $csvFilePath = "files/updatesansmarques.csv";
      //$csvNbrRows = count(file($csvFilePath));
      $reader = ReaderFactory::create(Type::CSV); // for CSV files
      $reader->setFieldDelimiter('|');
      $reader->open($csvFilePath);

      foreach ($reader->getSheetIterator() as $sheet) {

        foreach ($sheet->getRowIterator() as $key => $productRow) {
          $productRow[1] = utf8_encode ($productRow[1]);
          $brands = TableRegistry::get('brands');
          $brands = $brands->find('all')
                            ->where(['title =' => 'pipicaca'])
                            ->first();

          if(!is_null($brands)){


            $product =  $this->Products->find('all')
                          ->where(['code =' => $productRow[0]]);

            if($product->update()->set(['brand_id' => $brands->id])->where(['code' => $productRow[0]])->execute()) {
            } else {
              Debug('Impossible de mettre à jour cet article:'.$productRow[0]);
            }

          } else {
            Debug('La marque '.$productRow[1].' N existe pas');
          }


        }
      }
          debug('Mise à jour des marques OK');
    }

}
