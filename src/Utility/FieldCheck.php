<?php
namespace App\Utility;

use App\Utility\Warnings;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

class FieldCheck
{

    /**
     * Liste des libelles SANS MARQUES
     * Utiliser lors de la verification de la catégorie
     */
    public $sansmarqueList = ['', '.', '..', '...', 'SANS', 'SANS MARQUE',
                              'SS MARQUE.', 'DIVERS', 'NC', 'GENERIQUE'];

    /**
     * Liste des ancien code Categories avec leur nouvelle correspondance
     * Utiliser lors de la verification de la catégorie
     */
    public $oldCategories = [['084','2586'], ['082','2585'], ['081','2584'],
                             ['086','2324'], ['087','2324'], ['080','2324']];

    /**
     * Liste des ancien code subCategories avec leur nouvelle correspondance
     * Utiliser lors de la verification de la subcatégorie
     */
    public $oldSubCategories = [['08406','25860'], ['082802','25853'], ['08104','25841'],
                             ['08602','23241'], ['082805','25853'], ['082804','25853'],
                             ['082801','25853'], ['082803','25853'], ['082807','25853'],
                             ['08101','25841'], ['08601','23241'], ['08701','23241'],
                             ['08005','23241'], ['082808','25853'], ['082809','25853']];

    /**
     * Liste des code subcategories qui corresponde aux vins
     * Utiliser lors de la verification de la marque
     */
    public $subcategoriesVin = [
        '10300', '10301', '10302', '10303', '10304', '10305', '10310', '10311', '10312',
        '10313', '10314', '10315', '10316', '10317', '10318', '10319', '10320', '10321',
        '10322','10323', '10324', '10325', '10326', '10330', '10331', '10332', '10333',
        '10334', '10335', '10336', '10337', '10340', '10341', '10342', '10343', '10344',
        '10345', '10346', '10347', '10350', '10398'];

    /**
    * Listes des entrepots Carrefour
    * Cette liste sert dans la fonction checkPieceartk
    */
    private $entrepotCarrefour = ['71744', '71746', '89063', '88884', '88642'];

    /**
    * Listes des entrepots avec en array la liste des types possible(frais, sec, surgeles, alimnetaire,...)
    * Cette liste sert dans la fonction searchcategorie pour associé l'articles à la bonne catégorie
    */
    private $entrepotType = [
              //71744 Recherche id famille where type 1AL ou 1NAL
              ['71744', ['1AL', '1NAL']],
              //, 71746 Recherche  id famille where type 1AL ou 1NAL
              ['71746', ['1AL', '1NAL']],
              //89063 Recherche  id famille where type 1AL ou 1NAL
              ['89063', ['1AL', '1NAL']],
              //89063 Recherche id famille where type 2AL ou 2NAL
              ['88884', ['2AL', '2NAL']],
              ['88642',	['3AL']],
              ['3520',  ['1AL']],
              ['3817',	['2AL']],
              ['4174',  ['1AL']],
              ['5587',	['2AL']],
              ['6828',  ['2AL']],
              ['7363',	['2AL']],
              ['9897',	['2AL']],
              ['10602',	['2AL']],
              ['10734',	['1AL']],
              ['13011',	['2AL']],
              ['13040',	['1NAL']],
              ['16055',	['1AL']],
              ['16327',	['2AL']],
              ['17764',	['2AL']],
              ['18266',	['1AL']],
              ['18862',	['1AL']],
              ['19593',	['1AL']],
              ['20224',	['1AL']],
              ['20225',	['1AL']],
              ['23788',	['2AL']],
              ['24472',	['2AL']],
              ['33261',	['2AL']],
              ['36207',	['2AL']],
              ['75676',	['1AL']],
              ['85869',	['2AL']],
              ['88853',	['2AL']],
              ['90433',	['2AL']],
              ['90665',	['2AL']],
              ['90678',	['2AL']],
              ['91700',	['2AL']],
              ['97028',	['2AL']],
              ['98099',	['2AL']],
              ['98293',	['2AL']],
              ['98653',	['2AL']],
              ['99132',	['2AL']],
              ['99197',	['2AL']]];


