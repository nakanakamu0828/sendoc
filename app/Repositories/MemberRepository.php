<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Member;
use App\Repositories\Interfaces\MemberRepositoryInterface;

class MemberRepository extends AppRepository implements MemberRepositoryInterface
{
    /**
     * 削除処理
     */
    public function delete($id)
    {
        $member = $this->find($id);
        if ($member) {
            if(1 == $member->user->members()->count()) {
                // どの組織にも属さない場合、ユーザー毎削除
                $member->user->delete();
            } else {
                $member->delete();
            }
        }
    }

    public function entity()
    {
        return Member::class;
    }
}
