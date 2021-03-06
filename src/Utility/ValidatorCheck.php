<?php
namespace App\Utility;

use App\Utility\FieldCheck;
use Cake\ORM\TableRegistry;


class ValidatorCheck
{


public function validate($data) {

  $fieldCheck = new FieldCheck;
  // Determiner si produit actif
  if($data['active'] == 1) {
    $activeProduct = true;
  } else {
    $activeProduct = true;
  }
  // Determiner si c'est un insert ou un update
  if (!isset($data['id'])) { // Si le product n'a pas d'id c'est un insert
    $isInsert = true;
  } else { // Sinon c'est un update et on récupérer les valeur enregistré dans la base
    $isInsert = false;
    $Products = TableRegistry::get('products');
    $productSaved = $Products->get($data['id'])->toArray(); // On récupere toutes les datas enregistré sur l'article dans la base64_decode
  }

  //Lister les variantes de la marque carrefour dans un tableaux
  foreach($data as $key => $row) {

    switch ($key) {

      case 'code': // alphanumeric, no empty
          $fieldCheck->isalphaNum($key, $row, $data['code'], $activeProduct); // Check si alphnumerique
          $fieldCheck->isVide($key, $row, $data['code'], $activeProduct); // Check si empty
          //On ne met pas le code à null car il est insere dans la table warning

        break;

      case 'remplacement_product': // alphanumeric, empty

            if (!$fieldCheck->isalphaNum($key, $row, $data['code'], $activeProduct)) {  // Check si alphnumerique
              // INSERT / UPDATE
              if($isInsert){ // Si c'est un insert on enregistre le champs à vide, et la valeur en erreur sera dans le warning
                $data['remplacement_product'] = null;
              } else { // Si c'est un update on garde le champs enregistré dans la base, et la valeur en erreur sera dans le warning
                $data['remplacement_product'] = $productSaved['remplacement_product'];
              }
            }


        break;

        case 'title': // alphanumeric, empty
          $data['title'] = $fieldCheck->sanitizeData($data['title']);
          break;

      case 'pcb': // entier,  no empty

          if (!$fieldCheck->isInteger($key, $row, $data['code'], $activeProduct) || !$fieldCheck->isVide($key, $row, $data['code'], $activeProduct)) {
            // INSERT / UPDATE
            if($isInsert){ // Si c'est un insert on enregistre le champs à vide, et la valeur en erreur sera dans le warning
              $data['pcb'] = null;
            } else { // Si c'est un update on garde le champs enregistré dans la base, et la valeur en erreur sera dans le warning
              $data['pcb'] = $productSaved['pcb'];
            }
          }

        break;

      case 'prix': // double ou vide
        $data['prix'] = str_replace(",", ".", $data['prix']); // On remplace la virgule par un point

          //TODO Si code entrepot carrefour prix obligatoire
          if (!$fieldCheck->isDouble($key, $data['prix'] , $data['code'], $activeProduct)) {  // Check si c'est un double
            // INSERT / UPDATE
            if($isInsert){ // Si c'est un insert on enregistre le champs à vide, et la valeur en erreur sera dans le warning
              $data['prix'] = null;
            } else { // Si c'est un update on garde le champs enregistré dans la base, et la valeur en erreur sera dans le warning
              $data['prix'] = $productSaved['prix'];
            }
          }

        break;

      case 'uv': // U ou K, no empty
        $data['uv'] = strtoupper($data['uv']);

          if (!$fieldCheck->matchString($key, $data['uv'], $data['code'], ['U','K'], $activeProduct) || !$fieldCheck->isVide($key, $data['uv'], $data['code'], $activeProduct)) {
            // INSERT / UPDATE
            if($isInsert){ // Si c'est un insert on enregistre le champs à vide, et la valeur en erreur sera dans le warning
              $data['uv'] = null;
            } else { // Si c'est un update on garde le champs enregistré dans la base, et la valeur en erreur sera dans le warning
              $data['uv'] = $productSaved['uv'];
            }
          }

        break;

      case 'poids': // double, no empty
        $data['poids'] = str_replace(",", ".", $data['poids']); // On remplace la virgule par un point

          if (!$fieldCheck->isDouble($key, $data['poids'] , $data['code'], $activeProduct) || !$fieldCheck->isVide($key, $data['poids'], $data['code'], $activeProduct)) {  // Check si c'est un double ou vide
            // INSERT / UPDATE
            if($isInsert){ // Si c'est un insert on enregistre le champs à vide, et la valeur en erreur sera dans le warning
              $data['poids'] = null;
            } else { // Si c'est un update on garde le champs enregistré dans la base, et la valeur en erreur sera dans le warning
              $data['poids'] = $productSaved['poids'];
            }
          }

        break;

      case 'volume': // double, no empty
        $data['volume'] = str_replace(",", ".", $data['volume']); // On remplace la virgule par un point

          if (!$fieldCheck->isDouble($key, $data['volume'] , $data['code'], $activeProduct) || !$fieldCheck->isVide($key, $data['volume'], $data['code'], $activeProduct)) {  // Check si c'est un double ou vide
            // INSERT / UPDATE
            if($isInsert){ // Si c'est un insert on enregistre le champs à vide, et la valeur en erreur sera dans le warning
              $data['volume'] = null;
            } else { // Si c'est un update on garde le champs enregistré dans la base, et la valeur en erreur sera dans le warning
              $data['volume'] = $productSaved['volume'];
            }
          }

        break;

        case 'dlv': // date ou vide
          if (!$fieldCheck->isValidDate($key, $data['dlv'], $data['code'], $activeProduct) ) { //Check si le format et le date sont valides
            // INSERT / UPDATE
            if($isInsert){ // Si c'est un insert on enregistre le champs à vide, et la valeur en erreur sera dans le warning
              $data['dlv'] = null;
            } else { // Si c'est un update on garde le champs enregistré dans la base, et la valeur en erreur sera dans le warning
              $data['dlv'] = $productSaved['dlv'];
            }
          } else if(!empty($data['dlv'])) { // Si la date n'est pas vide
            // On verifie la durée de la DLV (> à 4 mois) et on met au format YYY/mm/dd pour insert dans la base
            $data['dlv'] = $fieldCheck->checkDlv($data['dlv']);
          }
          break;

      case 'duree_vie': // entier ou vide

          if (!$fieldCheck->isInteger($key, $row, $data['code'], $activeProduct)) {
            // INSERT / UPDATE
            if($isInsert){ // Si c'est un insert on enregistre le champs à vide, et la valeur en erreur sera dans le warning
              $data['duree_vie'] = null;
            } else { // Si c'est un update on garde le champs enregistré dans la base, et la valeur en erreur sera dans le warning
              $data['duree_vie'] = $productSaved['duree_vie'];
            }
          }

        break;

      case 'gencod': // entier,  no empty

          if (!$fieldCheck->isInteger($key, $row, $data['code'], $activeProduct) || !$fieldCheck->isVide($key, $row, $data['code'], $activeProduct)) {
            // INSERT / UPDATE
            if($isInsert){ // Si c'est un insert on enregistre le champs à vide, et la valeur en erreur sera dans le warning
              $data['gencod'] = null;
            } else { // Si c'est un update on garde le champs enregistré dans la base, et la valeur en erreur sera dans le warning
              $data['gencod'] = $productSaved['gencod'];
            }
          }

        break;

      case 'douanier':
        $data['douanier'] = $fieldCheck->sanitizeData($data['douanier']); //Supprimer espace avant et après la chaine

          // Entier, 10 chiffres autre que 0000000000 sinon on met à blanc
          $data['douanier'] = $fieldCheck->checkDouanier($data['douanier'], $data['code']); //Vérifier le format du code douanier

        break;

      case 'dangereux': // entier, double ou empty
        $data['dangereux'] = str_replace(",", ".", $data['dangereux']); // On remplace la virgule par un point
        $data['dangereux'] = $fieldCheck->sanitizeData($data['dangereux']);

          if (!$fieldCheck->isNumeric($key, $data['dangereux'], $data['code'], $activeProduct)) {  // Check si numerique (entier ou double)
            // INSERT / UPDATE
            if($isInsert){ // Si c'est un insert on enregistre le champs à vide, et la valeur en erreur sera dans le warning
              $data['dangereux'] = null;
            } else { // Si c'est un update on garde le champs enregistré dans la base, et la valeur en erreur sera dans le warning
              $data['dangereux'] = $productSaved['dangereux'];
            }
          }

        break;

      case 'origin_id': // entier , no empty(alert)
          $data['origin_id']= $fieldCheck->sanitizeData($data['origin_id']); //Clean la variable

            // Recherche de l'id dans les tables origins et shortorigins
            $data['origin_id'] = $fieldCheck->searchOrigin($key, $data['origin_id'], $data['code'], $activeProduct);

            //TODO Add the // INSERT / UPDATE check

        break;

      case 'tva': // numerique ou vide
        $data['tva'] = str_replace(",", ".", $data['tva']); // On remplace la virgule par un point

          if (!$fieldCheck->isNumeric($key, $data['tva'] , $data['code'], $activeProduct))
               {  // Check si c'est un double ou vide
            // INSERT / UPDATE
            if($isInsert){ // Si c'est un insert on enregistre le champs à vide, et la valeur en erreur sera dans le warning
              $data['tva'] = null;
            } else { // Si c'est un update on garde le champs enregistré dans la base, et la valeur en erreur sera dans le warning
              $data['tva'] = $productSaved['tva'];
            }
          }

        break;

      case 'cdref': // entier, ou vide

        if (!$fieldCheck->isInteger($key, $row, $data['code'], $activeProduct) ) {
          // INSERT / UPDATE
          if($isInsert){ // Si c'est un insert on enregistre le champs à vide, et la valeur en erreur sera dans le warning
            $data['cdref'] = null;
          } else { // Si c'est un update on garde le champs enregistré dans la base, et la valeur en erreur sera dans le warning
            $data['cdref'] = $productSaved['cdref'];
          }
        }

      break;

      case 'category_id': // entier, no empty(alert)
        $data['category_id'] = $fieldCheck->sanitizeData($data['category_id']); //Clean la variable

          $data['category_id'] = $fieldCheck->checkOldCategories($data['category_id']); // Vérifier si le code catégorie est un ancien code
          // Recherche de le code dans les tables categories
          $data['category_id'] = $fieldCheck->searchCategory($key, $data['category_id'], $data['entrepot'], $data['code'], $activeProduct);
          //TODO Add the // INSERT / UPDATE check

        break;

      case 'subcategory_id': // entier, no empty(alert)
        $data['subcategory_id']= $fieldCheck->sanitizeData($data['subcategory_id']); //Clean la variable

          $data['subcategory_id']= $fieldCheck->checkOldSubCategories($data['subcategory_id']); // Vérifier si le code subcatégorie est un ancien code
          // Recherche de le code dans les tables subcategories
          $data['subcategory_id'] = $fieldCheck->searchSubcategory($key, $data['subcategory_id'], $data['entrepot'], $data['code'], $activeProduct);
          //TODO Add the // INSERT / UPDATE check

        break;

      case 'entrepot':
        // Doit correspondre à la liste des entrepots valides
        // Sinon alerte entrepot inconu
        $data['entrepot'] = $fieldCheck->sanitizeData($data['entrepot']);  //Clean la variable

          if(!$fieldCheck->checkEntrepot($key, $data['entrepot'], $data['code'], $activeProduct)) {
            // INSERT / UPDATE
            if($isInsert){ // Si c'est un insert on enregistre le champs à vide, et la valeur en erreur sera dans le warning
              $data['entrepot'] = null;
            } else { // Si c'est un update on garde le champs enregistré dans la base, et la valeur en erreur sera dans le warning
              $data['entrepot'] = $productSaved['entrepot'];
            }
          }

        break;

      case 'qualification': // P M ou A , no empty
        $data['qualification'] = strtoupper($data['qualification']);

          if (!$fieldCheck->matchString($key, $data['qualification'], $data['code'], ['P','M','A'], $activeProduct) || !$fieldCheck->isVide($key, $data['qualification'], $data['code'], $activeProduct)) {
            // INSERT / UPDATE
            if($isInsert){ // Si c'est un insert on enregistre le champs à vide, et la valeur en erreur sera dans le warning
              $data['qualification'] = null;
            } else { // Si c'est un update on garde le champs enregistré dans la base, et la valeur en erreur sera dans le warning
              $data['qualification'] = $productSaved['qualification'];
            }
          }

        break;

      case 'couche_palette': // entier ou vide

          if (!$fieldCheck->isInteger($key, $row, $data['code'], $activeProduct)) {
            // INSERT / UPDATE
            if($isInsert){ // Si c'est un insert on enregistre le champs à vide, et la valeur en erreur sera dans le warning
              $data['couche_palette'] = null;
            } else { // Si c'est un update on garde le champs enregistré dans la base, et la valeur en erreur sera dans le warning
              $data['couche_palette'] = $productSaved['couche_palette'];
            }
          }

        break;

      case 'colis_palette': // entier ou vide

          if (!$fieldCheck->isInteger($key, $row, $data['code'], $activeProduct)) {
            // INSERT / UPDATE
            if($isInsert){ // Si c'est un insert on enregistre le champs à vide, et la valeur en erreur sera dans le warning
              $data['colis_palette'] = null;
            } else { // Si c'est un update on garde le champs enregistré dans la base, et la valeur en erreur sera dans le warning
              $data['colis_palette'] = $productSaved['colis_palette'];
            }
          }

        break;

      case 'pieceartk': // entier ou vide

          //Verifier si pieceartk correspond avec la colonne UV
          $data['pieceartk'] = $fieldCheck->checkPieceartk($key, $row, $data['code'], $data['uv'],  $data['entrepot'], $activeProduct);

        break;

      case 'ifls_remplacement': // alphanumeric, empty

          if (!$fieldCheck->isalphaNum($key, $row, $data['code'], $activeProduct)) {  // Check si alphnumerique
            // INSERT / UPDATE
            if($isInsert){ // Si c'est un insert on enregistre le champs à vide, et la valeur en erreur sera dans le warning
              $data['ifls_remplacement'] = null;
            } else { // Si c'est un update on garde le champs enregistré dans la base, et la valeur en erreur sera dans le warning
              $data['ifls_remplacement'] = $productSaved['ifls_remplacement'];
            }
          }

        break;


      case 'assortiment': // entier, no empty

          if (!$fieldCheck->isInteger($key, $row, $data['code'], $activeProduct) || !$fieldCheck->isVide($key, $row, $data['code'], $activeProduct)) {
            // INSERT / UPDATE
            if($isInsert){ // Si c'est un insert on enregistre le champs à vide, et la valeur en erreur sera dans le warning
              $data['assortiment'] = null;
            } else { // Si c'est un update on garde le champs enregistré dans la base, et la valeur en erreur sera dans le warning
              $data['assortiment'] = $productSaved['assortiment'];
            }
          }

        break;

      case 'brand_id': // entier, no empty
        $data['brand_id']= $fieldCheck->sanitizeData($data['brand_id']); //Clean la variable
        //Renomer la Marques en fonction du cas particulier des subcategories et Qualification lier au Vin
        $listeSubcategoriVin = $fieldCheck->subcategoriesVin; //Call le Array des subcategory lier au vin
        $data['brand_id'] = $fieldCheck->checkVins($key, $data['brand_id'], $data['code'], $data['subcategory_id'], $data['qualification'], $listeSubcategoriVin, $activeProduct);

        if($isInsert){ //Si c'est un insert
          // Recherche de l'id dans les tables brands et shortbrands
          $data['brand_id'] = $fieldCheck->searchBrands($key, $data['brand_id'] , $data['code'], $data['qualification'], $activeProduct);
        } else { //Si c'est un update
          $data['brand_id'] = $fieldCheck->updateBrands($key, $data['brand_id'], $productSaved['brand_id'], $data['code'], $data['qualification'], $activeProduct);
        }


        //TODO Add the // INSERT / UPDATE check
        break;
  }
};
  return $data;

}


}
