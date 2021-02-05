<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT ?>/posts" class='btn btn-light my-3'> <i class="fa fa-chevron-left"></i> Back</a>
<br />

<h1 class="display-3"><?php echo $data['post']->title ?></h1>
<div class="bg-secondary text-white p-2 mb-3">
    Written by <strong><?php echo $data['user']->name ?></strong>
    On: <?php echo $data['post']->created_at ?>
</div>
<p class="lead"><?php echo $data['post']->body ?></p>

<!-- show this only if this post belongs to this user -->
<?php if ($_SESSION['user_id'] === $data['post']->user_id) : ?>
    <hr>
    <a href="<?php echo URLROOT . '/posts/edit/' . $data['post']->id ?>" class='btn btn-info '> <i class="fa fa-pencil"></i> Edit</a>

    <form action="<?php echo URLROOT . '/posts/delete/' . $data['post']->id ?>" method="post" class='pull-right'>
        <button type="submit" class="btn btn-danger"><i class="fa fa-close"></i> Delete</button>
    </form>
<?php endif; ?>

<?php if (isset($data['commentsOn'])) : ?>

    <hr class="mt-5 mb-4">
    <div class="row mb-5">
        <div class="col">
            <h2>Comments</h2>
            <div id="comments" class="comment-container">
                <div class="card">
                    <div class="card-header">Author <span>When</span></div>
                    <div class="card-body">
                        comment text
                    </div>
                </div>
            </div>

        </div>
    </div>

<?php endif; ?>


<?php require APPROOT . '/views/inc/footer.php'; ?>