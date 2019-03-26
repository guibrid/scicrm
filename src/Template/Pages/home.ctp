<h1>Gestion base de produits</h1>
<hr />
<h3>Importation de la nouvelle base de produits</h3>
<?= $this->Form->create(null , ['type' => 'file']) ?>
<p><?= $this->Form->file('submittedfile') ?><?= $this->Form->button(__('Update'),['class' => 'button']) ?></p>
<?= $this->Form->end() ?>
<hr />
<h3>Chercher les marques manquantes</h3>
<p><?php //echo $this->Html->link('Rechercher', '/photos/find',['class' => 'button']); ?></p>
<hr />
<h3>Chercher les photos</h3>
<p><?= $this->Html->link(
    'Rechercher',
    '/photos/find',
    ['class' => 'button']
) ?></p>

<hr />