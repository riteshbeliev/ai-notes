<?php

namespace Tests\Unit\Services\AI;

use App\Services\AI\VectorSearchService;
use PHPUnit\Framework\TestCase;

class VectorSearchServiceTest extends TestCase
{
    protected VectorSearchService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new VectorSearchService();
    }

    public function test_identical_vectors_return_similarity_one(): void
    {
        $score = $this->service->cosineSimilarity(
            [1, 2, 3],
            [1, 2, 3]
        );

        $this->assertEqualsWithDelta(1.0, $score, 0.000001);
    }

    public function test_orthogonal_vectors_return_similarity_zero(): void
    {
        $score = $this->service->cosineSimilarity(
            [1, 0],
            [0, 1]
        );

        $this->assertEqualsWithDelta(0.0, $score, 0.000001);
    }

    public function test_opposite_vectors_return_similarity_negative_one(): void
    {
        $score = $this->service->cosineSimilarity(
            [1, 0],
            [-1, 0]
        );

        $this->assertEqualsWithDelta(-1.0, $score, 0.000001);
    }

    public function test_different_dimension_vectors_return_zero(): void
    {
        $score = $this->service->cosineSimilarity(
            [1, 2, 3],
            [1, 2]
        );

        $this->assertSame(0.0, $score);
    }

    public function test_zero_vector_returns_zero(): void
    {
        $score = $this->service->cosineSimilarity(
            [0, 0, 0],
            [1, 2, 3]
        );

        $this->assertSame(0.0, $score);
    }

    public function test_similarity_is_symmetric(): void
    {
        $scoreAB = $this->service->cosineSimilarity(
            [1, 2, 3],
            [4, 5, 6]
        );

        $scoreBA = $this->service->cosineSimilarity(
            [4, 5, 6],
            [1, 2, 3]
        );

        $this->assertEqualsWithDelta($scoreAB, $scoreBA, 0.000001);
    }
}
