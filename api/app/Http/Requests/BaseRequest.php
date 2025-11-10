<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use App\Support\ApiResponse;

/**
 *
 */
abstract class BaseRequest extends FormRequest
{
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * @return void
     */
    protected function failedAuthorization()
    {
        abort(response()->json(ApiResponse::error('Forbidden', 403)->getData(true), 403));
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }
}
