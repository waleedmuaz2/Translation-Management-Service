<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Translation",
 *     description="Translation model",
 *     @OA\Xml(name="Translation")
 * )
 */
class Translation
{
    /**
     * @OA\Property(type="integer", example=1)
     */
    private $id;

    /**
     * @OA\Property(type="string", example="welcome_message")
     */
    private $key;

    /**
     * @OA\Property(type="string", example="Welcome to our application")
     */
    private $value;

    /**
     * @OA\Property(type="integer", example=1)
     */
    private $language_id;

    /**
     * @OA\Property(type="array", @OA\Items(type="string"), example={"frontend", "common"})
     */
    private $tags;

    /**
     * @OA\Property(type="string", format="datetime", example="2023-01-01 00:00:00")
     */
    private $created_at;

    /**
     * @OA\Property(type="string", format="datetime", example="2023-01-01 00:00:00")
     */
    private $updated_at;
} 