<?php

namespace App\Traits\Http;

use App\Exceptions\Auth\InvalidCredentialsException;
use App\Exceptions\Company\CompanyNotFoundException;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

trait APIResponse {

    protected function handlerException(Exception $e) {

        Log::error($e);

        if ($e instanceof UnauthorizedHttpException || $e instanceof AuthorizationException) {
            return $this->unauthorized(trans('errors.unauthorized'));
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return $this->notAllowed(trans('errors.not_allowed'));
        }

        if ($e instanceof NotFoundHttpException) {
            return $this->notFound(trans('errors.not_found'));
        }

        if ($e instanceof ValidationException) {
            return $this->handlerValidationException($e);
        }

        if ($e instanceof HttpResponseException) {
            return $this->internalServerError($e, trans('errors.general'));
        }

        if ($e instanceof \PDOException) {
            return $this->conflict($e->getMessage());
            //return $this->conflict(trans('errors.databese_foreign_key'));
        }

        if ($e instanceof InvalidCredentialsException) {
            return $this->unauthorized(trans('errors.invalid_credentials'));
        }

        if ($e instanceof HeaderException) {
            return $this->respondState($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($e instanceof CompanyNotFoundException) {
            return $this->respondState($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }



        return $this->internalServerError($e, trans('errors.general'));
    }

    protected function handlerValidationException(ValidationException $e) {
        $validator = $e->validator;

        return $this->respondState(trans('errors.validations'), Response::HTTP_UNPROCESSABLE_ENTITY, $validator->getMessageBag());
    }

    protected function internalServerError($e, $message) {
        return $this->respondState($message, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    protected function unprocessableEntity($message) {
        return $this->respondState($message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function forbidden($message) {
        return $this->respondState($message, Response::HTTP_FORBxIDDEN);
    }

    protected function unauthorized($message) {
        return $this->respondState($message, Response::HTTP_UNAUTHORIZED);
    }

    protected function notAllowed($message) {
        return $this->respondState($message, Response::HTTP_METHOD_NOT_ALLOWED);
    }

    protected function notFound($message) {
        return $this->respondState($message, Response::HTTP_NOT_FOUND);
    }

    protected function badRequest($message) {
        return $this->respondState($message, Response::HTTP_BAD_REQUEST);
    }

    protected function conflict($message) {
        return $this->respondState($message, Response::HTTP_CONFLICT);
    }

    protected function deleted() {
        return $this->respondState(null, Response::HTTP_NO_CONTENT);
    }

    protected function created($item) {
        return $this->json($item, Response::HTTP_CREATED);
    }

    protected function json($data, $status = 200) {
        return response()->json($data, $status);
    }

    protected function respondState($message, $code, $errors = []) {
        $data = [
            'message' => $message,
            'status_code' => $code
        ];

        if ($errors) {
            $data['errors'] = $errors;
        }

        return response()->json($data, $code);
    }
}
