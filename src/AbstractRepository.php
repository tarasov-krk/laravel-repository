<?php declare(strict_types=1);

namespace TarasovKrk\LaravelRepository;

use TarasovKrk\LaravelRepository\Contracts\CriteriaContract;
use TarasovKrk\LaravelRepository\Contracts\RepositoryContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements RepositoryContract
{
    private Model $model;

    private Builder $query;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->resetQuery();
    }

    public function model(): Model
    {
        return $this->model;
    }

    public function query(): Builder
    {
        return $this->query;
    }

    public function resetQuery(): static
    {
        $this->query = $this->model::query();

        return $this;
    }

    public function parseResult(mixed $result)
    {
        $this->resetQuery();

        return $result;
    }

    public function all(array $columns = ['*'])
    {
        $result = $this->query->get($columns);

        return $this->parseResult($result);
    }

    public function paginate($count = 25)
    {
        $result = $this->query->paginate($count);

        return $this->parseResult($result);
    }

    public function get($id)
    {
        $result = $this->query->where('id', $id)->first();

        return $this->parseResult($result);
    }

    public function store(array $data)
    {
        $result = $this->query->create($data);

        return $this->parseResult($result);
    }

    public function update($id, array $data): int
    {
        $result = $this->query->where('id', $id)->update($data);

        return $this->parseResult($result);
    }

    public function destroy($id)
    {
        $result = $this->query->where('id', $id)->delete();

        return $this->parseResult($result);
    }

    public function findByField(string $field, mixed $value): Collection
    {
        $result = $this->query->where($field, $value)->get();

        return $this->parseResult($result);
    }

    public function addCriteria(\Closure|CriteriaContract $criteria): static
    {
        if ($criteria instanceof CriteriaContract) {
            $criteria->apply($this->query);
        } else {
            $criteria($this->query);
        }

        return $this;
    }
}