    public function isValidDate($field, $value, $product_code, $activeProduct)
    {
      // Regex du format date jj/mm/YYYY
      $regex = '/(^(((0[1-9]|1[0-9]|2[0-8])[\/](0[1-9]|1[012]))|((29|30|31)[\/](0[13578]|1[02]))|((29|30)[\/](0[4,6,9]|11)))[\/](19|[2-9][0-9])\d\d$)|(^29[\/]02[\/](19|[2-9][0-9])(00|04|08|12|16|20|24|28|32|36|40|44|48|52|56|60|64|68|72|76|80|84|88|92|96)$)/m';
      preg_match_all($regex, $value, $matches, PREG_SET_ORDER, 0);

      if(empty($matches) && !empty($value)) { //Si la valeur n'existe pas on insert un warning
        if($activeProduct){
          $warning = new Warnings;
          $warning->insert($field.' ne correspond pas au format date jj/mm/YYYY', $product_code, $field,  $value);
        }
        return false;
      }
        return true;
    }



    /**
     * checkDlv method
     * Vérifier si la dlv à plus de 4 mois par rapport à la date du jour
     * @param string | $dlv = dlv au format dd/mm/year
     * @return string | $dlv
     */
    public function checkDlv($dlv)
    {
      //On formate la date de la DLV
      $dlv = date_create_from_format('d/m/Y', $dlv);

      // Definir la date de DLV minimun de 4 moins
      $minDlv = date_create( date('Y-m-d', strtotime(date('Y-m-d'). ' + 4 months')));

      // Si la date de DLV est inférieur à 4 mois, on lui ajoute la différence du nbr de jour
      if($dlv < $minDlv){
        //debug('La dlv a moins de 4 mois');
        $interval = date_diff($dlv, $minDlv); // Comparaison des 2 dates
        // Ajout nbr de jours manquant à la dlv et on formate la date pour la BDD
        $dlv = date_format(date_add($dlv, date_interval_create_from_date_string($interval->days.' days')), 'Y-m-d');
      } else {
        // On retourne la date formater pour BDD
        $dlv = date_format($dlv, 'Y-m-d');
      }
        return $dlv;
    }

    public function matchString($field, $value, $product_code, $options, $activeProduct)
    {
      if (!in_array($value, $options) && !empty($value)) { // On recherche dans le array des options si la valeur existe
        //Si la valeur n'existe pas on insert un warning
        if($activeProduct){
          $warning = new Warnings;
          $warning->insert($field.' ne correspond pas aux options valide', $product_code, $field,  $value);
        }
        return false;
      }
      return true;
    }

    public function isVide($field, $value, $product_code, $activeProduct)
    {
      if (empty($value)) {
        //Si la valeur est empty on insert un warning
        if($activeProduct){
          $warning = new Warnings;
          $warning->insert($field.' est vide', $product_code, $field,  $value);
        }
        return false;
      }
      return true;
    }

    public function isInteger($field, $value, $product_code, $activeProduct)
    {
      if (!ctype_digit((string)$value) && !empty($value)) {
        //Si la valeur n'est pas un entier ou vide
        if($activeProduct){
          $warning = new Warnings;
          $warning->insert($field.' n\'est pas un entier', $product_code, $field,  $value);
        }
        return false;
      }
      return true;
    }

    public function isDouble($field, $value, $product_code, $activeProduct)
    {

      if (!filter_var($value, FILTER_VALIDATE_FLOAT) && !empty($value)) { // Valide string **.** as float number
        //Si la valeur n'est pas un float
        if($activeProduct){
          $warning = new Warnings;
          $warning->insert($field.' n\'est pas un chiffre à décimal', $product_code, $field,  $value);
        }
        return false;
      }
      return true;
    }

