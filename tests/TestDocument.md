# AI Notes Application – Testing Documentation

**Project:** AI Notes – Laravel 13 + Gemini AI  
**Testing Framework:** PHPUnit 12  
**Backend:** Laravel 13  
**Database:** SQLite  
**Document Purpose:** Future testing reference and regression testing guide

---

## 1. Testing Overview

This document explains how to test the AI Notes application whenever a new feature is developed, existing functionality is modified, or a bug is fixed.

The project uses PHPUnit with Laravel's testing features.

### Testing objectives

1. Verify that all API endpoints work correctly.
2. Verify database operations such as create, read, update, and delete.
3. Verify AI summary and embedding generation.
4. Verify semantic search and similarity calculations.
5. Verify validation and error handling.
6. Prevent regressions when adding new features.
7. Avoid unnecessary real Gemini API calls during automated tests.

## 2. Testing Environment

The following environment was used for the initial test suite.

| Component | Version / Configuration |
|---|---|
| PHP | 8.5.12 |
| Laravel | 13.20.0 |
| PHPUnit | 12.5.31 |
| Composer | 2.10.3 |
| Database | SQLite |
| Test database | In-memory SQLite |

### PHPUnit configuration

File: `phpunit.xml`

The test environment uses:

- `APP_ENV=testing`
- `DB_CONNECTION=sqlite`
- `DB_DATABASE=:memory:`
- Array cache driver
- Array session driver
- Synchronous queue driver

Using an in-memory SQLite database keeps tests isolated from the development database.

**Important:** Never run automated tests against your production database.

## 3. Test Folder Structure

The current test files are organized as follows:

```text
tests/
├── Feature/
│   ├── Api/
│   │   ├── NoteCrudTest.php
│   │   ├── NoteAITest.php
│   │   └── NoteSearchTest.php
│   │
│   └── ExampleTest.php
│
└── Unit/
    ├── ExampleTest.php
    │
    └── Services/
        ├── NoteServiceTest.php
        │
        └── AI/
            ├── GeminiServiceTest.php
            └── VectorSearchServiceTest.php
```

### Feature tests

Feature tests verify complete application behavior, including:

- API routes
- Controllers
- Form Requests
- Database operations
- Service integration
- API responses

### Unit tests

Unit tests verify individual classes or methods independently.

Examples:

- Gemini API response handling
- Cosine similarity calculation
- NoteService business logic

## 4. Current Testing Results

The following results have been confirmed from the complete test-suite run.

| Test file | Test cases |
|---|---:|
| Unit ExampleTest | 1 |
| GeminiServiceTest | 6 |
| VectorSearchServiceTest | 6 |
| NoteServiceTest | 4 |
| NoteAITest | 4 |
| NoteCrudTest | 8 |
| NoteSearchTest | 4 |
| Feature ExampleTest | 1 |
| **Total** | **34** |

**Last confirmed result:**

- Tests passed: 34
- Assertions passed: 92
- Failures: 0
- Duration: 61.23 seconds

Note: The CRUD update test took approximately 60 seconds. This suggests that it may still be making a real Gemini API request. Its mocking needs to be verified before treating the suite as fully isolated from external services.

## 5. Testing Individual Modules

### 5.1 Note CRUD API

File: `tests/Feature/Api/NoteCrudTest.php`

Test cases:

1. List all notes.
2. Create a note.
3. Require title and content during creation.
4. Retrieve an existing note.
5. Return 404 for a missing note.
6. Update an existing note.
7. Delete a note.
8. Prevent retrieval of a soft-deleted note.

Run:

```bash
php artisan test tests/Feature/Api/NoteCrudTest.php
```

### 5.2 GeminiService

File: `tests/Unit/Services/AI/GeminiServiceTest.php`

Test cases:

1. Generate summary successfully.
2. Return null when summary API fails.
3. Return null for an invalid summary response.
4. Generate embedding successfully.
5. Return null when embedding API fails.
6. Return null for an invalid embedding response.

Run:

