<?php

namespace App\Repositories\Interfaces;

/* Model */
use App\Team;

interface TeamRepositoryInterface
{
    /**
     * Create a new Team
     * 
     * @param array $data         - [ key => value ]
     *
     * @return Team
     */
    public function create($input): Team;

    /**
     * Update a Team
     * 
     * @param int   $id           - team.id
     * @param array $data         - [ key => value ]
     *
     * @return bool
     */
    public function update(int $id, array $data): bool;

    /**
     * Find a Team
     * 
     * @param int   $id           - team.id
     *
     * @return Team
     */
    public function find(int $id): Team;

    /**
     * Find all Team
     *
     * @return Collection
     */
    public function findAll();

    /**
     * Find Team with pagination
     *
     * @return Collection
     */
    public function findAllWithPagination($page = 10);

    /**
     * Delete a Team
     * 
     * @param int   $id           - team.id
     *
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Make a Team member as Admin
     * 
     * @param int   $id           - team.id
     *
     * @return
     */
    public function updateTeamMember(int $id,array $data);
}
