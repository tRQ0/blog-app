<?php

namespace App\Filters\V1;

use App\Filters\ApiResponseFilter;

class PostFilter extends ApiResponseFilter {
    protected $remapAttrs = [
        'user_id' => 'authorId',
        'cover_image' => 'coverImage',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
        'user' => 'author',
    ];
}