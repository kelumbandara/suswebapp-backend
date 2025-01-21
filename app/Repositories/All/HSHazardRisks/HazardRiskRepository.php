<?php
namespace App\Repositories\All\HSHazardRisks;

use App\Models\HSHazardRisk;
use App\Repositories\Base\BaseRepository;

class HazardRiskRepository extends BaseRepository implements HazardRiskInterface
{
    /**
     * @var HSHazardRisk
     */
    protected $model;

    /**
     * HazardRiskRepository constructor.
     *
     * @param HSHazardRisk $model
     */
    public function __construct(HSHazardRisk $model)
    {
        $this->model = $model;
    }

    /**
     * Find a HazardRisk by its ID.
     *
     * @param int $id
     * @return HSHazardRisk|null
     */
    public function find(int $id): ?HSHazardRisk
    {
        return $this->model->find($id);
    }

    /**
     * Find a HazardRisk by its ID or throw an exception.
     *
     * @param int $id
     * @return HSHazardRisk
     */
    public function findOrFail(int $id): HSHazardRisk
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create a new HazardRisk.
     *
     * @param array $data
     * @return HSHazardRisk
     */
    public function create(array $data): HSHazardRisk
    {
        return $this->model->create($data);
    }

    /**
     * Update an existing HazardRisk.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $hazardRisk = $this->findOrFail($id);
        return $hazardRisk->update($data); // Returns true/false
    }

    /**
     * Delete a HazardRisk by its ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $hazardRisk = $this->findOrFail($id);
        return $hazardRisk->delete(); // Returns true/false
    }


}
