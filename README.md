# Orbits

Orbits is a web-based faculty evaluation and academic management system.
Students can evaluate faculty members, while faculty, program chairs, and
administrators can view the information and results relevant to their roles.

The project is built with Laravel, Livewire, MySQL, and a small Flask service
for sentiment analysis of written feedback.

![Orbits login screen](docs/screenshots/login.jpeg)

## Features

### Authentication and dashboards

- Role-based access for students, faculty, program chairs, and administrators
- Separate dashboards for each user role

![Dashboard](docs/screenshots/dashboard.png)

### Faculty evaluations

- Evaluation forms with ratings and written comments
- Survey and question management
- Students can complete assigned evaluations

![Evaluation form](docs/screenshots/evaluation-form.png)

### Academic management

Administrators can manage:

- Departments
- Courses
- Programs
- Sections
- Faculty
- Students
- User accounts

The management pages include search, filtering, sorting, pagination, and
common create, edit, and delete actions.

![Administration screen](docs/screenshots/administration.png)

### Results and reporting

- Evaluation results and faculty summaries
- Sentiment analysis for written comments
- Activity logs for important changes
- Profile management and profile image uploads

![Results summary](docs/screenshots/results-summary.png)

Additional screenshot templates:

```text
docs/screenshots/faculty-profile.png
docs/screenshots/survey-builder.png
docs/screenshots/activity-logs.png
```

## User Roles

| Role | Main use |
| --- | --- |
| Student | Complete assigned faculty evaluations |
| Faculty | View relevant evaluation information |
| Program chair | Review program and faculty results |
| Administrator | Manage users, academic data, surveys, and reports |

## Technology

- **Backend:** PHP 8.2+, Laravel 11, Livewire 3
- **Database:** MySQL
- **Frontend:** Blade, Tailwind CSS, Alpine.js, Vite
- **Charts:** ApexCharts
- **Sentiment service:** Python, Flask, Joblib, scikit-learn

## Requirements

Install the following tools:

- PHP 8.2 or newer
- Composer
- Node.js and npm
- MySQL
- Python 3 and pip (only needed for sentiment analysis)

## Installation

### 1. Clone the project

```bash
git clone https://github.com/Moya-Fried-Rice/Orbits_v1.2.git
cd Orbits_v1.2
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Configure the environment

Create the environment file:

```powershell
Copy-Item .env.example .env
php artisan key:generate
```

Set the database values in `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=orbits_v1.2
DB_USERNAME=root
DB_PASSWORD=
```

Create the database in MySQL before continuing.

### 4. Run migrations and seed data

```bash
php artisan migrate --seed
```

To reset the local database and reload all seed data:

```bash
php artisan migrate:fresh --seed
```

The development seeder creates an administrator account:

```text
Email:    appleadmin@gmail.com
Password: admin123
```

Change this password before using the application outside local development.

### 5. Link storage

```bash
php artisan storage:link
```

## Running the Application

The easiest way to start the Laravel server, queue listener, and Vite is:

```bash
composer run dev
```

The application is usually available at:

```text
http://127.0.0.1:8000
```

To run the processes separately:

```bash
php artisan serve
php artisan queue:listen --tries=1
npm run dev
```

For a production frontend build:

```bash
npm run build
```

## Sentiment Analysis

The optional Flask service analyzes evaluation comments as `positive`,
`negative`, or `neutral`.

The service expects these files in `python_api/`:

```text
sentiment_analyzer_api.py
sentiment_model.pkl
tfidf_vectorizer.pkl
```

### Start the service

From the project root:

```powershell
cd python_api
python -m venv .venv
.\.venv\Scripts\Activate.ps1
pip install flask joblib scikit-learn
python sentiment_analyzer_api.py
```

The service runs on:

```text
http://127.0.0.1:5003
```

Laravel uses the following setting by default:

```dotenv
SENTIMENT_API_URL=http://127.0.0.1:5003/analyze_sentiment
```

You can test the service with:

```bash
curl -X POST http://127.0.0.1:5003/analyze_sentiment ^
  -H "Content-Type: application/json" ^
  -d "{\"text\":\"The instructor was helpful.\"}"
```

The Flask service currently runs in debug mode for development. Disable debug
mode and use a production WSGI server before deployment.

## Project Structure

```text
app/
├── Http/Controllers/       Controllers and API endpoints
├── Http/Middleware/        Authentication and role checks
├── Livewire/               Interactive pages and CRUD components
└── Models/                 Database models

database/
├── migrations/             Database schema
└── seeders/                Development seed data

python_api/                 Sentiment-analysis service
public/                     Public assets and logos
resources/views/            Blade pages and Livewire views
routes/web.php              Application routes
```

## Testing

Run the Laravel tests:

```bash
php artisan test
```

Format PHP files with Laravel Pint:

```bash
vendor/bin/pint
```

Build the frontend:

```bash
npm run build
```

## Troubleshooting

### Database errors

Check that MySQL is running and that the database values in `.env` are
correct. Clear cached configuration after changing `.env`:

```bash
php artisan config:clear
```

### Missing assets

Run the Vite development server:

```bash
npm run dev
```

Or create a production build:

```bash
npm run build
```

### Sentiment analysis is unavailable

Check that:

1. The Flask service is running on port `5003`.
2. The model and vectorizer files exist in `python_api/`.
3. `SENTIMENT_API_URL` points to the correct endpoint.
4. Laravel logs in `storage/logs/laravel.log` for connection errors.

## Security Notes

- Do not commit `.env` or production credentials.
- Change the seeded administrator password.
- Set `APP_DEBUG=false` in production.
- Do not run `migrate:fresh` on a database containing important data.
- Protect the sentiment service before exposing it publicly.

## License

No project-specific license has been declared yet.
