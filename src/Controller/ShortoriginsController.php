<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Shortorigins Controller
 *
 * @property \App\Model\Table\ShortoriginsTable $Shortorigins
 *
 * @method \App\Model\Entity\Shortorigin[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ShortoriginsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Origins']
        ];
        $shortorigins = $this->paginate($this->Shortorigins);

        $this->set(compact('shortorigins'));
    }

    /**
     * View method
     *
     * @param string|null $id Shortorigin id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $shortorigin = $this->Shortorigins->get($id, [
            'contain' => ['Origins', 'Products']
        ]);

        $this->set('shortorigin', $shortorigin);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $shortorigin = $this->Shortorigins->newEntity();
        if ($this->request->is('post')) {
            $shortorigin = $this->Shortorigins->patchEntity($shortorigin, $this->request->getData());
            if ($this->Shortorigins->save($shortorigin)) {
                $this->Flash->success(__('The shortorigin has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The shortorigin could not be saved. Please, try again.'));
        }
        $origins = $this->Shortorigins->Origins->find('list', ['limit' => 200]);
        $products = $this->Shortorigins->Products->find('list', ['limit' => 200]);
        $this->set(compact('shortorigin', 'origins', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Shortorigin id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $shortorigin = $this->Shortorigins->get($id, [
            'contain' => ['Products']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $shortorigin = $this->Shortorigins->patchEntity($shortorigin, $this->request->getData());
            if ($this->Shortorigins->save($shortorigin)) {
                $this->Flash->success(__('The shortorigin has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The shortorigin could not be saved. Please, try again.'));
        }
        $origins = $this->Shortorigins->Origins->find('list', ['limit' => 200]);
        $products = $this->Shortorigins->Products->find('list', ['limit' => 200]);
        $this->set(compact('shortorigin', 'origins', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Shortorigin id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shortorigin = $this->Shortorigins->get($id);
        if ($this->Shortorigins->delete($shortorigin)) {
            $this->Flash->success(__('The shortorigin has been deleted.'));
        } else {
            $this->Flash->error(__('The shortorigin could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
