# Orbits

Orbits is a role-based faculty evaluation and academic information management
system. It gives students a structured way to evaluate their instructors,
while faculty members, program chairs, and administrators receive access to
the academic data and evaluation results relevant to their responsibilities.

The application combines a Laravel web application with Livewire-driven
interfaces, a MySQL database, and an optional Flask sentiment-analysis
service for classifying written feedback.

> **Documentation status:** Screenshot locations below are templates. Replace
> each placeholder with the corresponding screenshot when the final images are
> available.

## Contents

- [Highlights](#highlights)
- [User roles](#user-roles)
- [Core features](#core-features)
- [Application flow](#application-flow)
- [Technology stack](#technology-stack)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Running the application](#running-the-application)
- [Sentiment-analysis service](#sentiment-analysis-service)
- [Deployment](#deployment)
- [Project structure](#project-structure)
- [Screenshots](#screenshots)
- [Testing and code quality](#testing-and-code-quality)
- [Troubleshooting](#troubleshooting)
- [Security notes](#security-notes)
- [Contributing](#contributing)
- [License](#license)

## Highlights

- Role-aware dashboards and navigation for students, faculty members, program
  chairs, and administrators.
- Course and faculty evaluation workflows with rating questions and optional
  written comments.
- Administration of departments, courses, programs, sections, faculty,
  students, accounts, surveys, and survey questions.
- Search, filtering, sorting, pagination, create/update/delete workflows, and
  import support across management screens.
- Evaluation result summaries with charts and written-feedback sentiment
  counts.
- Activity logging for important data changes and system events.
- UUID-based links with middleware checks for protected records.
- Responsive Blade/Tailwind interfaces enhanced with Alpine.js and Livewire.

## User roles

The seeded roles are defined in `database/seeders/RolesTableSeeder.php`.

| Role | Typical capabilities |
| --- | --- |
| **Student** | View assigned evaluations and submit ratings and comments. |
| **Faculty** | View faculty-oriented evaluation pages and relevant feedback. |
| **Program chair** | Review evaluation results and program-level summaries. |
| **Administrator** | Manage users, academic records, surveys, evaluation settings, logs, and system data. |

Access is enforced by the `check_role` middleware. A user sees a dashboard
appropriate to their role, and protected routes reject unauthenticated or
unauthorized requests.

## Core features

### Evaluation management

- Configure evaluation periods and surveys.
- Manage survey questions and question criteria.
- Assign evaluations to eligible users and course sections.
- Present rating questions and optional comments to evaluators.
- Prevent completed evaluations from being submitted again.
- Record response timestamps and completion state.

### Academic data management

Administrators can maintain the records used by the evaluation process:

- Departments
- Courses
- Programs
- Sections and section-course assignments
- Faculty and faculty-course assignments
- Students and student-course assignments
- Program chairs
- User accounts and profiles

Many of these screens support live search, filters, pagination, soft-delete or
restore workflows, and activity logging.

### Results and reporting

- Browse faculty evaluation results.
- Filter results by faculty search terms and department.
- Open a faculty summary using a protected UUID route.
- View rating breakdowns and summary metrics.
- Display positive and negative written-feedback counts in a donut chart.
- Review monitoring and ranking pages available to authorized roles.

### Sentiment analysis

Written comments can be sent to the optional Flask service at
`/analyze_sentiment`. The service returns the original text, a
`positive`/`negative`/`neutral` label, and an explanatory comment. The Laravel
results summary consumes this response and logs connection or prediction
errors rather than silently treating an unavailable service as a successful
analysis.

The service loads `sentiment_model.pkl` and `tfidf_vectorizer.pkl` from
`python_api/`. If the model cannot be loaded or prediction fails, the current
implementation falls back to keyword-based classification.

### Auditing

The application uses Spatie Activitylog to record significant changes,
including successful operations and relevant validation or system errors. The
administrator logs page exposes these records for review.

## Application flow

1. The root URL redirects to the login page.
2. An authenticated user is routed to a role-specific dashboard.
3. The user receives only the evaluation, administration, or reporting pages
   permitted by their role.
4. Students open assigned evaluations, select ratings, optionally add a
   comment, and submit once.
5. Authorized reviewers inspect aggregated results and faculty summaries.
6. Written comments may be classified by the sentiment service and visualized
   in the results summary.

## Technology stack

### Backend

- PHP 8.2+
- Laravel 11
- Livewire 3
- Laravel Eloquent ORM
- MySQL
- Laravel database sessions, cache, and queues
- Spatie Laravel Activitylog
- PhpSpreadsheet, Laravel Excel, and League CSV for data operations

### Frontend

- Blade templates
- Tailwind CSS
- Alpine.js
- Vite
- Axios
- ApexCharts
- Font Awesome

### Sentiment service

- Python 3
- Flask
- Joblib
- A serialized model and TF-IDF vectorizer

## Requirements

Install the following before starting development:

- PHP 8.2 or later with the extensions required by Laravel
- Composer
- Node.js and npm
- MySQL 8 or a compatible MySQL server
- Python 3 and `pip` (only required for sentiment analysis)
- Git

The repository includes `vendor/` and `node_modules/` in some working copies,
but fresh installations should use Composer and npm rather than relying on
those directories.

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/Moya-Fried-Rice/Orbits_v1.2.git
cd Orbits_v1.2
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install frontend dependencies

```bash
npm install
```

### 4. Create the environment file

```bash
copy .env.example .env
php artisan key:generate
```

On macOS or Linux, use `cp .env.example .env` instead of `copy`.

### 5. Create and configure the database

Create a MySQL database named `orbits_v1.2` (or choose another name) and set
the matching values in `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=orbits_v1.2
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Migrate and seed

For a normal local setup:

```bash
php artisan migrate --seed
```

To rebuild the database from scratch with the development seed data:

```bash
php artisan migrate:fresh --seed
```

The seeders create the role catalog and representative academic records. The
development admin seeder currently creates:

```text
Email:    appleadmin@gmail.com
Password: admin123
Role:     administrator
```

Change or remove this development credential before using the application in a
shared or production environment.

### 7. Link public storage

If profile images or other public uploads are used, create Laravel's storage
link:

```bash
php artisan storage:link
```

## Configuration

The main application settings live in `.env`. At minimum, configure:

- `APP_NAME`, `APP_URL`, and `APP_ENV`
- `APP_KEY` (generated with `php artisan key:generate`)
- `DB_*` database settings
- `SESSION_DRIVER`, `CACHE_STORE`, and `QUEUE_CONNECTION`
- Mail settings if welcome messages or password emails are enabled

The sentiment endpoint is configurable through `config/services.php`:

```dotenv
SENTIMENT_API_URL=http://127.0.0.1:5003/analyze_sentiment
```

Keep `.env` out of version control. Do not place passwords, API keys, or
production credentials in the repository.

## Running the application

### Development

Start the Laravel server, queue listener, and Vite development server
together:

```bash
composer run dev
```

Alternatively, run the processes separately:

```bash
php artisan serve
php artisan queue:listen --tries=1
npm run dev
```

Open <http://127.0.0.1:8000> (or the URL printed by Artisan).

### Production asset build

```bash
npm run build
```

For a production deployment, also cache the application configuration,
routes, and views after setting the production environment values:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Sentiment-analysis service

The Laravel application expects a separate Flask process when sentiment
classification is enabled.

### Start the service

From the repository root:

```bash
cd python_api
python -m venv .venv
```

Activate the environment:

```powershell
# Windows PowerShell
.\.venv\Scripts\Activate.ps1
```

```bash
# macOS/Linux
source .venv/bin/activate
```

Install the Python packages used by the service:

```bash
pip install flask joblib scikit-learn
python sentiment_analyzer_api.py
```

The service listens on `127.0.0.1:5003` by default. Verify it independently:

```bash
curl -X POST http://127.0.0.1:5003/analyze_sentiment \
  -H "Content-Type: application/json" \
  -d "{\"text\":\"The instructor was helpful and knowledgeable.\"}"
```

Expected response shape:

```json
{
  "text": "The instructor was helpful and knowledgeable.",
  "sentiment": "positive",
  "comment": "..."
}
```

The Flask service currently runs with `debug=True` and binds to localhost.
Use a production WSGI server and disable debug mode before exposing it beyond
local development.

## Deployment

`railway.toml` defines a Railway/Nixpacks deployment flow:

1. Install Composer dependencies.
2. Install npm dependencies and build frontend assets.
3. Run migrations and seeders.
4. Cache configuration, routes, and views.
5. Start the Laravel server on the assigned `$PORT`.

Before deploying:

- Set `APP_ENV=production` and `APP_DEBUG=false`.
- Configure a managed MySQL database and all `DB_*` variables.
- Configure a secure `APP_KEY`.
- Replace development credentials and seed data.
- Configure mail, queue, cache, and storage services for the target platform.
- Review the deployment command before using `migrate:fresh --seed`; it
  destroys existing database data and is appropriate only for a disposable
  environment.
- Provide the sentiment service separately if production results require it.

## Project structure

```text
app/
├── Http/Controllers/       HTTP controllers and API endpoints
├── Http/Middleware/        Role, UUID, and evaluation guards
├── Livewire/               Stateful CRUD, evaluation, and results components
├── Mail/                   Application mailables
└── Models/                 Eloquent models and relationships

config/                     Application and service configuration
database/
├── migrations/             Database schema history
└── seeders/                Development roles and academic data
python_api/                 Flask sentiment service and serialized models
public/                     Public assets, logos, fonts, and compiled files
resources/
├── css/                    Tailwind/CSS entry points
├── js/                     JavaScript entry points
├── sass/                   Sass variables and styles
└── views/                  Blade layouts, pages, and Livewire views
routes/web.php              Web routes and role-protected pages
storage/                    Logs, cache, compiled views, and uploads
```

## Screenshots

Add screenshots to a directory such as `docs/screenshots/`, then replace the
template paths below. Use descriptive filenames and capture the application at
the same viewport size where possible.

### Landing and authentication

<!-- Screenshot template: replace with the supplied image. -->
![Orbits login screen](docs/screenshots/login.png)

_Suggested capture: login screen showing the Orbits branding and form._

### Role-based dashboard

<!-- Screenshot template: replace with the supplied image. -->
![Role-based dashboard](docs/screenshots/dashboard.png)

_Suggested capture: dashboard cards and navigation for one representative
role._

### Student evaluation

<!-- Screenshot template: replace with the supplied image. -->
![Student evaluation form](docs/screenshots/evaluation-form.png)

_Suggested capture: rating questions, comment field, and submission action._

### Administration

<!-- Screenshot template: replace with the supplied image. -->
![Academic data administration](docs/screenshots/administration.png)

_Suggested capture: a CRUD table with search, filters, pagination, and actions._

### Results and reporting

<!-- Screenshot template: replace with the supplied image. -->
![Evaluation results summary](docs/screenshots/results-summary.png)

_Suggested capture: faculty results, rating summaries, and sentiment chart._

### Optional gallery

<!-- Add additional supplied screenshots here. -->

| Screen | Image | Description |
| --- | --- | --- |
| Faculty profile | `docs/screenshots/faculty-profile.png` | Faculty details and evaluation summary |
| Survey builder | `docs/screenshots/survey-builder.png` | Survey and question management |
| Activity logs | `docs/screenshots/activity-logs.png` | Recorded user and system actions |

## Testing and code quality

Run the Laravel test suite with:

```bash
php artisan test
```

Format PHP files with Laravel Pint:

```bash
vendor/bin/pint
```

Build frontend assets to catch Vite and asset compilation errors:

```bash
npm run build
```

For the sentiment service, verify the endpoint manually with the `curl`
request shown in [Sentiment-analysis service](#sentiment-analysis-service).

## Troubleshooting

### Database connection errors

Confirm that MySQL is running, the database exists, and the `DB_*` values in
`.env` match the local server. Clear cached configuration after changing
environment variables:

```bash
php artisan config:clear
```

### Missing application key

Run:

```bash
php artisan key:generate
```

### Assets are not loading

Start Vite for development:

```bash
npm run dev
```

Or build production assets:

```bash
npm run build
```

### Sentiment results are unavailable

Confirm that the Flask service is running on port `5003`, that the model files
exist in `python_api/`, and that `SENTIMENT_API_URL` points to the correct
endpoint. Laravel logs the connection and response errors in
`storage/logs/laravel.log`.

### Stale cached routes or configuration

```bash
php artisan optimize:clear
```

## Security notes

- Never commit `.env`, credentials, serialized private data, or production
  logs.
- Replace the seeded admin password immediately outside local development.
- Keep `APP_DEBUG=false` in production.
- Run the sentiment service behind a production WSGI server and restrict its
  network exposure.
- Review authorization middleware whenever adding a route or Livewire action.
- Avoid using `migrate:fresh` against a database that contains data that must
  be preserved.

## Contributing

1. Create a feature branch.
2. Make focused changes following the existing Laravel, Livewire, and Blade
   conventions.
3. Run the relevant tests, Pint, and frontend build.
4. Update this README when setup, features, routes, or screenshots change.
5. Open a pull request describing the behavior change and validation performed.

## License

This project does not currently declare a project-specific license. Add the
appropriate license and copyright holder information before distributing or
deploying the application publicly.
