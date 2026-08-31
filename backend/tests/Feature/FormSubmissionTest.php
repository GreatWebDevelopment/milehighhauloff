<?php

namespace Tests\Feature;

use App\Models\FormSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FormSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_stores_a_quote_request_with_photos(): void
    {
        Storage::fake('public');

        $response = $this->post('/submit/quote', [
            'name' => 'Test Customer',
            'email' => 'test@example.com',
            'phone' => '720-555-1234',
            'service' => 'Furniture Removal Services',
            'message' => 'Old couch and recliner in the garage.',
            'photos' => [
                UploadedFile::fake()->image('couch.jpg', 800, 600),
                UploadedFile::fake()->image('recliner.png', 800, 600),
            ],
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $submission = FormSubmission::latest()->first();
        $this->assertSame('quote', $submission->type);
        $this->assertSame('Test Customer', $submission->name);
        $this->assertCount(2, $submission->photos);

        foreach ($submission->photos as $path) {
            Storage::disk('public')->assertExists($path);
        }
    }

    public function test_stores_a_contact_request_without_photos(): void
    {
        $this->post('/submit/contact', [
            'name' => 'No Photo Person',
            'email' => 'nophoto@example.com',
            'message' => 'Just a question.',
        ])->assertRedirect()->assertSessionHas('success');

        $this->assertNull(FormSubmission::latest()->first()->photos);
    }

    public function test_rejects_more_than_six_photos(): void
    {
        Storage::fake('public');

        $photos = array_map(fn ($i) => UploadedFile::fake()->image("p{$i}.jpg"), range(1, 7));

        $this->post('/submit/quote', [
            'name' => 'Too Many',
            'photos' => $photos,
        ])->assertSessionHasErrors('photos');
    }

    public function test_rejects_non_image_uploads(): void
    {
        Storage::fake('public');

        $this->post('/submit/quote', [
            'name' => 'Bad File',
            'photos' => [UploadedFile::fake()->create('malware.pdf', 100, 'application/pdf')],
        ])->assertSessionHasErrors('photos.0');
    }
}
