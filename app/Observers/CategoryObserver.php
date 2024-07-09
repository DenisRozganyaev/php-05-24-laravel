<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    public function deleted(Category $category): void
    {
        if ($category->childs()->exists()) {
            $category->childs()->update(['parent_id' => null]);
        }
    }
}
