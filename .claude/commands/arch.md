Follow these architecture rules for every piece of code you write or suggest in this project:

## Layer Rules

**Controllers** (`app/Http/Controllers/`)
- No business logic, no Eloquent queries.
- Only call service methods and return views/responses.
- Inject services via constructor using the **interface**, not the concrete class.
- Use `FormRequest` classes for all validation.

**Services** (`app/Services/{domain}/`)
- All business logic lives here.
- Always backed by an interface in `app/Services/Contracts/`.
- Accept DTOs as parameters, return typed values.
- Delegate every DB query to a **model static method** — never write `::query()` chains inside a service.

**Models** (`app/Models/`)
- Own all Eloquent query logic as static methods.
- Name methods descriptively: `filter()`, `listPaginated()`, `listForSelect()`, `checkReferralExists()`.
- No business logic.

**DTOs** (`app/DTO/`)
- Plain typed PHP classes — no logic.
- Filter DTOs extend `PaginatorFilter`.
- Organized by domain: `DTO/user/`, `DTO/filter/`, `DTO/form/`.

## Quick Reference

| Layer | Does | Does NOT |
|---|---|---|
| Controller | Route → Service → Response | Query DB or contain logic |
| Service | Business logic | Write Eloquent chains |
| Model | Eloquent static query methods | Contain business logic |
| DTO | Carry typed data between layers | Contain logic |
| FormRequest | Validate HTTP input | Touch the DB |

## Correct Pattern

```php
// Controller
public function store(CreateRequest $request): RedirectResponse
{
    $this->userService->create(CreateData::fromRequest($request));
    return redirect()->route('users.index');
}

// Service
public function filter(UserFilterData $filter): Paginator
{
    return User::filter($filter); // delegate to model
}

// Model
public static function filter(UserFilterData $filter): Paginator
{
    return self::query()
        ->simplePaginate(perPage: $filter->per_page, page: $filter->page)
        ->withQueryString();
}
```
