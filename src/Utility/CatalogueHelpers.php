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

    /**
     * getProductsToDisplay method
     * Mets en forme le tableau des articles avec les marques en entete suivi des articles associé
     * Si la qualification est M on utilise uniquement la marque MDD comme entete
     * @param array| $array = tableau des produits à mettre ne forme
     * @param string|null $qualification = renseigner 'M' si la liste des articles à la code qualifaction M
     * @return array| // Retourne la liste des produits formater pour la génération du catalogue Excel
     */
    public function getProductsToDisplay($array, $qualification = null) {
      $listeProduct= []; //Initialisation de la liste produits
      // Si le code qualification est M la seul marque d'entete est MDD
      //if($qualification == 'M') { $listeProduct[] = ['Marque' =>'MDD'];  }
      // On boucle sur tous les articles du tableau
      foreach ($array as $key => $value) {
        // Si l'article à le code qualification M
        if($qualification == 'M') {
          if(!isset($listeProduct[0]['Produits'])) { $listeProduct[] = ['Marque' =>'MDD']; }
          $listeProduct[0]['Produits'][$key] = $value; //On ajoute les produits à la marque MDD quelque soit la marque du produit
        } else {
              // Rechercher dans le tableau si la marque existe deja
              $key = $this->searchForMarque($value[6], $listeProduct);

              //Si elle n'existe pas on l'ajoute et on ajoute l'article l'article avec cette marque
              if(is_null($key)){
                  $listeProduct[] = ['Marque' =>$value[6]]; // On ajoute la marque
                  end($listeProduct); //Set the internal pointer to the end.
                  $key = key($listeProduct); //Retrieve the key of the current element.
                  $listeProduct[$key]['Produits'] = [$value]; // On ajoute le premier produit associé à cette marque
              // Si elle existe on ajoute l'article à la marque
              } else {
                $listeProduct[$key]['Produits'][] = $value; // On ajoute le produit associé à la marque
              }
        }

      }
      sort($listeProduct); //Organiser le tableau par ordre alphabetique des marques
      return $listeProduct;
    }



}
