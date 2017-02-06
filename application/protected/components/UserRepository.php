<?php

class UserRepository
{
    /**
     * @var CDbConnection
     */
    private $db;

    public function __construct(CDbConnection $db)
    {
        $this->db = $db;
    }

    /**
     * @param int $id
     *
     * @return array|false
     */
    public function find($id)
    {
        $user = $this->db->createCommand('SELECT * FROM tbl_user WHERE id = :id')->queryRow(true, ['id' => $id]);

        if ($user) {
            $user['password'] = '******';
        }

        return $user;
    }
}
