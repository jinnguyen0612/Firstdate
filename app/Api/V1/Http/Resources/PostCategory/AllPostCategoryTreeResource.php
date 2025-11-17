<?php

namespace App\Api\V1\Http\Resources\PostCategory;

use App\Api\V1\Http\Resources\MiniApp\ShowMiniAppCategoryWithPostResource;
use App\Traits\HasRepositoryFromApi;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AllPostCategoryTreeResource extends ResourceCollection
{
    use HasRepositoryFromApi;
    public function toArray($request)
    {
        return $this->collection->map(function ($category) {

            return $this->recursive($category);
        });
    }

    private function recursive($category)
    {
        return new ShowMiniAppCategoryWithPostResource($category, $this->getPostRepository());
    }
}
