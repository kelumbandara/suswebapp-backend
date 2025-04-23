<?php
namespace App\Repositories\All\SaAiIaQrQuection;

use App\Repositories\Base\EloquentRepositoryInterface;

// Interface
interface QuestionsInterface extends EloquentRepositoryInterface
{

    public function findByQuestionRecoId(int $questionRecoId);
    public function deleteByQuestionRecoId(int $questionRecoId);
    public function findByQueGroupId(int $queGroupId);
    public function deleteByQueGroupId(int $queGroupId);
    public function findByQueGroupIdAndQuestionRecoId(int $queGroupId, int $questionRecoId);

}
