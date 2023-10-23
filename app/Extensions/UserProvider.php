<?php

namespace App\Extensions;

use Illuminate\Auth\EloquentUserProvider;

class UserProvider extends EloquentUserProvider
{
    public function retrieveById($identifier) {
        $model = $this->createModel();
        return $this->newModelQuery($model)
            ->with(['intranet'])
            ->where($model->getAuthIdentifierName(), $identifier)
            ->first();
    }
}
