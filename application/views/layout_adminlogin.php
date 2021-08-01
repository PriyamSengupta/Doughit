<?php
if($this->session->userdata('pz_admin_userid'))
{
  redirect($this->config->item('base_url').'admin/dashboard');
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Meta -->
        <meta name="description" content="Responsive Bootstrap4 Dashboard Template">
        <meta name="author" content="ParkerThemes">
        <link rel="shortcut icon" href="<?=base_url()?>dist/admin/img/fav.png" />
        <!-- Title -->
        <title><?php echo 'Doughit'.' :: '.$mainheader; ?></title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?=base_url()?>dist/admin/css/bootstrap.min.css" />

        <!-- Master CSS -->
        <link rel="stylesheet" href="<?=base_url()?>dist/admin/css/main.css" />

    </head>

    <body class="authentication">

        <?php echo $content_for_layout ?>

    </body>
</html>