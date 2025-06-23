<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;



class ProductController extends Controller
{

    /**
     * @OA\Get(
     *      path="/api/products",
     *      operationId="getProducts",
     *      tags={"Product"},
     *      summary="Get all products",
     *      description="Returns a list of all products",
     *      security={{"ApiKeyAuth": {}}},
     *      @OA\Response(
     *         response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string"),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Product")
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *      )
     * )
     */
    public function index() { 
        $data = Product::all(); 
        $responseData = [
            'status' => 'success', 
            'message' => 'Data retrieved successfully', 
            'data' => $data 
        ]; 
        
        $encryptResponse = Encryption::encrypt[json_encode($response)]; 
        // return response()->json([ 'data' => $encryptResponse, ]); 
        
        return response()->json([ 'data' => $data, ]); 
    }


    /**
     * @OA\Post(
     *     path="/api/products/decrypt",
     *     operationId="decryptProductResponse",
     *     tags={"Product"},
     *     summary="Decrypt product response",
     *     description="Decrypts the encrypted product response data",
     *     security={{"ApiKeyAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"data"},
     *             @OA\Property(property="data", type="string", example="Encrypted data here")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Decrypted data successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Product")
     *             ) 
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Decrypt Response failed"
     *     )
     * )
     */

    public function decryptResponse(Request $request)
    {
        $encryptedData = $request->input('data');
        try{
            $decrypt = Encryption::decrypt($encryptedData);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Decryption failed: ' . $e->getMessage()
            ], 400);
        }
        
        return response()->json(['decrypted_data' => $decryptedData]);
    }

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     tags={"Product"},
     *     summary="Get a specific product",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product retrieved successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     )
     * )
     */
    public function show($id)
    {
        $data = Product::find($id);
        if (!$data) {
            return response()->json(['message' => 'Product not found.'], 404);
        }
        return response()->json([
            'message' => 'Product retrieved successfully.',
            'data' => $data,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/products",
     *     tags={"Product"},
     *     summary="Create a new product",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Example Product"),
     *             @OA\Property(property="description", type="string", example="Optional description")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Product created successfully"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = Product::create($validatedData);
        return response()->json([
            'message' => 'Product created successfully.',
            'data' => $data,
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/products/{id}",
     *     tags={"Product"},
     *     summary="Update an existing product",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Updated Product"),
     *             @OA\Property(property="description", type="string", example="Updated description")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $data = Product::find($id);
        if (!$data) {
            return response()->json(['message' => 'Product not found.'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data->update($validatedData);
        return response()->json([
            'message' => 'Product updated successfully.',
            'data' => $data,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     tags={"Product"},
     *     summary="Delete a product",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $data = Product::find($id);
        if (!$data) {
            return response()->json(['message' => 'Product not found.'], 404);
        }

        $data->delete();
        return response()->json(['message' => 'Product deleted successfully.']);
    }
}