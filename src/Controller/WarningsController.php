<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Warnings Controller
 *
 * @property \App\Model\Table\WarningsTable $Warnings
 *
 * @method \App\Model\Entity\Warning[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WarningsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $warnings = $this->paginate($this->Warnings);

        $this->set(compact('warnings'));
    }

    /**
     * View method
     *
     * @param string|null $id Warning id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $warning = $this->Warnings->get($id, [
            'contain' => ['Products']
        ]);

        $this->set('warning', $warning);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $warning = $this->Warnings->newEntity();
        if ($this->request->is('post')) {
            $warning = $this->Warnings->patchEntity($warning, $this->request->getData());
            if ($this->Warnings->save($warning)) {
                $this->Flash->success(__('The warning has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The warning could not be saved. Please, try again.'));
        }
        $products = $this->Warnings->Products->find('list', ['limit' => 200]);
        $this->set(compact('warning', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Warning id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $warning = $this->Warnings->get($id, [
            'contain' => ['Products']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $warning = $this->Warnings->patchEntity($warning, $this->request->getData());
            if ($this->Warnings->save($warning)) {
                $this->Flash->success(__('The warning has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The warning could not be saved. Please, try again.'));
        }
        $products = $this->Warnings->Products->find('list', ['limit' => 200]);
        $this->set(compact('warning', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Warning id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $warning = $this->Warnings->get($id);
        if ($this->Warnings->delete($warning)) {
            $this->Flash->success(__('The warning has been deleted.'));
        } else {
            $this->Flash->error(__('The warning could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
