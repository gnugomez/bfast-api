<?php

namespace App\Domain\Contracts;

interface RepositoryContract
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
