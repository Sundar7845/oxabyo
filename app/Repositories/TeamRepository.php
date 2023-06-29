<?php 

namespace App\Repositories;

/* Interfaces */
use App\Repositories\Interfaces\TeamRepositoryInterface;

/* Model */
use App\Team;
use App\TeamMember;

class TeamRepository implements TeamRepositoryInterface
{
    /**
     * Create a new Team
     * 
     * @param array $data         - [ key => value ]
     *
     * @return Team
     */    
    public function create($data): Team
    {
        return Team::create($data);
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
        return Team::where('id', $id)->update($data);
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
        return Team::find($id);
    }

    /**
     * Find all Team
     *
     * @return Collection
     */
    public function findAll()
    {
        return Team::get();
    }

    /**
     * Find Team with pagination
     *
     * @return Collection
     */
    public function findAllWithPagination($page = 10)
    {
        return Team::paginate($page);
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
        return Team::find($id)->delete();
    }

    /**
     * Make a Team member as Admin
     * 
     * @param int   $id           - team.id
     *
     * @return
     */
    public function updateTeamMember(int $id,array $data)
    {
        return TeamMember::where('id', $id)->update($data);;
    }
}
