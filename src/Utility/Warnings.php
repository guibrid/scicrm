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

}
