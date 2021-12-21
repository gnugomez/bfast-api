<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Infrastructure\Persistence\Eloquent\Models\User;
use App\Domain\Contracts\UserRepositoryContract;

class UserRepository implements UserRepositoryContract
{

    /**
     * @var User
     */
    protected User $model;

    public function __construct()
    {
        $this->model = new User();
    }

    function all(): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->model->all();
    }

    function find($id)
    {
        return $this->model->find($id);
    }

    function create($object): bool
    {
        $this->model->name = $object->name->value;
        $this->model->surname = $object->surname->value;
        $this->model->email = $object->email->value;
        $this->model->password = password_hash($object->getPassword()->value, PASSWORD_DEFAULT);

        return $this->model->save();
    }

    function update($id, array $data)
    {
        return $this->model->find($id)->update($data);
    }

    function delete($id)
    {
        return $this->model->find($id)->delete();
    }


    function first()
    {
        return $this->model->first();
    }

    function paginate($perPage = null, $columns = array('*'))
    {
        return $this->model->paginate($perPage, $columns);
    }

    function count()
    {
        return $this->model->count();
    }

    public function findByEmail($email)
    {
    }

    function where(string $field, string $operator, $value)
    {
        return $this->model->where($field, $operator, $value);
    }

}
