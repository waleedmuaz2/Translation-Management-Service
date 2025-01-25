<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="User",
 *     description="User model",
 *     @OA\Xml(name="User")
 * )
 */
class User
{
    /**
     * @OA\Property(type="integer", example=1)
     */
    private $id;

    /**
     * @OA\Property(type="string", example="John Doe")
     */
    private $name;

    /**
     * @OA\Property(type="string", format="email", example="user@example.com")
     */
    private $email;

    /**
     * @OA\Property(type="string", format="datetime", example="2023-01-01T00:00:00.000000Z")
     */
    private $email_verified_at;

    /**
     * @OA\Property(type="string", format="datetime", example="2023-01-01T00:00:00.000000Z")
     */
    private $created_at;

    /**
     * @OA\Property(type="string", format="datetime", example="2023-01-01T00:00:00.000000Z")
     */
    private $updated_at;
} 