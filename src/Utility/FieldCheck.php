<?php
namespace App\Utility;

use App\Utility\Warnings;
use Cake\ORM\TableRegistry;


class FieldCheck
{

    public function isValidDate($field, $value, $product_code)
    {
      // Regex du format date jj/mm/YYYY
      $regex = '/(^(((0[1-9]|1[0-9]|2[0-8])[\/](0[1-9]|1[012]))|((29|30|31)[\/](0[13578]|1[02]))|((29|30)[\/](0[4,6,9]|11)))[\/](19|[2-9][0-9])\d\d$)|(^29[\/]02[\/](19|[2-9][0-9])(00|04|08|12|16|20|24|28|32|36|40|44|48|52|56|60|64|68|72|76|80|84|88|92|96)$)/m';
      preg_match_all($regex, $value, $matches, PREG_SET_ORDER, 0);

      if(empty($matches) && !empty($value)) { //Si la valeur n'existe pas on insert un warning
        $warning = new Warnings;
        $warning->insert($field.' ne correspond pas au format date jj/mm/YYYY', $product_code, $field,  $value);
        return false;
      }
        return true;
    }

    public function matchString($field, $value, $product_code, $options)
    {
      if (!in_array($value, $options) && !empty($value)) { // On recherche dans le array des options si la valeur existe
        //Si la valeur n'existe pas on insert un warning
        $warning = new Warnings;
        $warning->insert($field.' ne correspond pas aux options valide', $product_code, $field,  $value);
        return false;
      }
      return true;
    }

    public function isVide($field, $value, $product_code)
    {
      if (empty($value)) {
        //Si la valeur est empty on insert un warning
        $warning = new Warnings;
        $warning->insert($field.' est vide', $product_code, $field,  $value);
        return false;
      }
      return true;
    }

    public function isInteger($field, $value, $product_code)
    {
      if (!ctype_digit((string)$value) && !empty($value)) {
        //Si la valeur n'est pas un entier ou vide
        $warning = new Warnings;
        $warning->insert($field.' n\'est pas un entier', $product_code, $field,  $value);
        return false;
      }
      return true;
    }

    public function isDouble($field, $value, $product_code)
    {
      if (!filter_var($value, FILTER_VALIDATE_FLOAT) && !empty($value)) { // Valide string **.** as float number
        //Si la valeur n'est pas un float
        $warning = new Warnings;
        $warning->insert($field.' n\'est pas un chiffre à décimal', $product_code, $field,  $value);
        return false;
      }
      return true;
    }

    //Verification du format alphanumerique
    public function isalphaNum($field, $value, $product_code)
    {
      if (!ctype_alnum($value) && !empty($value)) {
        //Si le code n'est pas alpha numérique ou vide on ajoute un warning
        $warning = new Warnings;
        $warning->insert($field.' n\'est pas alphanuméric', $product_code, $field, $value);
        return false;
      }
      return true;
    }

    //Recherche de l'origine
    public function searchOrigin($field, $value, $product_code)
    {
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
        $warning = new Warnings;
        $warning->insert('Origine n\'existe pas dans la table origins ou shortorigins', $product_code, $field, $value);
        return null;
    }

    //Recherche le category code
    public function searchCategory($field, $value, $product_code)
    {
        //Verifier dans la table categories que la valeur existe
        $categorySearch = TableRegistry::get('categories');
        $category = $categorySearch->find()->where(['code =' => $value])->first();
        if (!is_null($category)) {  // Si non trouve une correspondance dans la table categories
          return $category->code;
        } else {
          //Sinon on créée une alerte Category inconu et on return null pour la valeur
          $warning = new Warnings;
          $warning->insert('Ce code catégorie n\'existe pas dans la table categories', $product_code, $field, $value);
          return null;
        }
    }

    //Recherche le subcategory code
    public function searchSubcategory($field, $value, $product_code)
    {
        //Verifier dans la table subcategories que la valeur existe
        $subcategorySearch = TableRegistry::get('subcategories');
        $subcategory = $subcategorySearch->find()->where(['code =' => $value])->first();
        if (!is_null($subcategory)) {  // Si non trouve une correspondance dans la table subcategories
          return $subcategory->code;
        } else {
          //Sinon on créée une alerte subCategory inconu et on return null pour la valeur
          $warning = new Warnings;
          $warning->insert('Ce code subcatégorie n\'existe pas dans la table subcategories', $product_code, $field, $value);
          return null;
        }
    }

    //Recherche de brands
    public function searchBrands($field, $value, $product_code)
    {
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
        $warning = new Warnings;
        $warning->insert('La marque n\'existe pas dans la table brands ou shortbrands', $product_code, $field, $value);
        return null;
    }

    //Vérification Marques pour les vins
    public function checkVins($field, $value, $product_code, $subcategory_code, $qualification, $subcategoriesVin)
    {
      /**
      *
      * Marques "Vin" pour tous les articles ayant un code "Qualification" A.
      * Pour code Qualification P indiquer 1er Prix.
      * Pour code Qualification M indiquer MDD sauf pour la marque Reflets de France qu'il faut indiquer en toutes lettres.
      *
      **/
        if (!is_null($subcategory_code) && !is_null($qualification)) {

          if (in_array($subcategory_code, $subcategoriesVin)) {

            switch ($qualification) {
            case 'P':
                $value = '1er Prix';
                break;
            case 'A':
                $value = 'Vin';
                break;
            case 'M':
                $brand = strtolower($value);
                if ($brand === 'reflets de france') {
                  $value = 'Reflets de France'; }
                else {
                  $value = 'MDD';
                }
                break;
            }

          }

        } else {
          //Sinon on créée une alerte Marque
          $warning = new Warnings;
          $warning->insert('Code sous famille ou Qualification absente. Impossible de déterminer la marque lier au Vin', $product_code, $field, $value);
        }
        return $value;
    }

    //Vérification Marques pour les vins
    public function checkPieceartk($field, $value, $product_code, $uv)
    {
        /**
        *
        * Si la colonne uv est égale à K, pieceartk ne peut pas être vide (si uv U vide)
        * Si la colonne uv est égale à U, pieceartk doit être vide
        *
        **/
        if ( !empty($uv) || is_null($uv) )
        {
          if ( $uv === 'K' && empty($value) ) {
            //On créée une alerte
            $warning = new Warnings;
            $warning->insert('uv est à K, pieceartk ne peut pas être vide', $product_code, $field, $value);
            $value = null;
          } else if( $uv === 'U' && !empty($value) ) {
            //On créée une alerte
            $warning = new Warnings;
            $warning->insert('uv est à U, pieceartk doit être vide', $product_code, $field, $value);
            $value = null;
          }
        } else {
          //On créée une alerte
          $warning = new Warnings;
          $warning->insert('Impossible de definir pieceartk car UV est vide', $product_code, $field, $value);
        }
        return $value;
    }

}
