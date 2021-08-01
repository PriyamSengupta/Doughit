<div class="comment-part">
    <h3><?=$get_post_comments['total_comments']?> COMMENTS</h3>
    <ul>
        <?php foreach ($get_post_comments['comment_array'] as $comment) { ?>
            <li>
                <div class="comment-user">
                    <img src="<?=$this->config->item('file_upload_base_url').'user/normal/'.get_user_image($comment->user_id)?>" alt="comment-img">
                </div>
                <div class="comment-detail">
                    <span class="commenter">
                        <span><?=get_username($comment->user_id)?></span> (<?=date("F j, Y",strtotime($comment->comment_time))?>)
                    </span>
                    <p><?=$comment->comment?></p>
                    <!-- <a href="#" class="reply-btn btn btn-color small">Reply</a> -->
                </div>
                <div class="clearfix"></div>
            </li>
        <?php } ?>
    </ul>
</div>