    public function checkLength($field, $value, $product_code, $length)
    {
      if ( strlen($value)!=$length ) {
        // si le nombre de caractere n'est pas bon
        $warning = new Warnings;
        $warning->insert($field.' ne fait pas '.$length.' caractères', $product_code, $field,  $value);
        return false;
      }
      return true;
    }

    //Verification du format alphanumerique
    public function isalphaNum($field, $value, $product_code, $activeProduct)
    {
      if (!ctype_alnum($value) && !empty($value)) {
        //Si le code n'est pas alpha numérique ou vide on ajoute un warning
        if($activeProduct){
          $warning = new Warnings;
          $warning->insert($field.' n\'est pas alphanuméric', $product_code, $field, $value);
        }
        return false;
      }
      return true;
    }

    //Verification du format numerique (entier ou double)
    public function isNumeric($field, $value, $product_code, $activeProduct)
    {

      if (!is_numeric($value) && !empty($value)) {
        //Si le code n'est pas numérique (entier ou double) ou vide on ajoute un warning
        if($activeProduct){
          $warning = new Warnings;
          $warning->insert($field.' n\'est pas un chiffre entier ou décimal', $product_code, $field, $value);
        }
        return false;
      }
      return true;
    }

    //Recherche de l'origine
    public function searchOrigin($field, $value, $product_code, $activeProduct)
    {
        if(is_null($value) || empty($value)) {
          return null;
        }
        //Verifier dans la table origins que la valeur existe
        $originSearch = TableRegistry::get('origins');
        $origin = $originSearch->find()->where(['title =' => $value])->first();
        if (!is_null($origin)) {  // Si non trouve une correspondance dans la table origins
          return $origin->id;
        };

        //Sinon on verifie dans la table shortorigins que la valeur existe et qu'elle a une origin_id associée
        $shortoriginSearch = TableRegistry::get('shortorigins');
        $shortorigin = $shortoriginSearch->find()->where(['title =' => $value, 'origin_id IS NOT' => null])->first();
        if (!is_null($shortorigin)) {  // Si non trouve une correspondance dans la table $shortorigin on renvoie origin_id associé
          return $shortorigin->origin_id;
        };

        //Sinon on créée une alerte Origin inconu et on return null pour la valeur
        if($activeProduct){
          $warning = new Warnings;
          $warning->insert('Origine n\'existe pas dans la table origins ou shortorigins', $product_code, $field, $value);
        }
        return null;
    }

    /**
     * Recherche Category id method
     * Rechercher la category_id en fonction du code categorie et du code entrepot
     * @param string| $field = nom du champs traité
     * @param int| $value = code de la category
     * @param int| $entrepot = code le entrepot
     * @param string| $product_code = code article du produit
     * @return int|null category_id
     */
    public function searchCategory($field, $value, $entrepot, $product_code, $activeProduct)
    {
        //Recherche le type d'entrepot dans la liste entrepotType 1AL, 2NAL,...
        $typeList = $this->typeEntrepot($entrepot);

        //Recherche le code categorie et le type associé au product
        $categorySearch = TableRegistry::get('categories');
        $category = $categorySearch->find()
                                   ->where(['code =' => $value,
                                            'OR'     => $typeList])
                                   ->first();

        if (!is_null($category)) {
           // Si on trouve  une correspondance dans la table categories on return l'id de la categorie
          return $category->id;
        } else {
          //Sinon on créée une alerte Category inconu et on return null pour la valeur
          if($activeProduct){
            $warning = new Warnings;
            $warning->insert('Ce code catégorie n\'existe pas dans la table categories', $product_code, $field, $value);
          }
          return null;
        }
    }

