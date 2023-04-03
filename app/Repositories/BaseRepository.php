<?php   

namespace App\Repositories;

use App\Contracts\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Database\Eloquent\Collection;

class BaseRepository implements EloquentRepositoryInterface
{
    protected const ITEM_PER_PAGE = 25;

    /**
     * @var Model
     */
     protected $model;

    /**
     * BaseRepository constructor.
     *      
     * @param Model $model
     */     
    public function __construct(Model $model)
    {         
        $this->model = $model;
    }
 
    /**
    * @param array $attributes
    *
    * @return Model
    */
    public function create(array $attributes): Model
    {
        $model = $this->model->create($attributes);
        return $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    /**
    * @param int $id
    * @param array $attributes
    *
    * @return Model
    */
    public function update(int $id, array $attributes): Model
    {
        $model = $this->model->find($id);
        $model->update($attributes);
        return $model;
    }
 
    /**
    * @param $id
    * @return Model
    */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    /**
    * @param $id
    * @return Model
    */
    public function findWhere(array $where): ?Collection
    {
        if (empty($where)) {
            return null;
        }

        if (count($where) === 3) {
            return $this->model->where($where[0], $where[1], $where[2])->get();
        }

        return $this->model->where($where[0], $where[1])->get();
    }

    /**
    * @param $id
    * @return Model
    */
    public function findWhereFirst(array $where): ?Model
    {
        if (empty($where)) {
            return null;
        }

        if (count($where) === 3) {
            return $this->model->where($where[0], $where[1], $where[2])->first();
        }

        return $this->model->where($where[0], $where[1])->first();
    }

    /**
    * @param $id
    * @return Model
    */
    public function delete($id): bool
    {
        $model = $this->model->find($id);
        return $model->delete($id);
    }

    protected function getResponseData(AnonymousResourceCollection $collection)
    {
        return $collection->response()->getData(true);
    }
}