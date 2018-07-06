<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product[]|\Cake\Collection\CollectionInterface $products
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Product'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Origins'), ['controller' => 'Origins', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Origin'), ['controller' => 'Origins', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Brands'), ['controller' => 'Brands', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Brand'), ['controller' => 'Brands', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Warnings'), ['controller' => 'Warnings', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Warning'), ['controller' => 'Warnings', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Shortbrands'), ['controller' => 'Shortbrands', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Shortbrand'), ['controller' => 'Shortbrands', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Shortorigins'), ['controller' => 'Shortorigins', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Shortorigin'), ['controller' => 'Shortorigins', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="products index large-9 medium-8 columns content">
    <h3><?= __('Products') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('code') ?></th>
                <th scope="col"><?= $this->Paginator->sort('remplacement_product') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('pcb') ?></th>
                <th scope="col"><?= $this->Paginator->sort('prix') ?></th>
                <th scope="col"><?= $this->Paginator->sort('uv') ?></th>
                <th scope="col"><?= $this->Paginator->sort('poids') ?></th>
                <th scope="col"><?= $this->Paginator->sort('volume') ?></th>
                <th scope="col"><?= $this->Paginator->sort('dlv') ?></th>
                <th scope="col"><?= $this->Paginator->sort('duree_vie') ?></th>
                <th scope="col"><?= $this->Paginator->sort('gencod') ?></th>
                <th scope="col"><?= $this->Paginator->sort('douanier') ?></th>
                <th scope="col"><?= $this->Paginator->sort('dangereux') ?></th>
                <th scope="col"><?= $this->Paginator->sort('origin_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tva') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cdref') ?></th>
                <th scope="col"><?= $this->Paginator->sort('category_code') ?></th>
                <th scope="col"><?= $this->Paginator->sort('subcategory_code') ?></th>
                <th scope="col"><?= $this->Paginator->sort('entrepot') ?></th>
                <th scope="col"><?= $this->Paginator->sort('supplier') ?></th>
                <th scope="col"><?= $this->Paginator->sort('qualification') ?></th>
                <th scope="col"><?= $this->Paginator->sort('couche_palette') ?></th>
                <th scope="col"><?= $this->Paginator->sort('colis_palette') ?></th>
                <th scope="col"><?= $this->Paginator->sort('pieceartk') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ifls_remplacement') ?></th>
                <th scope="col"><?= $this->Paginator->sort('assortiment') ?></th>
                <th scope="col"><?= $this->Paginator->sort('brand_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('temperature') ?></th>
                <th scope="col"><?= $this->Paginator->sort('active') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?= $this->Number->format($product->id) ?></td>
                <td><?= h($product->code) ?></td>
                <td><?= h($product->remplacement_product) ?></td>
                <td><?= h($product->title) ?></td>
                <td><?= $this->Number->format($product->pcb) ?></td>
                <td><?= $this->Number->format($product->prix) ?></td>
                <td><?= h($product->uv) ?></td>
                <td><?= $this->Number->format($product->poids) ?></td>
                <td><?= $this->Number->format($product->volume) ?></td>
                <td><?= h($product->dlv) ?></td>
                <td><?= h($product->duree_vie) ?></td>
                <td><?= h($product->gencod) ?></td>
                <td><?= h($product->douanier) ?></td>
                <td><?= h($product->dangereux) ?></td>
                <td><?= $product->has('origin') ? $this->Html->link($product->origin->title, ['controller' => 'Origins', 'action' => 'view', $product->origin->id]) : '' ?></td>
                <td><?= $this->Number->format($product->tva) ?></td>
                <td><?= h($product->cdref) ?></td>
                <td><?= h($product->category_code) ?></td>
                <td><?= h($product->subcategory_code) ?></td>
                <td><?= h($product->entrepot) ?></td>
                <td><?= h($product->supplier) ?></td>
                <td><?= h($product->qualification) ?></td>
                <td><?= $this->Number->format($product->couche_palette) ?></td>
                <td><?= $this->Number->format($product->colis_palette) ?></td>
                <td><?= h($product->pieceartk) ?></td>
                <td><?= h($product->ifls_remplacement) ?></td>
                <td><?= $this->Number->format($product->assortiment) ?></td>
                <td><?= $product->has('brand') ? $this->Html->link($product->brand->title, ['controller' => 'Brands', 'action' => 'view', $product->brand->id]) : '' ?></td>
                <td><?= h($product->temperature) ?></td>
                <td><?= h($product->active) ?></td>
                <td><?= h($product->created) ?></td>
                <td><?= h($product->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $product->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $product->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $product->id], ['confirm' => __('Are you sure you want to delete # {0}?', $product->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
