<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Illuminate\Http\Response;
class CategoriesController extends Controller
{

    public function index()
    {
        try {
            $categories = Category::get();
            if(count($categories) > 0) {
                $response = [
                    'status' => HttpResponse::HTTP_OK,
                    'message' => 'Get All Resource',
                    'data' => $categories,
                ];
                return response()->json($response, HttpResponse::HTTP_OK);
            } else {
                $response = [
                    'status' => HttpResponse::HTTP_OK,
                    'message' => 'Data Is Empty'
                ];
                return response()->json($response, HttpResponse::HTTP_OK);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to get categories',
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|min:3|max:50',
            ]);
            $category = Category::create($data);
            return response()->json([
                'status' => HttpResponse::HTTP_CREATED,
                'message' => 'Category created successfully',
                'data' => $category,
            ], Response::HTTP_CREATED);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $response = [
                'status' => HttpResponse::HTTP_BAD_REQUEST,
                'message' => 'Data yang dimasukkan tidak valid',
                'errors' => $e->errors()
            ];
            return response()->json($response, HttpResponse::HTTP_BAD_REQUEST);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to create categories',
                'error' => $th->getMessage(),
            ], HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(string $id)
    {
        try {
            $category = Category::find($id);
            if($category) {
                $response = [
                    'status' => HttpResponse::HTTP_OK,
                    'message' => 'Get Resource By Id',
                    'data' => $category,
                ];
                return response()->json($response, HttpResponse::HTTP_OK);
            } else {
                $response = [
                    'status' => HttpResponse::HTTP_NOT_FOUND,
                    'message' => 'Resources not Found'
                ];
                return response()->json($response, HttpResponse::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to get detail category',
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $category = Category::find($id);
            if(!$category){
                $response = [
                    'status' => HttpResponse::HTTP_NOT_FOUND,
                    'message' => 'Resource not Found'
                ];
                return response()->json($response, HttpResponse::HTTP_NOT_FOUND);
            } else {
                $data = $request->validate([
                    'name' => 'required|string|min:3|max:50',
                ]);
                $category->update($data);
                return response()->json([
                    'status' => HttpResponse::HTTP_OK,
                    'message' => 'Category updated successfully',
                    'data' => $category,
                ], Response::HTTP_OK);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $response = [
                'status' => HttpResponse::HTTP_BAD_REQUEST,
                'message' => 'Invalid data',
                'errors' => $e->errors()
            ];
            return response()->json($response, HttpResponse::HTTP_BAD_REQUEST);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to update category',
                'error' => $th->getMessage(),
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);        }
    }

    public function destroy(string $id)
    {
        try {
            $category = Category::find($id);
            if(!$category) {
                $response = [
                    'status' => HttpResponse::HTTP_NOT_FOUND,
                    'message' => 'Resource not Found'
                ];
                return response()->json($response, HttpResponse::HTTP_NOT_FOUND);
            } else {
                $category->delete();
                return response()->json([
                    'status' => HttpResponse::HTTP_OK,
                    'message' => 'Category deleted successfully',
                ], Response::HTTP_OK);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to delete category',
                'error' => $th->getMessage(),
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);        }
    }
}