    /**
     * Recherche Subcategory id method
     * Rechercher la subcategory_id en fonction du code subcategorie et du code entrepot de la category
     * @param string| $field = nom du champs traité
     * @param int| $value = code de la subcategory
     * @param int| $entrepot = code le entrepot
     * @param string| $product_code = code article du produit
     * @return int|null subcategory_id
     */
    public function searchSubcategory($field, $value, $entrepot, $product_code, $activeProduct)
    {

        //Recherche le type d'entrepot correspondant à l'article dans la liste entrepotType 1AL, 2NAL,...
        $typeList = $this->typeEntrepot($entrepot);

        //Verifier dans la table subcategories que le code subcategory existe
        $subcategorySearch = TableRegistry::get('subcategories');
        $subcategory = $subcategorySearch->find()
                                         ->where(['Subcategories.code =' => $value]);

        //Et on ne fait resortir que la subcategory qui match avec le type(1AL,2AL,..) de categorie associé
        $subcategory->matching('Categories',
                                function ($q) use ($typeList) {
                                     return $q->where(['OR' => $typeList]);
                                 });

       // Si on trouve 0 ou plus d'une correspondance alrte car ce n'est pas normal
       if($subcategory->count() != 1) {
         if($activeProduct){
           $warning = new Warnings;
          $warning->insert('Ce code subcatégorie n\'existe pas, ou est en double', $product_code, $field, $value);
         }
         return null;
       //Sinon retourne l'id de la subcategory correspondante
       } else {
         return $subcategory->first()->id;
       }

    }

    //Recherche de brands
    public function searchBrands($field, $value, $product_code, $qualification, $activeProduct)
    {
        //$sansmarqueList = ['', '.', '..', '...', 'SANS', 'SANS MARQUE', 'SS MARQUE.', 'DIVERS', 'NC', 'GENERIQUE'];
        // Si la marque est de type 'SANS MARQUE' et que Qualification = P
        if(array_search($value, $this->sansmarqueList)){
          if($qualification === 'P') { // On renome la Marque en '1er Prix'
            $value = '1er Prix';
          }
        }

        //Verifier dans la table brands que la valeur existe
        $brandSearch = TableRegistry::get('brands');
        $brand = $brandSearch->find()->where(['title =' => $value])->first();
        if (!is_null($brand)) {  // Si non trouve une correspondance dans la table brands
          return $brand->id;
        };

        //Sinon on verifie dans la table shortbrands que la valeur existe et qu'elle a une brand_id associée
        $shortbrandSearch = TableRegistry::get('shortbrands');
        $shortbrand = $shortbrandSearch->find()->where(['title =' => $value, 'brand_id IS NOT' => null])->first();
        if (!is_null($shortbrand)) {  // Si non trouve une correspondance dans la table $shortorigin on renvoie origin_id associé
          return $shortbrand->brand_id;
        };

        //Sinon on créée une alerte Origin inconu et on return null pour la valeur
        if($activeProduct){
          $warning = new Warnings;
          $warning->insert('La marque n\'existe pas dans la table brands ou shortbrands', $product_code, $field, $value);
        }
        return null;
    }


    //Recherche de brands
    public function updateBrands($field, $value, $valueSavedId, $product_code, $qualification, $activeProduct)
    {
      //TODO Refactoriser avec searchBrand Method en ajouter en paramettre  $valueSavedId en dernier de la fonction
      // avec un valeur à null par default pour savoir quand on a affaire à un update


      // si valeur est egale à sans marques
      if(array_search($value, $this->sansmarqueList)){
        return $valueSavedId;
      }

      // Sinon on recherche l'id de value et on la compare avec $valueSavedId.
      //Verifier dans la table brands que la valeur existe
      $brandSearch = TableRegistry::get('brands');
      $brand = $brandSearch->find()->where(['title =' => $value])->first();
      if (!is_null($brand)) {  // Si non trouve une correspondance dans la table brands
        // Si l'id de la marque enregister correspond à l'id de la nouvelle
        if($brand->id == $valueSavedId) {
          return $brand->id;
        }
      };

      //Sinon on verifie dans la table shortbrands que la valeur existe et qu'elle a une brand_id associée
      $shortbrandSearch = TableRegistry::get('shortbrands');
      $shortbrand = $shortbrandSearch->find()->where(['title =' => $value, 'brand_id IS NOT' => null])->first();
      if (!is_null($shortbrand)) {  // Si non trouve une correspondance dans la table $shortorigin on renvoie origin_id associé
        // Si l'id de la marque enregister correspond à l'id de la nouvelle
        if($shortbrand->brand_id == $valueSavedId) {
          return $shortbrand->brand_id;

        }
      };
      // Si différent warning
      //Sinon on créée une alerte Origin inconu et on return null pour la valeur
      if($activeProduct){
        $warning = new Warnings;
        $warning->insert('La marque ne correspond pas à la marque enregistrer dans la base de donnée', $product_code, $field, $value);
      }
      return $valueSavedId;

    }

