# 🚀 Taskly — AI-Powered Productivity Suite

Taskly is a comprehensive AI-powered productivity platform built with PHP that brings together multiple content generation tools in one place. Powered by Google's **Gemini API**, it helps you generate professional emails, study notes, creative ideas, documents, and complete websites — all from a single dashboard.

---

## ✨ Features

| Tool | Description |
|------|-------------|
| **📧 EmailGenX** | Generate professional emails instantly — perfect for business communication, marketing campaigns, and personal correspondence. |
| **📝 NotesGenX** | Create comprehensive study notes and summaries in multiple formats including bullet points, Q&A, and detailed explanations. |
| **💡 IdeaGenX** | Brainstorm and generate creative ideas for projects, content, business ventures, and problem-solving. |
| **📄 DocGenX** | Generate professional documents, reports, and presentations. Export to Word, PDF, and other formats. |
| **🌐 WebGenX** | Build complete websites instantly — portfolios, business sites, and landing pages with modern designs. |

---

## 🛠️ Tech Stack

- **Backend:** PHP
- **AI Engine:** Google Gemini API (`gemini-2.0-flash-thinking-exp`)
- **Frontend:** Bootstrap, AOS (Animate On Scroll), Font Awesome
- **Document Processing:** PHPWord, DomPDF
- **Package Manager:** Composer

---

## 📁 Project Structure

```
taskly/
├── index.php                  # Application entry point
├── config.php                 # Gemini API configuration & helper
├── routes.php                 # Page routing logic
├── composer.json              # PHP dependencies
│
├── views/
│   ├── dashboard_professional.php   # Landing page / dashboard
│   ├── layouts/                     # Shared layout templates
│   ├── emailgenx/                   # Email generator module
│   ├── notesgenx/                   # Notes generator module
│   ├── ideagenx/                    # Idea generator module
│   ├── docgenx/                     # Document generator module
│   └── webgenx/                     # Website generator module
│
├── generated_websites/        # Output directory for WebGenX (gitignored)
├── downloads/                 # Exported documents (gitignored)
└── storage/                   # App storage (gitignored)
```

---

## ⚙️ Installation & Setup

### Prerequisites

- PHP 7.4 or higher
- Composer
- cURL extension enabled
- A Google Gemini API key

### Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/Mayur142-CODE/Taskly.git
   cd Taskly
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Configure the API key**

   Open `config.php` and replace the API key with your own:
   ```php
   define('GEMINI_API_KEY', 'YOUR_GEMINI_API_KEY');
   ```

4. **Run the application**
   ```bash
   php -S localhost:8000
   ```

5. **Open in browser**
   ```
   http://localhost:8000
   ```

---

## 🔑 API Configuration

Taskly uses the Google Gemini API. You can obtain an API key from the [Google AI Studio](https://aistudio.google.com/apikey).

The API endpoint and key are configured in `config.php`:

```php
define('GEMINI_API_KEY', 'your-api-key-here');
define('GEMINI_API_ENDPOINT', 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-thinking-exp-01-21:generateContent');
```

---

## 📸 How It Works

1. **Choose Your Tool** — Select from the suite of AI-powered tools based on your needs.
2. **Provide Input** — Enter your requirements or content for the AI to work with.
3. **Get Results** — Receive high-quality, AI-generated content ready to use.

---

## 🤝 Contributing

Contributions are welcome! Feel free to open issues or submit pull requests.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

---

## 📄 License

This project is open-source and available for educational and personal use.

---

<p align="center">
  Built with ❤️ using PHP & Google Gemini AI
</p>
