<?php

namespace App\Http\Validators;

use App\Http\Transformers\BaseTransformer;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator; 
use Symfony\Component\HttpFoundation\Response as IlluminateResponse;

class BaseValidator
{
    /**
     * @var BaseTransformer
     */
    public $baseTransformer;

    /**
     * BaseValidator constructor.
     * @param BaseTransformer $baseTransformer
     */
    public function __construct(BaseTransformer $baseTransformer)
    {
        $this->baseTransformer = $baseTransformer;
    }

    /**
     * @param array $input
     * @param array $rules
     * @param array $message
     * @return bool
     */
    protected function validate(array $input, array $rules, array $message)
    {
        $validator = Validator::make($input, $rules, $message);
        if ($validator->fails()) {
            $errors = $this->messageErrors($validator->errors()->toArray());
            $response = $this->baseTransformer->transformFailValidationResponse(IlluminateResponse::HTTP_UNPROCESSABLE_ENTITY, 'Fail', trans('Validation Error'), $errors);
            throw new HttpResponseException(response()->json($response, $response['code']));
        }

        return true;
    }

    
     /**
     * @param $errors
     * @return array
     */
    private function messageErrors($errors)
    {
        $result = [];
        foreach ($errors as $value) {
            $result[] = $value[0];
        }
       
        return $result;
    }
}