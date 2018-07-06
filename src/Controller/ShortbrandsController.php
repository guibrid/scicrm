<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Shortbrands Controller
 *
 * @property \App\Model\Table\ShortbrandsTable $Shortbrands
 *
 * @method \App\Model\Entity\Shortbrand[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ShortbrandsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Brands']
        ];
        $shortbrands = $this->paginate($this->Shortbrands);

        $this->set(compact('shortbrands'));
    }

    /**
     * View method
     *
     * @param string|null $id Shortbrand id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $shortbrand = $this->Shortbrands->get($id, [
            'contain' => ['Brands', 'Products']
        ]);

        $this->set('shortbrand', $shortbrand);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $shortbrand = $this->Shortbrands->newEntity();
        if ($this->request->is('post')) {
            $shortbrand = $this->Shortbrands->patchEntity($shortbrand, $this->request->getData());
            if ($this->Shortbrands->save($shortbrand)) {
                $this->Flash->success(__('The shortbrand has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The shortbrand could not be saved. Please, try again.'));
        }
        $brands = $this->Shortbrands->Brands->find('list', ['limit' => 200]);
        $products = $this->Shortbrands->Products->find('list', ['limit' => 200]);
        $this->set(compact('shortbrand', 'brands', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Shortbrand id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $shortbrand = $this->Shortbrands->get($id, [
            'contain' => ['Products']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $shortbrand = $this->Shortbrands->patchEntity($shortbrand, $this->request->getData());
            if ($this->Shortbrands->save($shortbrand)) {
                $this->Flash->success(__('The shortbrand has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The shortbrand could not be saved. Please, try again.'));
        }
        $brands = $this->Shortbrands->Brands->find('list', ['limit' => 200]);
        $products = $this->Shortbrands->Products->find('list', ['limit' => 200]);
        $this->set(compact('shortbrand', 'brands', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Shortbrand id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shortbrand = $this->Shortbrands->get($id);
        if ($this->Shortbrands->delete($shortbrand)) {
            $this->Flash->success(__('The shortbrand has been deleted.'));
        } else {
            $this->Flash->error(__('The shortbrand could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
