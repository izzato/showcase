<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'agreed_to_terms_and_conditions' => [
                'accepted',
            ],
        ], [
            'agreed_to_terms_and_conditions.accepted' => __('validation.agreed_to_terms_and_conditions.accepted'),
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        if (session('locale') && in_array(session('locale'), array_keys(\Symfony\Component\Intl\Locales::getNames()))) {
            $user->settings()->set('locale', session('locale'));
        }

        $user->settings()->set('agreed_to_terms_and_conditions_at', now());

        return $user;
    }
}
