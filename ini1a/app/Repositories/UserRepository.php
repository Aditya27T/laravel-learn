<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;


class UserRepository implements UserRepositoryInterface
{
    /**
     * @var User
     */
    protected $model;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     * @codeCoverageIgnore
     * @mixin \App\Repositories\UserRepository
     */
    public function getAllUsers()
    {
        return $this->model->all();
    }

    /**
     * @param $id
     * @return mixed
     * @codeCoverageIgnore
     * @mixin \App\Repositories\UserRepository
     */
    public function getUserById($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param array $data
     * @return mixed
     * @codeCoverageIgnore
     * @mixin \App\Repositories\UserRepository
     */
    public function createUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->model->create($data);
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed
     * @codeCoverageIgnore
     * @mixin \App\Repositories\UserRepository
     */
    public function updateUser($id, array $data)
    {
        $user = User::findOrFail($id);
        
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        // Filter empty values
        $data = array_filter($data, function ($value) {
            return $value !== null && $value !== '';
        });

        $user->update($data);
        
        return $user->fresh();
    }

    /**
     * @param $id
     * @return mixed
     * @codeCoverageIgnore
     * @mixin \App\Repositories\UserRepository
     */
    public function deleteUser($id)
    {
        return $this->model->destroy($id);
    }
}