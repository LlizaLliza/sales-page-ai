<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Live Preview:') }} {{ $salesPage->product_name }}
            </h2>
            <div>
                <a href="{{ route('sales-pages.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-2">
                    Back to History
                </a>
                <button onclick="downloadHTML()" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Download HTML
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Live Preview Container -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-4 border-gray-200">
                <div class="bg-gray-100 px-4 py-2 border-b flex items-center space-x-2">
                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                    <div class="ml-4 text-xs text-gray-500 font-mono">Live Preview Render</div>
                </div>
                
                <!-- The actual generated HTML is rendered here safely -->
                <div id="preview-content" class="w-full min-h-[600px] overflow-y-auto">
                    {!! $salesPage->generated_html !!}
                </div>
            </div>

            <!-- Details Section -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Prompt Input Data</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-semibold text-gray-500">Product Name</p>
                            <p class="mb-3">{{ $salesPage->product_name }}</p>
                            
                            <p class="text-sm font-semibold text-gray-500">Description</p>
                            <p class="mb-3">{{ $salesPage->description }}</p>

                            <p class="text-sm font-semibold text-gray-500">Price</p>
                            <p class="mb-3">{{ $salesPage->price }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-500">Target Audience</p>
                            <p class="mb-3">{{ $salesPage->target_audience }}</p>
                            
                            <p class="text-sm font-semibold text-gray-500">Features</p>
                            <p class="mb-3">{{ $salesPage->features }}</p>

                            <p class="text-sm font-semibold text-gray-500">Selling Points</p>
                            <p class="mb-3">{{ $salesPage->selling_points ?: '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script to download HTML -->
    <script>
        function downloadHTML() {
            const htmlContent = document.getElementById('preview-content').innerHTML;
            const fullHtml = `<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ addslashes($salesPage->product_name) }} - Sales Page</title>
    <script src="https://cdn.tailwindcss.com"><\/script>
</head>
<body>
    ${htmlContent}
</body>
</html>`;

            const blob = new Blob([fullHtml], { type: 'text/html' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = 'sales-page-{{ Str::slug($salesPage->product_name) }}.html';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
        }
    </script>
</x-app-layout>
