<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Product'), ['action' => 'edit', $product->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Product'), ['action' => 'delete', $product->id], ['confirm' => __('Are you sure you want to delete # {0}?', $product->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Products'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Product'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Origins'), ['controller' => 'Origins', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Origin'), ['controller' => 'Origins', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Brands'), ['controller' => 'Brands', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Brand'), ['controller' => 'Brands', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Warnings'), ['controller' => 'Warnings', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Warning'), ['controller' => 'Warnings', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Shortbrands'), ['controller' => 'Shortbrands', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Shortbrand'), ['controller' => 'Shortbrands', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Shortorigins'), ['controller' => 'Shortorigins', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Shortorigin'), ['controller' => 'Shortorigins', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="products view large-9 medium-8 columns content">
    <h3><?= h($product->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Code') ?></th>
            <td><?= h($product->code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Remplacement Product') ?></th>
            <td><?= h($product->remplacement_product) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($product->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Uv') ?></th>
            <td><?= h($product->uv) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Duree Vie') ?></th>
            <td><?= h($product->duree_vie) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gencod') ?></th>
            <td><?= h($product->gencod) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Douanier') ?></th>
            <td><?= h($product->douanier) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Dangereux') ?></th>
            <td><?= h($product->dangereux) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Origin') ?></th>
            <td><?= $product->has('origin') ? $this->Html->link($product->origin->title, ['controller' => 'Origins', 'action' => 'view', $product->origin->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cdref') ?></th>
            <td><?= h($product->cdref) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Category Code') ?></th>
            <td><?= h($product->category_code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Subcategory Code') ?></th>
            <td><?= h($product->subcategory_code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Entrepot') ?></th>
            <td><?= h($product->entrepot) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Supplier') ?></th>
            <td><?= h($product->supplier) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Qualification') ?></th>
            <td><?= h($product->qualification) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Pieceartk') ?></th>
            <td><?= h($product->pieceartk) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ifls Remplacement') ?></th>
            <td><?= h($product->ifls_remplacement) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Brand') ?></th>
            <td><?= $product->has('brand') ? $this->Html->link($product->brand->title, ['controller' => 'Brands', 'action' => 'view', $product->brand->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Temperature') ?></th>
            <td><?= h($product->temperature) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($product->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Pcb') ?></th>
            <td><?= $this->Number->format($product->pcb) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Prix') ?></th>
            <td><?= $this->Number->format($product->prix) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Poids') ?></th>
            <td><?= $this->Number->format($product->poids) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Volume') ?></th>
            <td><?= $this->Number->format($product->volume) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tva') ?></th>
            <td><?= $this->Number->format($product->tva) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Couche Palette') ?></th>
            <td><?= $this->Number->format($product->couche_palette) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Colis Palette') ?></th>
            <td><?= $this->Number->format($product->colis_palette) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Assortiment') ?></th>
            <td><?= $this->Number->format($product->assortiment) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Dlv') ?></th>
            <td><?= h($product->dlv) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($product->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($product->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Active') ?></th>
            <td><?= $product->active ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Warnings') ?></h4>
        <?php if (!empty($product->warnings)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('Urgence') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($product->warnings as $warnings): ?>
            <tr>
                <td><?= h($warnings->id) ?></td>
                <td><?= h($warnings->title) ?></td>
                <td><?= h($warnings->urgence) ?></td>
                <td><?= h($warnings->created) ?></td>
                <td><?= h($warnings->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Warnings', 'action' => 'view', $warnings->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Warnings', 'action' => 'edit', $warnings->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Warnings', 'action' => 'delete', $warnings->id], ['confirm' => __('Are you sure you want to delete # {0}?', $warnings->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Shortbrands') ?></h4>
        <?php if (!empty($product->shortbrands)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('Brand Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($product->shortbrands as $shortbrands): ?>
            <tr>
                <td><?= h($shortbrands->id) ?></td>
                <td><?= h($shortbrands->title) ?></td>
                <td><?= h($shortbrands->brand_id) ?></td>
                <td><?= h($shortbrands->created) ?></td>
                <td><?= h($shortbrands->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Shortbrands', 'action' => 'view', $shortbrands->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Shortbrands', 'action' => 'edit', $shortbrands->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Shortbrands', 'action' => 'delete', $shortbrands->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shortbrands->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Shortorigins') ?></h4>
        <?php if (!empty($product->shortorigins)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('Origin Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($product->shortorigins as $shortorigins): ?>
            <tr>
                <td><?= h($shortorigins->id) ?></td>
                <td><?= h($shortorigins->title) ?></td>
                <td><?= h($shortorigins->origin_id) ?></td>
                <td><?= h($shortorigins->created) ?></td>
                <td><?= h($shortorigins->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Shortorigins', 'action' => 'view', $shortorigins->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Shortorigins', 'action' => 'edit', $shortorigins->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Shortorigins', 'action' => 'delete', $shortorigins->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shortorigins->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
