<?php namespace Arcanedev\Support\Bases;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;
use Illuminate\Http\JsonResponse;

/**
 * Class     FormRequest
 *
 * @package  Arcanedev\Support\Laravel
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class FormRequest extends BaseFormRequest
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Specify if the form request is an ajax request.
     *
     * @var bool
     */
    protected $ajaxRequest = false;

    /**
     * The errors format.
     *
     * @var string|null
     */
    protected $errorsFormat = null;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        if (method_exists($this, 'sanitize')) {
            $this->merge($this->sanitize());
        }
    }

    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array  $errors
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        return $this->ajaxRequest
            ? $this->formatJsonErrorsResponse($errors)
            : parent::response($errors);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Format the json response.
     *
     * @param  array  $errors
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function formatJsonErrorsResponse(array $errors)
    {
        return new JsonResponse([
            'status' => 'error',
            'code'   => 422,
            'errors' => array_map('reset', $errors)
        ], 422);
    }

    /**
     * {@inheritdoc}
     */
    protected function formatErrors(Validator $validator)
    {
        if (is_null($this->errorsFormat)) {
            return parent::formatErrors($validator);
        }

        $errors   = [];
        $messages = $validator->getMessageBag();

        foreach ($messages->keys() as $key) {
            $errors[$key] = $messages->get($key, $this->errorsFormat);
        }

        return $errors;
    }
}
