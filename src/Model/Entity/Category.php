<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Category Entity
 *
 * @property int $id
 * @property string $code
 * @property string $title
 * @property string $type
 * @property int $substore_id
 * @property bool $active
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Substore $substore
 * @property \App\Model\Entity\Subcategory[] $subcategories
 */
class Category extends Entity
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
        'type' => true,
        'substore_id' => true,
        'active' => true,
        'created' => true,
        'modified' => true,
        'substore' => true,
        'subcategories' => true
    ];
}
