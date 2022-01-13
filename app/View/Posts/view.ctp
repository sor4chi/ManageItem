<h2>
    <?php echo h($post['Post']['title']); ?>
</h2>
<p>
    <?php echo h($post['Post']['body']); ?>
</p>

<h2>Comments</h2>
<ul>
<?php foreach ($post['Comment'] as $comment): ?>
<li id="comment_<?php echo h($comment['id']); ?>">
    <?php echo h($comment['body']) ?> by <?php echo h($comment['commenter']); ?>
    <?php echo $this->Html->link('削除', '#', array('class'=>'delete', 'data-comment-id'=>$comment['id'])); ?>
</li>
<?php endforeach; ?>
</ul>

<h2>Add Comment</h2>

<form>
    <label for="commenter">Commenter</label>
    <input type="text" id="commenter" name="commenter">
    <label for="comment_body">Body</label>
    <textarea name="body" id="comment_body" cols="30" rows="3"></textarea>
    <input type="hidden" id="comment_post_id" value="<?php echo h($post['Post']['id']);?>">
    <input type="button" id="comment_post_btn" value="post comment">
</form>

<script>
$(function() {
    $('a.delete').click(function(e) {
        if (confirm('sure?')) {
            $.post('/blog/comments/delete/'+$(this).data('comment-id'), {}, function(res) {
                $('#comment_'+res.id).fadeOut(800);
            }, "json");
        }
        return false;
    });
    $('input#comment_post_btn').click(function(e) {
        var body = {}
        body.commenter = $("#commenter").val()
        body.body = $("#comment_body").val()
        body.post_id = $("#comment_post_id").val()
        $.ajax({
            type: 'POST',
            url: '/blog/comments/add',
            data: body,
            success: function(data) {
                location.reload();
            }
        })
    })
});
</script>