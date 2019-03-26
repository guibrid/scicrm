Find photos
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
//var data =
//{
//  "kind": "customsearch#search",
//  "url": {
//    "type": "application/json",
//    "template": "https://www.googleapis.com/customsearch/v1?q={searchTerms}&num={count?}&start={startIndex?}&lr={language?}&safe={safe?}&cx={cx?}&sort={sort?}&filter={filter?}&gl={gl?}&cr={cr?}&googlehost={googleHost?}&c2coff={disableCnTwTranslation?}&hq={hq?}&hl={hl?}&siteSearch={siteSearch?}&siteSearchFilter={siteSearchFilter?}&exactTerms={exactTerms?}&excludeTerms={excludeTerms?}&linkSite={linkSite?}&orTerms={orTerms?}&relatedSite={relatedSite?}&dateRestrict={dateRestrict?}&lowRange={lowRange?}&highRange={highRange?}&searchType={searchType}&fileType={fileType?}&rights={rights?}&imgSize={imgSize?}&imgType={imgType?}&imgColorType={imgColorType?}&imgDominantColor={imgDominantColor?}&alt=json"
//  },
//  "queries": {
//    "request": [
//      {
//        "title": "Google Custom Search - 3039660002366",
//        "totalResults": "72",
//        "searchTerms": "3039660002366",
//        "count": 4,
//        "startIndex": 1,
//        "inputEncoding": "utf8",
//        "outputEncoding": "utf8",
//        "safe": "off",
//        "cx": "004174363264685956401:feculhur8rm",
//        "searchType": "image",
//        "imgSize": "large",
//        "imgType": "photo"
//      }
//    ],
//    "nextPage": [
//      {
//        "title": "Google Custom Search - 3039660002366",
//        "totalResults": "72",
//        "searchTerms": "3039660002366",
//        "count": 4,
//        "startIndex": 5,
//        "inputEncoding": "utf8",
//        "outputEncoding": "utf8",
//        "safe": "off",
//        "cx": "004174363264685956401:feculhur8rm",
//        "searchType": "image",
//        "imgSize": "large",
//        "imgType": "photo"
//      }
//    ]
//  },
//  "context": {
//    "title": "Sc-international.fr"
//  },
//  "searchInformation": {
//    "searchTime": 0.108483,
//    "formattedSearchTime": "0.11",
//    "totalResults": "72",
//    "formattedTotalResults": "72"
//  },
//  "items": [
//    {
//      "kind": "customsearch#result",
//      "title": "Bocal super 1.5 l - lot de 6 - 900508 - le parfait - home boulevard",
//      "htmlTitle": "Bocal super 1.5 l - lot de 6 - 900508 - le parfait - home boulevard",
//      "link": "https://www.home-boulevard.com/42282-52413-thickbox/bocal-super-1-5-l-lot-de-6.jpg",
//      "displayLink": "www.home-boulevard.com",
//      "snippet": "Bocal super 1.5 l - lot de 6 - 900508 - le parfait - home boulevard",
//      "htmlSnippet": "Bocal super 1.5 l - lot de 6 - 900508 - le parfait - home boulevard",
//      "mime": "image/jpeg",
//      "image": {
//        "contextLink": "http://www.home-boulevard.com/bassine-bocal-a-confiture-et-accessoire/42282-bocal-super-1-5-l-lot-de-6-900508-le-parfait-3039660002366.html",
//        "height": 600,
//        "width": 600,
//        "byteSize": 44707,
//        "thumbnailLink": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTli1Ap6uePjcsV-xVMLKX7DpzbnmtTvMLakyJ738tm1skwK4GaemPgTsPL",
//        "thumbnailHeight": 135,
//        "thumbnailWidth": 135
//      }
//    },
//    {
//      "kind": "customsearch#result",
//      "title": "bol.com | Le Parfait Super Weckpot -   85 mm - 1,5 L - Set-6",
//      "htmlTitle": "bol.com | Le Parfait Super Weckpot -   85 mm - 1,5 L - Set-6",
//      "link": "https://s.s-bol.com/imgbase0/imagebase3/large/FC/6/3/0/2/9200000028782036.jpg",
//      "displayLink": "www.bol.com",
//      "snippet": "bol.com | Le Parfait Super Weckpot -   85 mm - 1,5 L - Set-6",
//      "htmlSnippet": "bol.com | Le Parfait Super Weckpot -   85 mm - 1,5 L - Set-6",
//      "mime": "image/jpeg",
//      "image": {
//        "contextLink": "https://www.bol.com/nl/p/le-parfait-super-weckpot-85-mm-1-5-l-set-6/9200000028782036/",
//        "height": 840,
//        "width": 451,
//        "byteSize": 48890,
//        "thumbnailLink": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSb748uf9v9p26j1pBRfkSI1aPur6q8nw7ZGe6b41X2ZHhV-5br_uFd48k",
//        "thumbnailHeight": 145,
//        "thumbnailWidth": 78
//      }
//    },
//    {
//      "kind": "customsearch#result",
//      "title": "Le Parfait Super weckpot 1,5 liter (6 stuks)",
//      "htmlTitle": "Le Parfait Super weckpot 1,5 liter (6 stuks)",
//      "link": "https://www.weckenonline.com/media/catalog/product/cache/2/image/400x/040ec09b1e35df139433887a97daa66f/l/e/le-parfait-weckpot-super-1_5-liter.jpg",
//      "displayLink": "www.weckenonline.com",
//      "snippet": "Le Parfait Super weckpot 1,5 liter (6 stuks)",
//      "htmlSnippet": "Le Parfait Super weckpot 1,5 liter (6 stuks)",
//      "mime": "image/jpeg",
//      "image": {
//        "contextLink": "https://www.weckenonline.com/le-parfait-bewaarpot-1-5-liter-6-stuks.html",
//        "height": 515,
//        "width": 400,
//        "byteSize": 24094,
//        "thumbnailLink": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSVdq5TQbU2SsVS6jOhI2kz3tiaxmb9XAPO4UzgCdXWB3CPV16Z__eh0LXW",
//        "thumbnailHeight": 131,
//        "thumbnailWidth": 102
//      }
//    },
//    {
//      "kind": "customsearch#result",
//      "title": "Le Parfait Bewaarbokaal Super 1,5 l - 6 stuks | ColliShop",
//      "htmlTitle": "Le Parfait Bewaarbokaal Super 1,5 l - 6 stuks | ColliShop",
//      "link": "https://static.collishop.be/wcsstore/ColruytB2CCAS/JPG/JPG/646x1000/std.lang.all/66/62/asset-636662.jpg",
//      "displayLink": "www.collishop.be",
//      "snippet": "Le Parfait Bewaarbokaal Super 1,5 l - 6 stuks | ColliShop",
//      "htmlSnippet": "Le Parfait Bewaarbokaal Super 1,5 l - 6 stuks | ColliShop",
//      "mime": "image/jpeg",
//      "image": {
//        "contextLink": "https://www.collishop.be/e/nl/cs/le-parfait-bewaarbokaal-super-1-5-l---6-stuks-364568",
//        "height": 945,
//        "width": 507,
//        "byteSize": 38519,
//        "thumbnailLink": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTb6LWoerlVs4Rz6fXyqzpmoHo6zq8-wN_G6wXe1-Y1J9W0fVjFbx2UeOY",
//        "thumbnailHeight": 148,
//        "thumbnailWidth": 79
//      }
//    }
//  ]
//};


