<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\OpenApi(
    openapi: "3.0.3"
)]

#[OA\Info(
    title: "AI Notes API",
    version: "1.0.0",
    description: "AI Notes Management API Documentation"
)]

#[OA\Server(
    url: "http://127.0.0.1:8000",
    description: "Local Development Server"
)]

class OpenApi
{
}