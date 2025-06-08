<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CreationPageController extends Controller
{
    private function convertNameToSlug($name)
    {
        return Str::slug($name);
    }
    private function getCreationPageConfig($entity) {
        $configs = [
            $this->convertNameToSlug("Product Category") => [
                'title' => 'Create Product Category',
                'description' => 'Add a new product category to the system.',
                'fields' => [
                    ["label" => "Category Name", "name" => "category_name", "type" => "text", "required" => true],
                    ["label" => "Description", "name" => "category_description", "type" => "textarea", "required" => false],
                    ["label" => "Category Banner", "name" => "category_banner", "type" => "file", "required" => false],
                ]
            ],
            // Add more entities as needed
        ];
        return $configs[$entity] ?? null;
    }
    public function getCreationPage(Request $request, $page) {
        $entity = $request->query('entity', $page);
        $config = $this->getCreationPageConfig($entity);
        if (!$config) {
            abort(404, 'Creation page not found');
        }
        $title = $config['title'];
        $description = $config['description'];
        return view('Pages.Admin.Creation', compact('title', 'description', 'entity'));
    }

    public function handleCreation($entity, Request $request) {
        switch ($entity) {
            case $this->convertNameToSlug("Product Category"):
                return app(ProductCategoryController::class)->create($request);
                break;
            default:
                abort(404, 'Creation handler not found for this entity');
                break;
        }
    }
}
