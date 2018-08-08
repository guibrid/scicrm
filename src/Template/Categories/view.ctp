<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Category'), ['action' => 'edit', $category->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Category'), ['action' => 'delete', $category->id], ['confirm' => __('Are you sure you want to delete # {0}?', $category->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Stores'), ['controller' => 'Stores', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Store'), ['controller' => 'Stores', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Products'), ['controller' => 'Products', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Product'), ['controller' => 'Products', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Subcategories'), ['controller' => 'Subcategories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Subcategory'), ['controller' => 'Subcategories', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="categories view large-9 medium-8 columns content">
    <h3><?= h($category->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Code') ?></th>
            <td><?= h($category->code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($category->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= h($category->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Store') ?></th>
            <td><?= $category->has('store') ? $this->Html->link($category->store->title, ['controller' => 'Stores', 'action' => 'view', $category->store->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($category->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($category->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($category->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Active') ?></th>
            <td><?= $category->active ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Products') ?></h4>
        <?php if (!empty($category->products)): ?>
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
                <th scope="col"><?= __('Category Id') ?></th>
                <th scope="col"><?= __('Subcategory Id') ?></th>
                <th scope="col"><?= __('Entrepot') ?></th>
                <th scope="col"><?= __('Supplier') ?></th>
                <th scope="col"><?= __('Qualification') ?></th>
                <th scope="col"><?= __('Couche Palette') ?></th>
                <th scope="col"><?= __('Colis Palette') ?></th>
                <th scope="col"><?= __('Pieceartk') ?></th>
                <th scope="col"><?= __('Ifls Remplacement') ?></th>
                <th scope="col"><?= __('Assortiment') ?></th>
                <th scope="col"><?= __('Brand Id') ?></th>
                <th scope="col"><?= __('New') ?></th>
                <th scope="col"><?= __('Active') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($category->products as $products): ?>
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
                <td><?= h($products->category_id) ?></td>
                <td><?= h($products->subcategory_id) ?></td>
                <td><?= h($products->entrepot) ?></td>
                <td><?= h($products->supplier) ?></td>
                <td><?= h($products->qualification) ?></td>
                <td><?= h($products->couche_palette) ?></td>
                <td><?= h($products->colis_palette) ?></td>
                <td><?= h($products->pieceartk) ?></td>
                <td><?= h($products->ifls_remplacement) ?></td>
                <td><?= h($products->assortiment) ?></td>
                <td><?= h($products->brand_id) ?></td>
                <td><?= h($products->new) ?></td>
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
    <div class="related">
        <h4><?= __('Related Subcategories') ?></h4>
        <?php if (!empty($category->subcategories)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Code') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('Category Id') ?></th>
                <th scope="col"><?= __('Active') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($category->subcategories as $subcategories): ?>
            <tr>
                <td><?= h($subcategories->id) ?></td>
                <td><?= h($subcategories->code) ?></td>
                <td><?= h($subcategories->title) ?></td>
                <td><?= h($subcategories->category_id) ?></td>
                <td><?= h($subcategories->active) ?></td>
                <td><?= h($subcategories->created) ?></td>
                <td><?= h($subcategories->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Subcategories', 'action' => 'view', $subcategories->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Subcategories', 'action' => 'edit', $subcategories->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Subcategories', 'action' => 'delete', $subcategories->id], ['confirm' => __('Are you sure you want to delete # {0}?', $subcategories->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
