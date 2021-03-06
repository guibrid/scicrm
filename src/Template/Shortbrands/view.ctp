<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shortbrand $shortbrand
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Shortbrand'), ['action' => 'edit', $shortbrand->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Shortbrand'), ['action' => 'delete', $shortbrand->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shortbrand->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Shortbrands'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Shortbrand'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Brands'), ['controller' => 'Brands', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Brand'), ['controller' => 'Brands', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Products'), ['controller' => 'Products', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Product'), ['controller' => 'Products', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="shortbrands view large-9 medium-8 columns content">
    <h3><?= h($shortbrand->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($shortbrand->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Brand') ?></th>
            <td><?= $shortbrand->has('brand') ? $this->Html->link($shortbrand->brand->title, ['controller' => 'Brands', 'action' => 'view', $shortbrand->brand->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($shortbrand->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($shortbrand->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($shortbrand->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Products') ?></h4>
        <?php if (!empty($shortbrand->products)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Code') ?></th>
                <th scope="col"><?= __('Remplacement Product') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('Pcb') ?></th>
                <th scope="col"><?= __('Prix') ?></th>
                <th scope="col"><?= __('Uv') ?></th>
                <th scope="col"><?= __('Poids') ?></th>
                <th scope="col"><?= __('Volume') ?></th>
                <th scope="col"><?= __('Dlv') ?></th>
                <th scope="col"><?= __('Duree Vie') ?></th>
                <th scope="col"><?= __('Gencod') ?></th>
                <th scope="col"><?= __('Douanier') ?></th>
                <th scope="col"><?= __('Dangereux') ?></th>
                <th scope="col"><?= __('Origin Id') ?></th>
                <th scope="col"><?= __('Tva') ?></th>
                <th scope="col"><?= __('Cdref') ?></th>
                <th scope="col"><?= __('Category Code') ?></th>
                <th scope="col"><?= __('Subcategory Code') ?></th>
                <th scope="col"><?= __('Entrepot') ?></th>
                <th scope="col"><?= __('Supplier') ?></th>
                <th scope="col"><?= __('Qualification') ?></th>
                <th scope="col"><?= __('Couche Palette') ?></th>
                <th scope="col"><?= __('Colis Palette') ?></th>
                <th scope="col"><?= __('Pieceartk') ?></th>
                <th scope="col"><?= __('Ifls Remplacement') ?></th>
                <th scope="col"><?= __('Assortiment') ?></th>
                <th scope="col"><?= __('Brand Id') ?></th>
                <th scope="col"><?= __('Temperature') ?></th>
                <th scope="col"><?= __('Active') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($shortbrand->products as $products): ?>
            <tr>
                <td><?= h($products->id) ?></td>
                <td><?= h($products->code) ?></td>
                <td><?= h($products->remplacement_product) ?></td>
                <td><?= h($products->title) ?></td>
                <td><?= h($products->pcb) ?></td>
                <td><?= h($products->prix) ?></td>
                <td><?= h($products->uv) ?></td>
                <td><?= h($products->poids) ?></td>
                <td><?= h($products->volume) ?></td>
                <td><?= h($products->dlv) ?></td>
                <td><?= h($products->duree_vie) ?></td>
                <td><?= h($products->gencod) ?></td>
                <td><?= h($products->douanier) ?></td>
                <td><?= h($products->dangereux) ?></td>
                <td><?= h($products->origin_id) ?></td>
                <td><?= h($products->tva) ?></td>
                <td><?= h($products->cdref) ?></td>
                <td><?= h($products->category_code) ?></td>
                <td><?= h($products->subcategory_code) ?></td>
                <td><?= h($products->entrepot) ?></td>
                <td><?= h($products->supplier) ?></td>
                <td><?= h($products->qualification) ?></td>
                <td><?= h($products->couche_palette) ?></td>
                <td><?= h($products->colis_palette) ?></td>
                <td><?= h($products->pieceartk) ?></td>
                <td><?= h($products->ifls_remplacement) ?></td>
                <td><?= h($products->assortiment) ?></td>
                <td><?= h($products->brand_id) ?></td>
                <td><?= h($products->temperature) ?></td>
                <td><?= h($products->active) ?></td>
                <td><?= h($products->created) ?></td>
                <td><?= h($products->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Products', 'action' => 'view', $products->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Products', 'action' => 'edit', $products->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Products', 'action' => 'delete', $products->id], ['confirm' => __('Are you sure you want to delete # {0}?', $products->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
