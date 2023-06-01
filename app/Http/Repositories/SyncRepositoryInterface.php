<?php

namespace App\Http\Repositories;
use Illuminate\Database\Eloquent\Model;

interface SyncRepositoryInterface
{

    /**
     * Attaches child model to parent
     *
     * @param string $parentId
     * @param string $attachId
     * @return Model|null
     */


    function attach(string $parentId, string $attachId): Model|null;

    /**
     * Detaches child model from parent
     *
     * @param string parent model id $parentId
     * @param string detached model id $detachId
     * @return Model
     */
    function detach(string $parentId, string $detachId): Model|null;
}
