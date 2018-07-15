<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Substore Entity
 *
 * @property int $id
 * @property int $code
 * @property string $title
 * @property int $store_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Store $store
 * @property \App\Model\Entity\Category[] $categories
 */
class Substore extends Entity
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
        'code' => true,
        'title' => true,
        'store_id' => true,
        'created' => true,
        'modified' => true,
        'store' => true,
        'categories' => true
    ];
}