    /**
     * Verification des marques pour les vins method
     * Gestion particuliere des marques pour les vins
     * Marques "Vin" pour tous les articles ayant un code "Qualification" A.
     * Pour code Qualification P indiquer 1er Prix.
     * Pour code Qualification M indiquer MDD sauf pour la marque Reflets de France qu'il faut indiquer en toutes lettres.
     * @param string| $field = nom du champs traité
     * @param string| $value = libelle de la marque
     * @param string| $product_code = code du produit
     * @param int| $subcategory_code = code de la subcategory
     * @param string| $qualification = P, A ou M
     * @param array| $subcategoriesVin = list des subcategories lié aux vins
     * @return string|null libelle de la marque modifié ou pas
     */
    public function checkVins($field, $value, $product_code, $subcategory_id, $qualification, $subcategoriesVin, $activeProduct)
    {
        //Check si si la subcat et la quelitfication sont renseigner pour pouvoir faire la verifiaction
        if (!is_null($subcategory_id) && !is_null($qualification)) {

          //Recherche dans subcategories le code correspondant l'id de la subcategorie
          $subcategoriesSearch = TableRegistry::get('Subcategories');
          $subcategory = $subcategoriesSearch->find()->where(['id =' => $subcategory_id])->first();
          // Si la Subcat faire partie de la liste des subcat lié au vin
          if (in_array($subcategory->code, $subcategoriesVin)) {
            switch ($qualification) {
            case 'P':
                $value = '1er Prix';
                break;
            case 'A':
                $value = 'VIN';
                break;
            case 'M':
                $value = 'MDD';
                break;
            }
          }

        } else {
          //Sinon on créée une alerte Marque
          if($activeProduct){
          $warning = new Warnings;
          $warning->insert('Code sous famille ou Qualification absente. Impossible de déterminer la marque lier au Vin', $product_code, $field, $value);
          }
        }
        return $value;
    }

    //Vérification Marques pour les vins
    public function checkPieceartk($field, $value, $product_code, $uv, $entrepot, $activeProduct)
    {
        /**
        *
        * Si la colonne uv est égale à K et que le code code entrepot est autre que Carrefour pieceartk ne peut pas être vide (si uv U vide)
        * Si la colonne uv est égale à U, pieceartk doit être vide
        *
        **/

        if ( !empty($uv) || is_null($uv) )
        {
          if ( $uv === 'K' && empty($value) ) {
            if (in_array($entrepot, $this->entrepotCarrefour)){ // On verrifie si l'entrepot est Carrefour
              //On créée une alerte
              if($activeProduct){
                $warning = new Warnings;
                $warning->insert('uv est à K, pieceartk ne peut pas être vide', $product_code, $field, $value);
              }
              $value = null;
            }
          } else if( $uv === 'U' && !empty($value) ) {
            //On créée une alerte
            if($activeProduct){
              $warning = new Warnings;
              $warning->insert('uv est à U, pieceartk doit être vide', $product_code, $field, $value);
            }
            $value = null;
          }
        } else {
          //On créée une alerte
          if($activeProduct){
            $warning = new Warnings;
            $warning->insert('Impossible de definir pieceartk car UV est vide', $product_code, $field, $value);
          }
        }
        return $value;
    }

