<?php
namespace App\Controller;

use App\Controller\AppController;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

/**
 * Substores Controller
 *
 * @property \App\Model\Table\SubstoresTable $Substores
 *
 * @method \App\Model\Entity\Substore[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SubstoresController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Stores']
        ];
        $substores = $this->paginate($this->Substores);

        $this->set(compact('substores'));
    }

    /**
     * View method
     *
     * @param string|null $id Substore id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $substore = $this->Substores->get($id, [
            'contain' => ['Stores', 'Categories']
        ]);

        $this->set('substore', $substore);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $substore = $this->Substores->newEntity();
        if ($this->request->is('post')) {
            $substore = $this->Substores->patchEntity($substore, $this->request->getData());
            if ($this->Substores->save($substore)) {
                $this->Flash->success(__('The substore has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The substore could not be saved. Please, try again.'));
        }
        $stores = $this->Substores->Stores->find('list', ['limit' => 200]);
        $this->set(compact('substore', 'stores'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Substore id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $substore = $this->Substores->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $substore = $this->Substores->patchEntity($substore, $this->request->getData());
            if ($this->Substores->save($substore)) {
                $this->Flash->success(__('The substore has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The substore could not be saved. Please, try again.'));
        }
        $stores = $this->Substores->Stores->find('list', ['limit' => 200]);
        $this->set(compact('substore', 'stores'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Substore id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $substore = $this->Substores->get($id);
        if ($this->Substores->delete($substore)) {
            $this->Flash->success(__('The substore has been deleted.'));
        } else {
            $this->Flash->error(__('The substore could not be deleted. Please, try again.'));
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
      $reader->open('files/substores.csv');
      $i = 0;
      foreach ($reader->getSheetIterator() as $sheet) {

        foreach ($sheet->getRowIterator() as $key => $substoreRow) {
          $i++;

          $substoreRow['code'] = trim($substoreRow[0]);
          $substoreRow['title'] = trim($substoreRow[1]);
          $substoreRow['store_id'] = trim($substoreRow[2]);
          unset($substoreRow[0], $substoreRow[1], $substoreRow[2]);// Supprimer les anciennes key

          //Recheche si le substore existe dans la base
          $query = $this->Substores->find('list')
                            ->where(['Substores.code =' => $substoreRow['code']]);

          // Si elle n'existe pas on l'ajoute
          if( $query->count()===0) { //Compte le nombre de résultat renvoyé
            $substore = $this->Substores->newEntity();
            $substore = $this->Substores->patchEntity($substore, $substoreRow);
            $insert =$this->Substores->save($substore);
          } else { // Si elle existe il y a un problème et on debug
            debug($substoreRow);
          }

        }
      }
      debug('Nombre de ligne traitées: '.$i);
      debug('Importation terminée');
      die;
    }
}
