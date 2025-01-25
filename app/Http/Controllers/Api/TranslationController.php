<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TranslationRequest;
use App\Services\TranslationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Translations",
 *     description="API Endpoints for translation management"
 * )
 */

class TranslationController extends Controller
{
    public function __construct(
        private readonly TranslationService $translationService
    ) {}

    /**
     * @OA\Get(
     *     path="/api/v1/translations",
     *     summary="Get translations list",
     *     tags={"Translations"},
     *     @OA\Parameter(
     *         name="locale",
     *         in="query",
     *         description="Language code",
     *         required=false,
     *         @OA\Schema(type="string", default="en")
     *     ),
     *     @OA\Parameter(
     *         name="tags",
     *         in="query",
     *         description="Filter by tags",
     *         required=false,
     *         @OA\Schema(type="array", @OA\Items(type="string"))
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Translation"))
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $locale = $request->get('locale', 'en');
        $tags = $request->get('tags', '');
        
        // Convert comma-separated string to array, or use empty array if no tags
        $tagsArray = $tags ? explode(',', $tags) : [];
        
        $translations = $this->translationService->getTranslations($locale, $tagsArray);
        
        return response()->json($translations);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/translations",
     *     summary="Create a new translation",
     *     tags={"Translations"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"key", "value", "locale"},
     *             @OA\Property(property="key", type="string", example="welcome_message"),
     *             @OA\Property(property="value", type="string", example="Welcome to our application"),
     *             @OA\Property(property="locale", type="string", example="en"),
     *             @OA\Property(property="tags", type="array", @OA\Items(type="string"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Translation created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Translation")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function store(TranslationRequest $request): JsonResponse
    {
        $translation = $this->translationService->createTranslation($request->validated());
        
        return response()->json($translation, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/translations/search",
     *     summary="Search translations",
     *     tags={"Translations"},
     *     @OA\Parameter(
     *         name="query",
     *         in="query",
     *         description="Search query",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="locale",
     *         in="query",
     *         description="Language code",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="tags",
     *         in="query",
     *         description="Filter by tags",
     *         required=false,
     *         @OA\Schema(type="array", @OA\Items(type="string"))
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Search results",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Translation"))
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function search(Request $request): JsonResponse
    {
        $results = $this->translationService->searchTranslations(
            $request->get('query'),
            $request->get('locale'),
            $request->get('tags', [])
        );
        
        return response()->json($results);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/translations/export",
     *     summary="Export translations",
     *     tags={"Translations"},
     *     @OA\Parameter(
     *         name="locale",
     *         in="query",
     *         description="Language code",
     *         required=false,
     *         @OA\Schema(type="string", default="en")
     *     ),
     *     @OA\Parameter(
     *         name="tags",
     *         in="query",
     *         description="Filter by tags",
     *         required=false,
     *         @OA\Schema(type="array", @OA\Items(type="string"))
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Exported translations",
     *         @OA\JsonContent(type="object")
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function export(Request $request): JsonResponse
    {
        $locale = $request->get('locale', 'en');
        $tags = $request->get('tags', []);
        
        $translations = $this->translationService->getTranslationsForExport($locale, $tags);
        
        return response()->json($translations);
    }
} 