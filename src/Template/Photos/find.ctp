Find photos
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<?= $this->Html->script("googleapi"); ?>

<?= $this->Form->create() ?>
  <table id="mytable">
  Left: <?php echo $productQuery->count(); ?>
  <?php foreach ($productQuery as $key => $product): ?>
  <tr><td id="product-<?php echo  $key; ?>">
  <h5><?php echo  h($product->title); ?>|<?php echo  h($product->id); ?></h5>
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

  // Check if array of values is in a string
  var url_include = ['http'];
  var url_exclude = ['.xml'];
  var file_extension =['.jpeg','.jpg','.png']

  function contains(target, array_of_string){
    var value = 0;
    array_of_string.forEach(function(word){

      if (target.includes(word)){
        value = 1;
      };
      
    });

    if(value === 1) {
      return true;
    } else {
      return false;
    }
    
  }


  var gencod = <?php echo $product->gencod; ?>;

  var url = 'https://www.googleapis.com/customsearch/v1?start=1&q=' + gencod + '&cx=004174363264685956401:feculhur8rm&imgType=photo&searchType=image&num=7&key=' + googleapikey;
 
  $.get( url, function( data ) {
    console.log(data);
    //Si des resultat sont trouvé
    if (data.queries.request[0].totalResults >0){
      
      var htmlText = '<div><table><tr>';
      for (var i = 0; i < data.items.length; i++) { 
        if ( contains(data.items[i].link, url_include) && !contains(data.items[i].link, url_exclude) && contains(data.items[i].link, file_extension)) { 
          htmlText += '<td style="text-align:center"><label><input type="radio" name="product[<?php echo  $key; ?>][url]" value="' + data.items[i].link + '"><br /><img src="' + data.items[i].image.thumbnailLink + '" /></label><br /> Size: ' + data.items[i].image.width + ' x ' + data.items[i].image.height + '<br><a href="' + data.items[i].link + '" target="_blank">Agrandir photo</a><br /><a href="' + data.items[i].image.contextLink + '" target="_blank">Context</a></td>';
        }
      }
      htmlText += '</tr><tr><td><input name="product[<?php echo  $key; ?>][customLink]" type"text" placeholder="Custom photo link" /></td></tr></table></div>';
      $('td#product-<?php echo  $key; ?>').append(htmlText);
    } else {
      $('td#product-<?php echo  $key; ?>').append('<div>Aucune photo trouvé</div>');
    }

  });
      
  </script>

  </td></tr>
  
  <?php endforeach; ?>
  </table>
  <p style="text-align:center"><?= $this->Form->button(__('Valider!')) ?></p>
<?= $this->Form->end() ?>