</script>
<?= $this->Form->create() ?>
  <table id="mytable">
  <?php foreach ($productQuery as $key => $product): ?>
  <tr><td id="product-<?php echo  $key; ?>">
  <h5><?php echo  h($product->title); ?></h5>
  <p style="font-size:11px">
    <b>Marque:</b> <?php echo  h($product->brand->title); ?> | 
    <b>Gencod:</b> <?php echo  h($product->gencod); ?> | 
    <b>Origine:</b> <?php echo  h($product->origin->title); ?> |
    <b>Code article:</b> <?php echo  h($product->code); ?> | 
    <b>Famille:</b> <?php echo  h($product->category->title); ?> | 
    <b>Sous famille:</b> <?php echo  h($product->subcategory->title); ?>
  <input type="hidden" name="product[<?php echo  $key; ?>][id]" value="<?php echo $product->id; ?>">
  <input type="hidden" name="product[<?php echo  $key; ?>][gencod]" value="<?php echo $product->gencod; ?>">
  <script>

  var gencod = <?php echo $product->gencod; ?>;
  var url = 'https://www.googleapis.com/customsearch/v1?q=' + gencod + '&cx=004174363264685956401:feculhur8rm&imgSize=medium&imgType=photo&searchType=image&num=4&key=AIzaSyDBXvQjtQUFM6I8cd2grlXO70a9Chss8jw';
  //$.get( url, function( data ) {
    // Si des resultat sont trouvé
    if (data.queries.request[0].totalResults >0){
      
      var htmlText = '<div><table><tr>';
      for (var i = 0; i < data.items.length; i++) { 
        if (data.items[i].link.includes('http') === true) { 
          htmlText += '<td style="text-align:center"><label><input type="radio" name="product[<?php echo  $key; ?>][url]" value="' + data.items[i].link + '"><br /><img src="' + data.items[i].image.thumbnailLink + '" /></label><br><a href="' + data.items[i].link + '" target="_blank">Agrandir photo</a><br /><a href="' + data.items[i].image.contextLink + '" target="_blank">Context</a></td>';
        }
      }
      htmlText += '</tr></table></div>';
      $('td#product-<?php echo  $key; ?>').append(htmlText);
    } else {
      $('td#product-<?php echo  $key; ?>').append('<div>Aucune photo trouvé</div>');
    }

  //});
      
  </script>

  </td></tr>
  
  <?php endforeach; ?>
  </table>
  <p style="text-align:center"><?= $this->Form->button(__('Valider!')) ?></p>
<?= $this->Form->end() ?>
