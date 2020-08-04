<?php
namespace App\Controller;

use App\Controller\AppController;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;
use Cake\ORM\TableRegistry;
use App\Utility\FieldCheck;
use App\Utility\CatalogueHelpers;

use Cake\Database\Expression\QueryExpression;

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
        $csvFilePath = "files/test8.csv";
        $csvNbrRows = count(file($csvFilePath));
        $reader = ReaderFactory::create(Type::CSV); // for CSV files
        $reader->setFieldDelimiter('|');
        $reader->open($csvFilePath);

        // Avnt de faire l'importation on réinitialise les champs new et active à 0
        $productSearch = TableRegistry::get('products');
        $productSearch->updateAll(['new' => 0, "active" => 0],'');
        $fieldCheck = new FieldCheck;

        //Lister les varifations du nom de marque CARREFOUR
        //$flipped_Carrefour_variations = array_flip($fieldCheck->brandCarefourVariations());


        // AJOUT SANS CHUNKS
        foreach ($reader->getSheetIterator() as $sheet) {

          foreach ($sheet->getRowIterator() as $key => $productRow) {

            // On renome les keys du array avec les entetes de la table products
            $productRow = $this->renameHeaderArray($productRow);

            //On recherche si le code article existe dans la table products
            $product = $productSearch->find('all')
                                     ->select(['id','remplacement_product'])
                                     ->where(['code' => $productRow['code']]);

            // Si le produit est actif
            if( empty($productRow['remplacement_product']) ){

                $productRow['active'] = '1'; // Set le produit actif
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
            // Si le produit est inactif
          } else {
              $productRow['active'] = '0'; // Set le produit actif
              if ( $product->count() === 1 ) { // Nbr de resultat de le réquete
                //Si il existe on l'ajoute dans la liste des products à update
                $product_id = $product->first()->toArray(); // On récupere l'id du produit
                // Si le code de remplacement est différent on update
                if($product_id['remplacement_product'] <> $productRow['remplacement_product']) {
                $productRow = array_merge($product_id, $productRow); // On ajoute l'id à l'array du product
                $updateProductList[$key] = $productRow;
                }
              } else {  // Si l'article est nouveau et inactif(avec un code de remplacement)
                // On ajoute l'article inactif
                $insertProductList[$key] = $productRow;
              }

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

        // Check si le type est valide
        $validType = ['catalogue','boncommande'];
        if(!in_array($type, $validType)) {
          debug('Wrong type: catalogue ou boncommande');
          die;
        }

        $emptyXls = 'files/empty.xlsx';
        $exportFile = 'files/'.time().'.xlsx';
        if (!copy($emptyXls, $exportFile)) {
          echo "failed to copy";
          return false;
        }

        $finalFile = 'files/'.$type.'-'.time().'.xlsx';
        rename($exportFile, $finalFile);
        //$this->generateSommaire($finalFile);
        if($this->generateExcel($finalFile, $type)) {
          debug('Generate '.$type);
        } else {
            debug('Error');
        }
        die;


    }





    /**
     * generateExcel method
     * A partir des articles dans la table products, générer le fichier excel Catalogue et bon de commande
     * @param string| $file = Path du fichier Excel
     * @param string| $type = catalogue ou boncommande
     * @return true| Return true quand le fichier est généré
     */
    public function generateExcel($file, $type)
    {
      // Register les tables suivantes
      $subcategoriesList = TableRegistry::get('subcategories');
      $categoriesList = TableRegistry::get('categories');
      $storesList = TableRegistry::get('stores');
      $originsList = TableRegistry::get('origins');

      // Initialisation de l'ecriture sur le fichier excel
      $catalogueHelpers= new CatalogueHelpers;
      $writer = WriterFactory::create(Type::XLSX); // for XLSX files
      $writer->openToFile($file);

      //Si c'est un catalogue on genere le sommaire
      if($type == 'catalogue') {
        // Créé la feuille Page de garde
        $sheet = $writer->getCurrentSheet();
        $sheet->setName('Garde');
        $writer->addRows($catalogueHelpers->generateGarde());

        // Créé la feuille Sommaire
        $sommaireArrays = $catalogueHelpers->generateSommaire();
        $newSheet = $writer->addNewSheetAndMakeItCurrent();
        $sheet = $writer->getCurrentSheet();
        $sheet->setName('ÉPICERIE,LIQUIDE,DPH,BAZAR');
        $writer->addRows($sommaireArrays[1]);

        $newSheet = $writer->addNewSheetAndMakeItCurrent();
        $sheet = $writer->getCurrentSheet();
        $sheet->setName('SURGELES');
        $writer->addRows($sommaireArrays[2]);

        $newSheet = $writer->addNewSheetAndMakeItCurrent();
        $sheet = $writer->getCurrentSheet();
        $sheet->setName('FRAIS, ULTRA FRAIS');
        $writer->addRows($sommaireArrays[3]);
      }

      //Si c'est un catalogue on genere le sommaire
      if($type == 'boncommande') {
        // Populate le sommaire
        $sheet = $writer->getCurrentSheet();
        $sheet->setName('Commande');
        $writer->addRows($catalogueHelpers->generateCommande());
      }

      // Créé la nouvelle sheet le catalogue ou le bon de commande
      $newSheet = $writer->addNewSheetAndMakeItCurrent();
      $sheet = $writer->getCurrentSheet();
      $sheet->setName(ucfirst($type));

      // Définition des entetes
      if($type == 'catalogue') {
        $header = $catalogueHelpers->catalogueHeaders;
      } else if ($type == 'boncommande') {
        $header = $catalogueHelpers->boncommandeHeaders;
      }
      //Creation des ligne d'entetes
      foreach ($header as $value) {
        //Ajoute la date du premier jour du mois pour
        //la colonnes DLV indicative (Catalogue uniquement)
        foreach ($value as &$str) {
          $str = str_replace('au #1erduMois#', 'au '.date("01/m/Y"), $str);
        }
        $writer->addRow($value);
      }




      //Boucle des stores
      $stores = $storesList->find('all');
      foreach($stores as $store) {
            // CATALOGUE : on insert la ligne avec le nom du store
            if($type == 'catalogue') {
              $writer->addRowWithStyle( ['','','','','','',$store->title],
                                        $catalogueHelpers->getTitleStyle(36, 'FFC000'));
            }

            //Boucle des catégories
            $categories = $categoriesList->find('all')->where(['store_id =' => $store->id])
                                                      ->order(['code' => 'ASC']);
            foreach($categories as $category) {

                  //Boucle des sous catégories
                  $subcategories = $subcategoriesList->find('all')->where(['category_id =' => $category->id])
                                                                  ->order(['code' => 'ASC']);
                  // Verification pour la subcat produits bio
                  $listProductAjouter = false;
                  foreach($subcategories as $subcategory) {

                    // Si la subcat est "Produit bio" et qu'elle a deja été ajouté on passe à la subcat suivante
                    if($subcategory->title == 'PRODUITS BIOLOGIQUES ET DIÉTÉTIQUES' && $listProductAjouter) {
                      continue;
                    }
                    // List des subcat ID pour la requette
                    if(in_array($subcategory->id, $catalogueHelpers->subcatBio_ids)) { // Si produits bio
                      $subcat_ids = ['210','211','212','213','214','215','216','217','218','219'];
                      $listProductAjouter = true;
                    } else { // Si autre que produits bio
                      $subcat_ids = [$subcategory->id];
                    }

                    //Boucle des articles
                    $products = $this->Products->find('all')
                                               ->where(['Products.active =' => 1, 'Products.subcategory_id IN' => $subcat_ids])
                                               ->contain(['origins','categories','subcategories','brands', 'Photos' ]);          

                    // On verifie si il y a des produits dans la sousCategorie  et que le type est catalogue
                    if($products->count()>0 && $type == 'catalogue') {
                      $writer->addRowWithStyle(
                          ['','','','','','',$subcategory->title], $catalogueHelpers->getTitleStyle(22, '00B050'));
                    }


                    $listQualiM = []; // Initialisation des articles avec le code qualification M
                    $listQualiP = []; // Initialisation des articles avec le code qualification P
                    $listQualiA = []; // Initialisation des articles avec le code qualification A
                    foreach($products as $row) {
                      // Genere la ligne produit en fonction du type Catalogue ou bon de commande
                      $productRow =  $catalogueHelpers->generateRow($row, $type);

                      // On ajoute la ligne du produit dans un tableau en fonction de la qualification
                      switch ($row->qualification) {
                        case 'P':
                          $listQualiP[] = $productRow;
                          break;

                        case 'M':
                          $listQualiM[] = $productRow;
                          break;

                        default:
                          $listQualiA[] = $productRow;
                          break;
                      }

                    }

                    // Tri par marque pour les MDD
                    $listQualiM = $catalogueHelpers->sortMDDMarques($listQualiM);
                    // Orginiser les tableaux 1er prix, MDD, Marques nationale
                    $listeProducts = $catalogueHelpers->orderProduct($listQualiP, $listQualiM, $listQualiA);

                    //foreach qui va ajouter les lignes marques et produits au fichier Excel
                    foreach ($listeProducts as $key => $value) {
                      //Get le style en fonction de la marque
                      $style = $catalogueHelpers->renderStyle($value['Marque']);
                      if ($type == 'catalogue') {
                        //if(empty($value['Marque'])){ $value['Marque'] = 'Autres marques';} // Si la marque n'existe pas on cree autres marques
                        if($value['Marque'] !== 'VIN'){ // On créé la ligne Marque uf pour la marque VIN
                          $writer->addRowWithStyle(['','','','','','',$value['Marque']], $style['Marque']);
                        }
                      }
                      //On boucle sur les ligne produit associé à la marque
                      foreach ($value['Produits'] as $key => $article) {
                        $writer->addRowWithStyle($article, $style['Product']);
                      }
                    }

                  } //Foreach souscategorie end

            } //Foreach Categorie end

      } //Foreach Store end

      // pour le bon de commande, on ajoute à la fin du Excel tous les articles inactifs sans trie particulier
      if ($type == 'boncommande') {
        // Requete tous les produits non actifs
        $products = $this->Products->find('all')->where(['Products.active =' => 0])->contain(['origins']);
        // Ajouter tous les produits non actif
        foreach ($products as $row) {
          $productRow =  $catalogueHelpers->generateRow($row, $type);
          $writer->addRow($productRow);
        }

      }
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

    /**
     * updateSansMarques method
     * Mettre a jour via une table de correspondance CSV les articles sans marques ['Code produit', 'Libelle']
     * @return true| Return true quand l'update est terminé
     */
    public function updateOrigins()
    {
      $time_start = microtime(true);
      $csvFilePath = "files/updateproductorigin.csv";
      //$csvNbrRows = count(file($csvFilePath));
      $reader = ReaderFactory::create(Type::CSV); // for CSV files
      $reader->setFieldDelimiter('|');
      $reader->open($csvFilePath);

      foreach ($reader->getSheetIterator() as $sheet) {

        foreach ($sheet->getRowIterator() as $key => $productRow) {
          $codeproduit = $productRow[0];
          $originTitle = utf8_encode ($productRow[1]);
          //debug($originTitle);

          $origins = TableRegistry::get('origins');
          $origins = $origins->find('all')
                            ->where(['title =' => $originTitle])
                            ->first();
//debug($origins);

          if(is_null($origins)){
            $origins->id = NULL;
          }

//debug($origins->id);
//die;
            $product =  $this->Products->find('all')
                          ->where(['code =' => $codeproduit]);

            if($product->update()->set(['origin_id' => $origins->id])->where(['code' => $codeproduit])->execute()) {
            } else {
              Debug('Impossible de mettre à jour cet article:'.$codeproduit);
            }



        }
      }
          debug('Mise à jour des marques OK');
    }


    /**
     * deletedproducts method
     * recherche des prorduits sur disparu dans la base sogedial et les passé en supprimé dans notre base
     */
    public function deletedproducts()
    {

      $csvFilePath = "files/test8.csv";
      $csvNbrRows = count(file($csvFilePath));
      $reader = ReaderFactory::create(Type::CSV); // for CSV files
      $reader->setFieldDelimiter('|');
      $reader->open($csvFilePath);

      $productList = []; // array de tous les articles du fichier Sogedial
      
      foreach ($reader->getSheetIterator() as $sheet) {

        foreach ($sheet->getRowIterator() as $key => $productRow) {
          $productList[] = $productRow[0];
        }

      }

      $reader->close();
      //var_dump($productList);

      // Get tous les codes article présent dans notre base et non présent dans la base Sogedial
      // qui sont inactif et n'ont rien dans remplacement produit
      $query = $this->Products->find();
      $query->where(['code NOT IN' => $productList, 'remplacement_product' => '', 'active' => 0]);
      $number = $query->count();

      echo 'Nombre d\'articles manquant dans le catalogue: '.$number;
      echo '<br /><br />Liste de codes articles:<br /><table> ';
      foreach ($query as $data){
        echo '<tr><td>'.$data->code.'</td><td>'.$data->title.'</td></tr>';
      }
      echo '</table>';

      /* UNCOMMENT pour update les produits manquant
      
      $query = $this->Products->query();
      $query->update()
      ->set(['remplacement_product ' => 'Supprime'])
      ->where(['code NOT IN' => $productList, 'remplacement_product' => '', 'active' => 0])
      ->execute();*/

      die;
      
    }

    /**
     * CheckReplaceProduct method
     * Check si les codes articles de remplacement existent bien dans la colonne article. 
     * Si existe pas mettre "supprimer" dans article de remplacement à la place du code erroné et inactive.
     */
    public function CheckReplaceProduct()
    {

      $query = $this->Products->find();
      foreach ($query as $data){

        if( $data->remplacement_product != ''){
          if ( $data->remplacement_product != 'Supprime' && $data->remplacement_product != 'NPC') {
            
                $check = $this->Products->find()
                ->where(['code' => $data->remplacement_product])->count();
                if ($check != 1){
                  echo "'".$data->code."',";
                }
                
          }
        }
      
      }

      die;
      
    }

}
