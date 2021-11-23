<?php

namespace App\User\Infrastucture;

use App\Models\User;
use App\User\Domain\Contracts\UserRepositoryContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentUserRepository implements UserRepositoryContract
{

    /**
     * @var User
     */
    protected User $model;

    public function __construct(){
        $this->model = new User();
    }

    function all(): \Illuminate\Database\Eloquent\Collection|array
    {
        // TODO: Implement all() method.
        return $this->model->all();
    }

    function find($id)
    {
        // TODO: Implement find() method.
        if (null == $user = $this->model->find($id)) {
            throw new ModelNotFoundException("User not found");
        }

        return $user;
    }

    function create($object): bool
    {
        // TODO: Implement create() method.
        $userData = get_object_vars($object);

        $this->model->username = $userData['username']->value();
        $this->model->email = $userData['email']->value();
        $this->model->password = password_hash($object->getPassword()->value(), PASSWORD_DEFAULT);

        return $this->model->save();
    }

    function update($id, array $data)
    {
        // TODO: Implement update() method.
        return $this->model->find($id)->update($data);
    }

    function delete($id)
    {
        // TODO: Implement delete() method.
        return $this->model->find($id)->delete();
    }


    function first()
    {
        // TODO: Implement first() method.
        return $this->model->first();
    }

    function paginate($perPage = null, $columns = array('*'))
    {
        // TODO: Implement paginate() method.
        return $this->model->paginate($perPage, $columns);
    }

    function count()
    {
        // TODO: Implement count() method.
        return $this->model->count();
    }

    public function findByEmail($email){
        return $this->model->where('email', "=", $email)->first();
    }

    function where(string $field, string $operator, $value)
    {
        // TODO: Implement where() method.
        return $this->model->where($field, $operator, $value);
    }
}
