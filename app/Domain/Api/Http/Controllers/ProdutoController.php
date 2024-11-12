<?php

namespace App\Domain\Api\Http\Controllers;

use App\Domain\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Domain\Api\Http\Resources\ProductResource;

class ProdutoController extends Controller
{
    public function index(): JsonResponse
    {
        $produtos = Product::paginate(10);
        return response()->json(ProductResource::collection($produtos)->response()->getData(true), Response::HTTP_OK);
    }
    

    public function show($codigo): JsonResponse
    {
        $produto = Product::where('code', $codigo)->first();

        if (!$produto) {
            return response()->json(['mensagem' => 'Produto não encontrado'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($produto);
    }

    public function update(Request $request, $codigo): JsonResponse
    {
        $produto = Product::where('code', $codigo)->first();

        if (!$produto) {
            return response()->json(['mensagem' => 'Produto não encontrado'], Response::HTTP_NOT_FOUND);
        }

        $produto->update($request->all());
        return response()->json(['mensagem' => 'Produto atualizado com sucesso', 'produto' => $produto], Response::HTTP_OK);
    }

    public function destroy($codigo): JsonResponse
    {
        $produto = Product::where('code', $codigo)->first();

        if (!$produto) {
            return response()->json(['mensagem' => 'Produto não encontrado'], Response::HTTP_NOT_FOUND);
        }

        if ($produto->status === 'trash') {
            return response()->json(['mensagem' => 'O produto já está na lixeira'], Response::HTTP_OK);
        }

        $produto->update(['status' => 'trash']);
        return response()->json(['mensagem' => 'Produto movido para a lixeira'], Response::HTTP_OK);
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->input('query');

        $produtos = Product::where('product_name', 'like', "%{$query}%")
            ->orWhere('categories', 'like', "%{$query}%")
            ->orWhere('brands', 'like', "%{$query}%")
            ->get();

        return response()->json($produtos, Response::HTTP_OK);
    }
}
