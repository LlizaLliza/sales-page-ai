# AI Sales Page Generator

An AI-powered web application built with **Laravel 11** and the **Google Gemini API** that generates high-converting, TailwindCSS-styled sales pages automatically from a few simple inputs.

## 🚀 Live Demo
**[https://sales-page-ai-production.up.railway.app/](https://sales-page-ai-production.up.railway.app/)**

## ✨ Features
- **User Authentication**: Secure login and registration using Laravel Breeze.
- **AI Generation**: Leverages `gemini-2.5-flash-lite` (chosen for being lightweight, fast, and avoiding high-demand queues) to instantly generate complete HTML landing pages with compelling copywriting.
- **Multiple Design Templates**: Users can choose from various aesthetics (Minimalist, Cyberpunk, Corporate, Vibrant) to dynamically style the AI output.
- **Modern UI Styling**: AI is instructed to return ready-to-use HTML embedded with Tailwind CSS classes.
- **Live Preview & History**: View past generated sales pages, preview them dynamically, edit (re-generate) them with new prompts, and delete them if needed.
- **HTML Export**: Download the generated sales page as a standalone `.html` file.

## 🛠️ Technology Stack
- **Backend:** Laravel 11 (PHP)
- **Frontend:** Blade Templates, Tailwind CSS
- **Database:** SQLite (Embedded & easy to deploy)
- **AI Integration:** Google Gemini REST API (`generativelanguage.googleapis.com`)
- **Hosting:** Railway.app (Docker/Nixpacks)

## 💻 Local Setup Instructions
If you want to run this project locally, follow these steps:

1. **Clone the repository**
   ```bash
   git clone https://github.com/YOUR_GITHUB_USERNAME/sales-page-ai.git
   cd sales-page-ai
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   npm run build
   ```

3. **Environment Setup**
   Copy `.env.example` to `.env` (or just create an `.env` file).
   Ensure the following variables are set:
   ```env
   DB_CONNECTION=sqlite
   GEMINI_API_KEY="your_gemini_api_key_here"
   ```

4. **Run Migrations**
   ```bash
   php artisan migrate
   ```

5. **Start Local Server**
   ```bash
   php artisan serve
   ```
   Visit `http://localhost:8000` in your browser.

## 📝 Design Decisions (Option B)
I chose Option B (AI Sales Page Generator) because it provides immediate, visible value and showcases integration with modern LLM APIs.
- **Why SQLite?** For a prototype take-home test, SQLite removes the barrier of setting up an external database service. It makes deployments fast and zero-cost on platforms like Railway.
- **Why Native HTTP Client?** Instead of adding heavy third-party composer SDKs for Google AI, I utilized Laravel's native `Http::withHeaders()` facade inside `GeminiService`. This keeps the codebase lightweight and demonstrates fundamental API communication skills.
