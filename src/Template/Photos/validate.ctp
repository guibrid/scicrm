<style>
input.validate {

  height: 35px;
  width: 35px;
  color: red;
}
</style>
<?= $this->Form->create() ?>
<table>
<?php foreach ($photos as $photo): ?>
<tr>

    <td><a href="<?= h($photo->url) ?>" target="_blank"><img src="<?= h($photo->url) ?>" width="200px" height="200px" /></a></td>
    <td valign="middle"><?php echo h($photo->product->title); ?></td>
    <td>
    
    <input type="hidden" name="product_ids[]" value="<?php echo $photo->product->id; ?>">
    <input type="checkbox" class="validate" name="<?php echo $photo->product->id; ?>" value="1" checked></td>
</tr>
<?php endforeach; ?>

</table>
<p style="text-align:center"><?= $this->Form->button(__('Valider!')) ?></p>
<?= $this->Form->end() ?>