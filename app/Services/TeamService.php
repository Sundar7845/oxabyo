<?php

namespace App\Services;

/* Interfaces */
use App\Services\Interfaces\TeamServiceInterface;

/* Repository */
use App\Repositories\TeamRepository;

/* Model */
use App\Team;

class TeamService implements TeamServiceInterface
{

    /**
     * TeamService constructor.
     *
     * @param TeamRepository              $teamRepository
     */
    public function __construct(
        TeamRepository $teamRepository
    ) {
        $this->teamRepository = $teamRepository;
    }

    /**
     * Create a new Team
     * 
     * @param array $data         - [ key => value ]
     *
     * @return Team
     */    
    public function create($data): Team
    {
        return $this->teamRepository->create($data);
    }

    /**
     * Update a Team
     * 
     * @param int   $id           - team.id
     * @param array $data         - [ key => value ]
     *
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->teamRepository->update($id, $data);
    }

    /**
     * Find a Team
     * 
     * @param int   $id           - team.id
     *
     * @return Team
     */
    public function find(int $id): Team
    {
        return $this->teamRepository->find($id);
    }

    /**
     * Find all Team
     *
     * @return Collection
     */
    public function findAll()
    {
        return $this->teamRepository->get();
    }

    /**
     * Find Team with pagination
     *
     * @return Collection
     */
    public function findAllWithPagination($page = 10)
    {
        return $this->teamRepository->paginate($page);
    }

    /**
     * Delete a Team
     * 
     * @param int   $id           - team.id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->teamRepository->delete($id);
    }

    /**
     * Make a Team member as Admin
     * 
     * @param int   $id           - team.id
     *
     * @return
     */
    public function assignTeamAsAdmin(int $id)
    {
        return $this->teamRepository->updateTeamMember($id, [
            'is_admin' => 1
        ]);
    }

    /**
     * Remove a Team member from Admin
     * 
     * @param int   $id           - team.id
     *
     * @return
     */
    public function removeAdminFromTeamMember(int $id)
    {
        return $this->teamRepository->updateTeamMember($id, [
            'is_admin' => 0
        ]);
    }

    /**
     * Make a Team member as Admin
     * 
     * @param int   $id           - team.id
     *
     * @return
     */
    public function banTeamMember(int $id)
    {
        return $this->teamRepository->updateTeamMember($id, [
            'status' => 0
        ]);
    }

    /**
     * Remove a Team member from Admin
     * 
     * @param int   $id           - team.id
     *
     * @return
     */
    public function unbanTeamMember(int $id)
    {
        return $this->teamRepository->updateTeamMember($id, [
            'status' => 1
        ]);
    }
}
