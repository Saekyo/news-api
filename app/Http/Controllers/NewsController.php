<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Category;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function index()
    {
        try {
            $news = News::with('category', 'author')->get();
            if(count($news) > 0) {
                $response = [
                    'status' => HttpResponse::HTTP_OK,
                    'message' => 'Get All Resource',
                    'data' => $news,
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
                'message' => 'Failed to get news',
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'title' => 'required|string',
                'description' => 'required|string',
                'content' => 'required|string',
                'url' => 'required|string',
                'url_image' => 'required|string',
                'category_id' => 'required|exists:categories,id',
            ]);

            $data['published_at'] = now();
            $data['author_id'] = Auth::user()->id;


            $news = News::create($data);

            return response()->json([
                'status' => HttpResponse::HTTP_CREATED,
                'message' => 'Resources is added succesfully',
                'data' => $news,
            ], HttpResponse::HTTP_CREATED);
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
                'message' => 'Failed to create news',
                'error' => $th->getMessage(),
            ], HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(string $id)
    {
        try {
            $news = News::find($id);
            if($news) {
                $news->load('category', 'author');
                $response = [
                    'status' => HttpResponse::HTTP_OK,
                    'message' => 'Get Detail Resource',
                    'data' => $news,
                ];
                return response()->json($response, HttpResponse::HTTP_OK);
            } else {
                $response = [
                    'status' => HttpResponse::HTTP_NOT_FOUND,
                    'message' => 'Resources Not Found'
                ];
                return response()->json($response, HttpResponse::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to get detail news',
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $news = News::find($id);
            if(!$news){
                return response()->json([
                    'status' => HttpResponse::HTTP_NOT_FOUND,
                    'message' => 'Resource not found',
                ], HttpResponse::HTTP_NOT_FOUND);
            } else {
                $data = $request->validate([
                    'title' => 'required|string',
                    'description' => 'required|string',
                    'content' => 'required|string',
                    'url' => 'required|string',
                    'url_image' => 'required|string',
                    'category_id' => 'required|exists:categories,id',
                ]);

                $news->update($data);

                return response()->json([
                    'status' => HttpResponse::HTTP_OK,
                    'message' => 'Resource updated successfully',
                    'data' => $news,
                ], HttpResponse::HTTP_OK);
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
                'message' => 'Failed to update news',
                'error' => $th->getMessage(),
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(string $id)
    {
        try {
            $news = News::find($id);
            if (!$news) {
                return response()->json([
                    'status' => HttpResponse::HTTP_NOT_FOUND,
                    'message' => 'Resource not found',
                ], HttpResponse::HTTP_NOT_FOUND);
            } else {
                $news->delete();

                return response()->json([
                    'status' => HttpResponse::HTTP_OK,
                    'message' => 'Resource delete successfully',
                ], HttpResponse::HTTP_OK);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to delete news',
                'error' => $th->getMessage(),
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function search($title)
    {
        try {
            $news = News::where('title', 'like', '%' . $title . '%')->get();

            if(count($news) > 0) {
                $news->load('category', 'author');
                $response = [
                    'status' => HttpResponse::HTTP_OK,
                    'message' => 'Get Searched Resource',
                    'data' => $news,
                ];
                return response()->json($response, HttpResponse::HTTP_OK);
            } else {
                $response = [
                    'status' => HttpResponse::HTTP_NOT_FOUND,
                    'message' => 'Resources Not Found'
                ];
                return response()->json($response, HttpResponse::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to search news',
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function sport()
    {
        try {
            $category_name = 'sport';
            $category = Category::where('name', 'like', '%' . $category_name . '%')->first();

            if ($category) {
                $sport_news = $category->news->load('category', 'author');

                $response = [
                    'status' => HttpResponse::HTTP_OK,
                    'message' => 'Get Sport Resource',
                    'total' => count($sport_news),
                    'data' => $sport_news,
                ];
                return response()->json($response, HttpResponse::HTTP_OK);
            } else {
                $response = [
                    'status' => HttpResponse::HTTP_NOT_FOUND,
                    'message' => 'Resources Not Found'
                ];
                return response()->json($response, HttpResponse::HTTP_NOT_FOUND);

            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to search news',
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function finance()
    {
        try {
            $category_name = 'finance';
            $category = Category::where('name', 'like', '%' . $category_name . '%')->first();

            if ($category) {
                $finance_news = $category->news->load('category', 'author');

                $response = [
                    'status' => HttpResponse::HTTP_OK,
                    'message' => 'Get Sport Resource',
                    'total' => count($finance_news),
                    'data' => $finance_news,
                ];
                return response()->json($response, HttpResponse::HTTP_OK);
            } else {
                $response = [
                    'status' => HttpResponse::HTTP_NOT_FOUND,
                    'message' => 'Resources Not Found'
                ];
                return response()->json($response, HttpResponse::HTTP_NOT_FOUND);

            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to search news',
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function automotive()
    {
        try {
            $category_name = 'automotive';
            $category = Category::where('name', 'like', '%' . $category_name . '%')->first();

            if ($category) {
                $automotive_news = $category->news->load('category', 'author');

                $response = [
                    'status' => HttpResponse::HTTP_OK,
                    'message' => 'Get Sport Resource',
                    'total' => count($automotive_news),
                    'data' => $automotive_news,
                ];
                return response()->json($response, HttpResponse::HTTP_OK);
            } else {
                $response = [
                    'status' => HttpResponse::HTTP_NOT_FOUND,
                    'message' => 'Resources Not Found'
                ];
                return response()->json($response, HttpResponse::HTTP_NOT_FOUND);

            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Failed to search news',
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
