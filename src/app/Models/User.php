<?php

namespace App\Models;

use App\Http\Requests\AdminUserUpdateFormRequest;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\UserStoreFormRequest;
use App\Http\Requests\UserUpdateFormRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;


/**
 * @method static whereIn(string $string, $chatUsersIds)
 * @method static findOrFail($id)
 * @method static create(array $all)
 * @method static paginate(int $int)
 * @property mixed $is_manager
 * @property mixed $is_executive
 * @property mixed $is_logist
 * @property mixed $is_accountant
 * @property mixed $id
 */
class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    use FormAccessible, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'middle_name',
        'email',
        'password',
        'phone',
        'address',
        'photo_path',
        'birth_date',
        'gender',
        'bank_card',
        'passport_number',
        'passport_series',
        'is_admin',
        'is_manager',
        'is_executive',
        'is_brigadier',
        'is_hr',
        'is_accountant',
        'is_logist',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasAnyRole($roles): bool
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->{$role}) {
                    return true;
                }
            }
        } else {
            if ($this->{$roles}) {
                return true;
            }
        }

        return false;
    }

    public function userTasks(): HasMany
    {
        return $this->hasMany(UserTask::class, 'user_id');
    }

    public function usersFiles(): HasMany
    {
        return $this->hasMany(UsersFile::class, 'user_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_manager_id');
    }

    public function chatsActivities(): HasMany
    {
        return $this->hasMany(ChatsActivity::class, 'user_id');
    }

    public function usersChats(): HasMany
    {
        return $this->hasMany(UsersChat::class, 'user_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_user_id');
    }

    public function kanbans(): HasMany
    {
        return $this->hasMany(Kanban::class, 'user_id');
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'creator_id');
    }

    public function applyPositionFilters(Builder $query, $position): void
    {
        if ($position) {

            switch ($position) {
                case 'is_manager':
                    $query->where('is_manager', true);
                    break;
                case 'is_hr':
                    $query->where('is_hr', true);
                    break;
                case 'is_accountant':
                    $query->where('is_accountant', true);
                    break;
                case 'is_logist':
                    $query->where('is_logist', true);
                    break;
                case 'is_executive':
                    $query->where('is_executive', true);
                    break;
            }
        }
    }

    public function applyPhoneFilters(Builder $query, $phone): void
    {
        if ($phone) {
            $query->where('phone', $phone);
        }
    }

    public function applyAgeFilters(Builder $query, $ageFrom, $ageTo): void
    {

        if ($ageFrom && !$ageTo) {
            $currentYear = date('Y');
            $birthYear = $currentYear - $ageFrom;
            $query->whereYear('birth_date', '<', $birthYear);
        }

        if (!$ageFrom && $ageTo) {
            $currentYear = date('Y');
            $birthYear = $currentYear - $ageTo;
            $query->whereYear('birth_date', '>', $birthYear);
        }

        if ($ageFrom && $ageTo) {
            $currentYear = date('Y');
            $birthYearFrom = $currentYear - $ageTo;
            $birthYearTo = $currentYear - $ageFrom;

            $query->whereYear('birth_date', '>', $birthYearFrom)
                ->whereYear('birth_date', '<', $birthYearTo);
        }
    }

    public function applyCreatedAtFilters(Builder $query, $startDate, $endDate): void
    {
        if ($startDate && !$endDate) {
            $query->where('created_at', '>=', $startDate);
        } elseif (!$startDate && $endDate) {
            $query->where('created_at', '<=', $endDate);
        } elseif ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
    }

    public function findUser($id)
    {
        return User::findOrFail($id);
    }

    public function updateUser(UserUpdateFormRequest $request, $user): void
    {
        $user->update($request->all());
    }

    public function createUser(UserStoreFormRequest $request)
    {
        $user = User::create($request->all());
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return $user;
    }

    public function createUserFromInterviewee($interviewee, $userRoles, $intervieweeName, $intervieweeLastname, $intervieweeMiddleName): User
    {
        $newUser = new User([
            'name' => $intervieweeName,
            'lastname' => $intervieweeLastname,
            'middle_name' => $intervieweeMiddleName,
            'email' => $interviewee->email,
            'password' => Hash::make('12345678'),
            'phone' => $interviewee->phone,
            'address' => $interviewee->address,
            'birth_date' => $interviewee->birth_date,


            'is_manager' => (bool)$userRoles['Менеджер'],
            'is_executive' => (bool)$userRoles['Керівник'],
            'is_hr' => (bool)$userRoles['HR'],
            'is_brigadier' => (bool)$userRoles['Бригадир'],
            'is_accountant' => (bool)$userRoles['Бухгалтер'],
            'is_logist' => (bool)$userRoles['Логіст'],
            'is_mover' => (bool)$userRoles['Вантажник'],
        ]);
        $newUser->save();

        return $newUser;
    }

    public function passwordUpdate(PasswordUpdateRequest $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        if (!Hash::check($request->input('old_password'), $user->password)) {
            return back()->withErrors(['old_password' => 'Старый пароль введен неверно.']);
        }
        if ($request->input('new_password') !== $request->input('new_password_confirm')) {
            return back()->withErrors(['new_password_confirm' => 'Подтверждение нового пароля не совпадает.']);
        }

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return redirect()->back()->with('reload', true);
    }

    public function userUpdate(AdminUserUpdateFormRequest $request, $id): void
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        $user->update([
            'is_admin' => 0,
            'is_executive' => 0,
            'is_hr' => 0,
            'is_manager' => 0,
            'is_accountant' => 0,
            'is_logist' => 0,
        ]);

        $position = $request->position;
        $user["is_$position"] = 1;
        $user->password = Hash::make($request->input('password'));
        $user->save();
    }

    public function userAdminUpdate(EditUserRequest $request, $user): void
    {
        $user->update([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => password_hash($request->password, PASSWORD_BCRYPT),
            'is_admin' => $request->has('is_admin') ? $request->is_admin : false,
            'is_manager' => $request->has('is_manager') ? $request->is_manager : false,
            'is_executive' => $request->has('is_executive') ? $request->is_executive : false,
            'is_hr' => $request->has('is_hr') ? $request->is_hr : false,
            'is_accountant' => $request->has('is_accountant') ? $request->is_accountant : false,
            'is_logist' => $request->has('is_logist') ? $request->is_logist : false,
            'is_mover' => $request->has('is_mover') ? $request->is_mover : false,


        ]);
    }

