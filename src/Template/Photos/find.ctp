Find photos
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
var data =
{
 "kind": "customsearch#search",
 "url": {
  "type": "application/json",
  "template": "https://www.googleapis.com/customsearch/v1?q={searchTerms}&num={count?}&start={startIndex?}&lr={language?}&safe={safe?}&cx={cx?}&sort={sort?}&filter={filter?}&gl={gl?}&cr={cr?}&googlehost={googleHost?}&c2coff={disableCnTwTranslation?}&hq={hq?}&hl={hl?}&siteSearch={siteSearch?}&siteSearchFilter={siteSearchFilter?}&exactTerms={exactTerms?}&excludeTerms={excludeTerms?}&linkSite={linkSite?}&orTerms={orTerms?}&relatedSite={relatedSite?}&dateRestrict={dateRestrict?}&lowRange={lowRange?}&highRange={highRange?}&searchType={searchType}&fileType={fileType?}&rights={rights?}&imgSize={imgSize?}&imgType={imgType?}&imgColorType={imgColorType?}&imgDominantColor={imgDominantColor?}&alt=json"
 },
 "queries": {
  "request": [
   {
    "title": "Google Custom Search - 4008713700923",
    "totalResults": "50",
    "searchTerms": "4008713700923",
    "count": 3,
    "startIndex": 1,
    "inputEncoding": "utf8",
    "outputEncoding": "utf8",
    "safe": "off",
    "cx": "004174363264685956401:feculhur8rm",
    "searchType": "image",
    "imgSize": "large",
    "imgType": "photo"
   }
  ],
  "nextPage": [
   {
    "title": "Google Custom Search - 4008713700923",
    "totalResults": "50",
    "searchTerms": "4008713700923",
    "count": 3,
    "startIndex": 4,
    "inputEncoding": "utf8",
    "outputEncoding": "utf8",
    "safe": "off",
    "cx": "004174363264685956401:feculhur8rm",
    "searchType": "image",
    "imgSize": "large",
    "imgType": "photo"
   }
  ]
 },
 "context": {
  "title": "Sc-international.fr"
 },
 "searchInformation": {
  "searchTime": 0.591682,
  "formattedSearchTime": "0.59",
  "totalResults": "50",
  "formattedTotalResults": "50"
 },
 "items": [
  {
   "kind": "customsearch#result",
   "title": "Joe's Farm Corn Flakes 375g – NHAM24 Fresh",
   "htmlTitle": "Joe&#39;s Farm Corn Flakes 375g – NHAM24 Fresh",
   "link": "https://nham24.com/fresh/wp-content/uploads/2017/09/Untitled-1-23.jpg",
   "displayLink": "nham24.com",
   "snippet": "Joe's Farm Corn Flakes 375g – NHAM24 Fresh",
   "htmlSnippet": "Joe&#39;s Farm Corn Flakes 375g – NHAM24 Fresh",
   "mime": "image/jpeg",
   "image": {
    "contextLink": "https://nham24.com/fresh/shop/groceries/cereal-spread-cream-butter-cheese/cerealmueslioatmeal/joes-farm-corn-flakes-375g/",
    "height": 600,
    "width": 510,
    "byteSize": 53788,
    "thumbnailLink": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQbt9y0SJtbZE3KBA_ElmYGzfpGKTXt1_5AWfo3oNGsHQ0hdV0YKen54FU",
    "thumbnailHeight": 135,
    "thumbnailWidth": 115
   }
  },
  {
   "kind": "customsearch#result",
   "title": "Potato Puree Rochambeau 4x125g 500g =\u003e DRIED SPECIES",
   "htmlTitle": "Potato Puree Rochambeau 4x125g 500g =&gt; DRIED SPECIES",
   "link": "http://chineseshoes.fr/prods/photos/09062371.jpg",
   "displayLink": "chineseshoes.fr",
   "snippet": "Potato Puree Rochambeau 4x125g 500g =\u003e DRIED SPECIES",
   "htmlSnippet": "Potato Puree Rochambeau 4x125g 500g =&gt; DRIED SPECIES",
   "mime": "image/jpeg",
   "image": {
    "contextLink": "http://chineseshoes.fr/store/stocki.php?categoryref=219&start=0&lang=en",
    "height": 661,
    "width": 500,
    "byteSize": 51822,
    "thumbnailLink": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSrNJH9lnINBJrhPTeoJJ0gPEQJA7mbIw81p5N5Um3BcltUMSTGz4KdIKQ",
    "thumbnailHeight": 138,
    "thumbnailWidth": 104
   }
  },
  {
   "kind": "customsearch#result",
   "title": "Maple Joe - Maple Joe Sirop Erable Bouteille 250G - 3088542500285",
   "htmlTitle": "Maple Joe - Maple Joe Sirop Erable Bouteille 250G - 3088542500285",
   "link": "https://images.ssstatic.com/maple-joe-maple-joe-sirop-erable-bouteille-250g-3088542500285-9225579z2-22232775.jpg",
   "displayLink": "www.solostocks.fr",
   "snippet": "Maple Joe - Maple Joe Sirop Erable Bouteille 250G - 3088542500285",
   "htmlSnippet": "Maple Joe - Maple Joe Sirop Erable Bouteille 250G - 3088542500285",
   "mime": "image/jpeg",
   "image": {
    "contextLink": "https://www.solostocks.fr/vente-produits/condiments-sauces/sucre/maple-joe-maple-joe-sirop-erable-bouteille-250g-3088542500285-9225579",
    "height": 500,
    "width": 500,
    "byteSize": 34777,
    "thumbnailLink": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRdQtcpxbTgSDWTyWvl-tqHeysVqZpGd2wvfYejth6d0Muhq_x8QbmQYCS3QQ",
    "thumbnailHeight": 130,
    "thumbnailWidth": 130
   }
  }
 ]
};


</script>
<?= $this->Form->create() ?>
  <table id="mytable">
  <?php foreach ($productQuery as $key => $product): ?>
  <?php 
  debug($product->id);
  debug($product->photos[0]->url)
    ?>
  

  <tr><td id="product-<?php echo  $key; ?>">
  <h5><?php echo  h($product->title); ?></h5>
  <input type="hidden" name="product_ids[<?php echo  $key; ?>]" value="<?php echo $product->id; ?>">
  <input type="hidden" name="product_gencods[<?php echo  $key; ?>]" value="<?php echo $product->gencod; ?>">
  <script>
  //var gencod = <?php echo $product->gencod; ?>;
  //var url = 'https://www.googleapis.com/customsearch/v1?q=' + gencod + '&cx=004174363264685956401:feculhur8rm&imgSize=large&imgType=photo&searchType=image&num=3&key=AIzaSyDBXvQjtQUFM6I8cd2grlXO70a9Chss8jw';
  //$.get( url, function( data ) {

    var htmlText = '<div><table><tr>';
    for (var i = 0; i < data.items.length; i++) { 
        console.log(data.items[i].link)
        htmlText += '<td style="text-align:center"><label><input type="radio" name="photo_url[<?php echo  $key; ?>]" value="' + data.items[i].link + '"><br /><img src="' + data.items[i].image.thumbnailLink + '" /></label><br><a href="' + data.items[i].link + '" target="_blank">Ouvrir photo</a></td>';
    }
    htmlText += '</tr></table></div>';
    $('td#product-<?php echo  $key; ?>').append(htmlText);

  //});
      
  </script>

  </td></tr>
  
  <?php endforeach; ?>
  </table>
  <p style="text-align:center"><?= $this->Form->button(__('Valider!')) ?></p>
<?= $this->Form->end() ?>
