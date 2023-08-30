<?php

namespace App\Traits;

use App\Constants\ResponseConstants\ResponseInterface;
use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

trait HasResponse
{
    public function execute(Closure $callback, ResponseInterface $message): Application|ResponseFactory|Response|JsonResource
    {
        try {
            DB::beginTransaction();

            /** @var JsonResource|null $response */
            $response = $callback();

            $additional = [
                'message' => $message->value,
                'success' => true
            ];

            DB::commit();

            return $response ? $response->additional($additional) : response($additional);
        } catch (Throwable $exception) {
            DB::rollBack();

            if ($exception instanceof HttpException) {
                throw $exception;
            }

            return response([
                'message' => $exception->getMessage(),
                'success' => false,
            ]);
        }
    }

}