//    public function addFile($request, $fileType, $photoPath): ?string
//    {
//        $path = null;
//        if ($request->hasFile($fileType) && $request->file($fileType)->isValid()) {
//            $file = $request->file($fileType);
//            $fileName = $file->getClientOriginalName();
//            $path = $photoPath . $fileName;
//            Storage::disk('public')->put($path, file_get_contents($file));
//        }
//        return $path;
//    }
//
//    public function removeFile($path, $newPath): ?string
//    {
//        $file = Storage::disk('public')->get($path);
//        $newFilePath = null;
//        if($file !== false){
//            $newFileName = pathinfo($path, PATHINFO_BASENAME);
//            $newFilePath = $newPath.$newFileName;
//            Storage::disk('public')->put($newFilePath, $file);
//            Storage::disk('public')->delete($path);
//        }
//        return $newFilePath;
//    }
//
//
//
//
//    public function userUpdatePhotoPath($path, $user): void
//    {
//        $user->update([
//            'photo_path' => $path,
//        ]);
//    }

    public function searchUser($search, $withGet = true)
    {
        $query = User::where(function ($query) use ($search) {
            $query->where('name', 'LIKE', "%$search%")
                ->orWhere('lastname', 'LIKE', "%$search%")
                ->orWhere('birth_date', 'like', "%$search%")
                ->orWhere('phone', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('address', 'like', "%$search%")
                ->orWhere('bank_card', 'like', "%$search%")
                ->orWhere('passport_number', 'like', "%$search%")
                ->orWhere('passport_series', 'like', "%$search%");
        })
            ->orWhere(function ($query) use ($search) {
                if (is_numeric($search)) {
                    $query->orWhere('name', 'LIKE', "%$search%")
                        ->orWhere('lastname', 'LIKE', "%$search%");
                }
            });

        return $withGet ? $query->get() : $query;
    }

    public function usersForMessage($search)
    {
        return User::where(function ($query) use ($search) {
            $query->where('name', 'LIKE', "%$search%")
                ->orWhere('lastname', 'LIKE', "%$search%");
        })
            ->orWhere(function ($query) use ($search) {
                // Проверяем, является ли введенный поисковый запрос числом
                if (is_numeric($search)) {
                    $query->orWhere('name', 'LIKE', "%$search%")
                        ->orWhere('lastname', 'LIKE', "%$search%");
                }
            })
            ->get();
    }


    public function formattedUsers($users)
    {
        return $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'lastname' => $user->lastname,
            ];
        })->toArray();
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