```bash
php artisan test tests/Unit/Services/AI/GeminiServiceTest.php
```

### 5.3 NoteAIController

File: `tests/Feature/Api/NoteAITest.php`

Test cases:

1. Generate a summary for a note.
2. Generate an embedding for a note.
3. Return HTTP 500 when summary generation fails.
4. Return HTTP 500 when embedding generation fails.

Run:

```bash
php artisan test tests/Feature/Api/NoteAITest.php
```

### 5.4 NoteService

File: `tests/Unit/Services/NoteServiceTest.php`

Test cases:

1. Create a note with a generated summary.
2. Update note content and regenerate its summary.
3. Update only the title without regenerating the summary.
4. Save a note even when summary generation fails.

Run:

```bash
php artisan test tests/Unit/Services/NoteServiceTest.php
```

Current business rule: A note can be saved even when Gemini summary generation fails. Its summary remains null.

### 5.5 Semantic Search

File: `tests/Feature/Api/NoteSearchTest.php`

Test cases:

1. Return matching notes.
2. Sort search results by similarity.
3. Require a search query.
4. Return HTTP 500 when embedding generation fails.

Run:

```bash
php artisan test tests/Feature/Api/NoteSearchTest.php
```

### 5.6 VectorSearchService

File: `tests/Unit/Services/AI/VectorSearchServiceTest.php`

Test cases:

1. Identical vectors return similarity 1.
2. Orthogonal vectors return similarity 0.
3. Opposite vectors return similarity -1.
4. Different vector dimensions return 0.
5. A zero vector returns 0.
6. Similarity is symmetric.

Run:

```bash
php artisan test tests/Unit/Services/AI/VectorSearchServiceTest.php
```

## 6. Important PHPUnit Commands

Run commands from the project root directory.

### Run the complete test suite

```bash
php artisan test
```

### Run only unit tests

```bash
php artisan test --testsuite=Unit
```

### Run only feature tests

```bash
php artisan test --testsuite=Feature
```

### Run one test file

```bash
php artisan test tests/Feature/Api/NoteCrudTest.php
```

### Run one specific test method

```bash
php artisan test --filter=test_note_can_be_updated
```

### Run tests with detailed output

```bash
php artisan test --testdox
```

### Stop after the first failure

```bash
php artisan test --stop-on-failure
```

### Display available test suites

```bash
php artisan test --list-suites
```

## 7. Mocking Gemini API Requests

**This is one of the most important testing rules for this project.**

Do not make actual Gemini API requests during normal automated tests.

Real API requests can:
- Consume API quota.
- Cause additional costs depending on the API plan.
- Make tests slow.
- Fail because of network or API availability.
- Produce inconsistent test results.

Instead, mock the Gemini service.

Example:

```php
$this->mock(GeminiService::class, function ($mock) {
    $mock->shouldReceive('generateSummary')
        ->once()
        ->andReturn('Generated test summary.');
});
```

For embedding generation:

```php
$embedding = [0.12, 0.34, 0.56, 0.78];

$this->mock(GeminiService::class, function ($mock) use ($embedding) {
    $mock->shouldReceive('generateEmbedding')
        ->once()
        ->andReturn($embedding);
});
```

For direct HTTP-level tests of `GeminiService`, use Laravel's HTTP fake:

```php
Http::fake([
    '*' => Http::response([
        'candidates' => [
            [
                'content' => [
                    'parts' => [
                        ['text' => 'Test summary']
                    ]
                ]
            ]
        ]
    ], 200),
]);
```

This lets you test how your service handles API responses without contacting Gemini.

## 8. Database Testing

For tests that create or modify database records, use:

```php
use Illuminate\Foundation\Testing\RefreshDatabase;
```

Then inside the test class:

```php
use RefreshDatabase;
```

This ensures that tests start with a clean database state.

Useful assertions:

```php
$this->assertDatabaseHas('notes', [
    'title' => 'Test Note',
]);

$this->assertDatabaseMissing('notes', [
    'title' => 'Deleted Note',
]);
```