    /**
     * Recherche Type entrepot method
     * en fonction du code entrepot renoie la liste des types de cet entrepot
     * Exemple 1AL, 2AL, 1NAL,...
     * @param string| $codeEntrepot = code de l'entrepot du product
     * @return array|false $typeList
     */
    public function typeEntrepot($codeEntrepot)
    {
        foreach($this->entrepotType as $types){
          // Rechercher le code entrepot dans la list entrepotType
          if($types[0] == $codeEntrepot){
              foreach($types[1] as $type){
                // On récupere les valeurs du type d'entrepot
                $typeList[]['type'] =  $type;
              }
              return $typeList;
          }
        }

        return false;
    }

    /**
     * sanityseData method
     * Supprimer les espaces de début et de fin. Verifier si la valeur ne contient pas uniquement des espaces
     * @param string| $value = valeur à sanitize
     * @return string| return value sanityze
     */
    public function sanitizeData($value)
    {
       // Vérifie si le champs ne contient que des espaces
      if (ctype_space($value)) {
        $value= '';
      }
      //  Convertir en UTF8 les caracteres spéciaux
      $value = utf8_encode ($value);
      //  Supprimer les espaces de début et de fin
      $value = trim($value);

      return $value;
    }

    /**
     * checkEntrepot method
     * Vérifier si la valeur du code entrepot existe dans la liste des entrepots valide
     * @param string| $field = nom du champs traité
     * @param int| $value = code entrepot
     * @param string| $product_code = code article du produit
     * @return boolean| return true or false
     */
    public function checkEntrepot($field, $value, $product_code, $activeProduct)
    {
      //Pour toute la liste des entrepot valide
       foreach($this->entrepotType as $entrepot) {
         //On recherche si la valeur correspond à un des codes valides
         if($entrepot[0] === $value){
           return true;
         }
       }
       //Sinon on créée une alerte entrepot inconu et on return false
       if($activeProduct){
         $warning = new Warnings;
        $warning->insert('Ce code entrepot est inconu', $product_code, $field, $value);
       }
       return false;

    }

    /**
     * brandVariations method
     * Lister toutes les variations d'une marques à partir d'un nom de brand (recherche dans brands et shortbrands)
     * @param string| $value = chaine à chercher
     * @return array| return array de toutes les variantes de la marque ['brand_id']['brand_titles']
     */
    public function brandVariations($value)
    {
      // Recherche de la value dans la table brands
      $brandSearch = TableRegistry::get('Brands');
      $brand = $brandSearch->find()->where(['title =' => $value])->first();
      $titleList['brand_id'] = $brand->id;
      $titleList['brand_titles'] = [$brand->title];
      // Recherche dans des shortbrands associé à la brands
      $shortbrandSearch = TableRegistry::get('Shortbrands');
      $shortbrand = $shortbrandSearch->find()->where(['brand_id =' => $brand->id]);
      $i= 1;
      foreach ($shortbrand as $key => $row) {
        $titleList['brand_titles'][$i] = $row->title;
        $i++;
      }
      return $titleList;
    }

    /**
     * checkDouanier method
     * Vérifier si le code douanier est un entier de 10 chiffre autre que 000000000
     * et si le deuxieme caractere n'est pas un 0 car ces codes ne peuvent pas commencer par un double 0
     * @param string| $codeDouannier = code douanier
     * @return string| return le code douanier
     */
    public function checkDouanier($codeDouannier)
    {
      if(!ctype_digit((string)$codeDouannier) || strlen($codeDouannier) !== 10 || $codeDouannier === '0000000000' ||  substr($codeDouannier, 0, 2) == 00) {
        $codeDouannier = "";
      }
      return $codeDouannier;
    }

