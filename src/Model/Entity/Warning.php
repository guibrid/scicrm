<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Warning Entity
 *
 * @property int $id
 * @property string $title
 * @property string $product_code
 * @property string $value
 * @property int $urgence
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Product[] $products
 */
class Warning extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'title' => true,
        'product_code' => true,
        'value' => true,
        'urgence' => true,
        'created' => true,
        'modified' => true,
        'products' => true
    ];
}
