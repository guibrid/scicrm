<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Shortbrand Entity
 *
 * @property int $id
 * @property string $title
 * @property int $brand_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Brand $brand
 * @property \App\Model\Entity\Product[] $products
 */
class Shortbrand extends Entity
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
        'brand_id' => true,
        'created' => true,
        'modified' => true,
        'brand' => true,
        'products' => true
    ];
}
