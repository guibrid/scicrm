<?php
namespace App\Utility;




class CatalogueHelpers
{

    public $catalogueHeaders = [
      ['Code',	  'Cde',	'New',	'Durée de',	'DLV',	'Désignation des marchandises',	'Marque',	'Piéces',	'PCB',	'Tarif',	'UV',	'Unités',	'Poids',	'Volume',	'Montant',	'Poids',	'Volume',	'Colis par',	'Colis par', 'Code', 'Q', 'GENCOD'],
      ['Article',	'Colis','', 'vie jours',	'Indicative','', '', 'Article', 'Colis','', '', '', 'Cde', 'Cde', 'Cde', 'Colis',	'Colis', 'couche',	'Palette',	'Douanier', '', ''],
      ['', '', '', 'Indicative',	'au #1erduMois#', '', '',	'Kilo']
    ];

    /**
     * searchForMarque method
     * Recherchez dans un tableau multidimension la valeur Marque
     * Utiliser dans la generation du catalogue pour classer les marques
     * @param object| $marque = nom de la marque
     * @param string| $array = tableau à chercher
     * @return int|null retourne la key du tableau si trouvé
     */
    public function searchForMarque($marque, $array) {
        foreach ($array as $key => $val) {
            if ($val['Marque'] === $marque) {
                return $key;
            }
        }
        return null;
    }


}
