<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Izinkan semua pengguna untuk mengakses form ini
    }

    public function rules()
    {
        $userId = $this->user ? $this->user->id : null; // Untuk update, ambil ID pengguna

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }
}

