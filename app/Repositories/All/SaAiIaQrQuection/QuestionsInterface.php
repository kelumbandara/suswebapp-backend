<?php
namespace App\Repositories\All\SaAiIaQrQuection;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface QuestionsInterface extends EloquentRepositoryInterface
{

    public function findByQuectionRecoId(int $quectionRecoId);
    public function deleteByQuectionRecoId(int $quectionRecoId);
    public function findByQueGroupId(int $queGroupId);
    public function deleteByQueGroupId(int $queGroupId);
    public function findByQueGroupIdAndQuectionRecoId(int $queGroupId, int $quectionRecoId);

}