    /**
     * checkActiveProduct method
     * Vérifier si l'article est actif ou non
     * @param string| $codeRemplacement = code de remplacement
     * @return boolean| return true pour actif et false pour inactif
     */
    public function checkActiveProduct($codeRemplacement)
    {
      $codeRemplacement = $this->sanitizeData($codeRemplacement);
      if(empty($codeRemplacement)) {
        return true;
      }
    }

    /**
     * checkOldCategories method
     * Vérifier si la code category est un ancien code
     * @param string| $category_code = code category
     * @return int| return le code catégorie mise à jour ou non
     */
    public function checkOldCategories($category_code)
    {
      foreach ($this->oldCategories as $key => $value) {
        if($category_code == $value[0]) {
          $category_code = $value[1];
        }
      }
        return $category_code;
    }

    /**
     * checkOldSubCategories method
     * Vérifier si la code category est un ancien code
     * @param string| $category_code = code category
     * @return int| return le code catégorie mise à jour ou non
     */
    public function checkOldSubCategories($subcategory_code)
    {
      foreach ($this->oldSubCategories as $key => $value) {
        if($subcategory_code == $value[0]) {
          $subcategory_code = $value[1];
        }
      }
        return $subcategory_code;
    }

    /**
     * brandCarefourVariations method
     * Lister toutes les variations de la marque CARREFOUR et les enregistrer dans un array
     * @return array| return array de toutes les variantes de la marque CARREFOUR ['variante de la marque']
     */
    public function brandCarefourVariations()
    {
      // Recherche de la value dans la table brands
      $brandSearch = TableRegistry::get('Brands');
      $brand = $brandSearch->find()->where(['title LIKE' => '%CARREFOUR%']);

      foreach ($brand as $value1) {
        //debug($row->title);
        $carrefour_Brand_List [] = $value1->title;
        // Recherche dans des shortbrands associé à la brands
        $shortbrandSearch = TableRegistry::get('Shortbrands');
        $shortbrand = $shortbrandSearch->find()->where(['brand_id =' => $value1->id]);
        foreach ($shortbrand as $value2) {
          $carrefour_Brand_List [] = $value2->title;
        }
      }

      return $carrefour_Brand_List;
    }


    /**
     * dlvControle method
     * Controle du champs DLV
     * @return string|null return la date formater ou null
     */
    public function dlvControle($key, $dlv, $code_produit, $isActive, $isInsert, $dlvSaved = null)
    {
      debug('Field : '.$key);
      debug('Valeur de la DLV : '.$dlv);
      debug('Code produit : '.$code_produit);
      debug('Actif : '.$isActive);
      debug('Insertion : '.$isInsert);
      debug('Valeur dans la base : '.$dlvSaved);

      // Si Insert et Actif et le format de la date n'est pas bon
      if($isInsert && $isActive && !$this->isValidDate($dlv)) {
        $alert = true;
        $dlvReturn = null;
      }
      // Si Update et Actif et le format de la date n'est pas bon
      if(!$isInsert && $isActive && !$this->isValidDate($dlv)) {
        $alert = true;
        $dlvReturn = $dlvSaved;
      }

      // Si Insert et inactif et et le format de la date n'est pas bon
      if($isInsert && !$isActive && !$this->isValidDate($dlv)) {
        $dlvReturn = null;
      }

      // Si Update et inactif et et le format de la date n'est pas bon
      if(!$isInsert && !$isActive && !$this->isValidDate($dlv)) {
        $dlvReturn = $dlvSaved;
      }

      // Si Update et inactif et et le format de la date n'est pas bon
      if(isset($alert)) {
        // On enregistre une alerte
        $warning = new Warnings;
        $warning->insert($key.' ne correspond pas au format date jj/mm/YYYY', $code_produit, $key,  $dlv);
      }

      if($this->isValidDate($dlv) && !empty($dlv)) { // Si la date n'est pas vide
       // On verifie la durée de la DLV (> à 4 mois) et on met au format YYY/mm/dd pour insert dans la base
       $dlvReturn = $fieldCheck->checkDlv($dlv);
     }

      return $dlvReturn;
    }

}
