<?php

namespace App\Repositories\Interfaces;

interface FixtureRepositoryInterface
{
    /**
     * Create a new Fixture
     * 
     * @param array $data         - [ key => value ]
     *
     * @return 
     */
    public function create($data);

    /**
     * Create a new FixtureResult
     * 
     * @param array $data         - [ key => value ]
     *
     * @return 
     */
    public function createFixtureResult($data);

    /**
     * Find and update Fixture
     * 
     * @param int   $id           - fixtures.id
     * @param array $data         - [ key => value ]
     *
     * @return 
     */
    public function findAndUpdate($id, $data);

    /**
     * Find Fixture result
     * 
     * @param int   $id           - fixtures.id
     * @param array $data         - [ key => value ]
     *
     * @return 
     */
    public function findFixtureResult($id);

        /**
     * Find and update Fixture result
     * 
     * @param int   $id           - fixtures.id
     * @param array $data         - [ key => value ]
     *
     * @return 
     */
    public function findAndUpdateFixtureResult($id, $data);
}
