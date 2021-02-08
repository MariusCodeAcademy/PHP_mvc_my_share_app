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
        <div class="col-12">
            <h2>Add Comment</h2>
            <form id="add-comment-form" action="" method="post">
                <div class="form-group">
                    <input  type="text" name="username" class="form-control" value="<?php echo $_SESSION['user_name'] ?>" placeholder="Your Name">
                </div>
                <div class="form-group">
                    <textarea id="comment-body"  name="commentBody" class="form-control" placeholder="Add comment"></textarea>
                </div>
                <button type="submit" class='btn btn-success'>Comment</button>
            </form>
        </div>
        <div class="col-12">
            <h2 class='my-3'>Comments</h2>
            <div id="comments" class="comment-container">
                <h2 class="display-3">Loading</h2>
            </div>
        </div>
    </div>

    <script>
        const commentsOutputEl = document.getElementById('comments');
        const addCommentFormEl = document.getElementById('add-comment-form');
        const commentBodyEl = document.getElementById('comment-body');

        addCommentFormEl.addEventListener('submit', addCommentAsync);



        fetchComments();

        function fetchComments() {
            fetch('<?php echo URLROOT . '/api/comments/' . $data['post']->id ?>')
                .then(resp => resp.json())
                .then(data => {
                    console.log(data);
                    generateHTMLComments(data.comments);
                });
        }

        function generateHTMLComments(commentArr) {
            commentsOutputEl.innerHTML = '';
            commentArr.forEach(function(commentObj) {
                commentsOutputEl.innerHTML += generateComment(commentObj);
            });
        }

        function generateComment(oneComment) {
            return `
                <div class="card" id='${oneComment.comment_id}' >
                    <div class="card-header">
                    ${oneComment.author} 
                    <span>${oneComment.created_at}</span></div>
                    <div class="card-body">
                        ${oneComment.comment_body}
                    </div>
                </div>
            `;
        }

        function addCommentAsync(event) {
            event.preventDefault();
            // console.log('add comment');
            // add data and post it to api 
            const addCommentFormData = new FormData(addCommentFormEl);

            // send data to api 
            fetch('<?php echo URLROOT . '/api/addComment/' . $data['post']->id ?>', {
                    method: 'post',
                    body: addCommentFormData
                })
                .then(resp => resp.json())
                .then(data => {
                    console.log(data);
                    if (data.success){
                        handleSuccessComment();
                    }
                })
                .catch(error => console.error(error));
        }

        function handleSuccessComment(){
            // clear comment fields
            commentBodyEl.value = '';

            // add new comment
            fetchComments();
        }
    </script>

<?php endif; ?>


<?php require APPROOT . '/views/inc/footer.php'; ?>