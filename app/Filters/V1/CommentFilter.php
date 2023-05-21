<?php

namespace App\Filters\V1;

use App\Filters\ApiResponseFilter;

class CommentFilter extends ApiResponseFilter {
    protected $remapAttrs = [
        'user_id' => 'authorId',
        'parent_id' => 'parentId',
        'post_id' => 'postId',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
        'child_comment' => 'replies',
    ];
}