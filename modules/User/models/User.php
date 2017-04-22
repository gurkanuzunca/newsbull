<?php

use Sirius\Application\Model;

class User extends Model
{
    private $table = 'users';
    private $hashAlgo = 'sha256';

    /**
     * Kayıt bulma
     *
     * @param $value
     * @param string $column
     * @return object
     */
    public function find($value, $column = 'id')
    {
        return $this->db
            ->from($this->table)
            ->where($column, $value)
            ->where('status', 'verified')
            ->get()
            ->row();
    }


    /**
     * Kayıtları bulma
     *
     * @param array $values
     * @param string $column
     * @return array
     */
    public function findIn(array $values, $column = 'id')
    {
        $values = array_unique($values);

        return $this->db
            ->from($this->table)
            ->where_in($column, $values)
            ->where('status', 'verified')
            ->get()
            ->result();
    }

    /**
     * Slug'a göre kaydı bulur.
     *
     * @param array $criteria
     * @param string $hash Hash uygulanacak değişken.
     * @return object
     */
    public function findByCriteria(array $criteria, $hash = 'password')
    {
        if (isset($criteria[$hash])) {
            $criteria[$hash] = hash($this->hashAlgo, $criteria[$hash]);
        }

        return $this->db
            ->from($this->table)
            ->where($criteria)
            ->get()
            ->row();
    }

    /**
     * Tüm kayıtları döndürür.
     *
     * @param array $paginate
     * @return array
     */
    public function all($paginate = [])
    {
        $this->setPaginate($paginate);

        return $this->db
            ->from($this->table)
            ->where('status', 'verified')
            ->order_by('id', 'asc')
            ->get()
            ->result();
    }

    /**
     * Toplam kayıt sayısı.
     *
     * @return int
     */
    public function count()
    {
        return $this->db
            ->from($this->table)
            ->where('status', 'verified')
            ->count_all_results();
    }

    /**
     * Yeni hesap oluşturma.
     *
     * @return bool|string
     */
    public function create()
    {
        $verifyToken = hash($this->hashAlgo, microtime());
        $this->db->insert($this->table, array(
            'username' => $this->input->post('name') .' '. $this->input->post('surname'),
            'email' => $this->input->post('email'),
            'password' => hash($this->hashAlgo, $this->input->post('password')),
            'name' => $this->input->post('name'),
            'surname' => $this->input->post('surname'),
            'verifyToken' => $verifyToken,
            'createdAt' => $this->date->set()->mysqlDatetime(),
            'updatedAt' => $this->date->set()->mysqlDatetime()
        ));

        $insertId = $this->db->insert_id();

        if ($insertId > 0) {
            return $verifyToken;
        }

        return false;
    }

    /**
     * E-mail adresinin kullanım durumunu kontrol eder.
     * $this->find() ile yapılabilirsi ancak find() sadece doğrulanmış kayıtları döndürüyor.
     *
     * @param $email
     * @return bool
     */
    public function exists($email)
    {
        $user = $this->db
            ->from($this->table)
            ->where('email', $email)
            ->count_all_results();

        if ($user > 0) {
            return true;
        }

        return false;
    }

    /**
     * Kullanıcı için yeni token üretir ve kaydı günceller.
     *
     * @param object $user
     * @return bool|string
     */
    public function createRememberToken($user)
    {
        $token = hash($this->hashAlgo, microtime());

        $this->db
            ->where('id', $user->id)
            ->update($this->table, array(
                'rememberToken' => $token,
            ));

        if ($this->db->affected_rows() > 0) {
            $user->rememberToken = $token;

            return $token;
        }

        return false;
    }


    /**
     * Kullanıcı için yeni token üretir ve kaydı günceller.
     *
     * @param object $user
     * @return bool|string
     */
    public function verify($user)
    {
        $this->db
            ->where('id', $user->id)
            ->update($this->table, array(
                'verifyToken' => null,
                'status' => 'verified',
            ));

        if ($this->db->affected_rows() > 0) {
            return true;
        }

        return false;
    }
}