For checking soft deletes:

```php
$this->assertSoftDeleted('notes', [
    'id' => $note->id,
]);
```

## 9. Procedure for Testing a New Feature

Follow this process whenever a new module or feature is added.

**Step 1 – Review implementation**

Inspect the relevant:
- Model
- Migration
- Controller
- Service
- Form Request
- API route
- Resource

**Step 2 – Identify test scenarios**

List successful operations, validation failures, missing records, and exceptional cases.

**Step 3 – Create the test file**

Example:

```bash
php artisan make:test Api/NewFeatureTest
```

For a unit test:

```bash
php artisan make:test Services/NewFeatureServiceTest --unit
```

**Step 4 – Write test cases**

Cover both successful and unsuccessful scenarios.

**Step 5 – Run the individual test**

```bash
php artisan test tests/Feature/Api/NewFeatureTest.php
```

**Step 6 – Fix failures**

Investigate the actual cause. Do not change a test merely to make it pass if the application behavior is incorrect.

**Step 7 – Run the complete suite**

```bash
php artisan test
```

**Step 8 – Review the result**

Confirm that previously passing tests still pass and that no unexpected external API requests occur.

## 10. Future QA Checklist

Use this checklist before completing a new feature.

### General application

- [ ] Routes are registered correctly.
- [ ] Controllers return expected responses.
- [ ] Validation works correctly.
- [ ] Missing records return appropriate errors.
- [ ] Exceptions are handled safely.
- [ ] Database records are saved correctly.
- [ ] Existing functionality is not broken.

### API

- [ ] Successful response status codes are correct.
- [ ] Invalid requests return validation errors.
- [ ] Response JSON structure is correct.
- [ ] Unauthorized access is tested where authentication applies.
- [ ] Rate limiting is tested where applicable.
- [ ] Pagination and sorting are tested.

### Database

- [ ] Migrations run successfully.
- [ ] Foreign keys work correctly.
- [ ] Required fields are enforced.
- [ ] Soft deletes work correctly.
- [ ] Relationships return correct records.

### AI integration

- [ ] Gemini success responses are tested.
- [ ] API failure responses are tested.
- [ ] Invalid responses are tested.
- [ ] Timeout and connection exceptions are tested.
- [ ] Tests use mocks or HTTP fakes.
- [ ] No API key is exposed in source code or test output.

### Semantic search

- [ ] Query validation works.
- [ ] Embeddings are stored and retrieved correctly.
- [ ] Similarity calculations are correct.
- [ ] Results are sorted correctly.
- [ ] Empty embeddings are handled.
- [ ] Dimension mismatches are handled.
- [ ] Large datasets are considered.

## 11. Known Items for the Next QA Review

The initial 34-test suite passed, but passing tests do not mean that every possible edge case has been covered.

The following items should be reviewed next:

1. Verify that `NoteCrudTest` mocks Gemini during note updates. The 60-second execution time is a warning sign.
2. Review PUT and PATCH validation behavior. Decide whether PATCH should allow partial updates.
3. Add tests for pagination limits and invalid pagination values.
4. Add tests for Gemini timeout and connection exceptions.
5. Add semantic-search tests for empty embeddings and mismatched vector dimensions.
6. Review semantic-search performance with a large number of notes.
7. Review API authentication and authorization requirements.
8. Verify that embedding data is not exposed through API resources.
9. Check API rate limiting.
10. Verify all API documentation and README endpoint examples.

## 12. Final Testing Commands

Use this sequence before committing or deploying application changes:

```bash
php artisan optimize:clear

php artisan test

php artisan route:list --path=api/v1
```

For deployment, also verify the production environment configuration, database migrations, and application logs. Do not run development test database operations against production.

---

**Testing documentation status:** Initial PHPUnit test suite established.

**Last confirmed test result:** 34 passed, 92 assertions, 0 failures.

**Important:** Re-run the complete test suite after every significant code change. Update this document whenever new modules and test files are added.
