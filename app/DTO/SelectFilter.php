<?php

namespace App\DTO;

use App\Enums\SelectFilterOperator;
use Illuminate\Database\Eloquent\Builder;

/**
 * Usage examples:
 *
 *   SelectFilter::equals('status', 'active')
 *   SelectFilter::in('role', ['admin', 'editor'])
 *   SelectFilter::like('name', 'john')         // becomes LIKE %john%
 *   SelectFilter::notIn('type', ['banned'])
 *   SelectFilter::greaterThan('age', 18)
 *   SelectFilter::isNull('deleted_at')
 *
 * In Blade:
 *   <livewire:components.custom-select
 *       model="App\Models\User"
 *       :filters="[
 *           SelectFilter::equals('status', 'active'),
 *           SelectFilter::in('role', ['admin', 'editor']),
 *       ]"
 *       name="user_id"
 *   />
 */
final class SelectFilter
{
    private function __construct(
        public readonly string $column,
        public readonly SelectFilterOperator $operator,
        public readonly mixed $value = null,
    ) {}

    // -------------------------------------------------------------------------
    // Factory methods
    // -------------------------------------------------------------------------

    public static function equals(string $column, string|int|float|bool $value): self
    {
        return new self($column, SelectFilterOperator::Equals, $value);
    }

    public static function notEquals(string $column, string|int|float|bool $value): self
    {
        return new self($column, SelectFilterOperator::NotEquals, $value);
    }

    public static function greaterThan(string $column, int|float $value): self
    {
        return new self($column, SelectFilterOperator::GreaterThan, $value);
    }

    public static function greaterEqual(string $column, int|float $value): self
    {
        return new self($column, SelectFilterOperator::GreaterEqual, $value);
    }

    public static function lessThan(string $column, int|float $value): self
    {
        return new self($column, SelectFilterOperator::LessThan, $value);
    }

    public static function lessEqual(string $column, int|float $value): self
    {
        return new self($column, SelectFilterOperator::LessEqual, $value);
    }

    public static function like(string $column, string $value): self
    {
        return new self($column, SelectFilterOperator::Like, $value);
    }

    public static function in(string $column, array $values): self
    {
        return new self($column, SelectFilterOperator::In, $values);
    }

    public static function notIn(string $column, array $values): self
    {
        return new self($column, SelectFilterOperator::NotIn, $values);
    }

    public static function isNull(string $column): self
    {
        return new self($column, SelectFilterOperator::IsNull);
    }

    public static function isNotNull(string $column): self
    {
        return new self($column, SelectFilterOperator::IsNotNull);
    }

    // -------------------------------------------------------------------------
    // Apply to query
    // -------------------------------------------------------------------------

    public function apply(Builder $query): void
    {
        match ($this->operator) {
            SelectFilterOperator::Equals       => $query->where($this->column, '=', $this->value),
            SelectFilterOperator::NotEquals    => $query->where($this->column, '!=', $this->value),
            SelectFilterOperator::GreaterThan  => $query->where($this->column, '>', $this->value),
            SelectFilterOperator::GreaterEqual => $query->where($this->column, '>=', $this->value),
            SelectFilterOperator::LessThan     => $query->where($this->column, '<', $this->value),
            SelectFilterOperator::LessEqual    => $query->where($this->column, '<=', $this->value),
            SelectFilterOperator::Like         => $query->where($this->column, 'like', "%{$this->value}%"),
            SelectFilterOperator::In           => $query->whereIn($this->column, $this->value),
            SelectFilterOperator::NotIn        => $query->whereNotIn($this->column, $this->value),
            SelectFilterOperator::IsNull       => $query->whereNull($this->column),
            SelectFilterOperator::IsNotNull    => $query->whereNotNull($this->column),
        };
    }

    // Livewire-safe serialization
    public function toArray(): array
    {
        return [
            'column'   => $this->column,
            'operator' => $this->operator->value,
            'value'    => $this->value,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['column'],
            SelectFilterOperator::from($data['operator']),
            $data['value'] ?? null,
        );
    }
}
