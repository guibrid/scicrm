<?php
namespace App\Utility;

use App\Utility\FieldCheck;


class ValidatorCheck
{

public function validate($data) {

  $fieldCheck = new FieldCheck;

//die;
  foreach($data as $key => $row) {

    switch ($key) {

      case 'code': // alphanumeric, no empty
        $fieldCheck->isalphaNum($key, $row, $data['code']); // Check si alphnumerique
        $fieldCheck->isVide($key, $row, $data['code']); // Check si empty
        //On ne met pas le code à null car il est insere dans la table warning
        break;

      case 'remplacement_product': // alphanumeric, empty
        if( empty($row) ){ //Si vide le produit est actif
            $data['active'] = 1;
        } else { //Sinon est inactif
            if (!$fieldCheck->isalphaNum($key, $row, $data['code'])) {  // Check si alphnumerique
              $data['remplacement_product'] = null; //On met la value à null si la fonction renvoie false
            };
        };
        break;

        case 'title': // alphanumeric, empty
          $data['title']= utf8_encode ( $data['title'] );
          break;

      case 'pcb': // entier,  no empty
        if (!$fieldCheck->isInteger($key, $row, $data['code']) || !$fieldCheck->isVide($key, $row, $data['code'])) {
          // Check si entier ou vide
          $data['pcb'] = null; //On met la value à null si la fonction renvoie false
        };
        break;

      case 'prix': // double ou vide
        $data['prix'] = str_replace(",", ".", $data['prix']); // On remplace la virgule par un point
        if (!$fieldCheck->isDouble($key, $data['prix'] , $data['code'])) {  // Check si c'est un double
          $data['prix'] = null; //On met la value à null si la fonction renvoie false
        };
        break;

      case 'uv': // U ou K, no empty
      $data['uv'] = strtoupper($data['uv']);
      if (!$fieldCheck->matchString($key, $data['uv'], $data['code'], ['U','K']) || !$fieldCheck->isVide($key, $data['uv'], $data['code'])) {
        // Check si correspond aux options ou vide
        $data['uv'] = null; //On met la value à null si la fonction renvoie false
      };
      break;

      case 'poids': // double, no empty
        $data['poids'] = str_replace(",", ".", $data['poids']); // On remplace la virgule par un point
        if (!$fieldCheck->isDouble($key, $data['poids'] , $data['code']) || !$fieldCheck->isVide($key, $data['poids'], $data['code'])) {  // Check si c'est un double ou vide
          $data['poids'] = null; //On met la value à null si la fonction renvoie false
        };
        break;

      case 'volume': // double, no empty
        $data['volume'] = str_replace(",", ".", $data['volume']); // On remplace la virgule par un point
        if (!$fieldCheck->isDouble($key, $data['volume'] , $data['code']) || !$fieldCheck->isVide($key, $data['volume'], $data['code'])) {  // Check si c'est un double ou vide
          $data['volume'] = null; //On met la value à null si la fonction renvoie false
        };
        break;

      case 'dlv': // date ou vide
        // TODO si inferieur de 4 mois, update la DVL à 4 mois de la date jour
        if (!$fieldCheck->isValidDate($key, $data['dlv'], $data['code']) ) { //Check si le format et le date sont valides
          $data['dlv'] = null; //On met la value à null si la fonction renvoi false
        } else if(!empty($data['dlv'])) {
          // On met la date au format YYY/mm/dd pour insert dans la base
          $data['dlv'] = date_create_from_format('d/m/Y', $data['dlv']);
          $data['dlv'] = date_format($data['dlv'], 'Y-m-d');
        }

        break;

      case 'duree_vie': // entier ou vide
        if (!$fieldCheck->isInteger($key, $row, $data['code'])) {
          // Check si entier ou vide
          $data['duree_vie'] = null; //On met la value à null si la fonction renvoie false
        };
        break;

      case 'gencod': // entier,  no empty
        if (!$fieldCheck->isInteger($key, $row, $data['code']) || !$fieldCheck->isVide($key, $row, $data['code'])) {
          // Check si entier ou vide
          $data['gencod'] = null; //On met la value à null si la fonction renvoie false
        };
        break;

      case 'douanier':
        // Entier, 10 chiffres sinon alerte
        // Si vide ou 0000000000 on met à null sans alerte
        $data['douanier'] = $fieldCheck->sanitizeData($data['douanier']); //Supprimer espace avant et après la chaine
        if (!empty($data['douanier']) && $data['douanier']<> '0000000000'){
          if (!$fieldCheck->isInteger($key, $data['douanier'], $data['code']) || !$fieldCheck->checkLength($key, $data['douanier'], $data['code'], 10)) {
            // Check si entier ou vide
            $data['douanier'] = null; //On met la value à null si la fonction renvoie false
          };
        } else {
          $data['douanier'] = null; //On met la value à null si vide
        };

        break;

      case 'dangereux': // alphanumeric, empty
        $data['dangereux'] = $fieldCheck->sanitizeData($data['dangereux']);
        if (!$fieldCheck->isalphaNum($key, $data['dangereux'], $data['code'])) {  // Check si alphnumerique
          $data['dangereux'] = null; //On met la value à null si la fonction renvoie false
        };
        break;

      case 'origin_id': // entier , no empty(alert)
          $data['origin_id']= $fieldCheck->sanitizeData($data['origin_id']); //Clean la variable
          // Recherche de l'id dans les tables origins et shortorigins
          $data['origin_id'] = $fieldCheck->searchOrigin($key, $data['origin_id'], $data['code']);
        break;

      case 'tva': // double, no empty
        $data['tva'] = str_replace(",", ".", $data['tva']); // On remplace la virgule par un point
        if (!$fieldCheck->isDouble($key, $data['tva'] , $data['code']) || !$fieldCheck->isVide($key, $data['tva'], $data['code'])) {  // Check si c'est un double ou vide
          $data['tva'] = null; //On met la value à null si la fonction renvoie false
        };
        break;

      case 'cdref': // entier,  no empty
      if (!$fieldCheck->isInteger($key, $row, $data['code']) || !$fieldCheck->isVide($key, $row, $data['code'])) {
        // Check si entier ou vide
        $data['cdref'] = null; //On met la value à null si la fonction renvoie false
      };
      break;

      case 'category_id': // entier, no empty(alert)
        $data['category_id']= $fieldCheck->sanitizeData($data['category_id']); //Clean la variable
        // Recherche de le code dans les tables categories
        $data['category_id'] = $fieldCheck->searchCategory($key, $row, $data['entrepot'], $data['code']);
        break;

      case 'subcategory_id': // entier, no empty(alert)
        $data['subcategory_id']= $fieldCheck->sanitizeData($data['subcategory_id']); //Clean la variable
        // Recherche de le code dans les tables subcategories
        $data['subcategory_id'] = $fieldCheck->searchSubcategory($key, $row, $data['entrepot'], $data['code']);

        break;

      case 'entrepot':
        // Doit correspondre à la liste des entrepots valides
        // Sinon alerte entrepot inconu
        $data['entrepot'] = $fieldCheck->sanitizeData($data['entrepot']);  //Clean la variable
        if(!$fieldCheck->checkEntrepot($key, $data['entrepot'], $data['code'])) {
          $data['entrepot'] = null;
        }
        break;

      case 'qualification': // P M ou A , no empty
        $data['qualification'] = strtoupper($data['qualification']);
        if (!$fieldCheck->matchString($key, $data['qualification'], $data['code'], ['P','M','A']) || !$fieldCheck->isVide($key, $data['qualification'], $data['code'])) {
          // Check si correspond aux options ou vide
          $data['qualification'] = null; //On met la value à null si la fonction renvoie false
        };
        break;

      case 'couche_palette': // entier ou vide
        if (!$fieldCheck->isInteger($key, $row, $data['code'])) {
          // Check si entier ou vide
          $data['couche_palette'] = null; //On met la value à null si la fonction renvoie false
        };
        break;

      case 'colis_palette': // entier ou vide
        if (!$fieldCheck->isInteger($key, $row, $data['code'])) {
          // Check si entier ou vide
          $data['colis_palette'] = null; //On met la value à null si la fonction renvoie false
        };
        break;

      case 'pieceartk': // entier ou vide
        //Verifier si pieceartk correspond avec la colonne UV
        $data['pieceartk'] = $fieldCheck->checkPieceartk($key, $row, $data['code'], $data['uv']);
        break;

      case 'ifls_remplacement': // alphanumeric, empty
        if (!$fieldCheck->isalphaNum($key, $row, $data['code'])) {  // Check si alphnumerique
          $data['ifls_remplacement'] = null; //On met la value à null si la fonction renvoie false
        };
        break;


      case 'assortiment': // entier, no empty
        if (!$fieldCheck->isInteger($key, $row, $data['code']) || !$fieldCheck->isVide($key, $row, $data['code'])) {
          // Check si entier ou vide
          $data['assortiment'] = null; //On met la value à null si la fonction renvoie false
        };
        break;

      case 'brand_id': // entier, no empty
      $data['brand_id']= $fieldCheck->sanitizeData($data['brand_id']); //Clean la variable
      //Renomer la Marques en fonction du cas particulier des subcategories et Qualification lier au Vin
      $listeSubcategoriVin = $fieldCheck->subcategoriesVin; //Call le Array des subcategory lier au vin
      $data['brand_id'] = $fieldCheck->checkVins($key, $data['brand_id'], $data['code'], $data['subcategory_id'], $data['qualification'], $listeSubcategoriVin);
      // Recherche de l'id dans les tables brands et shortbrands
      $data['brand_id'] = $fieldCheck->searchBrands($key, $data['brand_id'] , $data['code'], $data['qualification']);
      break;
  }
};
  return $data;

}


}
