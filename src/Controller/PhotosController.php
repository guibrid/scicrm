<?php
namespace App\Controller;

use App\Controller\AppController;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Cake\ORM\TableRegistry;

/**
 * Photos Controller
 *
 * @property \App\Model\Table\PhotosTable $Photos
 *
 * @method \App\Model\Entity\Photo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PhotosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Products']
        ];
        $photos = $this->paginate($this->Photos);

        $this->set(compact('photos'));
    }

    /**
     * View method
     *
     * @param string|null $id Photo id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $photo = $this->Photos->get($id, [
            'contain' => ['Products']
        ]);

        $this->set('photo', $photo);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $photo = $this->Photos->newEntity();
        if ($this->request->is('post')) {
            $photo = $this->Photos->patchEntity($photo, $this->request->getData());
            if ($this->Photos->save($photo)) {
                $this->Flash->success(__('The photo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The photo could not be saved. Please, try again.'));
        }
        //$products = $this->Photos->Products->find('list', ['limit' => 200]);
        $this->set(compact('photo'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Photo id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $photo = $this->Photos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $photo = $this->Photos->patchEntity($photo, $this->request->getData());
            if ($this->Photos->save($photo)) {
                $this->Flash->success(__('The photo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The photo could not be saved. Please, try again.'));
        }
        $products = $this->Photos->Products->find('list', ['limit' => 200]);
        $this->set(compact('photo', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Photo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $photo = $this->Photos->get($id);
        if ($this->Photos->delete($photo)) {
            $this->Flash->success(__('The photo has been deleted.'));
        } else {
            $this->Flash->error(__('The photo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Import method
     *
     * 
     */
    public function import()
    {
        $reader = ReaderFactory::create(Type::CSV); // for CSV files
        $reader->setFieldDelimiter('|');
        $reader->open('files/photos.csv');
        $i = 0;
        foreach ($reader->getSheetIterator() as $sheet) {
  
          foreach ($sheet->getRowIterator() as $key => $photosRow) {
            $i++;
  
            $photosRow['code'] = trim($photosRow[0]);
            $photosRow['url'] = trim($photosRow[1]);

            //On cherche dans la table product l'id du produit correspondante
            $products = TableRegistry::get('Products');
            $productQuery = $products->find('all')
                                     ->where(['code =' => trim($photosRow[0])]);
            //Et on l'associe au champs product_id
            $photosRow['product_id'] = $productQuery->first()->id;
            debug($photosRow['code'].' - '.$photosRow['url'].' - '.$photosRow['product_id']);
            $photosRow['type'] = '0';
            $photosRow['active'] = '0';
            unset($photosRow[0], $photosRow[1]);// Supprimer les anciennes key

            $photo = $this->Photos->newEntity();
            $photo = $this->Photos->patchEntity($photo, $photosRow);
            $insert =$this->Photos->save($photo);

          }
        }
        debug('Nombre de ligne traitées: '.$i);
        debug('Importation terminée');
        die;
    }

    /**
     * Validate method
     *
     * 
     */
    public function validate()
    {
        if ($this->request->is(['patch', 'post', 'put'])) {
            $datas = $this->request->getData();
            //Liste des ids de produit
            $product_ids = array_slice($datas, 0, true);
            unset($datas['product_ids']);

            foreach ($product_ids['product_ids'] as $key => $value) {
                
                if (array_key_exists($value, $datas)) {
                    // Update
                    $active = 2;
                } else {
                    //Delete
                    $active = -1;
                }

                $query = $this->Photos->query();
                $query->update()
                ->set(['active' => $active])
                ->where(['product_id' => $value])
                ->execute();
            }
            //$photo = $this->Photos->patchEntity($photo, $this->request->getData());
            if ( $query->update()->set(['active' => $active])->where(['product_id' => $value])->execute() ) {
                $this->Flash->success(__('Validation effectué'));
            } else {
            $this->Flash->error(__('Problème de validation! Arrêtez tout et contactez Guigui!!!!!!!!'));
            }
        }
        $photos = $this->Photos->find()
                               ->where(['Photos.active ' => 1])
                               ->limit(50)
                               ->contain(['Products']);
        $this->set(compact('photos'));
 


    }

    /**
     * find method
     * List all the 'new' product and search in google image api images
     * donwload and save the google image selected as picture product
     */
    public function find()
    {
        if ($this->request->is(['post'])) {
            
            $datas = $this->request->getData();

            // Download image
            // Rename and resize image
            // upload on siteground serveur
            // Save image data in photos table
            $query = $this->Photos->query();
            foreach ($datas['product'] as $key => $value) {
                //Formatage des données pour l'insert/update
                if(isset($value['url']) || !empty($value['customLink'])) {
                    if(isset($value['url'])) { 
                        $url = $value['url'];
                    } else {
                        $url = $value['customLink'];
                    }
                    $photoData = ['url' => $url,
                                  'product_id' => $value['id'], 
                                  'type' => 0, 
                                  'active'=> 2];
                } else {
                    $photoData = ['url' => '-',
                                  'product_id' => $value['id'], 
                                  'type' => 0, 
                                  'active'=> -1];
                }

                //Check si une photo existe
                $nbrPhotos = $this->Photos->find()->where(['product_id' => $value['id']])->count();
                //debug($nbrPhotos);
                if($nbrPhotos === 0){ // Si aucun enregistrement n'hesite pour cette photo/produit on insert
                    $query->insert(['url', 'product_id', 'type', 'active'])
                          ->values($photoData);
                } else {
                    $query->update()
                          ->set($photoData)
                          ->where(['product_id' => $value['id']]); 
                }

            }

            $query->execute();
            
         
        }
        // List all 'NEW' Product with no photo existing
        $products = TableRegistry::get('Products');
        $productQuery = $products->find('all')
                                    ->where(['new' => 1, 'Products.active' => 1, 'Photos.product_id IS'=> null])
                                    //         'OR' => [['Photos.product_id IS'=> null], ['Photos.url' => '-']]])
                                    ->leftJoinWith('Photos')
                                    ->limit(1)
                                    ->contain(['Photos', 'Brands', 'Origins', 'Categories', 'Subcategories']);
        
        $this->set(compact('productQuery'));

    }
}

