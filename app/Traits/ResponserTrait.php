<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ResponserTrait
{

    public function respondCollection($message, $data)
    {
        return response()->json([
            // 'code' => Response::HTTP_OK,
            'message' => $message,
            'data' => $data,
        ], 200);
    }

    public function respondForAlreadyExit($message)
    {
        return response()->json([
            // 'code' => Response::HTTP_CONFLICT,
            'message' => $message,
        ], 422);
    }

    public function respondcreateCollection($message, $data)
    {
        return response()->json([
            // 'code' => Response::HTTP_OK,
            'message' => $message,
            'data' => $data,
        ], 200);
    }
    public function respondCreateMessageOnly($message)
    {
        return response()->json([
            // 'code' => Response::HTTP_OK,
            'message' => $message,
        ], 200);
    }
    public function respondcreateCollectionWithToken($message, $data, $token)
    {
        return response()->json([
            'code' => Response::HTTP_CREATED,
            'message' => $message,
            'token' => $token,
            'data' => $data,
        ], 200);
    }
    public function respondCollectionWithPagination($message, $data)
    {
        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => $message,
            'data' => $data->values(),
            'meta' => [
                'total' => $data->total(),
                'count' => $data->count(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_pages' => $data->lastPage(),
                'next_pages' => $data->nextPageUrl(),
                'previous_pages' => $data->previousPageUrl(),
            ],
        ], 200);
    }
    public function respondReferalCollection($message, $data, $referralCompany)
    {
        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => $message,
            'data' => $data,
            'referral_company_loan_type' => [$referralCompany],
        ], 201);
    }
    protected function respondPermissionDenied()
    {
        return response()->json([
            'code' => 403,
            'message' => 'Permission denied',
        ], 403);
    }

    protected function exceptionResponse($msg, $code, $responseCode = 200)
    {
        $result = [
            'code' => $code,
            'message' => $msg,
        ];

        return response()->json($result, $responseCode);
    }

    protected function errorResponse($msg)
    {
        $result = [
            'code' => 426,
            'message' => $msg,
        ];

        return response()->json($result, 422);
    }

    public function respondSuccessMsgOnly($message)
    {
        return response()->json([
            // 'code' => Response::HTTP_OK,
            'message' => $message,
        ], 200);
    }

    public function respondPhone($temp_token, $phone, $message)
    {
        return response()->json([
            'code' => Response::HTTP_OK,
            'phone' => $phone,
            'temp_token' => $temp_token,
            'message' => $message,
        ]);
    }
    public function respondResetPassword($message)
    {
        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => $message,
        ], 200);
    }

    public function respondOtp($message, $otp)
    {
        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => $message,
            'data' => [
                'otp' => $otp,
            ],
        ], 200);
    }
    public function respondImage($message, $imagePath)
    {
        return response()->json([
            // 'code' => Response::HTTP_OK,
            'message' => $message,
            'url' => $imagePath,
        ], 200);
    }
    public function respondImageMicroLoan($message, $imagePath)
    {
        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => $message,
            'data' => $imagePath,
        ], 201);
    }

    protected function exceptionResponseGuarantorValid($msg, $code, $statusFlag)
    {
        $result = [
            'code' => $code,
            'guarantorInvalid' => $statusFlag,
            'message' => $msg,
        ];

        return response()->json($result, 200);
    }
    protected function responseMicroLoanRequestEligible($msg, $code, $statusFlag, $loanType = null, $loanCount = 0)
    {
        if ($loanType === null) {
            $result = [
                'code' => $code,
                'is_eligible' => $statusFlag,
                'closeMicroLoanCount' => $loanCount,
                'message' => $msg,
            ];
        } else {
            $result = [
                'code' => $code,
                'is_eligible' => $statusFlag,
                'closeMicroLoanCount' => $loanCount,
                'message' => $msg,
                'data' => $loanType,
            ];
        }

        return response()->json($result, 200);
    }
    protected function newResponseMicroLoanRequestEligible($msg, $code, $data)
    {
        $result = [
            'code' => $code,
            'message' => $msg,
            'data' => $data,
        ];
        return response()->json($result, 200);
    }

    protected function responseSmeLoanRequestEligible($msg, $code, $data)
    {
        $result = [
            'code' => $code,
            'message' => $msg,
            'data' => $data,
        ];
        return response()->json($result, 200);
    }

    protected function exceptionLoanRequestEligible($msg, $code, $statusFlag)
    {
        $result = [
            'code' => $code,
            'is_eligible' => $statusFlag,
            'message' => $msg,
        ];

        return response()->json($result, 200);
    }
    protected function responseMicroLoanAnswerSubmit($msg, $code, $answerSubmitID)
    {
        $result = [
            'code' => $code,
            'message' => $msg,
            'answer_submit_id' => $answerSubmitID,
        ];

        return response()->json($result, 200);
    }
    protected function responseSalaryLoanRequestEligible($msg, $code, $data)
    {
        $result = [
            'code' => $code,
            'message' => $msg,
            'data' => $data,
        ];
        return response()->json($result, 200);
    }
    public function respondVideo($message, $videoPath)
    {
        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => $message,
            'url' => $videoPath,
        ], 201);
    }
    public function respondErrorToken($message)
    {
        return response()->json([
            'code' => Response::HTTP_UNAUTHORIZED,
            'message' => $message,
        ], 400);
    }
    public function respondErrorTokenExpire($message)
    {
        return response()->json([
            'code' => Response::HTTP_NOT_ACCEPTABLE,
            'message' => $message,
        ], Response::HTTP_NOT_ACCEPTABLE);
    }

    protected function clientOutOfDateResponse()
    {
        $result = [
            'code' => 426,
            'message' => 'အသုံးပြုရတာ ပိုမို အဆင်ပြေနိုင်စေဖို့ Application Version အသစ်တစ်ခု ထပ်မံ release ပြုလုပ်ထားပါတယ်။',
        ];

        return response()->json($result, 200);
    }

    protected function clientOutOfDateForceResponse()
    {
        $result = [
            'code' => 426,
            'message' => 'အသုံးပြုရတာ ပိုမို အဆင်ပြေနိုင်စေဖို့ Application Version အသစ်တစ်ခု ထပ်မံ release ပြုလုပ်ထားပါတယ်။',
        ];

        return response()->json($result, 200);
    }

    public function errResponse($error = '', $error_des = '', $message = '')
    {
        $data = [
            "error" => $error,
            "error_description" => $error_des,
            "message" => $message,
        ];

        return response()->json($data, 404);
    }

    public function loginErrResponse($message = '')
    {
        $data = [
            'error' => "invalid_request",
            'error_description' => "The request is missing a required parameter, includes an invalid parameter value, includes a parameter more than once, or is otherwise malformed.",
            'hint' => "Check the `password` parameter",
            'message' => $message,
        ];

        return response()->json($data, 404);
    }

    public function notFoundResponse($message)
    {
        $result = [
            'code' => 404,
            'message' => $message,
        ];

        return response()->json($result, 200);
    }

    public function invalidData($message)
    {
        $result = [
            'message' => $message,
        ];

        return response()->json($result, 422);
    }

    public function duplicateEntry()
    {
        $result = [
            'message' => "Duplicate Entry",
        ];

        return response()->json($result, 409);
    }
    public function loginFailed($message)
    {
        $result = [
            'message' => $message,
        ];

        return response()->json($result, 401);
    }

    // public function loginResponse($token){
    //     $data = [
    //         'token_type' => 'Bearer',
    //         'expires_in' => 31622400,
    //         'access_token' => $token,
    //         'refresh_token' => ''
    //     ]

    //     return repsonse()->json($data,404);
    // }
}
