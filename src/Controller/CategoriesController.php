<?php
namespace App\Controller;

use App\Controller\AppController;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Cake\ORM\TableRegistry;


/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 *
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategoriesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Substores']
        ];
        $categories = $this->paginate($this->Categories);

        $this->set(compact('categories'));
    }

    /**
     * View method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => ['Substores', 'Subcategories']
        ]);

        $this->set('category', $category);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $category = $this->Categories->newEntity();
        if ($this->request->is('post')) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }
        $substores = $this->Categories->Substores->find('list', ['limit' => 200]);
        $this->set(compact('category', 'substores'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }
        $substores = $this->Categories->Substores->find('list', ['limit' => 200]);
        $this->set(compact('category', 'substores'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Categories->get($id);
        if ($this->Categories->delete($category)) {
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Import method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function import()
    {
      $reader = ReaderFactory::create(Type::CSV); // for CSV files
      $reader->setFieldDelimiter('|');
      $reader->open('files/categories.csv');
      $i = 0;
      foreach ($reader->getSheetIterator() as $sheet) {

        foreach ($sheet->getRowIterator() as $key => $categoriesRow) {
          $i++;

          $categoriesRow['code'] = trim($categoriesRow[0]);
          $categoriesRow['title'] = trim($categoriesRow[1]);
          $categoriesRow['type'] = trim($categoriesRow[2]);

          switch($categoriesRow['type']) {
            case '1AL':
              $categoriesRow['type']=1;
              break;
            case '1NAL':
              $categoriesRow['type']=2;
              break;
            case '2AL':
              $categoriesRow['type']=3;
              break;
            case '3AL':
              $categoriesRow['type']=4;
              break;
          }

          // On cherche dans la table Substores l'id du substore correspondante
          $substores = TableRegistry::get('Substores');
          $substoreQuery = $substores->find('all')
                                ->where(['code =' => $categoriesRow[3]]);
          //Et on l'associe au champs substore_id
          $categoriesRow['substore_id'] = $substoreQuery->first()->id;
          //Si le Substore n'existe pas on debug
          if (is_null($categoriesRow['substore_id'])){
            debug($categoriesRow);
          }

          $categoriesRow['active'] = '1';
          unset($categoriesRow[0], $categoriesRow[1], $categoriesRow[2], $categoriesRow[3]);// Supprimer les anciennes key

          //Recheche si le code de la Category existe dans la base
          $query = $this->Categories->find('list')
                            ->where(['code =' => $categoriesRow['code']]);

          // Si elle n'existe pas on l'ajoute
          if( $query->count()===0) { //Compte le nombre de résultat renvoyé
            $category = $this->Categories->newEntity();
            $category = $this->Categories->patchEntity($category, $categoriesRow);
            $insert =$this->Categories->save($category);
          } else { // Si elle existe il y a un problème et on debug
            debug($categoriesRow);
          }

        }
      }
      debug('Nombre de ligne traitées: '.$i);
      debug('Importation terminée');
      die;
    }
}
