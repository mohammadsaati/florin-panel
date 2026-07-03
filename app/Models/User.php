<?php

namespace App\Models;

use App\DTO\filter\UserFilterData;
use App\DTO\user\CreateData;
use App\Enums\UserGenderEnum;
use App\Enums\UserStatusEnum;
use App\Enums\UserTypeEnum;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Pagination\Paginator;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $mobile
 * @property string $invited_by
 * @property string $referral_code
 * @property int $age
 * @property UserTypeEnum $type
 * @property UserStatusEnum $status
 * @property string $password
 *
 * @method static Builder|User query()
 * @method static Builder|User getByReferralCode(string $referral_code)
 */
#[Hidden(['password'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $guarded = ['id'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'gender' => UserGenderEnum::class,
            'status' => UserStatusEnum::class,
            'type' => UserTypeEnum::class,
            'birth_date' => 'datetime'
        ];
    }

    /**
     * @param Builder<User> $query
     * @return Builder<User>
     */
    #[Scope]
    public function getByReferralCode(Builder $query, string $referral_code): Builder
    {
        return $query->where('referral_code', $referral_code);
    }

    /**
     * @param Builder<User> $query
     * @return Builder<User>
     */
    #[Scope]
    public function ofPhoneNumber(Builder $query, string $phone): Builder
    {
        return $query->where('mobile', $phone);
    }

    public function getName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function showInvitedBy(): User|null
    {
        if (empty($this->invited_by)) {
            return null;
        }

        return self::query()->getByReferralCode($this->invited_by)->first() ?? null;
    }

    /**
     * @return Paginator<int, User>
     */
    public static function filter(UserFilterData $filter): Paginator
    {

        return self::query()
            ->when($filter->user_id, function(Builder $query) use ($filter) {
                $query->where('id', $filter->user_id);
            })
            ->when(!empty($filter->invited_by), function(Builder $query) use ($filter) {
                $query->where('invited_by', $filter->invited_by);
            })
            ->when(!empty($filter->search), function (Builder $query) use ($filter) {
                $query->orWhere('first_name', 'like', '%' . $filter->search . '%')
                    ->orWhere('last_name', 'like', '%' . $filter->search . '%')
                    ->orWhere('mobile', 'like', '%' . $filter->search . '%');
            })
            ->simplePaginate(
                perPage: $filter->per_page,
                page: $filter->page,
            )
            ->withQueryString();
    }

    public static function createFromData(CreateData $data): self
    {
        return self::create([
            'first_name'    => $data->first_name,
            'last_name'     => $data->last_name,
            'mobile'        => $data->mobile,
            'birth_date'    => $data->birth_date,
            'gender'        => $data->gender->value,
            'age'           => $data->age,
            'referral_code' => $data->referral_code,
            'invited_by'    => $data->invited_by,
            'type'          => $data->type->value,
            'status'        => $data->status->value,
            'password'      => $data->password,
        ]);
    }

    public static function checkReferralExists(string $code): bool
    {
        return self::query()
            ->where('referral_code', $code)
            ->exists();
    }

    public static function findByPhoneNumber(string $phone): User|null
    {
        return self::query()
            ->ofPhoneNumber($phone)->first();
    }
}
