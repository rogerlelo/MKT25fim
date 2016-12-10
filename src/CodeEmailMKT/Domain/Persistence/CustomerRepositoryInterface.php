<?php

namespace CodeEmailMKT\Domain\Persistence;

use CodeEmailMKT\Domain\Persistence\RepositoryInterface;

interface  CustomerRepositoryInterface extends RepositoryInterface
{
    public function findByTags(array $tags);
}