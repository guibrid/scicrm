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
 * @property string $duree_vie
 * @property string $gencod
 * @property string $douanier
 * @property string $dangereux
 * @property string $origin_id
 * @property float $tva
 * @property string $cdref
 * @property string $category_code
 * @property string $subcategory_code
 * @property string $entrepot
 * @property string $supplier
 * @property string $qualification
 * @property int $couche_palette
 * @property int $colis_palette
 * @property string $pieceartk
 * @property string $ifls_remplacement
 * @property int $assortiment
 * @property string $brand_id
 * @property string $temperature
 * @property bool $active
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Origin $origin
 * @property \App\Model\Entity\Brand $brand
 * @property \App\Model\Entity\Warning[] $warnings
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
        'category_code' => true,
        'subcategory_code' => true,
        'entrepot' => true,
        'supplier' => true,
        'qualification' => true,
        'couche_palette' => true,
        'colis_palette' => true,
        'pieceartk' => true,
        'ifls_remplacement' => true,
        'assortiment' => true,
        'brand_id' => true,
        'temperature' => true,
        'active' => true,
        'created' => true,
        'modified' => true,
        'origin' => true,
        'brand' => true,
        'warnings' => true,
        'shortbrands' => true,
        'shortorigins' => true
    ];
}
