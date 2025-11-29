<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="FoodMart API",
 *     version="1.0.0",
 *     description="FoodMart E-commerce API Documentation",
 *     @OA\Contact(
 *         email="karim.hossam813@gmail.com",
 *         name="FoodMart Support"
 *     )
 * )
 * 
 * @OA\Server(
 *     url="http://localhost:8000/api/v1",
 *     description="Local Development Server"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Enter your Bearer token in the format: Bearer {token}"
 * )
 * 
 * @OA\Tag(name="Authentication", description="User authentication endpoints")
 * @OA\Tag(name="Search", description="Product search endpoints")
 */
abstract class Controller
{
    //
}
