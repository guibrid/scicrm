<?php
namespace App\Controller;

use App\Controller\AppController;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Cake\ORM\TableRegistry;

/**
 * Subcategories Controller
 *
 * @property \App\Model\Table\SubcategoriesTable $Subcategories
 *
 * @method \App\Model\Entity\Subcategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SubcategoriesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Categories']
        ];
        $subcategories = $this->paginate($this->Subcategories);

        $this->set(compact('subcategories'));
    }

    /**
     * View method
     *
     * @param string|null $id Subcategory id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $subcategory = $this->Subcategories->get($id, [
            'contain' => ['Categories']
        ]);

        $this->set('subcategory', $subcategory);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $subcategory = $this->Subcategories->newEntity();
        if ($this->request->is('post')) {
            $subcategory = $this->Subcategories->patchEntity($subcategory, $this->request->getData());
            if ($this->Subcategories->save($subcategory)) {
                $this->Flash->success(__('The subcategory has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subcategory could not be saved. Please, try again.'));
        }
        $categories = $this->Subcategories->Categories->find('list', ['limit' => 200]);
        $this->set(compact('subcategory', 'categories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Subcategory id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $subcategory = $this->Subcategories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $subcategory = $this->Subcategories->patchEntity($subcategory, $this->request->getData());
            if ($this->Subcategories->save($subcategory)) {
                $this->Flash->success(__('The subcategory has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subcategory could not be saved. Please, try again.'));
        }
        $categories = $this->Subcategories->Categories->find('list', ['limit' => 200]);
        $this->set(compact('subcategory', 'categories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Subcategory id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $subcategory = $this->Subcategories->get($id);
        if ($this->Subcategories->delete($subcategory)) {
            $this->Flash->success(__('The subcategory has been deleted.'));
        } else {
            $this->Flash->error(__('The subcategory could not be deleted. Please, try again.'));
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
      $reader->open('files/subcategorie.csv');
      $i = 0;
      foreach ($reader->getSheetIterator() as $sheet) {

        foreach ($sheet->getRowIterator() as $key => $subcategoriesRow) {
          $i++;

            $subcategoriesRow['code'] = trim($subcategoriesRow[0]);
            $subcategoriesRow['title'] = trim($subcategoriesRow[1]);
            // On cherche dans la table categories l'id de la categorie correspondante
            $categories = TableRegistry::get('Categories');
            $categoryQuery = $categories->find('all')
                                  ->where(['code =' => $subcategoriesRow[2]]);
            //Et on l'associe au champs category_id
            $subcategoriesRow['category_id'] = $categoryQuery->first()->id;
            //Si la categorie n'existe pas on debug
            if (is_null($subcategoriesRow['category_id'])){
                debug($subcategoriesRow);
            }

            $subcategoriesRow['active'] = '1';
            unset($subcategoriesRow[0], $subcategoriesRow[1], $subcategoriesRow[2]);// Supprimer les anciennes key


          //Recheche si le code de la subcategory existe dans la base
          //$query = $this->Subcategories->find('list')
          //                  ->where(['code =' => $subcategoriesRow['code']]);

          // Si elle n'existe pas on l'ajoute
          //if( $query->count()===0) { //Compte le nombre de résultat renvoyé
            $subcategory = $this->Subcategories->newEntity();
            $subcategory = $this->Subcategories->patchEntity($subcategory, $subcategoriesRow);
            $insert =$this->Subcategories->save($subcategory);
          //} else { // Si elle existe il y a un problème et on debug
            //debug($subcategoriesRow);
          //}

        }
      }
      debug('Nombre de ligne traitées: '.$i);
      debug('Importation terminée');
      die;
    }
}
