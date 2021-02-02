<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT ?>/posts" class='btn btn-light my-3'> <i class="fa fa-chevron-left"></i> Back</a>
<br />

<h1 class="display-3"><?php echo $data['post']->title ?></h1>
<div class="bg-secondary text-white p-2 mb-3">
    Written by <strong><?php echo $data['user']->name ?></strong>
    On: <?php echo $data['post']->created_at ?>
</div>
<p class="lead"><?php echo $data['post']->body ?></p>




<?php require APPROOT . '/views/inc/footer.php'; ?>