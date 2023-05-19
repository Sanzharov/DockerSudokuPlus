<?php

namespace App\Controller;

use App\Controller\Traits\FormErrorsTrait;
use App\Form\Type\CsvFileType;
use App\Service\SudokuPlusValidator;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SudokuUploadController extends AbstractController
{
    use FormErrorsTrait;

    /**
     * @param SudokuPlusValidator $sudokuPlusValidator
     */
    public function __construct(private readonly SudokuPlusValidator $sudokuPlusValidator)
    {
    }

    #[Route(path: '/api/sudoku/upload', methods: ['POST'])]
    /**
     * @OA\Post(
     *     path="/api/sudoku/upload",
     *     tags={"upload"},
     *     summary="Uploads a Sudoku file and validates it",
     *     @OA\RequestBody(
     *         description="The CSV file to upload",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="file",
     *                     description="The CSV file to upload",
     *                     type="string",
     *                     format="binary"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Returns a validation message",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Returns error messages when validation fails",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="errors", type="array", @OA\Items(type="string"))
     *         )
     *     ),
     * )
     */
    public function upload(Request $request): JsonResponse
    {
        $form = $this->createForm(CsvFileType::class);
        $form->handleRequest($request);
        $form->submit($request->files->all());

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('file')->getData();

            $csvData = file_get_contents($file->getPathname());
            $isValid = $this->sudokuPlusValidator->validateSudoku($csvData);

            if (!$isValid) {
                return new JsonResponse(['message' => 'Invalid Sudoku grid.'], Response::HTTP_OK);
            }

            return new JsonResponse(['message' => 'Sudoku grid is valid.'], Response::HTTP_OK);
        }

        return new JsonResponse(['errors' => $this->getGeneralFormErrors($form)], Response::HTTP_BAD_REQUEST);
    }
}