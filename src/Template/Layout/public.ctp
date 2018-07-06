<script>
  //Defnie l'url de l'appli pour utilisation dans les fichier js avec la varialbe baseUrl
  var baseUrl = '<?php echo $this->Url->build('/', true); ?>';
</script>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Nature App</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<?= $this->Html->css('https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css') ?>
<?= $this->Html->css('custom') ?>
<?= $this->fetch('css') ?>



</head>
<body>
<div class="container">
<p class="logo">
<?= $this->Html->image('logo-nature.png',["id" => "logo"]) ?>
</p>

<?php echo $this->Flash->render(); ?>
<?php echo $this->Flash->render('auth'); ?>
<?php echo $this->fetch('content'); ?>

<?= $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js') ?>
<?= $this->Html->script('https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js') ?>
<?= $this->Html->script('https://use.fontawesome.com/releases/v5.0.13/js/all.js') ?>
<?= $this->Html->script('custom') ?>
<?= $this->fetch('scriptBottom') ?>



</body>
</html>
