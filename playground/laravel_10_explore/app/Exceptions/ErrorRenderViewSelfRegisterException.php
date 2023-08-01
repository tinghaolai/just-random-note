<?php
namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ErrorRenderViewSelfRegisterException extends \Exception
{
    public function report(): void
    {
        Log::info('ErrorRenderViewSelfRegisterException, test20');
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        return response()->json('test20 render response', 500);
    }
}
