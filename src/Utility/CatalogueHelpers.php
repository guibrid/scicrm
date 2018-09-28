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
     * Liste des subcategory id des PRODUITS BIOLOGIQUES ET DIÉTÉTIQUES
     * Utiliser lors de la generation du catalogue
     */
    public $subcatBio_ids = ['210','211','212','213','214','215','216','217','218','219'];


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
     * generateCommande method
     * genere la page commande du bon de commande
     * @return array| Return le tableau des lignes de la page commande
     */
    public function generateCommande()
    {
      $current_month = date("F Y");
      $premiermois = date("01/m/Y");
      $data = [
        ['','','','','','BON DE COMMANDE '.$current_month],
        ['MODE D\'EMPLOI DU BON DE COMMANDE '],
        ['1) Saisir le code article en colonne A et le nombre de colis en colonne B'],
        ['Nota :'],
        ['Lorsqu\'un code apparaît dans la colonne C "article de remplacement" le ressaisir à la place de l\'ancien code en colonne A'],
        ['', 'Attention : des articles peuvent être remplacés plusieurs fois.'],
        ['Lorsque "N/A" apparaît, cela signifie que l\'article est supprimé. Voir dans le catalogue pour remplacement éventuel par une autre référence.'],
        [''],
        ['2) Lorsque la saisie de la commande est TERMINEE CLIQUEZ SUR LE BOUTON "Fin Commande"'],
        [''],
        ['Zone de saisie de commande', '', '','NE SAISIR AUCUNE DONNEE DANS CES COLONNES'],
        ['Code',	  'Nombre',	  'Article de',	  'DLV indicative',	'Duré de',	  'DESIGNATION     DES     MARCHANDISES',	'PCB',	  'Qté',	'Poids',	'Volume',	'Tarif', 'UV',	'Montant',	'Poids',	'Volume',	'Code',	     'Gencod',	'Rang',	      'Code',	'Origine'],
        ['Article',	'de colis',	'remplacement',	'Au',	            'Vie',	      '',	                                    'Colis',	'',	    'Cde',	   'Cde',	  '',      '',	  '',	        'Colis',	'Colis', 	'Douanier',	 '',	      'Catalogue', 	'Produits'],
        ['',	      '',	        'à ressaisir',	$premiermois,	    'Indicative',	'',	                                    '',     	'',     '',       '',       '',	     '',  	'',      	  '',       '',	      'Indicatif', '',        '',    	      'Dangereux']
      ];

      return $data;
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

    /**
     * formatDLV method
     * Formatage du champs DLV d-m-Y
     * @return string| Return la date formaté
     */
     public function formatDLV($date)
     {
       if(!empty($date)) {
         $date = date_format($date, 'd-m-Y');
       }
       return $date;
     }

     /**
      * formatPrix method
      * Formatage du champs prix
      * @return string| Return le prix formaté
      */
      public function formatPrix($prix,$entrepot,$articleremplacement,$typeExport)
      {
        if ($typeExport == 'catalogue') {
          $listEntrepot = ['71744', '71746', '89063', '88642', '88884', '1'];
          if(empty($prix) && !in_array($entrepot,$listEntrepot) && empty($articleremplacement)) {
            $prix = 'Au cours';
          }
        } else if ($typeExport == 'boncommande') {
          if(!empty($articleremplacement)) {
            $prix = 0;
          }
        }
        return $prix;
      }

      /**
       * formatNew method
       * Formatage du champsnew
       * @return string| Return la valeur formatée
       */
       public function formatNew($value)
       {
         if($value){
           $value = 'New';
         } else {
           $value = '';
         }
         return $value;
       }

       /**
        * formatBrand method
        * Formatage du marque
        * @return string| Return la marque formatée
        */
        public function formatBrand($brand)
        {
          if($brand == 'VIN'){
            $brand = '-';
          }
          return $brand;
        }

        /**
         * orderProduct method
         * ordonner la listes (array) des produits par type : 1er prix, MDD, Marques nationale
         * @param array| $listQualificationP = tableau des produits donc la qualification est P (1er prix)
         * @param array| $listQualificationM = tableau des produits donc la qualification est M (MDD)
         * @param array| $listQualificationA = tableau des produits donc la qualification est A (Marques nationales)
         * @return string| Return la marque formatée
         */
         public function orderProduct($listQualificationP, $listQualificationM, $listQualificationA)
         {
           // On fusionne les tableaux de produits en fonction de l'order souhaite : 1er prix, MDD, Marques nationale
           $listProductOrdered = array_merge($this->getProductsToDisplay($listQualificationM, 'M'),
                                        $this->getProductsToDisplay($listQualificationA));
           $listProductOrdered = array_merge($this->getProductsToDisplay($listQualificationP), $listProductOrdered);

           return $listProductOrdered;
         }

         /**
          * generateRow method
          * genere la ligne produit pour le catalogue et le bon de commande
          * @param object| $productDetails = tableau contenant tous les infos du produit
          * @param string| $type = Type de génération Catalogue ou Bon de commande
          * @return array| Return les information a ajouter dans le fichier excel
          */
          public function generateRow($productDetails, $type)
          {
            // Information exporter pour chaque produit
            if ($type == 'catalogue') {
              $productRow = [
                $productDetails->code , '', '', $this->formatNew($productDetails->new),
                $productDetails->duree_vie, $this->formatDLV($productDetails->dlv),
                $productDetails->title, $this->formatBrand($productDetails->Brands['title']),
                $productDetails->pieceartk, $productDetails->pcb,
                $this->formatPrix($productDetails->prix, $productDetails->entrepot, $productDetails->remplacement_product, 'catalogue'),
                $productDetails->uv, '', '', '', '', $productDetails->poids, $productDetails->volume,
                (int)$productDetails->couche_palette, (int)$productDetails->colis_palette,
                (string)$productDetails->douanier,  $productDetails->qualification, $productDetails->gencod, ''];
            } else if ($type == 'boncommande') {
              if ($productDetails->remplacement_product == 'Carrefour') { $productDetails->remplacement_product = ''; }
              $productRow = [
                $productDetails->code , $productDetails->remplacement_product, $productDetails->title, $productDetails->pcb,
                $this->formatPrix($productDetails->prix, $productDetails->entrepot, $productDetails->remplacement_product, 'boncommande'),
                $productDetails->uv, $productDetails->poids,
                $productDetails->volume, $this->formatDLV($productDetails->dlv),
                $productDetails->duree_vie, $productDetails->gencod, (string)$productDetails->douanier, '',
                $productDetails->dangereux, $productDetails->Origins['title']];
            }

            return $productRow;
          }




}
