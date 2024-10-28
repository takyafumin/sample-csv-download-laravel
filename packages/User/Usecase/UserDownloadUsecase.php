<?php

namespace Packages\User\Usecase;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * UserDownload Usecase
 */
class UserDownloadUsecase
{
    /**
     * @param User $userModel
     */
    public function __construct(
        private User $userModel
    ) {}

    /**
     * @return Collection<User>
     */
    public function exec(): Collection
    {
        // ユーザーデータ取得（全件）
        return $this->userModel
            ->query()
            ->get();
    }
}
