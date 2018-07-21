<?php
namespace App\Utility;

use Cake\ORM\TableRegistry;



class Warnings
{

    // Insert un nouveau Warning
    public function insert($title = null , $product_code = null, $field = null, $value = null, $urgence= null   )
    {

      $warningTable = TableRegistry::get('warnings');
      $warning = $warningTable->newEntity();

      $warning->title = $title;
      $warning->product_code = $product_code;
      $warning->field = $field;
      $warning->value = $value;
      $warning->urgence = $urgence;

      $warningTable->save($warning);
      return true;

    }

    /**
     * warningDisplay method
     * Affiche un div warning sur en fonction de champs produit
     * @param object| $warningObject = objet contenant tous les warnings du produit
     * @param string| $field = nom du champs products
     * @return string|null code html du warning
     */
    public function warningDisplay($warningObject , $field)
    {
        foreach($warningObject as $warning) {
          // On boucle sur tous les warnings pour voir si le field correspond. Si oui on retour le warning
          if($warning->field === $field){
            $value =  '<div class="message error alert alert-warning">'.$warning->title.' : '.$warning->value.'</div>';
            return $value;
          }
        }
        return null;
    }

}
