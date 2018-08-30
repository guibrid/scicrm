<?php
namespace App\Controller;

use App\Controller\AppController;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Cake\ORM\TableRegistry;

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

    /**
     * import method
     * Ajouter via une table de correspondance CSV les nouvelles abréviations de marques ['Libellé abreviation', 'Libelle marque']
     * @return true| Return true quand les insert sont terminés
     */
    public function import()
    {
      $reader = ReaderFactory::create(Type::CSV); // for CSV files
      $reader->setFieldDelimiter('|');
      $reader->open('files/shortbrandslist.csv');
      $i = 0;
      $u =0;
      foreach ($reader->getSheetIterator() as $sheet) {

        foreach ($sheet->getRowIterator() as $key => $productRow) {

              $shortbrand['title'] = trim($productRow[0]); // Valeur du shortbrand
              $brand['title'] = trim($productRow[1]); // Valeur du brand

              if($shortbrand['title'] != $brand['title'] && !empty($shortbrand['title'])) { // Si le shortbrand et la brand sont différents ou vide
                  //Recherche si shortbrand existe
                  $query = $this->Shortbrands->find('list')
                                        ->where(['Shortbrands.title =' => $shortbrand['title']]);
                  // Si il n'existe pas on l'ajoute
                  if( $query->count()===0) { //Compte le nombre de résultat renvoyé
                      //debug('le shortcode n\'existe pas');
                      // On cherche dans la table brands l'id de la marque correspondante
                      $brands = TableRegistry::get('Brands');
                      $brandQuery = $brands->find('all')
                                            ->where(['Brands.title =' => $brand['title']]);

                        $data['title'] = $shortbrand['title'];
                        $data['brand_id'] = $brandQuery->first()->id;

                        $newShortbrands = $this->Shortbrands->newEntity();
                        $newShortbrands = $this->Shortbrands->patchEntity($newShortbrands, $data);
                        $insert =$this->Shortbrands->save($newShortbrands);

                  }

              }

              $i++;

        }
      }
      debug('Nombre de shortcode empty: '.$u);
      debug('Nombre de ligne traitées: '.$i);
      debug('Importation terminée');
      die;
    }
}
