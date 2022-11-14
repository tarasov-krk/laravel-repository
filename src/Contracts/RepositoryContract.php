<?php declare(strict_types=1);

namespace TarasovKrk\LaravelRepository\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface RepositoryContract
{
    public function all(array $columns = ['*']);

    public function get($id);

    public function store(array $data);

    public function update($id, array $data): int;

    public function destroy($id);

    public function query(): Builder;
}
