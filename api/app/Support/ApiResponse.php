<?php

namespace App\Support;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;

class ApiResponse
{
    public static function success($data = null, $meta = [], int $status = 200)
    {
        $message = $meta['message'] ?? 'Operation successful';

        if ($data instanceof ResourceCollection) {
            $resource = $data->resource;

            if ($resource instanceof AbstractPaginator) {
                $meta = array_merge([
                    'page'        => $resource->currentPage(),
                    'per_page'    => $resource->perPage(),
                    'total'       => $resource->total(),
                    'total_pages' => $resource->lastPage(),
                ], $meta);

                $data = $data->response()->getData(true)['data'] ?? [];
            } else {
                // Коллекция без пагинации
                $data = $data->resolve();
            }
        }

        elseif ($data instanceof JsonResource) {
            $data = $data->resolve();
        }

        elseif ($data instanceof AbstractPaginator) {
            $meta = array_merge([
                'page'        => $data->currentPage(),
                'per_page'    => $data->perPage(),
                'total'       => $data->total(),
                'total_pages' => $data->lastPage(),
            ], $meta);

            $data = $data->items();
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
            'meta'    => $meta,
        ], $status);
    }

    public static function error($message, $code = 422, $errors = [])
    {
        return response()->json(['success' => false, 'message' => $message, 'errors' => $errors], $code);
    }
}