<?php

namespace App\Http\Controllers;

use App\Models\FormSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class FormSubmissionController extends Controller
{
    public function quote(Request $request): RedirectResponse
    {
        return $this->store($request, 'quote');
    }

    public function contact(Request $request): RedirectResponse
    {
        return $this->store($request, 'contact');
    }

    private function store(Request $request, string $type): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:190'],
            'phone' => ['nullable', 'string', 'max:30'],
            'service' => ['nullable', 'string', 'max:190'],
            'message' => ['nullable', 'string', 'max:5000'],
            'website' => ['prohibited'], // honeypot
        ]);

        $submission = FormSubmission::create([
            'type' => $type,
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'service' => $validated['service'] ?? null,
            'message' => $validated['message'] ?? null,
            'payload' => $request->except(['website']),
        ]);

        $notifyTo = config('mail.notify_to');
        if ($notifyTo) {
            try {
                Mail::raw(
                    "New {$type} request from milehighhauloff.com\n\n"
                    ."Name: {$submission->name}\n"
                    ."Email: {$submission->email}\n"
                    ."Phone: {$submission->phone}\n"
                    ."Service: {$submission->service}\n\n"
                    ."Message:\n{$submission->message}",
                    fn ($mail) => $mail->to($notifyTo)->subject("New {$type} request — Mile High Haul Off")
                );
            } catch (\Throwable $e) {
                Log::error('Form notification email failed: '.$e->getMessage());
            }
        }

        return back()->with('success', "Thanks! We received your {$type} request and will get back to you shortly.");
    }
}
