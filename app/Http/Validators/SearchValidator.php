<?php

namespace App\Http\Validators;

use Illuminate\Http\Request;

/**
 * SearchValidator is responsible for validating the search-related requests.
 */
class SearchValidator extends BaseValidator
{

    /**
     * Validate the search parameters from the request.
     *
     * @param  \Illuminate\Http\Request  $request  The request object containing the search parameters.
     * @return \Illuminate\Validation\Validator
     * 
     * @throws \Illuminate\Validation\ValidationException If any of the search parameters fails validation.
     */
    public function validateSearch(Request $request)
    {
        // Custom validation messages
        $messages = [
            'required' => 'The :attribute field is required.',
            'integer' => 'The :attribute field must be an integer.',
            'string' => 'The :attribute field must be a string.',
        ];

        // Define the validation rules for the search parameters
        $rules = [
            'query' => 'required|string',
            'page' => 'nullable|integer',
            'pagesize' => 'nullable|integer',
            'site' => 'nullable|string',
        ];

        // Validate the search parameters against the defined rules and messages
        return $this->validate($request->query(), $rules, $messages);
    }
}
