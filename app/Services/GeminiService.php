<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent';

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
    }

    public function generateSalesPage(array $data)
    {
        $prompt = $this->buildPrompt($data);

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
            ]
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '?key=' . $this->apiKey, $payload);

            if ($response->successful()) {
                $result = $response->json();
                return $result['candidates'][0]['content']['parts'][0]['text'] ?? '';
            }

            Log::error('Gemini API Error: ' . $response->body());
            return null;
        } catch (\Exception $e) {
            Log::error('Gemini API Exception: ' . $e->getMessage());
            return null;
        }
    }

    protected function buildPrompt(array $data)
    {
        return "You are an expert copywriter and web developer. Generate a complete, persuasive sales page in HTML format for the following product/service:
        
- Product Name: {$data['product_name']}
- Description: {$data['description']}
- Key Features: {$data['features']}
- Target Audience: {$data['target_audience']}
- Price: {$data['price']}
- Unique Selling Points: {$data['selling_points']}

Requirements for the output:
1. ONLY output valid HTML code. Do NOT wrap it in markdown blockquotes like ```html.
2. The HTML MUST include inline CSS or Tailwind CSS utility classes (assume CDN is loaded) for styling. Use a modern, beautiful, and premium design aesthetic (e.g., modern gradients, clean typography, shadow, rounded corners).
3. Structure the page with:
   - A compelling Headline and Sub-headline.
   - A Product Description section.
   - A Benefits & Features section.
   - A placeholder for Social Proof/Testimonials.
   - A clear Pricing display.
   - A Call-to-Action (CTA) button.
4. Do NOT output <html>, <head>, or <body> tags. Just output the content inside the <body> tag (e.g., a wrapping <div class='max-w-5xl mx-auto...'>).";
    }
}
