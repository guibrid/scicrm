<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Origins Controller
 *
 * @property \App\Model\Table\OriginsTable $Origins
 *
 * @method \App\Model\Entity\Origin[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OriginsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $origins = $this->paginate($this->Origins);

        $this->set(compact('origins'));
    }

    /**
     * View method
     *
     * @param string|null $id Origin id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $origin = $this->Origins->get($id, [
            'contain' => ['Products', 'Shortorigins']
        ]);

        $this->set('origin', $origin);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $origin = $this->Origins->newEntity();
        if ($this->request->is('post')) {
            $origin = $this->Origins->patchEntity($origin, $this->request->getData());
            if ($this->Origins->save($origin)) {
                $this->Flash->success(__('The origin has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The origin could not be saved. Please, try again.'));
        }
        $this->set(compact('origin'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Origin id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $origin = $this->Origins->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $origin = $this->Origins->patchEntity($origin, $this->request->getData());
            if ($this->Origins->save($origin)) {
                $this->Flash->success(__('The origin has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The origin could not be saved. Please, try again.'));
        }
        $this->set(compact('origin'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Origin id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $origin = $this->Origins->get($id);
        if ($this->Origins->delete($origin)) {
            $this->Flash->success(__('The origin has been deleted.'));
        } else {
            $this->Flash->error(__('The origin could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
