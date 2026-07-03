# florin-flowe — Project Conventions

## Architecture

This is a Laravel project that follows a strict layered architecture:

```
Request → Controller → Service → Model (queries) → DB
                  ↑          ↑
            FormRequest    DTO
```

### Controllers (`app/Http/Controllers/`)
- **No business logic.** Controllers only call service methods and return views/responses.
- Inject services via constructor using their **interface** (not the concrete class).
- Use `FormRequest` classes for validation — never validate inside the controller method.

```php
// CORRECT
public function store(CreateRequest $request): RedirectResponse
{
    $data = CreateData::fromRequest($request);
    $this->userService->create($data);
    return redirect()->route('users.index');
}

// WRONG — logic in controller
public function store(Request $request): RedirectResponse
{
    $user = User::create($request->all()); // never query in controller
    $user->sendWelcomeEmail();             // never call business logic here
}
```

### Services (`app/Services/{domain}/`)
- All business logic lives here.
- Always backed by an interface in `app/Services/Contracts/`.
- Receive DTOs as input, return typed values (models, collections, DTOs).
- Delegate all DB queries to **model static methods** — never write `::query()` chains inside a service.

```php
// CORRECT — delegate query to model
public function filter(UserFilterData $filter): Paginator
{
    return User::filter($filter);
}

// WRONG — query logic inside service
public function filter(UserFilterData $filter): Paginator
{
    return User::query()->where(...)->simplePaginate($filter->per_page);
}
```

### Models (`app/Models/`)
- Own all Eloquent query logic as **static methods**.
- No raw `::query()` chains should live outside model files.
- Name query methods descriptively: `filter()`, `listPaginated()`, `listForSelect()`, `checkReferralExists()`.

```php
// CORRECT — query logic in model
public static function filter(UserFilterData $filter): Paginator
{
    return self::query()
        ->simplePaginate(perPage: $filter->per_page, page: $filter->page)
        ->withQueryString();
}
```

### DTOs (`app/DTO/`)
- Plain PHP classes carrying typed data between layers.
- Input DTOs (e.g. `CreateData`, `UserFilterData`) are built in the controller or FormRequest and passed into services.
- Filter DTOs extend `PaginatorFilter` for paginated list endpoints.
- No business logic inside DTOs.

```
app/DTO/
├── filter/         # Filter/paginator DTOs (extend PaginatorFilter)
│   └── UserFilterData.php
├── user/           # Operation DTOs per domain
│   └── CreateData.php
└── form/           # View/form helper DTOs
    └── SubmitBtnData.php
```

### Service Interfaces (`app/Services/Contracts/`)
- Every service has a corresponding interface.
- Controllers always type-hint the interface, never the concrete class.
- Bindings are registered in `AppServiceProvider`.

## Directory Layout

```
app/
├── DTO/                        # Data transfer objects
├── Enums/                      # Backed enums (use LabelTrait / ValuesTrait)
├── Http/
│   ├── Controllers/            # Thin controllers — no logic
│   └── Requests/               # FormRequest validation classes
├── Livewire/                   # Livewire components
├── Models/                     # Eloquent models + all query methods
├── Services/
│   ├── Contracts/              # Service interfaces
│   └── {domain}/               # Concrete service implementations
└── Commons/                    # Shared infrastructure (Menu, Types, etc.)
```

## Rules Summary

| Layer | Responsibility | Must NOT |
|---|---|---|
| Controller | Route → Service → Response | Contain query or business logic |
| Service | Business logic | Write Eloquent query chains |
| Model | Eloquent queries | Contain business logic |
| DTO | Typed data carrier | Contain logic |
| FormRequest | HTTP input validation | Touch the DB |
