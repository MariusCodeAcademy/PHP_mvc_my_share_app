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
                    <input id="username"  type="text" name="username" class="form-control" value="<?php echo $_SESSION['user_name'] ?>" placeholder="Your Name">
                    <span class='invalid-feedback'></span>

                </div>
                <div class="form-group">
                    <textarea id="comment-body"  name="commentBody" class="form-control " placeholder="Add comment"></textarea>
                    <span class='invalid-feedback'></span>
                </div>
                <button id='submit-btn' type="submit" class='btn btn-success'>Comment</button>
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
        const usernameInputEl = document.getElementById('username');
        const submitBtnEl = document.getElementById('submit-btn');

        addCommentFormEl.addEventListener('submit', addCommentAsync);

        commentBodyEl.addEventListener('input', clearErrorsOnInput);
        usernameInputEl.addEventListener('input', clearErrorsOnInput);

        fetchComments();

        function clearErrorsOnInput(event) {
            // console.log('clearErrorsOnInput');
            // if input length is  2 and more characters we remove error class
            const stringLength = event.target.value.length;
            // console.log(stringLength)
            if (stringLength > 1) {
                event.target.classList.remove('is-invalid');
                submitBtnEl.removeAttribute('disabled');
            }
        }

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
            resetErrors();
            
            // add data and post it to api 
            const addCommentFormData = new FormData(addCommentFormEl);

            // send data to api 
            fetch('<?php echo URLROOT . '/api/addComment/' . $data['post']->id ?>', {
                    method: 'post',
                    body: addCommentFormData
                })
                .then(resp => resp.json())
                .then(data => {
                    // console.log(data);
                    if (data.success){
                        handleSuccessComment();
                    } else {
                        handleCommentError(data.errors)
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

        function handleCommentError(errorObj) {
            console.log('handleCommentError');
            console.log(errorObj);

            submitBtnEl.setAttribute('disabled', '');

            if(errorObj.commentBodyErr) {
                // add error class
                commentBodyEl.classList.add('is-invalid');
                //add error text
                commentBodyEl.nextElementSibling.innerHTML = errorObj.commentBodyErr;
            }

            if(errorObj.usernameErr) {
                usernameInputEl.classList.add('is-invalid');
                usernameInputEl.nextElementSibling.innerHTML = errorObj.usernameErr;
            }

        }

        function resetErrors() {
            // search form for al is-inavlid clases and remove them
            const errorEl = addCommentFormEl.querySelectorAll('.is-invalid');
            // console.log("errorEl")
            // console.log(errorEl)
            errorEl.forEach((errorInputEl) => errorInputEl.classList.remove('is-invalid'));
        }
    </script>

<?php endif; ?>


<?php require APPROOT . '/views/inc/footer.php'; ?>