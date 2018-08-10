<?php
namespace App\Utility;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\Style\Color;


class CatalogueHelpers
{

    public $catalogueHeaders = [
      ['Code',	  'Cde',	'New',	'Durée de',	'DLV',	'Désignation des marchandises',	'Marque',	'Piéces',	'PCB',	'Tarif',	'UV',	'Unités',	'Poids',	'Volume',	'Montant',	'Poids',	'Volume',	'Colis par',	'Colis par', 'Code', 'Q', 'GENCOD'],
      ['Article',	'Colis','', 'vie jours',	'Indicative','', '', 'Article', 'Colis','', '', '', 'Cde', 'Cde', 'Cde', 'Colis',	'Colis', 'couche',	'Palette',	'Douanier', '', ''],
      ['', '', '', 'Indicative',	'au #1erduMois#', '', '',	'Kilo']
    ];

    /**
     * getTitleStyle method
     * Retourne le style pour les titres
     * @return object| retourne le style
     */
    public function getTitleStyle($size, $color) {

      $style = (new StyleBuilder())
        ->setFontBold()
        ->setFontSize($size)
        ->setFontColor($color)
        ->setShouldWrapText(false)
        ->build();
        return $style;
    }

    /**
     * getProductStyle method
     * Retourne le style pour les articles
     * @return object| retourne le style
     */
    public function getProductStyle($color) {

      $style = (new StyleBuilder())
        ->setFontColor($color)
        ->build();
        return $style;

    }

    /**
     * renderStyle method
     * retourne les styles pour la marque et le produit
     * @param string| $marque = Libelle de la marque
     * @return array| retourne les styles
     */
    public function renderStyle($marque) {

      $styles = [];

      switch ($marque) {
        case '1er Prix':
          $styles['Marque'] = $this->getTitleStyle(13, 'FF0000');
          $styles['Product'] = $this->getProductStyle('FF0000');
          break;

        case 'MDD':
          $styles['Marque'] = $this->getTitleStyle(13, '0070C0');
          $styles['Product'] = $this->getProductStyle('0070C0');
          break;

        default:
            $styles['Marque'] = $this->getTitleStyle(13, '000000');
          $styles['Product'] = $this->getProductStyle('000000');
          break;
      }
      //debug($styles);

      return $styles;

    }

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
      // On boucle sur tous les articles du tableau
      foreach ($array as $key => $value) {
        // Si l'article à le code qualification M
        if($qualification == 'M') {
          // Si le code qualification est M la seul marque d'entete est MDD
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


    /**
     * getProductsToDisplay method
     * Trie la liste des articles par marques lors de l'affichage de MDD
     * @param array| $array = tableau des produits
     * @return array| // Retourne la liste des produits trié par marque
     */
    public function sortMDDMarques($array) {
      $marques = array();
      // Créer un tableau avec toutes les marques des produits
      foreach ($array as $key => $row) {
          $marques[]  = &$row[6];
      }
      // Trié le tableau par la liste des marques créé ci-dessus
      array_multisort($marques, $array);
      return $array;
    }


}
