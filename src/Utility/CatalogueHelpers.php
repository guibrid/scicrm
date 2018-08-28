<?php
namespace App\Utility;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\Style\Color;
use Cake\ORM\TableRegistry;


class CatalogueHelpers
{
    /**
     * Entete de colonne du catalogue
     */
    public $catalogueHeaders = [
      ['Code',	  'Cde',	 'Photo',	'New',	'Durée de',	  'DLV',	          'Désignation des marchandises',	'Marque',	'Piéces',	 'PCB',	  'Tarif',	'UV',	'Unités',	'Poids',	'Volume',	'Montant',	'Poids',	'Volume',	'Colis par',	'Colis par', 'Code',     'Q', 'GENCOD', '1'],
      ['Article',	'Colis', '',       '',    'vie jours',  'Indicative',     '',                             '',       'Article', 'Colis', '',       '',   '',       'Cde',    'Cde',    'Cde',      'Colis',	'Colis',  'couche',	    'Palette',	 'Douanier', '',  '',       '2'],
      ['',        '',      '',       '',    'Indicative',	'au #1erduMois#', '',                             '',	      'Kilo',    ''     , '',       '',   '',       '',       '',       '',         '',       '',       '',           '',          '',         '',  '',       '3']
    ];

    /**
     * Entete de colonne du bon de commande
     */
    public $boncommandeHeaders = [
      ['Code',	  'Article de',	  'Désignation des marchandises',	'PCB',	 'Tarif',	'UV',	'Poids', 'Volume',	'DLV',	      'Durée de vie',	'Gencod',	'Code',	    '1', 'Classe',	  'Pays'],
      ['Article', 'Remplacement',	'',                             'Colis', '',      '',   'Colis', 'Colis',   'Indicative', 'Indicative',   '',       'Douanier', '2', 'Dangereux',	"d'origine"],
      ['',        '',	            '',                             '',      '',      '',   '',      '',        '',           '',             '',       '',         '3', '',	        '']
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
          $key = $this->searchForMarque($value[7], $listeProduct);

          //Si elle n'existe pas on l'ajoute et on ajoute l'article l'article avec cette marque
          if(is_null($key)){
              $listeProduct[] = ['Marque' =>$value[7]]; // On ajoute la marque
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

    /**
     * generateGarde method
     * genere la page de garde du catalogue
     * @return array| Return le tableau des lignes de la page de garde
     */
    public function generateGarde()
    {
      $current_month = date("F Y");
      $data = [
        [''],
        [''],
        ['EURL Société de Commerce International'],
        ['Fare Ute - Immeuble Le Caill'],
        ['BP 1504 - 98713 Papeete'],
        ['Polynésie Française'],
        ['R.C.S.PAPEETE TPI 15 128 B'],
        ['SARL au capital de 200 000 XPF'],
        ['Polynésie Française'],
        ['Mail : contact@sc-international.fr'],
        ['Téléphone : 689 89 56 24 80'],
        ['France'],
        ['Téléphone Elisabeth : 09 52 15 95 25 / 06 29 75 73 30'],
        ['Mail Elisabeth : elisabeth@sc-international.fr'],
        [''],
        ['CATALOGUE'],
        ['GMS & COLLECTIVITES'],
        [$current_month],
        [''],
        ['cliquez, ci-dessous, sur le sommaire souhaité, puis sur la famille de produits'],
        ['EPICERIE, LIQUIDES, DPH, BAZAR'],
        ['SURGELES'],
        ['FRAIS, ULTRA FRAIS']
      ];

      return $data;
    }

    /**
     * generateSommaire method
     * Genere array des subcategories classé par store et subcategorie.Title
     * @return array| Return le tableau du sommaire classé
     */
    public function generateSommaire()
    {
      $sommaire = array();
      $subcategoriesList = TableRegistry::get('subcategories');
      $subcategories = $subcategoriesList->find('all')
                                         ->contain(['Categories'])
                                         ->order(['Categories.store_id' => 'ASC', 'subcategories.title' => 'ASC']);
      $firstLetter = '';
      foreach($subcategories as $key =>$subcategory) {
        //Ajout de la premiere lettre A, B, C, ...
        if($firstLetter != substr($subcategory['title'], 0, 1)){
          $firstLetter = substr($subcategory['title'], 0, 1);
          $sommaire[] = [substr($subcategory['title'], 0, 1)];
        }
        $sommaire[] = [$subcategory['title']];
      }
      return $sommaire;
    }


}
