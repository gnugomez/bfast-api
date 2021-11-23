<?php

namespace App\Services;

interface RepositoryInterface
{

    function all();

    function find($id);

    function create($object);

    function update($id, array $data);

    function delete($id);

    function where(string $field, string $operator, $value);

    function first();

    function paginate($perPage = null, $columns = array('*'));

    function count();

}
