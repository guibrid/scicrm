<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property int $id
 * @property string $code
 * @property string $remplacement_product
 * @property string $title
 * @property int $pcb
 * @property float $prix
 * @property string $uv
 * @property float $poids
 * @property float $volume
 * @property \Cake\I18n\FrozenDate $dlv
 * @property int $duree_vie
 * @property int $gencod
 * @property int $douanier
 * @property string $dangereux
 * @property string $origin_id
 * @property float $tva
 * @property string $cdref
 * @property int $category_id
 * @property int $subcategory_id
 * @property string $entrepot
 * @property string $supplier
 * @property string $qualification
 * @property string $couche_palette
 * @property string $colis_palette
 * @property string $pieceartk
 * @property string $ifls_remplacement
 * @property string $assortiment
 * @property string $brand_id
 * @property bool $active
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Origin $origin
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\Subcategory $subcategory
 * @property \App\Model\Entity\Brand $brand
 * @property \App\Model\Entity\Shortbrand[] $shortbrands
 * @property \App\Model\Entity\Shortorigin[] $shortorigins
 */
class Product extends Entity
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
        'remplacement_product' => true,
        'title' => true,
        'pcb' => true,
        'prix' => true,
        'uv' => true,
        'poids' => true,
        'volume' => true,
        'dlv' => true,
        'duree_vie' => true,
        'gencod' => true,
        'douanier' => true,
        'dangereux' => true,
        'origin_id' => true,
        'tva' => true,
        'cdref' => true,
        'category_id' => true,
        'subcategory_id' => true,
        'entrepot' => true,
        'supplier' => true,
        'qualification' => true,
        'couche_palette' => true,
        'colis_palette' => true,
        'pieceartk' => true,
        'ifls_remplacement' => true,
        'assortiment' => true,
        'brand_id' => true,
        'active' => true,
        'created' => true,
        'modified' => true,
        'origin' => true,
        'category' => true,
        'subcategory' => true,
        'brand' => true,
        'shortbrands' => true,
        'shortorigins' => true
    ];
}
