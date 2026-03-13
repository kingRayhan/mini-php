# MiniPHP

A PHP micro-framework that gets out of your way. ~1,200 lines of framework code. No scaffolding, no CLI tools, no magic — just the essentials to build web apps and APIs fast.

**[Documentation](https://miniphp.netlify.app/)**

---

## Why MiniPHP?

Not every project needs Laravel or Symfony. If you're building a small API, a webhook handler, a prototype, an internal tool, or a simple website — a full framework is overkill. You spend more time configuring it than writing your actual code.

MiniPHP gives you the parts that matter and nothing else:

|                     | MiniPHP      | Laravel     | Slim      | Lumen    |
| ------------------- | ------------ | ----------- | --------- | -------- |
| Framework code      | ~1,200 lines | ~400k lines | ~6k lines | Archived |
| Install size        | ~15 MB       | ~80 MB      | ~30 MB    | -        |
| Time to first route | Seconds      | Minutes     | Seconds   | -        |
| Routing with params | Yes          | Yes         | Yes       | Yes      |
| Twig templates      | Built-in     | Blade       | Add-on    | Blade    |
| Eloquent ORM        | Built-in     | Built-in    | Add-on    | Built-in |
| Validation          | Built-in     | Built-in    | Add-on    | Built-in |
| Learning curve      | Read once    | Weeks       | Read once | Days     |

### Choose MiniPHP when you need:

- A REST API in minutes, not hours
- A small web app without a 50-file boilerplate
- Eloquent models without the rest of Laravel
- Something you can read end-to-end in one sitting
- A starting point you fully understand and control

### Choose something else when you need:

- Auth, queues, jobs, scheduling, broadcasting (use Laravel)
- Middleware pipeline, PSR-15, DI autowiring (use Slim)
- Enterprise-grade architecture, bundles, DI (use Symfony)

---

## Requirements

- PHP 8.1+
- Composer
- PDO, JSON extensions
- Apache with `mod_rewrite`, or PHP's built-in server

---

## Installation

```bash
git clone https://github.com/kingrayhan/mini-php.git
cd mini-php
composer install
cp .env.example .env
# Edit .env with your database credentials
```

**Run with PHP's built-in server:**

```bash
php -S localhost:8000 index.php
```

Or point your Apache/Nginx document root to the project root (`.htaccess` is included).

---

## Features & Code Snippets

### Routing

Define routes in `routes.php`. Handlers can be closures or controller class methods.

**Closures:**

```php
// Closure
$app->get('/', function ($request, $response) {
    return $response->view('welcome');
});

$app->post('/submit', function ($request, $response) {
    $data = $request->only(['name', 'email']);
    return $response->withJSON(['ok' => true]);
});
```

**Controller reference:**

```php
$app->get('/', [HomeController::class, 'index']);
$app->post('/login', [AuthController::class, 'login']);
```

**Path parameters:**

```php
$app->get('/users/{id}', function ($request, $response) {
    $id = $request->param('id');
    return $response->withJSON(['id' => $id]);
});

$app->get('/posts/{postId}/comments/{commentId}', function ($request, $response) {
    $postId = $request->param('postId');
    $commentId = $request->param('commentId');
    // ...
});
```

**Multiple HTTP methods for one URI:**

```php
$app->map('/api/resource', [ApiController::class, 'handle'], ['GET', 'POST']);
```

---

### Request

Injected into route handlers; use it to read input and request info.

```php
$app->get('/users/{id}', function ($request, $response) {
    // Path parameters
    $id = $request->param('id');
    $allParams = $request->param();       // ['id' => '42']

    // All input (form-encoded + JSON body + query string)
    $all = $request->all();

    // Only specific keys
    $data = $request->only(['name', 'email']);

    // All except certain keys
    $filtered = $request->except(['password', 'token']);

    // JSON body (parsed automatically when Content-Type is application/json)
    $json = $request->json();

    // Query string
    $page = $request->query('page');
    $allQuery = $request->query();        // entire $_GET

    // Request info
    $method   = $request->method();       // GET, POST, etc.
    $path     = $request->path();         // /users/42
    $url      = $request->fullUrl();      // https://example.com/users/42
    $host     = $request->host();
    $protocol = $request->protocol();     // https:// or http://

    return $response->withJSON($data);
});
```

---

### Response

Return a string or a `Response` instance. Use helpers for JSON, status codes, and views.

```php
// Plain string
return 'Hello World';

// Twig view
return $response->view('welcome');
return $response->view('users.show', ['user' => $user]);

// JSON
return $response->withJSON(['id' => 1, 'name' => 'Jane']);

// Custom status code
return $response->withStatus(StatusCodes::HTTP_CREATED)->withJSON($newItem);
return $response->withStatus(404)->setBody('Not found');

// Redirect (302 temporary by default)
return $response->redirect('/dashboard');

// Permanent redirect (301)
return $response->redirect('/new-url', 301);

// Redirect after form submission
flash()->add('success', 'Created!');
return $response->redirect('/posts');
```

---

### Views (Twig)

Templates live in `views/`, with `.twig` extension. Pass data as the second argument to `view()`.

**Controller:**

```php
public function show(Request $request, Response $response)
{
    $user = User::find(1);
    return $response->view('users.profile', [
        'user' => $user,
        'title' => 'Profile',
    ]);
}
```

**Template `views/users/profile.twig`:**

```twig
{% extends "layouts/base.twig" %}

{% block content %}
    <h1>{{ title }}</h1>
    <p>{{ user.name }}</p>
{% endblock %}
```

---

### Database (Eloquent ORM)

MiniPHP uses **Illuminate Database** (Eloquent). Configure `DB_*` in `.env`; the ORM is booted in `index.php` and available from the container.

**Model** (`app/models/User.php`):

```php
namespace MiniPHP\models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['name', 'email'];
}
```

**In routes or controllers (Capsule is set as global):**

```php
use MiniPHP\models\User;

// Fetch
$user = User::find(1);
$users = User::all();
$active = User::where('active', 1)->get();

// Create
$user = User::create(['name' => 'Jane', 'email' => 'jane@example.com']);

// Update
$user->update(['name' => 'Jane Doe']);

// Delete
$user->delete();
```

**Using the container (e.g. in a controller):**

```php
$capsule = $this->container->get('orm');
$capsule->getConnection()->table('logs')->insert([...]);
```

---

### Flash messages

One-time messages across redirects (uses Slim Flash).

```php
// Set a flash message (e.g. in a controller)
flash()->add('success', 'Profile updated.');
flash()->add('error', 'Invalid credentials.');

// In the next request (e.g. in a view or route)
$message = flash()->get('success');
if (flash()->has('error')) {
    $error = flash()->get('error');
}

// Clear all
flash()->clear();
```

**Example: pass flash from controller to view:**

```php
return $response->view('dashboard', [
    'flash_success' => flash()->get('success'),
    'flash_has_error' => flash()->has('error'),
]);
```

```twig
{% if flash_success %}
    <div class="alert">{{ flash_success }}</div>
{% endif %}
```

---

### Validation

Validate request data with `$request->validate()`. Rules are pipe-separated, Laravel-style.

```php
public function store(Request $request, Response $response)
{
    $validator = $request->validate([
        'title' => 'required|string|min:3|max:255',
        'email' => 'required|email',
        'status' => 'in:active,inactive',
    ]);

    if ($validator->fails()) {
        return $response
            ->withStatus(400)
            ->withJSON(['errors' => $validator->errors()]);
    }

    $data = $validator->validated();
    // $data contains only the validated fields
}
```

**Error response format:**

```json
{
  "errors": {
    "title": ["title is required"],
    "email": ["email must be a valid email"]
  }
}
```

**Available rules:**

| Rule       | Description                           |
| ---------- | ------------------------------------- |
| `required` | Must be present and non-empty         |
| `string`   | Must be a string                      |
| `integer`  | Must be an integer                    |
| `numeric`  | Must be numeric                       |
| `email`    | Must be a valid email                 |
| `boolean`  | Must be boolean-like (true/false/0/1) |
| `min:n`    | Minimum string length                 |
| `max:n`    | Maximum string length                 |
| `in:a,b,c` | Must be one of the listed values      |

You can also use `Validator::make()` directly:

```php
use MiniPHP\Validator;

$validator = Validator::make($data, [
    'name' => 'required|string',
    'age'  => 'required|integer',
]);
```

---

### Route groups

Group routes under a common prefix with `$app->group()`. Groups can be nested.

```php
$app->group('/api', function ($app) {
    $app->group('/todos', function ($app) {
        $app->get('', [TodoController::class, 'index']);        // GET  /api/todos
        $app->post('', [TodoController::class, 'store']);       // POST /api/todos
        $app->get('/{id}', [TodoController::class, 'show']);    // GET  /api/todos/1
        $app->put('/{id}', [TodoController::class, 'update']);  // PUT  /api/todos/1
        $app->delete('/{id}', [TodoController::class, 'destroy']); // DELETE /api/todos/1
    });

    $app->group('/users', function ($app) {
        $app->get('', [UserController::class, 'index']);        // GET /api/users
    });
});
```

---

### Helpers

Global helpers are available after Composer autoload (see `app/helpers.php`).

```php
// Request/Response
$req = request();
$res = response();

// JSON response
return toJSON(['status' => 'ok']);

// Flash
flash()->add('key', 'message');
```

---

### HTTP status codes

Use `MiniPHP\StatusCodes` for readable status codes and helpers.

```php
use MiniPHP\StatusCodes;

http_response_code(StatusCodes::HTTP_CREATED);  // 201
http_response_code(StatusCodes::HTTP_NOT_FOUND); // 404

$header = StatusCodes::httpHeaderFor(503);  // "HTTP/1.1 503 Service Unavailable"
$message = StatusCodes::getMessageForCode(500);
$isError = StatusCodes::isError(400);  // true
```

---

### Exceptions

The framework throws these when appropriate:

- `RouteNotFoundException` – no route for the path
- `MethodNotAllowedException` – route exists but method not allowed
- `InvalidControllerClass` – controller class doesn’t exist or isn’t loadable
- `InvalidContainerKeyException` – container key missing

Whoops is registered in `index.php` for detailed error pages in development.

---

## Project structure

```
mini-php/
├── app/
│   ├── App.php           # Application & routing facade
│   ├── Container.php     # Service container
│   ├── Router.php        # Route matching
│   ├── Route.php         # Single route
│   ├── Request.php       # HTTP request
│   ├── Response.php      # HTTP response
│   ├── View.php          # Twig renderer
│   ├── Orm.php           # Eloquent bootstrap
│   ├── Validator.php     # Request validation
│   ├── Flash.php         # Flash messages
│   ├── StatusCodes.php   # HTTP status constants
│   ├── helpers.php       # Global helpers
│   ├── Controllers/
│   ├── Exceptions/
│   └── models/
├── views/                # Twig templates
├── public/               # Web root assets
├── routes.php            # Route definitions
├── index.php             # Entry point
└── .env                  # Environment config (create from .env.example)
```

---

## License

MIT
