<?php

namespace App\Http\Controllers;

use App\Models\SalesPage;
use App\Services\GeminiService;
use Illuminate\Http\Request;

class SalesPageController extends Controller
{
    public function index()
    {
        $salesPages = auth()->user()->salesPages()->latest()->paginate(10);
        return view('sales-pages.index', compact('salesPages'));
    }

    public function create()
    {
        return view('sales-pages.create');
    }

    public function store(Request $request, GeminiService $geminiService)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'required|string',
            'features' => 'required|string',
            'target_audience' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'selling_points' => 'nullable|string',
        ]);

        // Validate API Key exists
        if (empty(env('GEMINI_API_KEY'))) {
            return back()->with('error', 'GEMINI_API_KEY is not set in the .env file.')->withInput();
        }

        // Call Gemini API
        $generatedHtml = $geminiService->generateSalesPage($validated);

        if (!$generatedHtml) {
            return back()->with('error', 'Failed to generate sales page from AI. Please try again.')->withInput();
        }

        // Clean up markdown blockquotes if AI hallucinated them
        $generatedHtml = preg_replace('/```html\n?/', '', $generatedHtml);
        $generatedHtml = preg_replace('/```\n?/', '', $generatedHtml);

        $salesPage = auth()->user()->salesPages()->create(array_merge($validated, [
            'generated_html' => trim($generatedHtml)
        ]));

        return redirect()->route('sales-pages.show', $salesPage)->with('success', 'Sales page generated successfully!');
    }

    public function show(SalesPage $salesPage)
    {
        // Ensure user owns this page
        if ($salesPage->user_id !== auth()->id()) {
            abort(403);
        }

        return view('sales-pages.show', compact('salesPage'));
    }

    public function edit(SalesPage $salesPage)
    {
        // Ensure user owns this page
        if ($salesPage->user_id !== auth()->id()) {
            abort(403);
        }

        return view('sales-pages.edit', compact('salesPage'));
    }

    public function update(Request $request, SalesPage $salesPage, GeminiService $geminiService)
    {
        // Ensure user owns this page
        if ($salesPage->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'required|string',
            'features' => 'required|string',
            'target_audience' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'selling_points' => 'nullable|string',
        ]);

        // Validate API Key exists
        if (empty(env('GEMINI_API_KEY'))) {
            return back()->with('error', 'GEMINI_API_KEY is not set in the .env file.')->withInput();
        }

        // Call Gemini API
        $generatedHtml = $geminiService->generateSalesPage($validated);

        if (!$generatedHtml) {
            return back()->with('error', 'Failed to generate sales page from AI. Please try again.')->withInput();
        }

        // Clean up markdown blockquotes if AI hallucinated them
        $generatedHtml = preg_replace('/```html\n?/', '', $generatedHtml);
        $generatedHtml = preg_replace('/```\n?/', '', $generatedHtml);

        $salesPage->update(array_merge($validated, [
            'generated_html' => trim($generatedHtml)
        ]));

        return redirect()->route('sales-pages.show', $salesPage)->with('success', 'Sales page re-generated successfully!');
    }

    public function destroy(SalesPage $salesPage)
    {
        // Ensure user owns this page
        if ($salesPage->user_id !== auth()->id()) {
            abort(403);
        }

        $salesPage->delete();
        return redirect()->route('sales-pages.index')->with('success', 'Sales page deleted.');
    }
}
