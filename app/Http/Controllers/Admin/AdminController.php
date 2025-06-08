<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{

    public function index()
    {
        return view('Pages.Admin.Dashboard');
    }

    public function getProfile() {
        return view('Pages.Admin.Profile');
    }


    public function getList(Request $request, $filter_entity)
    {
        $entity = $request->query("entity", $filter_entity);
        switch ($entity) {
            case 'customer':
                return app(CustomerController::class)->index($request, $entity);
                break;
            case 'seller':
                return app(SellerController::class)->index($request, $entity);
                break;
            case 'product':
                return app(ProductController::class)->index($request, $entity);
                break;
            case 'store':
                return app(StoreController::class)->index($request, $entity);
                break;
            case 'product-categories':
                return app(ProductCategoryController::class)->index($request, $entity);
            default:
                abort(404, "Page not found");
                break;
        }
    }

    public function getCreationPage(Request $request, $page)
    {
        $entity = $request->query('entity', $page);
        switch ($entity) {
            case 'product-category':
                return app(ProductCategoryController::class)->getCreationPage($request, $entity);
                break;
            case 'user':
                return app(UserController::class)->getCreationPage($request, $entity);
                break;
            default:
                abort(404, "Page not found");
                break;
        }
    }

    public function handleCreation($entity, Request $request)
    {
        switch ($entity) {
            case 'product-category':
                return app(ProductCategoryController::class)->create($request, $entity);
                break;
            case 'user':
                return app(UserController::class)->create($request, $entity);
                break;
            default:
                abort(404, "Creation handler not found for {$entity}");
                break;
        }
    }
}
