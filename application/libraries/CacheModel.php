<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Base Cache Model
 * Manipulate caching data
 * Like store, update or delete cache
 * 
 * This cache basically reference to postgres database
 *
 * @author Rifky Sultan Karisma A <rifkysultanka@gmail.com>
 */
trait CacheModel
{
    private $postgres = NULL;
    private $table = ' warroomr5_caches.caches';

    protected function instance_cache()
    {
        $this->postgres = $this->load->database('postgres', TRUE);
    }

    /**
     * Check is cache exists and not expired
     *
     * @param string $key
     * @return boolean
     * @author Rifky Sultan Karisma A <rifkysultanka@gmail.com>
     */
    protected function exists_cache($key)
    {
        $exist = $this->postgres
            ->select('key, expired_at')
            ->from($this->table)
            ->where('key', $key)
            ->get()
            ->row();

        if (!empty($exist)) {
            return $this->check_expiration($key, $exist->expired_at);
        }

        return false;
    }

    private function check_expiration($key, $expired_at)
    {
        $date = date("Y-m-d H:i:s");
        if ($expired_at > $date) {
            return true;
        }

        $this->destroy_cache($key);
        return false;
    }

    /**
     * Get cache when value is not expired
     *
     * @param string $key
     * @param any $value
     * @param object|array $options
     * @return array
     * @author Rifky Sultan Karisma A <rifkysultanka@gmail.com>
     */
    protected function get_cache($key)
    {
        $data = $this->postgres
            ->select('key, value, expired_at')
            ->from($this->table)
            ->where('key', $key)
            ->get()
            ->row();

        if (!empty($data)) {
            $isNotExpired = $this->check_expiration($key, $data->expired_at);

            if ($isNotExpired) {
                return json_decode($data->value);
            }
        }

        return [];
    }

    /**
     * This automatically update when the key is not empty and is not expired
     * and create when key is empty or is expired
     *
     * @param string $key
     * @param any $value
     * @param object|array $options
     * @return void
     * @author Rifky Sultan Karisma A <rifkysultanka@gmail.com>
     */
    protected function patch_cache($key, $value, $options = NULL)
    {
        if ($this->exists_cache($key)) {
            $this->put_cache($key, $value, $options);
        } else {
            $this->insert_cache($key, $value, $options);
        }
    }

    protected function store_cache($key, $value, $options = NULL)
    {
        if ($this->exists_cache($key)) {
            return [];
        }

        $this->insert_cache($key, $value, $options);
    }

    private function insert_cache($key, $value, $options = NULL)
    {
        $options = (object) $options;

        $data = [
            'key' => $key,
            'value' => json_encode($value),
            'expired_at' => $options->expiration,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->postgres->insert($this->table, $data);
    }

    protected function update_cache($key, $value, $options = NULL)
    {
        if (!$this->exists_cache($key)) {
            return [];
        }

        $this->put_cache($key, $value, $options);
    }

    private function put_cache($key, $value, $options = NULL)
    {
        $options = (object) $options;

        $data = [
            'value' => json_encode($value),
            'expired_at' => $options->expiration,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->postgres
            ->where('key', $key)
            ->update($this->table, $data);
    }

    protected function delete_cache($key)
    {
        if (!$this->exists_cache($key)) {
            return [];
        }

        $this->destroy_cache($key);
    }

    private function destroy_cache($key)
    {
        $this->postgres
            ->where('key', $key)
            ->delete($this->table);
    }
}
