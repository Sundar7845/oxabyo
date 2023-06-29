<?php

namespace App\Repositories;

/* Interfaces */
use App\Repositories\Interfaces\FixtureRepositoryInterface;

/** Model */
use App\Fixture;
use App\FixtureResult;

class FixtureRepository implements FixtureRepositoryInterface
{
    /**
     * Create a new Fixture
     * 
     * @param array $data         - [ key => value ]
     *
     * @return 
     */
    public function create($data)
    {
        return Fixture::create($data);
    }

    /**
     * Create a new FixtureResult
     * 
     * @param array $data         - [ key => value ]
     *
     * @return 
     */
    public function createFixtureResult($data)
    {
        return FixtureResult::create($data);
    }

    /**
     * Find and update Fixture
     * 
     * @param int   $id           - fixtures.id
     * @param array $data         - [ key => value ]
     *
     * @return 
     */
    public function findAndUpdate($id, $data)
    {
        return Fixture::find($id)->update($data);
        // return Fixture::find($id);
    }

    /**
     * Find Fixture result
     * 
     * @param int   $id           - fixtures.id
     * @param array $data         - [ key => value ]
     *
     * @return 
     */
    public function findFixtureResult($id)
    {
        return FixtureResult::where('fixture_id', $id)->first();
    }

    /**
     * Find and update Fixture result
     * 
     * @param int   $id           - fixtures.id
     * @param array $data         - [ key => value ]
     *
     * @return 
     */
    public function findAndUpdateFixtureResult($id, $data)
    {
        return FixtureResult::where('fixture_id',$id)->update($data);
    }
}
